<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = ['name', 'price'];

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_items')->withPivot('quantity');
    }
}
