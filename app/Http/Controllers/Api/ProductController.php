<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function index()
    {
        $products = $this->product->paginate(15);

        // return response()->json($products);

        return new ProductCollection($products);
    }

    public function get($id)
    {
        $product = $this->product->find($id);

        // return response()->json($product);

        return new ProductResource($product);

    }

    public function save(Request $request)
    {
        $data = $request->all();

        $product = $this->product->create($data);

        return response()->json($product);
    }

    public function update(Request $request, Product $id)
    {

        $id->name = $request->name;
        $id->price = $request->price;
        $id->description = $request->description;
        $id->slug = $request->slug;
        $id->save();

        return response()->json($id);
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();

        return response()->json([
            'data' => [
                'msg' => 'Produto removido com sucesso'
            ]
        ]);
    }
}
