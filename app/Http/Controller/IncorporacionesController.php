<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncorporacionesController extends Controller
{
    public function mostrar()
    {
        return view('incorporaciones');
    }
}