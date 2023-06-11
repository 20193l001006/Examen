<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pacientes;
use Illuminate\Support\Facades\DB;

class PacientesController extends Controller
{
    public function index(Request $request)
    {
        $edades = $request->get('edades');

        if($edades === 'Todos' || $edades === null){
            $pacientes = Pacientes::all();
            $edades = 'Todos';
            return view('welcome', compact('pacientes','edades'));

        } else if($edades === 'Niños') {
            $pacientes = DB::table('pacientes')->select('*')
                                      ->selectRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, now()) as anios')
                                      ->having('anios','<',18)
                                      ->get();
            return view('welcome', compact('pacientes','edades'));

        } else if($edades === 'Adultos') {
            $pacientes = DB::table('pacientes')->select('*')
                                      ->selectRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, now()) as anios')
                                      ->having('anios','>=','18')
                                      ->having('anios','<=','60')
                                      ->get();
            return view('welcome', compact('pacientes','edades'));

        } else if($edades === 'Mayores') {
            $pacientes = DB::table('pacientes')->select('*')
                                      ->selectRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, now()) as anios')
                                      ->having('anios','>',60)
                                      ->get();
            return view('welcome', compact('pacientes','edades'));
        }

    }

    public function store(Request $request)
    {
        $pacientes = new Pacientes; 
    
        $pacientes->nombre = $request->nombre;
        $pacientes->fecha_nacimiento = $request->fecha_nacimiento;
        $pacientes->genero = $request->genero;
        
        $pacientes->save();
    
        return redirect(''); 
    }

    public function edit($id)
    {
        $pacientes = Pacientes::find($id);
        return view('welcome',['pacientes'=>$pacientes]);
    }

    public function update(Request $request, $id)
    {        
        $pacientes = Pacientes::find($id);

        $pacientes->nombre = $request->nombre;
        $pacientes->fecha_nacimiento = $request->fecha_nacimiento;
        $pacientes->genero = $request->genero;
        
        $pacientes->save();
    
        return redirect('');
    }

    public function destroy($id)
    {
        $pacientes = Pacientes::find($id);
        
        $pacientes->delete();

        return redirect('');
    }
}
