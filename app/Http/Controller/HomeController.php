<?php

namespace App\Http\Controllers;
use App\Models\PersonaPuesto;
use Illuminate\Http\Request;

class HomeController extends Controller
{

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        
        $totalItemsOcupados = PersonaPuesto::where('estado', 'Ocupado')->count();
        $totalItemsDesocupados = PersonaPuesto::where('estado', 'Desocupado')->count();
    
        $personasDesignadas = PersonaPuesto::whereHas('puesto.procesoDeIncorporacion', function ($query) {
            $query->where('tipoMovimiento', 'DESIGNACION');
        })
        ->count();

        $personasCambiadas = PersonaPuesto::whereHas('puesto.procesoDeIncorporacion', function ($query) {
            $query->where('tipoMovimiento', 'CAMBIO DE ÍTEM');
        })
        ->count();
    
        return view('pages.dashboard', [
            'totalItemsOcupados' => $totalItemsOcupados,
            'totalItemsDesocupados' => $totalItemsDesocupados,
            'personasDesignadas' => $personasDesignadas,
            'personasCambiadas' => $personasCambiadas,
        ]);
    }
    
}
