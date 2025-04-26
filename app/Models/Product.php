<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'information',
        'slug',
        'images',
        'price',
        'taxonomy_id',
        'brand_id',
        'id_sistema',
        'unidad_medida',
        'stock'
    ];
    
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors() 
    {
        return $this->belongsToMany(Color::class);
    }
}
