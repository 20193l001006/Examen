<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pacientes;
use Illuminate\Support\Facades\DB;

class PacientesApiController extends Controller
{
    public function index(Request $request)
    {
        $edades = $request->get('edades');

        if($edades === null){
            $pacientes = Pacientes::all();
            return $pacientes;
        } else if($edades === 'Niños') {
            $pacientes = DB::table('pacientes')->select('*')
                                      ->selectRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, now()) as anios')
                                      ->having('anios','<',18)
                                      ->get();
            return $pacientes;
        } else if($edades === 'Adultos') {
            $pacientes = DB::table('pacientes')->select('*')
                                      ->selectRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, now()) as anios')
                                      ->having('anios','>=','18')
                                      ->having('anios','<=','60')
                                      ->get();
            return $pacientes;
        } else if($edades === 'Mayores') {
            $pacientes = DB::table('pacientes')->select('*')
                                      ->selectRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, now()) as anios')
                                      ->having('anios','>',60)
                                      ->get();
            return $pacientes;
        }

    }

    public function store(Request $request)
    {
        $pacientes = new Pacientes; 
    
        $pacientes->nombre = $request->nombre;
        $pacientes->fecha_nacimiento = $request->fecha_nacimiento;
        $pacientes->genero = $request->genero;
        
        $pacientes->save();
    
        return $pacientes;
    }

    public function show($id)
    {
        $pacientes = Pacientes::find($id);
        return $pacientes; 
    }

    public function update(Request $request, $id)
    {        
        $pacientes = Pacientes::find($id);

        $pacientes->nombre = $request->nombre;
        $pacientes->fecha_nacimiento = $request->fecha_nacimiento;
        $pacientes->genero = $request->genero;
        
        $pacientes->save();
    
        return $pacientes; 
    }

    public function destroy($id)
    {
        $pacientes = Pacientes::find($id);

        Pacientes::destroy($id); 

        return response()->json([
            "message" => "Registro eliminado"
          ], 202);
    }
}
