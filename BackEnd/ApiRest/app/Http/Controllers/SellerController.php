<?php

namespace App\Http\Controllers;

use App\Models\Seller as ModelsSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ModelsSeller::all();
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

        return ModelsSeller::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(ModelsSeller $seller)
    {
        return $seller;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsSeller $seller)
    {
        $validator = Validator::make($request->all(),$this->rules());
        if($validator->fails()){
            return response()->json($validator->errors(), 412);
        }
        $seller->update($request->all());
        return $seller;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsSeller $seller)
    {
        if(!$seller->delete()){
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
            'name' => 'max:80',
            'email' => 'unique:clients|email',
            'phone' => 'numeric'
        ];
    }
}
