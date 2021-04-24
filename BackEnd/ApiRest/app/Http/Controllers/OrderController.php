<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order as ModelsOrder;
use App\Models\Product;
use App\Models\ProductByOrder;
use App\Models\Seller;
use App\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ModelsOrder::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules($request));

        if($validator->fails()){
            return response()->json($validator->errors(), 412);
        }

        $client = Client::find($request->input('client.id')) ?: Client::create($request->get('client'));
        $seller = Seller::find($request->input('seller.id')) ?: Seller::create($request->get('seller'));

        $order = ModelsOrder::create([
            'client_id' => $client->id, 
            'seller_id' => $seller->id,
            'status_id' => 1
        ]);

        $request->offsetSet('order_id', $order->id);

        $productsFail = collect();
        foreach ($request->input('products') as $value) {
            $product = Product::find(Arr::get($value,'id')) ?: Product::create(Arr::add($value, 'status_id', 2));
            if(!$product->status->ifThere()){
                $productsFail->add([
                    'message' => $product->name.' out of stock or inactive.',
                    'product' => $product
                ]);
            }else{
                $request->offsetSet('product_id', $product->id);
                $request->offsetSet('amount', Arr::get($value, 'amount', 1));
                (new ProductByOrderController())->store($request);
            }
        }

        if(!$productsFail->isEmpty()){
            return response()->json([
                'messages'=>$productsFail,
                'order'=>$this->show($order)
            ]);
        }
        
        return $this->show($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(ModelsOrder $order)
    {
        $order->refresh();
        return $order
            ->setHidden(['client_id', 'seller_id', 'status_id'])
            ->load(['client', 'seller', 'status', 'products']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsOrder $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsOrder $order)
    {
        //
    }

    public function cancel(ModelsOrder $order){
        $success = $order->cancel();
        return response()->json([
            'success'=>$success,
            'message'=>$success?'Orden cancelada':'No se pudo cancelar la orden'
        ]);
    }

    public function finish(ModelsOrder $order){
        $success = $order->close();
        return response()->json([
            'success'=>$success,
            'message'=>$success?'Orden finalizada':'No se pudo finalizar la orden'
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'client.id' => ['exists:clients,id'],
            '*.name' => ['string', 'max:80'],
            '*.email' => ['email'],
            '*.phone' => ['numeric'],
            'seller.id' => ['exists:seller,id'],
            'products.*.id' => ['exists:products,id'],
            'products.*.name' => ['max:80'],
            'products.*.description' => ['max:180'],
            'products.*.value' => ['numeric'],
        ];

        if(!Arr::has($request->client, 'id')){
            $rules['client.name'][]='required';
            $rules['client.email'][]='required';
            $rules['client.phone'][]='required';
        }

        if(!Arr::has($request->seller, 'id')){
            $rules['seller.name'][]='required';
            $rules['seller.email'][]='required';
            $rules['seller.phone'][]='required';
        }

        foreach ($request->products ?: [] as $key => $product) {
            if(!Arr::has($product, 'id')){
                $rules['products.'.$key.'.name'] = ['required'];
                $rules['products.'.$key.'.description'] = ['required'];
                $rules['products.'.$key.'.value'] = ['required'];
            }
        }

        return $rules;
    }
}
