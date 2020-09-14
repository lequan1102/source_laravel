<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\Backend\Entities\Category;
use Modules\Backend\Entities\Products;

class IndexController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    //Chuyên mục
    $data['category_banner'] = Category::orderBy('id','DESC')->whereIn('id', [5, 6, 10])->limit(3)->get();

    /**
     * Các sản Phẩm
     * 1. Phụ nữ
     * 2. Đàn ông
     * 3. Túi
     * 4. Giày
     * 5. Đồng hồ
     */
    $data['products'] = Products::orderBy('id','DESC')->get();

    return view('index', $data);
  }
}