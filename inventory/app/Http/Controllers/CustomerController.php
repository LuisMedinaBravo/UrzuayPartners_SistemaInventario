<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('customer.customer'); 
    }

    public function CustomerList(Request $request){
        
        $name = $request->name;
        $abreviacion = $request->abreviacion;

        $customer = Customer::withCount([
            'sell AS total_amount' => function ($query){
      
              $query->select(DB::raw("COALESCE(SUM(total_amount),0)"));
              
            },
            
            'sell AS total_paid_amount' => function ($query){
      
              $query->select(DB::raw("COALESCE(SUM(paid_amount),0)"));
              
            },
            
            ])->orderBy('customer_name','asc');

            if($name != ''){
             
                $customer->where('customer_name','LIKE','%'.$name.'%');

            }

            if($abreviacion != ''){
               
                $customer->where('abreviacion','LIKE','%'.$abreviacion.'%');

            }
            
            $customer = $customer->paginate(10);

            return $customer;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'customer_name' => 'required',
            'abreviacion' => 'nullable',
        ]);
       
        try{
            $customer = new Customer;
            $customer->customer_name = $request->customer_name;
            $customer->abreviacion = $request->abreviacion;
            $customer->save();

            return response()->json(['status'=>'success','message'=>'Unidad agregada']);
        }
        catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'customer_name' => 'required',
            'abreviacion' => 'nullable',
        ]);
       
        try{
            $customer = Customer::find($id);
            $customer->customer_name = $request->customer_name;
            $customer->abreviacion = $request->abreviacion;
            $customer->update();

            return response()->json(['status'=>'success','message'=>'Información de la unidad actualizada']);
        }
        catch(\Exception $e)
        {
         
            return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);

        }
    }

    public function destroy($id){

        $customer = Customer::find($id);

        // Check if the customer ID is present in the Products table as the unit_id
        $productCount = Product::where('unit_id', $id)->count();

        if ($productCount > 0) {
            // If the customer ID is found in the Products table, return an error message
            return response()->json(['status' => 'error', 'message' => 'La unidad no puede eliminarse porque está siendo ocupado por algún producto']);
        }

        try {
            $customer->delete();
            return response()->json(['status' => 'success', 'message' => 'Unidad eliminada']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
}