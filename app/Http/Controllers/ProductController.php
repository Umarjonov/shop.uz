<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            $validatedData = $request->validate([
                'category_id'   =>  'required',
                'product_name'  =>  'required',
                'product_code'  =>  'required',
                'product_color' =>  'required',
                'description'   =>  '',
                'price'         =>  'required',
                'image'         =>  ''
            ]);
            $product = new Product();
            $product->fill($validatedData);
            $product->save();
            return redirect()->back()->with('flash_message_success','Product has been added');

        }
        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat){
                $categories_dropdown .= "<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
//        dd($categories_dropdown);
        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }
}
