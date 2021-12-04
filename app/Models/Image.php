<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name',
        'main_image',
        'product_id',
    ];

    /**
     * Связь «многие к одному» таблицы `images` с таблицей `products`
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
