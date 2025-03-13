<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_date', 'due_date', 'status'];

    public function rentalOrderDetails()
    {
        return $this->hasMany(RentalOrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
