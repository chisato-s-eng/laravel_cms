<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     *  make auth
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function ShowCartList()
    {
        $user_id = \Auth::id();
        $total_price = 0;
        $carts = \App\Cart::where('user_id', $user_id)->get();
        foreach($carts as $cart) {
            $price = $cart->item->price * $cart->amount;
            $total_price += $price;
        }
        return view('item.cart', [
            'carts' => $carts,
            'total_price' => $total_price,
        ]);
    }

    /**
     * Add item to cart.
     */
    public function AddCart(Request $request)
    {
        $item_id = $request->item_id;
        $user_id = \Auth::id();
        $cart = \App\Cart::firstOrNew(
            ['user_id' => $user_id, 'item_id' => $item_id],
            ['amount' => 0]
        );
        $cart->amount = $cart->amount +1;
        $cart->save();

        return redirect()->back()->with('status', 'カートに追加しました');
    }

    /**
     * Update cart's amount
     */
    public function UpdateAmount(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);
        $cart = \App\Cart::where('user_id', \Auth::id())->where('id', $request->cart_id)->first();
        $cart->amount = $request->amount;
        $cart->save();
        
        return redirect(route('cart'))->with('status', '購入予定数を変更しました');
    }

    public function DeleteItem(Request $request)
    {
        $cart = \App\Cart::find($request->cart_id)->first();
        $cart->delete();

        return redirect(route('cart'))->with('status', '商品をカートから削除しました');
    }

    public function Purchase(Request $request)
    {
        $carts = \App\Cart::where('user_id', \Auth::id())->get();
        if(count($carts) === 0){
            return redirect(route('cart'))->withErrors(['error' => 'カートに商品が入っていません']);
        }
        foreach($carts as $cart) {
            if($cart->amount > $cart->item->stock or $cart->item->status === 0) {
                return redirect(route('cart'))->withErrors(['error' => '現在買えない商品があります']);
            }
        }
        
        DB::transaction(function() use ($carts) {
            $history = new \App\History;
            $history->user_id = \Auth::id();
            $history->save();
            $last_insert_id = $history->id;
            foreach($carts as $cart) {
                // 在庫数を減らす
                $item = \App\Item::where('id', $cart->item_id)->first();
                $item->stock = $item->stock - $cart->amount;
                $item->save();

                // 購入履歴
                $history_detail = new \App\HistoryDetail;
                $history_detail->history_id = $last_insert_id;
                $history_detail->item_name = $cart->item->name;
                $history_detail->item_price = $cart->item->price;
                $history_detail->item_amount = $cart->amount;
                $history_detail->save();

                // カートから削除
                $cart->delete();
            }
        });
        return redirect(route('cart'))->with('status', 'ご購入いただきありがとうございました'); 
    }
}
