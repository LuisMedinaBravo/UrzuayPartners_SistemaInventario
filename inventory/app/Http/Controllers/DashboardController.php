<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sell;
use App\Product;
use App\Stock;
use App\Category;
use App\Vendor;
use App\Customer;
use App\User;
use Auth;

class DashboardController extends Controller{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('welcome');
    }

    public function InfoBox(){


        $total_solicitudes_linares = Sell::where('sede_lista_solicitud', 'linares')
                      ->count();
        $total_pendiente_linares = Sell::where('estado', 'Pendiente')
                      ->where('sede_lista_solicitud', 'linares')
                      ->count();
        $total_aceptado_linares = Sell::where('estado', 'Aceptado')
                      ->where('sede_lista_solicitud', 'linares')
                      ->count();
        $total_rechazado_linares = Sell::where('estado', 'Rechazado')
                      ->where('sede_lista_solicitud', 'linares')
                      ->count();
        
        
        $total_solicitudes_molina = Sell::where('sede_lista_solicitud', 'molina')
                       ->count();
        $total_pendiente_molina = Sell::where('estado', 'Pendiente')
                       ->where('sede_lista_solicitud', 'molina')
                       ->count();
        $total_aceptado_molina = Sell::where('estado', 'Aceptado')
                        ->where('sede_lista_solicitud', 'molina')
                        ->count();
        $total_rechazado_molina = Sell::where('estado', 'Rechazado')
                        ->where('sede_lista_solicitud', 'molina')
                        ->count();




        $actualUserId = Auth::user()->id;
        // Obtener los user_id que coinciden con el usuario actual
        $userSells = Sell::where('user_id', $actualUserId)->pluck('user_id');

        // Contar el número de filas de solicitudes hechas por el técnico
        $total_solicitud_tecnico = Sell::where('user_id', $actualUserId)->count();

        // Contar el número de filas con estado "Pendiente"
        $total_pendiente_tecnico = Sell::where('user_id', $actualUserId)
        ->where('estado', 'Pendiente')
        ->count();

        // Contar el número de filas con estado "Aceptado"
        $total_aceptado_tecnico = Sell::where('user_id', $actualUserId)
        ->where('estado', 'Aceptado')
        ->count();

        // Contar el número de filas con estado "Rechazado"
        $total_rechazado_tecnico = Sell::where('user_id', $actualUserId)
        ->where('estado', 'Rechazado')
        ->count();

        $total_invoice = Sell::count();
        $total_customer = Customer::count();
        $total_vendor = Vendor::count();

        $total_product = Product::count();
        $total_category = Category::count();
        $total_existencia = Stock::selectRaw('COUNT(DISTINCT orden) as total_existencia')
                        ->value('total_existencia');

        $total_aceptado = Sell::where('estado', 'Aceptado')->count();
        $total_rechazado = Sell::where('estado', 'Rechazado')->count();
        $total_pendiente = Sell::where('estado', 'Pendiente')->count();

        $total_critico = Product::whereRaw('CAST(critico AS SIGNED) >= CAST(stock AS SIGNED)')->count();

        return response()->json([

            'total_invoice' => $total_invoice,
            'total_customer' => $total_customer,
            'total_vendor' => $total_vendor,
            'total_product' => $total_product,
            'total_category' => $total_category,
            'total_existencia' => $total_existencia,
            'total_aceptado' => $total_aceptado,
            'total_rechazado' => $total_rechazado,
            'total_pendiente' => $total_pendiente,
            'total_critico' => $total_critico,

            'total_solicitudes_linares' => $total_solicitudes_linares,
            'total_pendiente_linares' => $total_pendiente_linares,
            'total_aceptado_linares' => $total_aceptado_linares,
            'total_rechazado_linares' => $total_rechazado_linares,

            'total_solicitudes_molina' => $total_solicitudes_molina,
            'total_pendiente_molina' => $total_pendiente_molina,
            'total_aceptado_molina' => $total_aceptado_molina,
            'total_rechazado_molina' => $total_rechazado_molina,

            'total_solicitud_tecnico' => $total_solicitud_tecnico,
            'total_pendiente_tecnico' => $total_pendiente_tecnico,
            'total_aceptado_tecnico' => $total_aceptado_tecnico,
            'total_rechazado_tecnico' => $total_rechazado_tecnico
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }
}