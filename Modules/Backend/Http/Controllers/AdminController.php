<?php
namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DateTime;
use Modules\Backend\Http\Requests\AdminRequest;
use Modules\Backend\Entities\Admin;
use Modules\Backend\Entities\Roles;
class AdminController extends BaseController
{
    public function __construct(){
        parent::__construct();
    }
    public function index()
    {
        $data['admin'] = Admin::paginate(12);

        $data['users'] = 'admin';
        return view('backend::admin.index', $data);
    }
    public function create()
    {
        $data['roles'] = Roles::all();
        return view('backend::admin.create', $data);
    }
    public function store(AdminRequest $request)
    {
        if ($request->isMethod('post')) {
            try {
                \DB::beginTransaction();
                $roles = $request->input('roles',[]);
                $data = array(
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => encrypt($request->password),
                    'avatar'        => $request->avatar,
                    'background'    => $request->background,
                    'status'        => $request->status,
                    'created_at'    => new DateTime(),
                );
                $admin_create = Admin::create($data);
                // $admin_create->roles()->attach($request->roles);
                if ($admin_create){
                    foreach ($roles as $role) {
                        \DB::table('admin_roles')->insert(array(
                            'admin_id' => $admin_create->id,
                            'roles_id'  => $role
                        ));
                    }
                }
                \DB::commit();
                return redirect()->route('index.admin')->with('success', 'Nó đã làm việc, Tạo mới quản trị thành công!');
            } catch (\Exception $e) {
                \DB::rollBack();
                return redirect()->route('index.admin')->with('error', 'Đã có lỗi sảy ra, Tạo mới quản trị không thành công!');
            }
        }
    }
    public function show($id)
    {
        return view('backend::show');
    }
    public function edit($id)
    {
        $id = (int)$id;
        if (is_numeric($id) && Admin::find($id)) {
            $data['lsRoleofAdmin'] = \DB::table('admin_roles')->where('admin_id',$id)->pluck('roles_id');
            // dd($data['lsRoleofAdmin']);
            //Pluck tips here thằng ml
            //'https://stackoverflow.com/questions/34405138/laravel-5-2-pluck-method-returns-array'
            //--Method contains dùng để kiểm tra nếu một collection chứa giá trị nhất định. Nó sẽ trả về true
            $data['roles'] = Roles::all();
            $data['edit'] = Admin::findOrFail($id);
            // $data['role_admin'] = \DB::table('role_admin')::all();
            return view('backend::admin.edit', $data);
        } else {
            return redirect()->route('index.admin')->with('error','bạn đang cố tìm kiếm '. $id .' không tồn tại dữ liệu');
        }
    }
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if ($request->isMethod('post')) {
            if (is_numeric($id) && Admin::find($id)) {
                try {
                    //get array roles input request
                    $roles = $request->input('roles',[]);
                    
                    //get and find $id exsist admin
                    $admin_update = Admin::find($id);

                    \DB::beginTransaction();
                    $data = array(
                        'name'          => $request->name,
                        'avatar'        => $request->avatar,
                        'background'    => $request->background,
                        'status'        => $request->status,
                        'updated_at'    => new DateTime(),
                    );
                    if ($admin_update->update($data)){
                        \DB::table('admin_roles')->where('admin_id', $id)->delete();
                        Admin::find($id)->roles()->attach($roles);
                        // foreach ($roles as $role) {
                        //     \DB::table('role_admin')->insert(array(
                        //         'admin_id' => $admin_update->id,
                        //         'role_id'  => $role
                        //     ));
                        // }
                    }
                    \DB::commit();
                    return redirect()->route('index.admin')->with('success', 'Làm việc, Cập nhập thành công!');
                } catch (\Throwable $th) {
                    \DB::rollBack();
                    // return redirect()->route('index.admin')->with('error', 'Đã có lỗi sảy ra, Cập nhập thông tin không thành công!');
                }
            } else {
                return redirect()->route('index.admin')->with('error','đang cố cập nhật '. $id .' không tồn tại dữ liệu');
            }
        }
    }
    public function destroy($id)
    {
        $id = (int)$id;
        $result = Admin::find($id);

        if (is_numeric($id) && $result){
            \DB::beginTransaction();
            if ($result){
                $result->roles()->detach();
                // foreach ($roles as $role) {
                //     \DB::table('admin_roles')->delete(array(
                //         'admin_id' => $admin_create->id,
                //         'roles_id'  => $role
                //     ));
                // }
            }
            if ($result->delete()){
                \DB::commit();
                return redirect()->back()->with('success','Xóa thành công.');
            } else {
                \DB::rollBack();
                return redirect()->back()->with('error','Xóa thất bại.');
            }
        } else {
            return redirect()->back()->with('error','Không tìm thấy bài viết cần xóa.');
        }
    }
}
