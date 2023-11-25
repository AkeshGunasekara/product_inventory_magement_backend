<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $authUser;

    public function __construct()
    {
        // $this->authUser = Auth::user()->id;
    }

    public function index()
    {
        try {
            Log::info(__METHOD__.' auth user --> '.$this->authUser);
            $products = Product::all();
            return response()->json(['products' => $products], 200);
        } catch (\Throwable $th) {
           $this->handleException($th);
           return response()->json(['message' => 'An error occurred while fetching products.'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           
            // Log::info(__METHOD__.' auth user --> '.$this->authUser);
            $newProduct = Product::create([
                'ref' => Product::generateRef(),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'qty' => $request->input('qty'),
                'created_by' => 1//$this->authUser,
            ]);
            return response()->json(['message' => 'Product created successfully'], 201);
        } catch (\Throwable $th) {
        $this->handleException($th);
        return response()->json(['message' => 'An error occurred while creating the product.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try {
            Log::info(__METHOD__.' auth user --> ');
            if (!$product) {
                return response()->json(['message' => 'Product not found.'], 404);
            }
            return response()->json(['product' => $product], 200);
        } catch (\Throwable $th) {
            $this->handleException($th);
            return response()->json(['message' => 'An error occurred while fetching the product.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            Log::info(__METHOD__.' auth user --> '.$this->authUser);

            // Validate the request data
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'qty' => 'required|integer',
            ]);

            // Update the product
            $product->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'qty' => $request->input('qty'),
                'updated_by' => $this->authUser,
            ]);
            return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
        } catch (\Throwable $th) {
            $this->handleException($th);
            return response()->json(['message' => 'An error occurred while updating the product.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            Log::info(__METHOD__.' auth user --> '.$this->authUser);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Throwable $th) {
            $this->handleException($th);
            return response()->json(['message' => 'An error occurred while deleting the product.'], 500);
        }
    }

    public function handleException($th){
        Log::error(
            __METHOD__.
            ' error: '.$th->getMessage().
            ' line: '.$th->getLine().
            ' file: '.$th->getFile().
            ' code: '.$th->getCode().
            ' auth: '.$this->authUser
        );
    }
}
