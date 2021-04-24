<?php

namespace App\Http\Controllers;

use App\Models\Client as ModelsClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ModelsClient::all();
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

        return ModelsClient::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(ModelsClient $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsClient $client)
    {
        $validator = Validator::make($request->all(),$this->rules());
        if($validator->fails()){
            return response()->json($validator->errors(), 412);
        }
        $client->update($request->all());
        return $client;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsClient $client)
    {
        if(!$client->delete()){
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
            'name' => 'string|max:80',
            'email' => 'unique:clients|email',
            'phone' => 'numeric'
        ];
    }
}
