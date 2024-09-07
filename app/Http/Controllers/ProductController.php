<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'description' => 'required|string',
            'category' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png|image|max:1024',
            'status' => 'required|boolean',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the new product using the validated data
        $formfields = [
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
        ];

        // The image function below, helps save images in the project and nit the local storage

        $image = uniqid() . '-' . 'product-image' . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $image);

        $formfields['image'] = $image;


        $product = Product::create($formfields);  // Create and save the product to the database

        if (!$product){
            return response()->json(['errors' => "Product creation failed"], 403);
        }else {
            return response()->json(['message' => "Product created successfully", "data"=>$product], 201);
        }

        // // Save the product to the database
        // $product->save();

        // // Return a successful response
        // return response()->json(['message' => 'Product added successfully!', 'product' => $product], 201);
    }

    public function allProducts(){
        $products = Product::all();
        if(!$products){
            return response()->json(['errors' => "Product creation failed"]);
        }
        return response()->json(['message' => "Product fetched successfully", "data"=>$products], 200);
    }


    public function updateProduct(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'description' => 'required|string',
            'category' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png|image|max:1024',
            'status' => 'required|boolean',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the new product using the validated data
        $formfields = [
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
            'image' => $request->image
        ];

        // The image function below, helps save images in the project and nit the local storage

        $image = uniqid() . '-' . 'product-image' . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $image);

        $formfields['image'] = $image;


        $product = Product::where('id', $id)->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
            'image' => $request->image
        ]);  // Create and save the product to the database

        if (!$product){
            return response()->json(['errors' => "Product update failed"], 400);
        }else {
            return response()->json(['message' => "Product update successfully", "data"=>$product], 201);
        }
    }

    public function deleteProduct($id){
        $deleteProduct = Product::where('id', $id)->delete();
        // if (!$deleteProduct){
        //         return response()->json(['errors' => "Product delete failed"]);
        //     }
                return response()->json(['message' => "Product deleted successfully"]);

        }



}
