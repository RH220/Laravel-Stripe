<?php

namespace App\Http\Middleware;

use Closure;
// 今回はセッションの機能を使用するためにSessionファザードを使用します。
// ここではSessionファザードを使用するための宣言をしています。
use Illuminate\Support\Facades\Session;
use App\Cart;

class CartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // セッションにカートIDがあるかの確認
        if (!Session::has('cart')) {
            $cart = Cart::create();
            Session::put('cart', $cart->id);
        }
        return $next($request);
    }
}
