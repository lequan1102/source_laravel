<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\Backend\Entities\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
      parent::__construct();
    }
    //Hiển thị chuyên mục
    public function index($slug, $id){
      $result = $data['category'] = Category::where('slug',$slug)->where('id',$id)->first();
      if($result){
        $result;
      } else {
        return redirect('404');
      }
      return view('category.index', $data);
    }
}
