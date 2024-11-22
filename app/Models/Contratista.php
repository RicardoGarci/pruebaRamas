<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contratista extends Model
{
    use HasFactory;
    protected $table = 'contratistas';
    protected $primaryKey = 'id_contratista';


    public static function getListContratistas(){

        $contratistas = DB::table('contratistas as c')
        ->leftJoin('catalogo_estados as ce', 'ce.id_estado', '=', 'c.id_estado_fk')
        ->select('*');

        return $contratistas;

    }


}
