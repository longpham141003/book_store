<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'price', 'stock', 'category_id', 'status', 'image_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rentalOrderDetails()
    {
        return $this->hasMany(RentalOrderDetail::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
