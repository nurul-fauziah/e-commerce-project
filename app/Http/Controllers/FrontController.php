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

    public function details(Product $product)
    {
        return view('front.details', compact('product'));
    }

    public function category(Category $category)
    {

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

        // Simpan bukti transfer
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
