<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
    // 変更を許可するカラムを指定するホワイトリスト
    protected $fillable = ['cart_id', 'product_id', 'quantity'];
}
