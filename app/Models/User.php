<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Entities\RentalOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\RoleEnum;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = ['role' => 'string'];
    private mixed $role;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
        ];
    }

    public function rentalOrders()
    {
        return $this->hasMany(RentalOrder::class, 'user_id');
    }





    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN->value;
    }

    public function isStaff(): bool
    {
        return $this->role === RoleEnum::STAFF->value;
    }
    public function isCustomer(): bool
    {
        return $this->role === RoleEnum::CUSTOMER->value;
    }
}
