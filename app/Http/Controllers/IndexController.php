<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $productAll = Product::latest()->get();
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
//        $categories = json_decode(json_encode($categories));
        $categories_menu = "";
////        echo "<pre>";print_r($categories);die;
//        foreach ($categories as $category) {
//            $categories_menu .= '
//                <div class="panel-heading">
//                    <h4 class="panel-title">
//                       <a data-toggle="collapse" data-parent="#accordian" href="#'.$category->id.'">
//                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
//                            '.$category->name.'
//                       </a>
//                    </h4>
//                </div>
//                <div id="'.$category->id.'" class="panel-collapse collapse">
//                    <div class="panel-body">
//                       <ul>';
//                        $sub_categories = Category::where(['parent_id'=>$category->id])->get();
//                        foreach ($sub_categories as $sub_cat){
//                            $categories_menu .= '<li><a href="#">'.$sub_cat->name.' </a></li>';
//                        }
//                        $categories_menu .= '
//                        </ul>
//                    </div>
//                </div>';
//        }
        return view('index')->with(compact('productAll','categories_menu','categories'));
    }
}
