<?php

namespace App\Http\Controllers;

use App\Models\Product as ModelsProduct;
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
        return ModelsProduct::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->offsetSet('status_id', $request->offsetGet('status_id') ?: 2);

        $validator = Validator::make($request->all(),$this->rules());

        if($validator->fails()){
            return response()->json($validator->errors(), 412);
        }

        return ModelsProduct::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(ModelsProduct $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsProduct $product)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if($validator->fails()){
            return response()->json($validator->errors(), 412);
        }
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsProduct $product)
    {
        if(!$product->delete()){
            return response()->json([
                'success' => false,
                'message' => 'Record could not be deleted.'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Record deleted.'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:80',
            'description' => 'required|max:180',
            'value' => 'required|numeric',
            'status_id' => 'numeric|exists:product_statuses,id'
        ];
    }
}
