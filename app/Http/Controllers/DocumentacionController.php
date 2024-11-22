<?php

namespace App\Http\Controllers;

use App\Models\Documentacion;
use Illuminate\Http\Request;

class DocumentacionController extends Controller
{
    //Crear un nuevo registro
    public function create(Request $request)
    {
        $documento = Documentacion::create([
            'nombre_documentacion' => $request->nombre_documentacion
        ]);
    }

    //obtener todos los documentos
    public function index()
    {
        return view('catalogos/documentos');
    }

    //Actualizar un documento existente
    public function update(Request $request,$id)
    {
        $documento = Documentacion::find($id);

        if(!$documento){
            return response()->json(['mensaje' => 'Documento no encontrado'], 404);
        }

        $documento->nombre_documentacion = $request->nombre_documentacion;
        $documento->save();
    }

    //Elimar documento
    public function destroy($id)
    {
        $documento = Documentacion::find($id);
        $documento->delete();
    }
}
