<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user',
        'id_car',
        'komentar',
        'nilai',
    ];
    
    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function Car()
    {
        return $this->belongsTo(Car::class,'id_car');
    }
}