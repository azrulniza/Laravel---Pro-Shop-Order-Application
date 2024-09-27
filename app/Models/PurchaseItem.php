<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_items';

    protected $fillable = ['purchase_id', 'item_id', 'quantity', 'customer_id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
