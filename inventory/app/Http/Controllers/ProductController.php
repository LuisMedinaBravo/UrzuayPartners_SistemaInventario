<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use App\Category;
use App\Customer;
use Session;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $category = Category::orderBy('name', 'asc')->get();
        $unit = Customer::orderBy('customer_name', 'asc')->get();
        return view('product.product', ['category' => $category, 'unit' => $unit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }


    public function ProductList(Request $request){
        $product = Product::with(['category' => function($query){
            $query->select('id','name');
        }])
        ->orderBy('product_name', 'asc');

        $name = $request->name;
        $marca = $request->marca;
        $category = $request->cat;
        $unit = $request->uni;

        if ($name != '') {
            $product->where('product_name', 'LIKE', '%' . $name . '%');
        }

        if ($marca != '') {
            $product->where('marca', 'LIKE', '%' . $marca . '%');
        }

        if ($category != '') {
            $product->where('category_id', '=', $category);
        }

        if ($unit != '') {
            $product->where('unit_id', '=', $unit);
        }

        $product = $product->paginate(10);

        return $product;
    }

    public function productByCategory($id){
          
        $product = Product::where('category_id','=',$id)->get();
        return $product;
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
            'name' => 'required|unique:products,product_name',
            'category' => 'required',
            'unit' => 'required',
            'critico' => 'required',
        ]);

        try{

            $product = new Product;

            $product->category_id = $request->category;
            $product->product_name = $request->name;
            $product->marca = $request->marca;
            $product->stock = $request->stock;
            $product->critico = $request->critico;
            $product->unit_id = $request->unit;
            $customer = Customer::find($request->unit);
            $product->details = $customer->customer_name;

            $product->save();
       
            return response()->json(['status'=>'success','message'=>'Producto agregado']);
        }
        catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'¡Algo salió mal! Por favor, vuelva a intentarlo']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product){
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'critico' => 'required'
        ]);

        try{
            
            $product = Product::find($id);
            $product->category_id = $request->category;
            $product->product_name = $request->name;
            $product->marca = $request->marca;
            $product->critico = $request->critico;
            $product->unit_id = $request->unit;

            $product->update();
       
            return response()->json(['status'=>'success','message'=>'Producto actualizado']);
        }
        catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'¡Algo salió mal! Por favor, vuelva a intentarlo']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    // delete product 

    public function destroy($id)
    {
        

        $product = Product::find($id);

        $check = Stock::where('product_id','=',$product->id)->count();


        if($check > 0){
           
           return response()->json(['status'=>'error','message'=>'El producto no puede eliminarse porque está siendo ocupado por alguna entrada']);

         }else{
           
           try{
              
              $product->delete();

              return response()->json(['status'=>'success','message'=>'Producto eliminado']);

           }
           catch(\Exception $e){
            
               return response()->json(['status'=>'error','message'=>'¡Algo salió mal!']);

           }
         }
    }
}
