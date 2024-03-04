<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleCancel;
use App\Models\SaleProduct;
use App\Models\Product;
use App\Http\Resources\V1\SaleResource;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    use HttpResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only([
            'store', 'update', 'cancel', 'index'
        ]);
    }
    
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
                return $this->error('Dados inválidos', 422, $validator->errors());
            }
        
            $productsData = $validator->validated()['products'];
        
            $sale = Sale::create([]);
        
            $createdSaleProducts = [];
        
            foreach ($productsData as $productData) {
                $product = Product::find($productData['product_id']);
                if (!$product) {
                    return $this->error('Produto não encontrado', 404, []);
                }
        
                $productData['price'] = $product->price;
                $productData['sale_id'] = $sale->id;
                $saleProduct = SaleProduct::create($productData);
        
                $createdSaleProducts[] = $saleProduct;
            }
        
            return $this->response(
                'Vendas realizadas com sucesso', 
                200, 
                new SaleResource($sale->load('saleProducts.product'))
            );            

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400, []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $sale = Sale::find($id);
        if (!$sale) {
            return $this->error('Venda não encontrada',404,[]);
        }
        return new SaleResource($sale);
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

    /**
     * Atualiza o status da venda para cancelado.
     */
    public function cancel(Request $request, int $id)
    {
        try {
            $sale = Sale::find($id);
            if (!$sale) {
                return $this->error('Venda não encontrada',404,[]);
            }

            $validator = Validator::make($request->all(), [
                'reason' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->error('Dados inválidos', 422, $validator->errors());
            }

            $sale->status = '6';
            $sale->save();

            $saleCancel = SaleCancel::updateOrCreate(
                ['sale_id' => $id],
                ['observation' => $request->input('reason')]
            );            

            return $this->response(
                'Venda cancelada com sucesso', 
                200, 
                $saleCancel
            ); 
        } catch (\Exception $e) {
            return $this->error('Erro ao cancelar a venda: ' . $e->getMessage(), 500, []);
        }
    }

}
