<?php

namespace App\Http\Controllers;

use App\Models\ProductByOrder as ModelsProductByOrder;
use App\ProductByOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductByOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $validator = Validator::make($request->all(),$this->rules());
        if($validator->fails()){
            return response()->json($validator->errors(), 412);
        }
        ModelsProductByOrder::create($request->only(['order_id', 'product_id', 'amount']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductByOrder  $productByOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ProductByOrder $productByOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductByOrder  $productByOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductByOrder $productByOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductByOrder  $productByOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductByOrder $productByOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductByOrder  $productByOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductByOrder $productByOrder)
    {
        //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => 'required|numeric|exists:orders,id',
            'product_id' => 'required|numeric|exists:products,id',
            'amount' => 'required|numeric'
        ];
    }
}
