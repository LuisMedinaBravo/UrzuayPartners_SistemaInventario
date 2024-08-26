<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\Stock;
use Illuminate\Http\Request;
use Session;
use Validator;
use Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

       return view('vendor.vendor');

   }

   public function Vendor(Request $request){
    

    $vendor = Vendor::orderBy('id','desc');

    if($request->name != ''){
     
        $vendor->where('name','LIKE','%'.$request->name.'%');
    }  

    if($request->rut != ''){
        
        $vendor->where('rut','LIKE','%'.$request->rut.'%');
    }

    $vendor = $vendor->paginate(10);

    return $vendor;
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
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'rut' => 'nullable',
            'email' => 'nullable|unique:vendors',
            'phone' => 'nullable|unique:vendors'
        ]);


        try{
            $vendor = new Vendor;

            $vendor->name = $request->name;
            $vendor->rut = $request->rut;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->region = $request->region;
            $vendor->comuna = $request->commune;
            $vendor->address = $request->address;
            $vendor->soporte_nombre = $request->soporte_nombre;
            $vendor->soporte_correo = $request->soporte_correo;
            $vendor->soporte_phone = $request->soporte_phone;

            $vendor->save();

            return response()->json(['status'=>'success','message'=>'Proveedor creado']);
        }
        catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'¡Se ha encontrado un error! Vuelva a intentarlo.']);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $supplier)
    {
        return $supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        

        $request->validate([
            'name' => 'required',
            'rut' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'region' => 'required',
            'commune' => 'required',
        ]);


        try{
            
            $supplier  = Vendor::find($id);
            $supplier->name = $request->name;
            $supplier->rut = $request->rut;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->region = $request->region;
            $supplier->comuna = $request->commune;
            $supplier->address = $request->address;
            $supplier->soporte_nombre = $request->soporte_nombre;
            $supplier->soporte_correo = $request->soporte_correo;
            $supplier->soporte_phone = $request->soporte_phone;

            $supplier->update();

            return response()->json(['status'=>'success','message'=>'Proveedor actualizado']);
        }
        catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'¡Se ha encontrado un error! Vuelva a intentarlo.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            // Check if there are any rows in the Stock table with the given vendor_id
            $stockCount = Stock::where('vendor_id', $id)->count();

            if ($stockCount > 0) {
                // If there are rows in the Stock table with the vendor_id, return an error message
                return response()->json(['status' => 'error', 'message' => 'El proveedor no puede eliminarse porque está siendo ocupado por alguna entrada']);
            }

            $vendor = Vendor::find($id);
            $vendor->delete();

            return response()->json(['status' => 'success', 'message' => 'Proveedor eliminado']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }
}