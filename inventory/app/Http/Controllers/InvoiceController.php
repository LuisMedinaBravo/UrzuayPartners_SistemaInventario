<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Stock;
use App\StockDetails;
use App\Vendor;
use App\Customer;
use App\Sell;
use App\SellDetails;
use App\Company;
use App\User;
use DB;
use Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

       $category = Category::orderBy('name','asc')->get();
       $customer = Customer::orderBy('customer_name','asc')->get();

       return view('invoice.invoice',[
        'category'=>$category,
        'customer'=>$customer
        ]);
    }


    public function getLastInvoice(){

      $invoice = Sell::orderBy('id','desc')->first();

      if($invoice){
        return $invoice->id + 1;
      }
      else{
        return 1;
      }
    }

    public function InvoiceList(Request $request){

         $invoice = Sell::with([

         'user'=>function($query){

            $query->select('name','id');
         }])
         ->orderBy('updated_at','desc');

          if($request->invoice_id != ''){
      
             $invoice->where('id','=',$request->invoice_id);
          }

          if($request->estado != ''){
      
            $invoice->where('estado','=',$request->estado);
         }
          
          if ($request->sede_lista_solicitud != ''){
             
            $invoice->where('sede_lista_solicitud','=',$request->sede_lista_solicitud);
         } 

          if ($request->start_date != '' && $request->end_date != ''){
             
             $invoice->whereBetween('sell_date',[$request->start_date,$request->end_date]);
          }
          $invoice = $invoice->paginate(10);

         return $invoice;
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
          'product.*.category' => 'required',
          'product.*.product_id' => 'required',
          'quantity' => 'required',
          'marca_modelo' => 'required',
          'patente' => 'required',
        ],[
          'product.*.category.required' => 'required field',
          'product.*.product_id.required' => 'required field',
          'quantity.required' => 'required',
          'quantity.integer' => 'required',
        ]);

        try{

            DB::beginTransaction();

            $invoice = new Sell;

            $invoice->user_id = Auth::user()->id;  
            $invoice->customer_id = 0;  
            $invoice->branch_id = Auth::user()->branch_id;  
            $invoice->total_amount = 0;  
            $invoice->discount_amount = 0;  
            $invoice->paid_amount = 0;  
            $invoice->sell_date = date("Y-m-d", strtotime($request->invoice_date));  
            $invoice->payment_method = 0;

            $invoice->marca_modelo = $request->marca_modelo;
            $invoice->patente = $request->patente;
            $invoice->codigo = $request->codigo;
            $invoice->estado = $request->estado;
            $invoice->sede_lista_solicitud = $request->sede_lista_solicitud;

            $invoice->save();

            foreach ($request->product as $value) {
                
               $inv_details = new SellDetails;
               
               $inv_details->stock_id = 0;
               $inv_details->sell_id = $invoice->id;


               $inv_details->product_id = $value['product_id']['id'];
               $inv_details->category_id = $value['category']['id'];
               $inv_details->customer_id = 0;
               $inv_details->vendor_id = 0;
               $inv_details->user_id = Auth::user()->id;
               
               $inv_details->chalan_no = 0;

               $inv_details->selling_date = date("Y-m-d", strtotime($request->invoice_date));

               $inv_details->sold_quantity = 0;
               $inv_details->buy_price = 0;
               $inv_details->sold_price = 0;
               $inv_details->total_buy_price = 0;
               $inv_details->total_sold_price = 0;
               $inv_details->discount = 0;
               $inv_details->discount_type = 0;
               $inv_details->discount_amount = 0;
               $inv_details->quantity = $request->quantity;
               $inv_details->estado = "Pendiente";
               $inv_details->save();
            }
             
             DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Solicitud creada']);
            }
               catch(\Exception $e){
             
             DB::rollback();
             return $e;
             return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $invoice = Sell::find($id);

        $invoice_details = SellDetails::with(['stock.category:id,name','stock.product:id,product_name'])
                          ->where('sell_id','=',$id)->get();

        return view('invoice.print_invoice',[
           'invoice' => $invoice,
           'invoice_details' => $invoice_details
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
      
      $sell = Sell::find($id);
      $invoice_details = SellDetails::where('sell_details.sell_id','=',$id)
                                    ->get();                          
      $quantities = $invoice_details->pluck('quantity')->toArray();
      $user = User::find($sell->user_id);
      $userName = $user->name;
      
      $arr = [
          'invoice_no' => $sell->id,
          'invoice_date' => $sell->sell_date,
          'user_id' => $sell->user_id,
          'user_name' => $userName,
          'marca_modelo' => $sell->marca_modelo,
          'patente' => $sell->patente,
          'codigo' => $sell->codigo,
          'observaciones' => $sell->observaciones,
          'estado'=>$sell->estado,
          'product' => []
      ];
         
      $product = [];
      foreach ($invoice_details as $key => $value) {
          $products = Product::where('category_id','=',$value->category_id)->get();
          $stocks = Stock::where('product_id','=',$value->product_id)->get();
          $product['id'] = $value->id; 
          $product['category'] = $value->category_id; 
          $product['product_id'] = $value->product_id; 
          $product['products'] = $products; 
          $product['stocks'] = $stocks; 
          $product['quantity'] = $quantities[$key];
          array_push($arr['product'],$product);
      }
  
      return $arr;
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id){
 
            $request->validate([
              'invoice_date' => 'required',
              'product.*.category' => 'required',
              'product.*.quantity' => 'required',
            ],[
           'product.*.category.required' => 'required field',
           'product.*.product_id.required' => 'required field',
           'product.*.quantity.required' => 'required field',
         ]);
 
         try{
 
             DB::beginTransaction();
 
             $invoice = Sell::find($id);
 
             $invoice->estado = "Aceptado";  
             $invoice->sell_date = date("Y-m-d", strtotime($request->invoice_date));
             $invoice->observaciones = $request->observaciones;
 
             $details = SellDetails::where('sell_id','=',$id)->get();
 
             SellDetails::where('sell_id','=',$id)->delete();
 
             foreach ($request->product as  $value) {
                 
                $inv_details = new SellDetails;
                // Buscar el producto en la tabla Product
                $product = Product::find($value['product_id']);
                if(($product->stock - $value['quantity']) < 0){
                  return response()->json(['status'=>'error','message'=>'¡Uno o más productos quedarían con stock negativo!']);
                }
                $product->stock = $product->stock - $value['quantity'];
 
                $inv_details->stock_id = 0;
                $inv_details->sell_id = $invoice->id;
                $inv_details->product_id = $value['product_id'];
                $inv_details->category_id = $value['category'];
                $inv_details->customer_id = 0;
                $inv_details->vendor_id = 0;
                $inv_details->user_id = Auth::user()->id;
                $inv_details->chalan_no = 0;
                $inv_details->selling_date = date("Y-m-d", strtotime($request->invoice_date));
                $inv_details->sold_quantity = 0;
                $inv_details->buy_price = 0;
                $inv_details->sold_price = 0;
                $inv_details->total_buy_price = 0;
                $inv_details->total_sold_price = 0;
                $invoice->total_amount = 0;
                $inv_details->discount = 0;
                $inv_details->discount_type = 0;
                $inv_details->discount_amount = 0;
                $inv_details->quantity = $value['quantity'];
                $inv_details->estado = "Aceptado";
                $product->save();
                $inv_details->save();
 
             }
             $invoice->update();
              DB::commit();
 
             return response()->json(['status' => 'success', 'message' => '¡Solicitud actualizada!']);
             }
                catch(\Exception $e){
              
              DB::rollback();
 
              return $e;
              return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
         }
     }


     public function updateRechazar(Request $request, $id){
 
      $request->validate([
      'invoice_date' => 'required',
      'product.*.category' => 'required',
      'product.*.quantity' => 'required',
      ],[
      'product.*.category.required' => 'required field',
      'product.*.product_id.required' => 'required field',
      'product.*.quantity.required' => 'required field',
      ]);

      try{

          DB::beginTransaction();

          $invoice = Sell::find($id);

          $invoice->estado = "Rechazado";  
          $invoice->sell_date = date("Y-m-d", strtotime($request->invoice_date));
          $invoice->observaciones = $request->observaciones;

          $details = SellDetails::where('sell_id','=',$id)->get();

          SellDetails::where('sell_id','=',$id)->delete();

          foreach ($request->product as  $value) {
              
              $inv_details = new SellDetails;
              // Buscar el producto en la tabla Product
              $product = Product::find($value['product_id']);

              $inv_details->stock_id = 0;
              $inv_details->sell_id = $invoice->id;
              $inv_details->product_id = $value['product_id'];
              $inv_details->category_id = $value['category'];
              $inv_details->customer_id = 0;
              $inv_details->vendor_id = 0;
              $inv_details->user_id = Auth::user()->id;
              $inv_details->chalan_no = 0;
              $inv_details->selling_date = date("Y-m-d", strtotime($request->invoice_date));
              $inv_details->sold_quantity = 0;
              $inv_details->buy_price = 0;
              $inv_details->sold_price = 0;
              $inv_details->total_buy_price = 0;
              $inv_details->total_sold_price = 0;
              $invoice->total_amount = 0;
              $inv_details->discount = 0;
              $inv_details->discount_type = 0;
              $inv_details->discount_amount = 0;
              $inv_details->quantity = $value['quantity'];
              $inv_details->estado = "Rechazado";
              $inv_details->save();

          }
          $invoice->update();
            DB::commit();

          return response()->json(['status' => 'success', 'message' => '¡Solicitud actualizada!']);
          }
              catch(\Exception $e){
            
            DB::rollback();

            return $e;
            return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try{
           DB::beginTransaction();
             
            $sell = Sell::find($id);

            $sell->delete();

            $details = SellDetails::where('sell_id','=',$id)->get();
          
             SellDetails::where('sell_id','=',$id)->delete();

            DB::commit();

           return response()->json(['status' => 'success', 'message' => 'Solicitud eliminada']);
  
        }
        catch(\Exception $e){
             
             DB::rollback();

             return $e;
             return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);
        }
    }
}