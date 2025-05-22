<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'sexo',
        'disability_type',
        'interest_area',
        'linkedin',
        'work_availability',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];
}
