<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\FrontService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();

        return view('front.index', $data);
    }

    public function catalog(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $stock = $request->query('stock');
        $sort = $request->query('sort', 'latest');

        $categories = Category::withCount('products')->get();

        $products = Product::query()
            ->with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', '%' . $search . '%');
                    });
                });
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('category', function ($categoryQuery) use ($category) {
                    $categoryQuery->where('slug', $category);
                });
            })
            ->when($minPrice, function ($query, $minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })
            ->when($stock === 'ready', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->when($stock === 'sold_out', function ($query) {
                $query->where('stock', '<=', 0);
            })
            ->when($sort === 'price_low', fn ($query) => $query->orderBy('price', 'asc'))
            ->when($sort === 'price_high', fn ($query) => $query->orderBy('price', 'desc'))
            ->when($sort === 'name', fn ($query) => $query->orderBy('name', 'asc'))
            ->when($sort === 'latest', fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        return view('front.catalog', compact(
            'products',
            'categories',
            'search',
            'category',
            'minPrice',
            'maxPrice',
            'stock',
            'sort'
        ));
    }

    public function details(Product $product)
    {
        $product->load(['variants', 'photos', 'category']);

        $availableAttributes = [];

        foreach ($product->variants as $variant) {
            if (is_array($variant->attributes)) {
                foreach ($variant->attributes as $key => $value) {
                    if (!isset($availableAttributes[$key])) {
                        $availableAttributes[$key] = [];
                    }

                    if (!in_array($value, $availableAttributes[$key])) {
                        $availableAttributes[$key][] = $value;
                    }
                }
            }
        }

        return view('front.details', compact('product', 'availableAttributes'));
    }

    public function category(Category $category)
    {
        $category->load('products');

        return view('front.category', compact('category'));
    }

    public function checkout(Product $product)
    {
        return view('front.checkout', compact('product'));
    }

    public function store_checkout(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'post_code' => 'required|string',
            'proof' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
            $validated['proof'] = $proofPath;
        }

        return redirect()->route('front.success');
    }

    public function success()
    {
        return view('front.success');
    }
}
