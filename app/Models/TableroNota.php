<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableroNota extends Model
{
    protected $fillable = [
        'titulo',
        'contenido',
        'tipo',
        'fecha',
    ];
}