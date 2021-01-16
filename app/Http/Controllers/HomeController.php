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

    /**
     * Show histories list.
     */
    public function ShowHistoryList()
    {
        $history_items = \App\History::where('user_id', \Auth::id())->get();
        $total_price = array();
        foreach($history_items as $history) {
            $price = 0;
            foreach($history->detail as $item) {
                $price += $item->item_price * $item->item_amount;
            }
            $total_price[$history->id] = $price;
        }

        return view('history.index', [
            'history_items' => $history_items,
            'total_price' => $total_price,
        ]);
    }

    public function ShowHistoryDetail($id)
    {
        $history = \App\History::where('id', $id)->first();
        if($history === null || $history->user_id !== \Auth::id()) {
            return redirect(route('history'))->withErrors(['error'=>'指定した購入明細はご覧いただけません']);
        }
        $total_price = 0;
        foreach($history->detail as $item) {
            $total_price += $item->item_price * $item->item_amount;
        }

        return view('history.detail', [
            'history' => $history,
            'total_price' => $total_price,
        ]);
    }
}
