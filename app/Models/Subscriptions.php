<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_subs';
    protected $fillable = [
        'id_user',
        'tipe',
        'harga',
        'deskripsi',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
//coba