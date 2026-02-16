<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    //product list
    public function list() {
        $products = Product::select('id','name','image','stock','created_at')->orderBy('created_at','desc')->get();
        return view('admin.product.list',compact('products'));
    }

    //product create page
    public function create() {
        $categories = Category::select('id','name')->orderBy('created_at','desc')->get();
        return view('admin.product.create',compact('categories'));
    }

    //product creation
    public function createProduct(Request $request) {
        $this->productValidation($request,'create');
        $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $request->image->move(public_path('productImage/'),$imageName);//store image in pj
        $data = $this->getProductData($request);
        $data['image'] = $imageName;
        Product::create($data);

        return back()->with(['success'=>'product created']);
    }

    //validation check
    private function productValidation($request,$action){
        $data = [
            'image' => $action == 'create' ? 'required|image|mimes:jpg,jpeg,gif,webp,png,svg' : 'image|mimes:jpg,jpeg,gif,webp,png,svg' ,
            'title' => 'required|min:3|max:100|unique:products,name,'.$request->id ,
            'price' => 'required|min:2|integer' ,
            'description' => 'required|min:10' ,
            'categoryId' => 'required' ,
            'stock' => 'required|integer|min:1' ,
        ];
        $request->validate($data,[
            'categoryId' => 'The category name field is required.'
        ]);
    }

    //delete product
    public function deleteProduct($id) {
        $deleteImage = Product::find($id);
        $deleteImage = $deleteImage['image'];
        if(file_exists(public_path('productImage/'.$deleteImage))){
            unlink(public_path('productImage/'.$deleteImage)); //delete image in pj
        }
        Product::destroy($id); //delete data in db
        return back();
    }

    //edit product
    public function editProduct($id) {
        $product = Product::find($id);
        $categories = Category::select('id','name')->orderBy('created_at','desc')->get();
        return view('admin.product.edit',compact('categories','product'));
    }

    //update product
    public function updateProduct(Request $request,$id) {
        $this->productValidation($request,'update');
        $updateData = $this->getProductData($request);//write upon to avoid overwrite
        if($request->hasFile('image')) {
            if(file_exists(public_path('productImage/'.$request->oldImage))) {
                unlink(public_path('productImage/'.$request->oldImage));//delete old image in pj
            }
            $newImage = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('productImage/'),$newImage);//update new image in pj

            $updateData['image'] = $newImage; // update image name in db
        }
        Product::find($id)->update($updateData);
        return to_route('product#list');
    }

    //product data
    private function getProductData($request) {
        return [
            'name' => $request->title ,
            'price' => $request->price ,
            'description' => $request->description ,
            'category_id' => $request->categoryId ,
            'stock' => $request->stock ,
        ];
    }

    //product detail
    public function detailProduct($id) {
        $product = Product::find($id);
        $categories = Category::select('id','name')->orderBy('created_at','desc')->get();
        return view('admin.product.detail',compact('product','categories'));
    }
}
