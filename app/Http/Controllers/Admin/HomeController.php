<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \App\Item::all();
        return view('admin.home', [
            'items' => $items,
        ]);
    }

    /**
     * Show histories list.
     */
    public function ShowHistoryList()
    {
        $history_items = \App\History::all();
        $total_price = array();
        foreach($history_items as $history) {
            $price = 0;
            foreach($history->detail as $item) {
                $price += $item->item_price * $item->item_amount;
            }
            $total_price[$history->id] = $price;
        }

        return view('admin.history.index', [
            'history_items' => $history_items,
            'total_price' => $total_price,
        ]);
    }

    public function ShowHistoryDetail($id)
    {
        $history = \App\History::where('id', $id)->first();
        if($history === null) {
            return redirect(route('admin.history'))->withErrors(['error'=>'指定した購入明細は存在しません']);
        }
        $total_price = 0;
        foreach($history->detail as $item) {
            $total_price += $item->item_price * $item->item_amount;
        }

        return view('admin.history.detail', [
            'history' => $history,
            'total_price' => $total_price,
        ]);
    }
}
