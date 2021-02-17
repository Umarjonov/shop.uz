<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
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
                'price'         =>  'required'
            ]);
            $product = new Product();
            $product->fill($validatedData);
            if ($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
//                    $filename = rand(111,99999).'.'.$extension;
                    $filename = time().'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    //Resize images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    //Store image name in products table
                    $product->image = $filename;
                }
            }
            $product->save();
//            return redirect()->back()->with('flash_message_success','Product has been added');
            return redirect('/admin/view-products')->with('flash_message_success','Product has been added');

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

    public function editProduct(Request $request, $id=null)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            $validatedData = $request->validate([
                'category_id'   =>  'required',
                'product_name'  =>  'required',
                'product_code'  =>  'required',
                'product_color' =>  'required',
                'description'   =>  '',
                'price'         =>  'required'
            ]);
            Product::where(['id'=>$id])->update($validatedData);
            if ($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
//                    $filename = rand(111,99999).'.'.$extension;
                    $filename = time().'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    //Resize images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    //Store image name in products table
                    Product::where(['id'=>$id])->update(['image'=>$filename]);
                }
            }
            return redirect()->back()->with('flash_message_success','Product has been updated successfull!');
        }
        $productDetails = Product::where(['id'=>$id])->first();

        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cat){
            if ( $cat->id == $productDetails->category_id ){
                $selected = 'selected';
            }else{
                $selected = '';
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat){
                if ( $sub_cat->id == $productDetails->category_id ){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                $categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }

    public function viewProducts()
    {
        $products = Product::get();
        foreach ($products as $key => $val ){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProduct($id = null)
    {
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted successfull!');
    }

    public function deleteProductImage($id = null)
    {
        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success','Product has been deleted successfull!');
    }

    public function addAttributes(Request $request, $id=null)
    {
        $productDetails = Product::findOrFail($id)->first();
        if ($request->isMethod('post')){
            $data = $request->all();
            print_r($data);die;
        }
        return view('admin.products.add_attribute')->with(compact('productDetails'));
    }

}
