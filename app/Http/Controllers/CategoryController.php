<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();

            $category = new Category();
            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->save();

            return redirect('/admin/view-categories')->with('flash_message_success','Category added Successfully!');
        }
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function editCategory(Request $request, $id = null)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            Category::find($id)->update([
               'name'       =>$data['category_name'],
               'parent_id'  =>$data['parent_id'],
               'description'=>$data['description'],
               'url'        =>$data['url']
            ]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category updated Successfully!');
        }
        $categoryDetails = Category::find($id)->first();
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.edit_category')->with(compact('categoryDetails','levels'));
    }

    public function deleteCategory($id = null)
    {
        if (!empty($id)){
            Category::find($id)->delete();
            return redirect()->back()->with('flash_message_success','Category deleted Successfully!');
        }
    }

    public function viewCategories(Request $request)
    {
        $categories = Category::get();
        return view('admin.categories.view_categories')->with(compact('categories'));
    }
}
