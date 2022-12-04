<?php

namespace App\Models\Digiflazz;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ref_id',
        'customer_no',
        'buyer_sku_code',
        'message',
        'status',
        'rc',
        'buyer_last_saldo',
        'sn',
        'price',
        'tele',
        'wa',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'buyer_sku_code', 'buyer_sku_code')->select('id', 'product_name', 'price', 'buyer_sku_code');
    }
}