<?php

namespace App\Http\Controllers;

use App\Models\SmsContent;
use Illuminate\Http\Request;

class SmsContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $smsContent = new SmsContent();
        $smsContent->content = $request->content_sms;
        $smsContent->campaign_id = $request->campaign_id;
        try {
            $smsContent->save();
            return redirect()->back()->with('success', 'Thêm mẫu tin nhắn thành công');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $smsContent = SmsContent::find($id);
        if (isset($smsContent)) {
            $smsContent->content = $request->content_sms;
            $smsContent->save();
            $response = [
                'status' => true,
                'message' => 'Update thành công'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Update thành công'
            ];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $smsContent = SmsContent::find($id);
        try {
            $smsContent->delete();
            return redirect()->back()->with('success', 'Xóa mẫu tin nhắn thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi');
        }
    }
}
