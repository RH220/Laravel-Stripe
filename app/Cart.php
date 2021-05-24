<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function products()
    {
        // 多対多のリレーションはbelongsToManyメソッドを記述することで定義します。
        // 第一引数には関係するモデルクラスを指定し、第二引数には中間テーブル名を指定します。
        return $this->belongsToMany(
            Product::class,
            'line_items',
        )->withPivot(['id', 'quantity']);
    }
}
