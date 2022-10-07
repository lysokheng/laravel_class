<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $product = Product::all();

        return response()->json([
            "data"=>$product,
            "success"=> true
        ]);
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
        $uploadFolder = 'products';
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:png,jpeg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->getMessages()], 400);

        }

          if($request->hasFile('image')){
            
            $image = $request->file('image');
            $image_upload_path = $image->store($uploadFolder, 'public');
            // $request['image'] = $image_upload_path;

            $data = Product::create(
                ['name'=> $request->name, 'code'=> $request->code, 'image'=> $image_upload_path]
            );
            return response()->json([
            'data'=>$data,
            'success'=>true]);
          }
          else {
        return response()->json([
            'data'=>"Please select image first.",
            'success'=>false,400
        ]);
          }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
                return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
         $product->update($request->all());
       return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
         $product->destroy($product->id);
        return null;
    }


}
