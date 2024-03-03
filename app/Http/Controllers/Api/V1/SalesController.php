<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Product;
use App\Http\Resources\V1\SaleResource;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('saleProducts.product')->get();
        return SaleResource::collection($sales);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'product_id' => 'required',
                'amount' => 'required|numeric|between:0,100',
            ]);

            if ($validator->fails()) {
                return $this->error('Dados inválidos',422,$validator->errors());
            }

            $validatedData = $validator->validate();

            $product = Product::find($validatedData['product_id']);

            if (!$product) {
                return $this->response('Produto não existe',400,[]);
            }

            $validatedData['price'] = $product->price;
            $validatedData['sale_id'] = Sale::create([])->id;

            $saleProduct = SaleProduct::create($validatedData);

            if ($saleProduct) {
                return $this->response('Venda realizada com sucesso',200,$saleProduct);
            }
            return $this->error('Venda não cadastrada',400,[]);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(),400,[]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return new SaleResource($sale);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'product_id' => 'required',
                'amount' => 'required|numeric|between:0,100',
                'sale_id' => 'required'
            ]);

            $validate = $validator->validate();

            $updated = SaleProduct::find($id)->update([
                'amount' => 555
            ]);

            var_dump($updated);
            exit;

            //$data = SaleProduct->update($request->all());

            //return response()->json(['status' => true, 'contact' => $data],200);
        }catch (\Exception $e){
            return $this->error('Erro ' . $e->getMessage(),500,[]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
