<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\Backend\Entities\Products;

class ProductsController extends Controller
{
    public function __construct()
    {
      parent::__construct();
    }
    //Hiển thị sản phẩm
    public function index($slug, $id){
      $result = $data['products'] = Products::where('slug',$slug)->where('id',$id)->first();
      if($result){
        $result;
      } else {
        return redirect('404');
      }
      return view('products.index', $data);
    }
}
