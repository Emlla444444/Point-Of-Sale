<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //validation
    private function validationCategory($request) {
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name,'.$request->id
        ]);
    }
    //category list
    public function list() {
        $categories = Category::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%');
        }) //use query to work duet outside of the function
        ->Orderby('created_at','desc')->paginate(5);
        $categoryCount = $categories->toArray();
        $categoryCount = count($categoryCount['data']);

        return view('admin.category.list',compact('categories','categoryCount'));
    }

    // category create
    public function create(Request $request) {
        $this->validationCategory($request);

        Category::create(['name'=>$request->categoryName]);

        return back()->with(['success'=>'item created!']);
    }

    //category delete
    public function deleteCategory($id){
        Category::destroy($id);
        return back();
    }

    //category edit
    public function editCategory($id) {
        $data = Category::find($id);
        return view('admin.category.edit',compact('data'));
    }

    //category update['id'->from request/ $id->url]
    public function updateCategory($id,Request $request) {
        $this->validationCategory($request);
        Category::where('id',$id)->update([
            'name'=>$request->categoryName
        ]);
        return back()->with(['update'=>'updated successfully']);
    }
}
