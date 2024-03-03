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
use App\Http\Resources\V1\SaleProductResource;

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
            $validator = Validator::make($request->all(), [
                'products' => 'required|array',
                'products.*.product_id' => 'required',
                'products.*.amount' => 'required|numeric|between:0,100',
            ]);

            if ($validator->fails()) {
                return $this->error('Dados inválidos',422,$validator->errors());
            }

            $productsData = $validator->validated()['products'];

            $createdSaleProducts = [];

            foreach ($productsData as $productData) {

                $product = Product::find($productData['product_id']);
                if (!$product) {
                    return $this->error('Produto não encontrado', 404, []);
                }
        
                $productData['price'] = $product->price;
                $saleId = Sale::create([])->id;
                $productData['sale_id'] = $saleId;
                $saleProduct = SaleProduct::create($productData);

                $createdSaleProducts[] = $saleProduct;
            }

            return $this->response('Vendas realizadas com sucesso', 200, SaleProductResource::collection($createdSaleProducts));

        } catch (\Exception $e) {
            return $this->error($e->getMessage(),400,[]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $int)
    {
        $sale = Sale::find($int);
        if (!$sale) {
            return $this->error('Venda não encontrada',404,[]);
        }
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
