<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_categorie extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = [
        'category_name',
        'cycle',
        'visit',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'product_category_id');
    }
}
