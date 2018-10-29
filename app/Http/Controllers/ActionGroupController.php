<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ActionGroup;
use App\Models\Permission;
use App\Libs\CommonLib;

class ActionGroupController extends Controller
{
    /**
     * Function show list role of company
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $user = Auth::user();
        $listData = ActionGroup::get();
        return view('action_group/index', [
            'listData' => $listData,
            
        ]);
    }

    /**
     * Function add role
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $user = Auth::user();
        $permissionDB = Permission::orderBy('order')->get();
        $listPermission = array();
        if (!empty($permissionDB)) {
            foreach ($permissionDB as $key => $value) {
                $listPermission[$value->module_name][$value->controller_name][$value->action_name] = $value;
            }
        }
        $post = $request->post();
        $error = '';
        if (!empty($post)) {
            $validation = Validator::make($post, [
                'name' => 'required',
                'description' => 'nullable',
            ]);
            if (!$validation->fails()) {
                $insert = array(
                    'name' => $post['name'],
                    'description' => !empty($post['description']) ? $post['description'] : '',
                    'action' => json_encode($post['action'])
                );
                $insertId = ActionGroup::insertGetId($insert);
                if (!empty($insertId)) {
                    return redirect(route('ActionGroup_index', []))->with('status',
                        json_encode(array('success' => true, 'message' => 'Thêm mới nhóm quyền thành công.')));
                } else {
                    $error = 'Có lỗi trong quá trình thêm mới nhóm quyền. Mời bạn thử lại sau';
                }
            } else {
                $error = CommonLib::getValidationError($validation);
            }
        }
        return view('action_group/add', [
            'listPermission' => $listPermission,
            'pageTitle' => 'Thêm nhóm quyền',
            'error' => $error,
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        
        $user = Auth::user();
        $role = ActionGroup::where('id', $id)->first();

        if (!empty($role)) {
            $permissionDB = Permission::orderBy('order')->get();
            $listPermission = array();
            if (!empty($permissionDB)) {
                foreach ($permissionDB as $key => $value) {
                    $listPermission[$value->module_name][$value->controller_name][$value->action_name] = $value;
                }
            }
            $post = $request->post();
            $error = '';
            if (!empty($post)) {
                $validation = Validator::make($post, [
                    'name' => 'required',
                    'description' => 'nullable'
                ]);
                if (!$validation->fails()) {
                    $update = array(
                        'name' => $post['name'],
                        'description' => !empty($post['description']) ? $post['description'] : '',
                        'action' => json_encode($post['action'])
                    );
                    ActionGroup::where('id', $id)->update($update);
                    return redirect(route('ActionGroup_index', []))->with('status',
                        json_encode(array('success' => true, 'message' => 'Sửa nhóm quyền thành công.')));
                } else {
                    $error = CommonLib::getValidationError($validation);
                }
            } else {
                $post = json_decode(json_encode($role), 1);
                $post['action'] = json_decode($role->action, 1);
            }
            return view('action_group/add', [
                'listPermission' => $listPermission,
                'pageTitle' => 'Sửa nhóm quyền',
                'error' => $error,
                'post' => $post
            ]);
        } else {
            return redirect(route('ActionGroup_index', []))->with('status',
                json_encode(array('success' => false, 'message' => 'Nhóm action không tồn tại hoặc bạn không có quyền quản lý nhóm quyền này.')));
        }
    }


    public function delete(Request $request, $id)
    {
        $user = Auth::user();
        $role = ActionGroup::where('id', $id)->first();
        if (!empty($role)) {
            ActionGroup::where('id', $id)->delete();
            return redirect(route('ActionGroup_index', []))->with('status',
                json_encode(array('success' => true, 'message' => 'Xóa nhóm quyền thành công.')));
        } else {
            return redirect(route('ActionGroup_index', []))->with('status',
                json_encode(array('success' => false, 'message' => 'Nhóm quyền không tồn tại hoặc bạn không có quyền quản lý nhóm quyền này.')));
        }
    }
}
