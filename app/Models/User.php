<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',       // Tambahkan 'name' di sini
        'username',
        'email',
        'password',
        // 'role',    // Kolom 'role' hanya disertakan jika memang ada di tabel users Anda
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Tambahkan 'remember_token' secara default untuk keamanan
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Tambahkan ini jika Anda menggunakan fitur verifikasi email
        'password' => 'hashed', // Laravel 9+ secara otomatis melakukan hashing password, tapi ini eksplisit lebih baik
    ];

    /**
     * Get the products for the user (if the user is a seller).
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Get the orders for the user (if the user is a buyer).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}