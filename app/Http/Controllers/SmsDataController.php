<?php

namespace App\Http\Controllers;

use App\Libs\Helpers;
use App\Models\Campaign;
use App\Models\Phone;
use App\Models\SmsCronjob;
use App\Models\SmsData;
use App\Rules\Utf8StringRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class SmsDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SmsData::select('*')->cursor();
        return view('page.phone.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.sms-data.create');
    }

    /**
     * Store a newly created resource in storage.
     *n
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new SmsData();
        $model->phone = $request->phone;
        $model->status = $request->status;
        try {
            $model->save();
            return redirect()->back()->with('success', 'Thêm mới thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cronjob = SmsCronjob::find($id);
        return view('page.sms-data.show', compact('cronjob'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = SmsData::find($id);
        if (!empty($model)) {
            return view('page.sms-data.edit', compact('model'));
        } else {
            return redirect()->back()->with('error', 'Sms data không tồn tại');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = SmsData::find($id);
        if (!empty($model)) {
            $model->phone = $request->phone;
            $model->status = $request->status;
            $model->save();
            return redirect()->back()->with('success', 'Cập nhập thành công');
        } else {
            return redirect()->back()->with('error', 'Sms data không tồn tại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = SmsData::find($id);
        if (!empty($model)) {
            $model->delete();
            return redirect()->back()->with('success', 'Xóa sms data thành công');
        } else {
            return redirect()->back()->with('error', 'Sms data không tồn tại');
        }
    }

}
