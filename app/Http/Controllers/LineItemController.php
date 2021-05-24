<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\LineItem;

class LineItemController extends Controller
{
    
    public function create(Request $request)
    {
        $cart_id = Session::get('cart');
        // Eloquentのwhereメソッドを使用し、
        // line_itemsテーブルのレコードをカートIDと商品IDで絞り込みをしています。
        $line_item = LineItem::where('cart_id', $cart_id)
        // whereメソッドの第一引数にはカラム名を指定し、第二引数には値を指定します。
        // whereを複数つなげることでAND検索ができます。
        ->where('product_id', $request->input('id'))
        // firstメソッドは最初にヒットしたレコードだけを返します。
        ->first();
        // SQL
        // SELECT * FROM line_items WHERE cart_id = {カートID} AND product_id = {商品ID} LIMIT 1;
        
        // cartにあるか
        if ($line_item) {
            // $request->input('インプットのname属性の値')
            $line_item->quantity += $request->input('quantity');
            // 値を更新したあとsaveメソッドを呼び出して保存しています。
            $line_item->save();
        } else {
            // 追加した商品が新規の場合
            LineItem::create([
                'cart_id' => $cart_id,
                'product_id' => $request->input('id'),
                'quantity' => $request->input('quantity'),
            ]);
        }
        // return redirect(route('product.index'));
        return redirect(route('cart.index'));
    }
        public function delete(Request $request)
        {
            // Eloquentのdestroyメソッドは引数に主キーを指定して、
            // レコードの削除をすることができます。
            // ここではフォームからカートの商品IDを取得して引数に指定しています。
            LineItem::destroy($request->input('id'));
            // レコードを削除したらカート画面へリダイレクトして画面を更新します。
            return redirect(route('cart.index'));
        }
    
}
