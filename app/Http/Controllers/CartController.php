<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\LineItem;


class CartController extends Controller
{
    
    public function index()
    {
        // カートを取得
// Session::get('cart')でセッションからカートIDを取得し、$cart_id変数へ代入しています。
// Cart::find($cart_id);では取得したカートIDでcartsテーブルのレコードを検索し、
// 取得したレコードを$cart変数へ代入しています。
        $cart_id = Session::get('cart');
        $cart = Cart::find($cart_id);
        // 合計金額の算出
// カートに入れた商品の一覧である$cart->productsをforeachで繰り返し処理をおこなっています。
// $total_price変数に商品の価格 * 商品の個数を足し合わせることで、合計金額を算出しています。
        $total_price = 0;
        foreach ($cart->products as $product) {
            $total_price += $product->price * $product->pivot->quantity;
        }
        // withメソッドでは、複数の値をBladeテンプレートへ渡したい場合、
        // 上記のように後ろにwithメソッド付け足します。
        return view('cart.index')
            ->with('line_items', $cart->products)
            ->with('total_price', $total_price);
    }

    public function checkout()
    {
        // indexアクションと同様にセッションからカートIDを取得し、$cart_id変数に代入しています。
        // 取得したカートIDでcartsテーブルのレコードを検索し、取得したレコードを$cart変数へ代入しています。
        $cart_id = Session::get('cart');
        $cart = Cart::find($cart_id);
        // カートに商品が無ければリダイレクト
        if (count($cart->products) <= 0) {
            return redirect(route('cart.index'));
        }


        $line_items = [];
        foreach ($cart->products as $product) {
            $line_item = [
                'name'        => $product->name,
                'description' => $product->description,
                // 料金
                'amount'      => $product->price,
                'currency'    => 'jpy',
                'quantity'    => $product->pivot->quantity,
            ];
            // array_pushメソッドは配列の末尾に値を追加するメソッドです。
            // 第一引数に追加する対象の配列を指定します。
            // 第一引数以降には配列に追加する値を1つまたは複数指定します。
            array_push($line_items, $line_item);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [$line_items],
            // 'success_url'          => route('product.index'),
            'success_url'          => route('cart.success'),
            'cancel_url'           => route('cart.index'),
        ]);

        return view('cart.checkout', [
            'session' => $session,
            'publicKey' => env('STRIPE_PUBLIC_KEY')
        ]);
    }

    public function success()
    {
        // Session::get('cart')でセッションからカートIDを取得し、$cart_id変数へ代入しています。
        // LineItem::where('cart_id', $cart_id)ではline_itemsテーブルからカートIDで検索しています。
        $cart_id = Session::get('cart');
        LineItem::where('cart_id', $cart_id)->delete();
        
        return redirect(route('product.index'));
    }
}
