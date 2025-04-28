<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'sexo',
        'disability_type'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];
}
