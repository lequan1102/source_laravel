<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Support\Facades\Input;
use Modules\Backend\Entities\MenuItems;
use Modules\Backend\Entities\Menus;
class MenuController extends BaseController
{
    public function __construct(){
        parent::__construct();
        $data['menus'] = 'menus';
    }
    /**
     * Hiển thị các Menus
     */
    public function index()
    {
        $data['menu'] = Menus::all();

        return view('backend::menu.list_menu', $data);
    }
    /**
     * Hiển thị các mục con của Menus được chọn
     */
     public function menu_items($id)
     {
         $menu = MenuItems::find($id);
         if ($menu) {
           $data['menu'] = MenuItems::all();
           $data['json'] = json_encode(MenuItems::all());
           return view('backend::menu.index',$data);
         }
         return redirect()->back()->with('error', 'ko co menu');
     }
     public function sortMenu(Request $request){

        $data = json_decode($request->reponse,true);
        echo '<pre>';
        print_r($data);
        echo '</pre>';die;
        $i=0;

        foreach($data as $row){
            $i++;
            // $menu = MenuItems::find($row['id']);
            echo '<pre>';
            // print_r($row['id']);
            print_r($row);
            print_r($row['parent_id']);
            echo '</pre>';
            // $menu->parent_id = $row['parent_id'];
            // $menu = MenuItems::save($row['id']);
        }
    }
    public function create()
    {
        return view('backend::create');
    }

    function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('backend::show');
    }

    public function edit($id)
    {
        return view('backend::edit');
    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }
}
