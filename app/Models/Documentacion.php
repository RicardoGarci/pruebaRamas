<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{
    use HasFactory;

    protected $table = 'catalogo_documentacion';

    protected $fillable =[
        'id_documento',
        'nombre_documento',
    ];


}