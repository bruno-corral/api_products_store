<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(): JsonResponse
    {
        $products = $this->product->all();

        if (!$products) {
            $response = [
                'error' => true,
                'message' => 'No products found!'
            ];

            return response()->json(['data' => $response]);
        }

        return response()->json(['products' => $products]);
    }

    public function findOne(Request $request): JsonResponse
    {
        $product = $this->product->find($request->id);

        if (!$product) {
            $response = [
                'error' => true,
                'message' => 'No product was found with the id '.$request->id.'.'
            ];

            return response()->json($response);
        }

        return response()->json(['product' => $product]);
    }

    public function create(CreateProductRequest $request): JsonResponse
    {
        $data = $request->only(['description', 'quantity', 'price', 'user_id']);

        $product = $this->product->create($data);

        $response = [
            'error' => false,
            'product' => $product
        ];

        return response()->json($response);
    }

    public function update(CreateProductRequest $request): JsonResponse
    {
        $data = $request->only(['description', 'quantity', 'price']);

        $product = $this->product->find($request->id);

        if (!$product) {
            return response()->json([
                'error' => true,
                'message' => 'The product with the id '.$request->id.' was not found!'
            ]);
        }

        $product->update($data);
        $product->save();

        $response = [
            'error' => false,
            'message' => 'Product has been updated successfully!',
            'product' => $product
        ];

        return response()->json(['data' => $response]);
    }

    public function delete(Request $request): JsonResponse
    {
        $product = $this->product->find($request->id);

        if (!$product) {
            return response()->json([
                'error' => true,
                'message' => 'The product was not deleted because the id '.$request->id.' was not found!'
            ]);
        }

        $product->delete();

        $response = [
            'error' => false,
            'message' => 'The product with the id '.$request->id.' has been deleted successfully!',
            'product' => $product
        ];

        return response()->json($response);
    }
}
