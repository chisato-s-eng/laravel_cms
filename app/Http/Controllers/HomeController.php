<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show items for list. 
     */
    public function ShowItemList(Request $request)
    {
        $category = $request->category;
        $items = \App\Item::where('category', $category)->where('status',1)->get();

        return view('item.index', [
            'items' => $items,
        ]);
    }
}
