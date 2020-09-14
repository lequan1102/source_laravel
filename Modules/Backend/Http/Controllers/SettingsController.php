<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App, DateTime;
use Modules\Backend\Entities\Settings;
use Modules\Backend\Entities\SettingsGroup;

class SettingsController extends BaseController
{
    private $setting;
    private $setting_group;
    public function __construct(Settings $caidat, SettingsGroup $nhom_caidat){
        parent::__construct();

        $this->setting         = $caidat;
        $this->setting_group   = $nhom_caidat;
        // $data['settings'] = 'settings';
    }


    public function index()
    {
        $data['settings']               = 'settings';
        $data['settings_group']         = $this->setting_group->all();
        // $this->basic();

        // $this->advanced();

        // $this->developers();

        return view('backend::settings.index', $data);
    }

    public function basic(Request $request)
    {

    }
    public function store_basic(Request $request)
    {
        if ($request->isMethod('post')) {
            \DB::beginTransaction();
            $basic = array(
                // Cơ bản
                'logo'                  => $request->input('logo'),
                'title_web'             => $request->input('title_web'),
                'email'                 => $request->input('email'),
                'phone'                 => $request->input('phone'),
                'location'              => $request->input('location'),

                // Mạng xã hội
                'facebook'              => $request->input('facebook'),
                'twitter'               => $request->input('twitter'),
                'instargam'             => $request->input('instargam'),
                'youtube'               => $request->input('youtube'),

                // Các trường tùy chỉnh
            );
            $result_basic = json_encode($basic);

            if ($this->setting->create($basic)){
                \DB::commit();
                return redirect()->route('index.settings')->with('success', 'Nó đã làm việc!');
            } else {
                \DB::rollBack();
                return redirect()->route('index.settings')->with('error', 'Đã có lỗi sảy ra!');
            }
        }
    }
    public function advanced()
    {

    }
    public function developers()
    {

    }

    /*
    * Tạo mới trường cài đặt
    *
    */
    public function create_field(Request $request)
    {
        if ($request->method('post')) {
            \DB::beginTransaction();

            //nếu group đã tồn tại
            if(!$this->setting::where('group_name', $request->input('group_name'))->first()){
                $this->setting_group->create([
                    'name'      =>  $request->input('group_name')
                ]);
            }
            
            $data = array(
                'key'                   =>      $request->input('key'),
                'label'                 =>      $request->input('label'),
                'type'                  =>      $request->input('type'),
                'group_name'            =>      $request->input('group_name'),
                'property'              =>      $request->input('property'),
                'element_placeholder'   =>      $request->input('element_placeholder')
            );
            if($this->setting->create($data)) {
                // dd($request); die;   
                \DB::commit();
                return redirect()->route('index.settings')->with('success', 'Thêm mới trường thành công!');
            } else {
                return redirect()->route('index.settings')->with('error', 'Thêm mới trường thất bại!');
                \DB::rollBack();
            }
        }
    }
}