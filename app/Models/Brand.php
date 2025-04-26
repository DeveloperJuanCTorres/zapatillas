<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'id_sistema'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, "brand_id", "id");
    }   
}
