<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function warranty()
    {
        return view('front.pages.warranty');
    }

    public function privacy()
    {
        return view('front.pages.privacy');
    }

    public function terms()
    {
        return view('front.pages.terms');
    }

    public function contact()
    {
        return view('front.pages.contact');
    }
}
