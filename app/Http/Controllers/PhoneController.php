<?php

namespace App\Http\Controllers;

use App\Libs\Helpers;
use App\Models\Admin;
use App\Models\AdminPhone;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Phone;
use App\Models\Transaction;
use App\Rules\Utf8StringRule;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Validator;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Phone::select('id', 'cronjob_id','phone', 'campaign_id')
            ->orderBy('created_at', 'DESC')
            ->cursor();
        return view('page.phone.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        $campaigns = Campaign::select('name', 'id')->where('category_id', $user->category_id)->pluck('name', 'id')->toArray();
        return view('page.phone.create', compact('campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', new Utf8StringRule(), 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'campaign_id' => ['required', 'numeric'],
            'phone' => ['required', 'max:20'],
            'ip' => ['max:20'],
            'source' => ['required', 'max:500'],
            'sale' => ['required', new Utf8StringRule(), 'max:255'],
            'time' => ['max:50'],
            'status' => ['required', 'numeric', Rule::in([Phone::$FAIL, Phone::$NOT_PROCESS, Phone::$PROCESS, Phone::$SUCCESS])],
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }
        $model = new Phone();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->campaign_id = $request->campaign_id;
        $model->phone = $request->phone;
        $model->ip = $request->ip;
        $model->source = $request->source;
        $model->sale = $request->sale;
        $model->time = $request->time;
        $model->status = $request->status;
        $model->note = $request->note;
        try {
            $model->save();
            return redirect()->back()->with('success', 'Tạo mới thành công');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        $model = Phone::findOrFail($id);
        $campaigns = Campaign::select('name', 'id')->pluck('name', 'id')->toArray();
        return view('page.phone.edit', compact('model', 'campaigns'));
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', new Utf8StringRule(), 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'campaign_id' => ['required', 'numeric'],
            'phone' => ['required', 'max:20'],
            'ip' => ['max:20'],
            'source' => ['required', 'max:500'],
            'sale' => ['required', new Utf8StringRule(), 'max:255'],
            'time' => ['max:50'],
            'status' => ['required', 'numeric', Rule::in([Phone::$FAIL, Phone::$NOT_PROCESS, Phone::$PROCESS, Phone::$SUCCESS])],
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }
        $model = Phone::findOrFail($id);
        $model->name = $request->name;
        $model->email = $request->email;
        $model->campaign_id = $request->campaign_id;
        $model->phone = $request->phone;
        $model->ip = $request->ip;
        $model->source = $request->source;
        $model->sale = $request->sale;
        $model->time = $request->time;
        $model->status = $request->status;
        $model->note = $request->note;
        try {
            $model->save();
            return redirect()->back()->with('success', 'Cập nhập thành công');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        $model = Phone::find($id);
        if (!empty($model)) {
            $model->delete();
            return redirect()->back()->with('success', 'Xóa data thành công');
        } else {
            return redirect()->back()->with('error', 'Data này không tồn tại');
        }
    }

    public function deleteCycle()
    {
        $time = date('Y-m-d', time());
        $timeCycle = env('DELETE_CYCLE');
        $phones = Phone::select(DB::raw("id, DATEDIFF('{$time}',created_at) as check_time"))->get();
        foreach ($phones as $phone) {
            if ($phone->check_time > $timeCycle) {
                $model = Phone::find($phone->id);
                $model->status = -1;
                $model->save();
            }
        }
        return 'OK';
    }

    public function updateNote(Request $request, $id)
    {
        $model = Phone::find($id);
        if (!empty($model)) {
            $model->note = $request->note;
            $model->status = $request->status;
            $model->save();
            $response = [
                'status' => 1,
                'message' => 'Cập nhập thành công'
            ];
            return $response;
        } else {
            $response = [
                'status' => -1,
                'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau'
            ];
            return $response;
        }
    }

}

