<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show items for management page.
     */
    public function index() {
        $items = \App\Item::all();

        return view('item.index',[
            'items' => $items,
        ]);
    }

    public function AddItem(Request $request)
    {
        // validateメソッド
        $request->validate([
            'name' => 'required|max:100',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|integer|min:1|max:4',
            'detail' => 'max:100',
            'img' => [
                'file',
                'image',
                'mimes:jpeg,png,jpg',
                'dimensions:min_width=100,min_height=100,max_width=600,max_height=600'
            ],
            'status' => 'required|integer|min:0|max:1',
        ]);

        if(isset($request->detail)) {
            $detail = $request->detail;
        } else {
            $detail = '';
        }

        $filename = '';
        $image = $request->file('img');
        if(isset($image)) {
            // 拡張子
            $ext = $image->guessExtension();
            // [ランダム20文字].[拡張子]
            $filename = str_random(20) . ".{$ext}";
            $path = $image->storeAs('photos', $filename, 'public');
        }

        // Itemモデルを利用して空のオブジェクトを作成
        $item = new \App\Item();

        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->category = $request->category;
        $item->detail = $detail;
        $item->img = $filename;
        $item->status = $request->status;

        $item->save();

        return redirect(route('admin.home'))->with('status', '登録完了しました');
    }

    public function UpdateStock(Request $request)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $item = \App\Item::find($request->item_id);

        $item->stock = $request->stock;
        $item->save();

        return redirect(route('admin.home'))->with('status', '在庫数を変更しました');
    }

    public function UpdateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:1',
        ]);

        $item = \App\Item::find($request->item_id);
        $item->status = $request->status;
        $item->save();

        return redirect(route('admin.home'))->with('status', 'ステータスを変更しました');
    }

    public function DeleteItem(Request $request)
    {
        $item = \App\Item::find($request->item_id);
        $item->delete();

        return redirect(route('admin.home'))->with('status', '商品を削除しました');
    }

    
}
