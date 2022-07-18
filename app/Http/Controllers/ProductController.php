<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function input(Request $request){
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:100',
            'product_type' => 'required|in:snack,drink,makeup,drugs',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag())->setStatusCode(422);
        }

        $validated = $validator->validated();

        Product::create([
            'product_name' => $validated['product_name'],
            'product_type' => $validated['product_type'],
            'product_price' => $validated['product_price'],
            'expired_at' => $validated['expired_at']
        ]);

        return response()->json('Produk Berhasil disimpan')->setStatusCode(201);
    }

    public function showAll(){
        $products = Product::all();

        return response()->json($products)->setStatusCode(200);   
    }

    public function showById($id){
        $products = Product::firstWhere('id',$id);

        if(!$products){
            return response()->json([
                'Messages' => "Data dengan" . $id . "Tidak ditemukan",
            ])->setStatusCode(200);
        }
        return response()->json([
            'Messages' => "Data ditemukan",
            'product' => $products
        ])->setStatusCode(200);

    }

    public function showByName($product_name){
        $products = Product::firstWhere('product_name',$product_name);

        if(!$products){
            return response()->json([
                'Messages' => "Data dengan nama " . $product_name . "Tidak ditemukan",
            ])->setStatusCode(200);
        }
        return response()->json([
            'Messages' => "Data ditemukan",
            'product' => $products
        ])->setStatusCode(200);

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:100',
            'product_type' => 'required|in:snack,drink,makeup,drugs',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag())->setStatusCode(422);
        }

        $validated = $validator->validated();

        $checkData = Product::find($id);

        if($checkData){
            Product::where('id', $id)->update([
                'product_name' => $validated['product_name'],
                'product_type' => $validated['product_type'],
                'product_price' => $validated['product_price'],
                'expired_at' => $validated['expired_at']
            ]);

            return response()->json([
                'Messages' => 'Data Product Berhasil diupdate'
            ])->setStatusCode(201);
        }

        return response()->json([
            'Messages' => 'Data product tidak ditemukan'
        ])->setStatusCode(401);
    }

    public function delete($id){
        $checkData = Product::find($id);

        if($checkData){

            Product::destroy($id);
            
            return response()->json([
                'Messages' => 'Data Product Berhasil dihapus'
            ])->setStatusCode(201);
        }

        return response()->json([
            'Messages' => 'Data product tidak ditemukan'
        ])->setStatusCode(401);
    }
}
