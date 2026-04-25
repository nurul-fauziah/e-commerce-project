<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    // Tampilkan halaman perbandingan
    public function index()
    {
        $compareIds = session()->get('compare_items', []);
        $compareProducts = Product::whereIn('id', $compareIds)->get();

        return view('front.compare', compact('compareProducts'));
    }

    // Tambahkan produk ke memori perbandingan
    public function add($id)
    {
        $compareIds = session()->get('compare_items', []);

        // Cegah duplikasi
        if (!in_array($id, $compareIds)) {
            // Batasi maksimal 2 produk untuk komparasi
            if (count($compareIds) >= 2) {
                // Hapus yang paling lama (index 0), masukkan yang baru
                array_shift($compareIds);
            }
            $compareIds[] = $id;
            session()->put('compare_items', $compareIds);
        }

        return redirect()->route('front.compare');
    }

    // Hapus produk dari perbandingan
    public function remove($id)
    {
        $compareIds = session()->get('compare_items', []);

        $compareIds = array_filter($compareIds, function($itemId) use ($id) {
            return $itemId != $id;
        });

        session()->put('compare_items', $compareIds);

        return redirect()->back();
    }
}
