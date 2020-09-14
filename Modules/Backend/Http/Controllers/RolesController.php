<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Backend\Entities\Roles;
use Modules\Backend\Entities\Permissions;
use App, DateTime;
class RolesController extends BaseController
{
    private $roles, $permissions;
    public function __construct(Roles $roles, Permissions $permissions){
        parent::__construct();
        $this->roles = $roles;
        $this->permissions = $permissions;
    }
    public function index(Request $request)
    {
        $data['roles'] = Roles::paginate(12);

        $action = $request->action;
        $checkbox = $request->input('checkbox',[]);
        
        if ($action){
            \DB::beginTransaction();
            if ($action == 'delete'){
                $result = \DB::table('roles')->whereIn("id",$checkbox)->delete();
                if ($result){
                    \DB::commit();
                    return redirect()->back()->with('success', 'Làm việc, Xóa thành công!');
                } else {
                    \DB::rollBack();
                    return redirect()->back()->with('error', 'Lỗi, Xóa không thành công!');
                }
            }
            elseif ($action == 'public') {
                $result = \DB::table('roles')->whereIn("id",$checkbox)->update(array('status'=> 1 ));
                if ($result){
                    \DB::commit();
                    return redirect()->back()->with('success', 'Làm việc, Xuất bản thành công!');
                } else {
                    \DB::rollBack();
                    return redirect()->back()->with('error', 'Lỗi, Xuất bản không thành công!');
                }
            } elseif ($action == 'sleep') {
                $result = \DB::table('roles')->whereIn("id",$checkbox)->update(array('status'=> 0 ));
                if ($result){
                    \DB::commit();
                    return redirect()->back()->with('success', 'Làm việc, Ẩn thành công!');
                } else {
                    \DB::rollBack();
                    return redirect()->back()->with('error', 'Lỗi, Ẩn không thành công!');
                }
            } else {
                return redirect()->back()->with('warning', 'Hãy chọn một hành động để thực hiện công việc!');
            }
        }
        return view('backend::roles.index', $data);
    }

    public function create()
    {
        $data['roles']          = 'Roles';
        $data['permissions']    = $this->permissions->all();
        return view('backend::roles.create', $data);
    }
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $permission = $request->input('permission',[]);
            try {
                \DB::beginTransaction();
                $data = array(
                    'name'          => $request->name,
                    'display_name'  => $request->display_name
                );
                $rolesCreate = $this->roles->create($data);
                if ($rolesCreate){
                    $rolesCreate->permissions()->attach($permission);
                }
                \DB::commit();
                return redirect()->route('index.posts')->with('success', 'Nó đã làm việc, Đăng bài thành công!');
            } catch (\Throwable $th) {
                \DB::rollBack();
                dd($th->getMessage(),$th->getLine());
                return redirect()->route('index.posts')->with('error', 'Đã có lỗi sảy ra, Đăng bài không thành công!');
            }
        }
    }

    public function show($id)
    {
        return view('backend::show');
    }
    public function edit($id)
    {
        $data['roles']          = 'Roles';
        $data['lsRole']         = \DB::table('permission_role')->where('roles_id',$id)->pluck('permissions_id');
        // dd($data['lsRole']);
        $data['permissions']    = Permissions::all();
        $data['edit']           = Roles::where('id',$id)->first();
        return view('backend::roles.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        $result = $this->roles->find($id);
        if(is_numeric($id) && $result){
            try {
                \DB::beginTransaction();
                $permission = $request->input('permission',[]);
                $data = array(
                    'name'          =>  $request->name,
                    'display_name'  =>  $request->display_name  
                );
                if($result->update($data)){
                    \DB::table('permission_role')->where('roles_id', $id)->delete();
                    $result->permissions()->attach($permission);
                    \DB::commit();
                }
                return redirect()->route('index.roles')->with('success', 'Cập nhật Roles thành công!');
            } catch (\Throwable $th) {
                //throw $th;
                dd($th->getMessage());
                \DB::rollback();
                return redirect()->route('index.roles')->with('error', 'Cập nhật Roles không thành công!');
            }
        }
    }
    public function destroy($id)
    {
        //
        $id = (int)$id;
        $result = Posts::find($id);

        if (is_numeric($id) && $result){
            $result_translations = PostsTranslation::where('posts_id',$id);
            
            if ($result->delete() && $result_translations->delete()){
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
