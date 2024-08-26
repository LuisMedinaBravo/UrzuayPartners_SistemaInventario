<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Product;
use App\Vendor;
use App\SellDetails;
use App\Category;
use App\Customer;
use Illuminate\Http\Request;
use Auth;
use DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


     $vendor = Vendor::orderBy('name','asc')->get();
     $category = Category::orderBy('name','asc')->get();
     $product = Product::orderBy('product_name','asc')->get();
     return view('stock.stock',[
      'vendor'=>$vendor,
      'category'=>$category,
      'product'=>$product,
    ]);
   }


   public function StockList(Request $request){


     $stock = Stock::with([
      'product'=>function($query){
        $query->select('id','product_name');
      },
      'vendor'=>function($query){
        $query->select('id','name');
      },
      'user'=> function($query){

        $query->select('id','name');
      },
      'category'=> function($query){

        $query->select('id','name');
      },
    ]
  )
     ->when($request->has('sede') && $request->sede != '', function ($query) use ($request) {
        $query->where('sede', $request->sede);
     })

     ->orderBy('updated_at', 'desc');

     if($request->category != ''){

       $stock->where('category_id','=',$request->category);

     }

     if($request->product != ''){

      $stock->where('product_id','=',$request->product);

    }

    if($request->vendor != ''){

      $stock->where('vendor_id','=',$request->vendor);

    }

    $stock = $stock->paginate(10000);

    return $stock;            

  }

  public function ChalanList($id){

    $chalan = Stock::where('product_id','=',$id)
              ->where('current_quantity','>',0)

    ->orderBy('updated_at','desc')
    ->get();

    return $chalan;
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
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
        'product' => 'required',
        'vendor' => 'required',
        'category' => 'required',
        'current_quantity' => 'required',
        'factura' => 'required',
        'fecha' => 'required'
    ]);

    try {

        $stock = new Stock;
        $product = Product::find($request->product);
    
        // Verificar si el valor de 'factura' es el mismo que el último registro
        $lastStock = Stock::where('factura', $request->factura)
            ->orderBy('id', 'desc')
            ->first();
    
        if ($lastStock && $lastStock->factura == $request->factura) {
            // Si 'factura' es el mismo, asignar el valor de 'orden' del último registro
            $stock->orden = $lastStock->orden;
            //return response()->json(['status' => 'error', 'message' => 'N° de factura ya existe en alguna orden de ingreso']);
        }else{
            // Obtener el último número de orden
            $lastOrder = DB::table('stocks')->max('orden');
            // Asignar un número de orden superior al último registro
            $stock->orden = $lastOrder + 1;
        }

        $stock->id = $request->id;
        //$stock->orden = $stock->id
        $stock->sede = $request->currentUrlPart;
        $stock->category_id = $request->category;
        $stock->product_id = $request->product;
        $stock->product_code = time();
        $stock->vendor_id = $request->vendor;
        // Obtener el nombre del vendor a partir del ID
        $vendor = Vendor::find($request->vendor);
        $stock->vendor_name = $vendor->name;
        $stock->user_id = Auth::user()->id;
        $stock->buying_price = 0;
        $stock->selling_price = 0;
        $stock->chalan_no = date('Y-m-d');
        $stock->current_quantity = $request->current_quantity;

        $product->stock = $product->stock + $request->current_quantity;

        $stock->discount = 0;
        $stock->note = $request->note;
        $stock->new_qty = 0;
        
        $stock->factura = $request->factura;
        $stock->fecha = date('Y-m-d', strtotime($request->fecha));
        
        $stock->status = 1;
        $stock->save();

        Stock::where('product_id', '=', $request->product)
            ->where('current_quantity', '>', 0);

        $product->save();
        return response()->json(['status' => 'success', 'message' => 'Existencia de producto agregado']);
    } catch (\Exception $e) {
        return $e;
        return response()->json(['status' => 'error', 'message' => 'Problema para actualizar existencia de producto']);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock){
      return $stock;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit($stock){
      return $stock = Stock::with('product')->where('id','=',$stock)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

      $request->validate([
        'category' => 'required',
        'product' => 'required',
        'vendor' => 'required',
      ]);

      try {
          $stock = Stock::find($id);
          $stock->category_id = $request->category;
          $stock->product_id = $request->product;
          $stock->vendor_id = $request->vendor;
          $stock->note = $request->note;
          $stock->save();

          // Find all rows where the 'orden' field is the same as the current row
          $sameOrdenRows = Stock::where('orden', $stock->orden)
                            ->update(['note' => $request->note]);

          return response()->json(['status' => 'success', 'message' => 'Observación actualizada']);
      } catch (\Exception $e) {
          return response()->json(['status' => 'error', 'message' => 'Problema para actualizar la observación']);
      }
    }


  public function StockUpdate(Request $request){

    $request->validate([

      'new_qty'=>'required|numeric',
      'state'=>'required',
    ]);

    $stock = Stock::find($request->id);
    $product = $stock->product;

       if($request->state == '+'){

            $stock->current_quantity = $stock->current_quantity+$request->new_qty;
            $product->stock = $product->stock + $request->new_qty;

            $stock->update();
            $product->update();
            return response()->json([
              'status' => 'success',
              'message' => 'Cantidad actualizada'
            ]);
          }

        else{
          //SIGNO MENOS
            $verificationNegativeTallerStock = $stock->current_quantity-$request->new_qty;

            if($verificationNegativeTallerStock >= 0){

              $stock->current_quantity = $stock->current_quantity-$request->new_qty;
              $product->stock = $product->stock - $request->new_qty;

              $stock->update();
              $product->update();
              return response()->json([
                'status' => 'success',
                'message' => 'Cantidad actualizada'
              ]);
            }else{
              return response()->json(['status'=>'error','message'=>'La cantidad pedida dejaría en negativo el stock']);
            }
        }

        if($request->state == '+'){

          $stock->current_quantity = $stock->current_quantity+$request->new_qty;
          $product->stock = $product->stock + $request->new_qty;

            $stock->update();
            $product->update();
            return response()->json([
              'status' => 'success',
              'message' => 'Cantidad actualizada'
            ]);
          
        }else{
          //SIGNO MENOS
          $verificationNegativeTallerStock = $stock->current_quantity-$request->new_qty;

          if($verificationNegativeTallerStock >= 0){
              
            $stock->current_quantity = $stock->current_quantity-$request->new_qty;
            $product->stock = $product->stock - $request->new_qty;
              
              $stock->update();
              $product->update();
                return response()->json([
                  'status' => 'success',
                  'message' => 'Cantidad actualizada'
              ]);
              
            }else{
              return response()->json(['status'=>'error','message'=>'La cantidad pedida dejaría en negativo el stock']);
            }            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
      try {
          $stock = Stock::findOrFail($id);
          if ($stock->current_quantity == 0) {
              $stock->delete();
              return response()->json(['status' => 'success', 'message' => 'Eliminado correctamente']);
          } else {
              return response()->json(['status' => 'error', 'message' => 'No se puede eliminar la existencia de producto porque tiene una cantidad mayor a cero']);
          }
      } catch (\Exception $e) {
          return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
      }
    }
}