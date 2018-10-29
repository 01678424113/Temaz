<?php

namespace App\Http\Controllers;

use App\Libs\Helpers;
use App\Libs\LogFile;
use App\Models\Admin;
use App\Models\Transaction;
use App\Models\Company;
use App\Rules\Utf8StringRule;
use DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::select('transactions.*', 'admins.name as user_name')
            ->join('admins', 'admins.id', '=', 'transactions.user_id')
            ->orderBy('created_at', 'DESC')
            ->cursor();
        return view('page.transaction-manager.index', compact('data'));
    }

    public function individual()
    {
        $user = Auth::user();
        $data = Transaction::select('transactions.*', 'admins.name as user_name')
            ->join('admins', 'admins.id', '=', 'transactions.user_id')
            ->where('admins.id',$user->id)
            ->orderBy('created_at', 'DESC')
            ->cursor();
        return view('page.transaction-manager.index', compact('data'));
    }

    /*
       * Function thống kê doanh thu hiển thị biểu dồ
       */
    public function manager(Request $request)
    {
        $revenues = Transaction::select(DB::raw('sum(amount) as `data`'), DB::raw("CONCAT_WS('-',MONTH(updated_at),YEAR(updated_at)) as monthyear"));
        if ($request->time) {
            if ($request->time == 'date') {
                $revenues = Transaction::select(DB::raw('sum(amount) as `data`'), DB::raw("CONCAT_WS('-',DATE(updated_at)) as monthyear"));
            } elseif ($request->time == 'month') {
                $revenues = Transaction::select(DB::raw('sum(amount) as `data`'), DB::raw("CONCAT_WS('-',MONTH(updated_at),YEAR(updated_at)) as monthyear"));
            } else {
                $revenues = Transaction::select(DB::raw('sum(amount) as `data`'), DB::raw("CONCAT_WS('-',YEAR(updated_at)) as monthyear"));
            }
        }
        if ($request->company_id) {
            $revenues = $revenues->where('user_id', $request->user_id);
        }
        $revenues = $revenues->where('type', Transaction::$TYPE_PLUS)->where('status', Transaction::$STATUS_SUCCESS)->groupBy('monthyear')->take(12)->pluck('data', 'monthyear')->toArray();
        $money = [];
        $month = [];
        foreach ($revenues as $key => $revenue) {
            $money[] = (string)$revenue;
            $month[] = $key;
        }
        $money = json_encode($money);
        $month = json_encode($month);
        return view('page.transaction-manager.manager', compact('money', 'month', 'revenues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listUser = Admin::select('name', 'id')->pluck('name', 'id')->toArray();
        return view('page.transaction-manager.create', compact('listUser'));
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
            'note' => [new Utf8StringRule(), 'max:255'],
            'amount' => 'required|numeric',
            'type' => [Rule::in([Transaction::$TYPE_MINUS, Transaction::$TYPE_PLUS])]
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }

        $model = new Transaction();
        $transactionId = 'RENEW' . time() . rand(111, 9999);
        $model->user_id = $request->user_id;
        $model->transaction_id = $transactionId;
        $model->note = $request->note;
        $model->amount = $request->amount;
        $model->type = $request->type;
        $model->status = Transaction::$STATUS_SUCCESS;
        if($request->amount != 0){
            $user = Admin::where('id',$request->user_id)->first();
            if(!empty($user)){
                if($request->type == Transaction::$TYPE_PLUS){
                    $user->amount = (int)$user->amount + $request->amount;
                }else{
                    $user->amount = (int)$user->amount - $request->amount;
                }
                $user->save();
            }
        }
        $model->save();

        return back()->with('success', 'Nạp tiền thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Transaction::findOrFail($id);
        $listUser = Admin::select('name', 'id')->pluck('name', 'id')->toArray();
        return view('page.transaction-manager.show', compact('model', 'listUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Transaction::findOrFail($id);
        $listUser = Admin::select('name', 'id')->pluck('name', 'id')->toArray();
        return view('page.transaction-manager.edit', compact('model','listUser'));
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
        $model = Transaction::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'note' => [new Utf8StringRule(), 'max:255'],
            'amount' => 'required|numeric',
            'type' => [Rule::in([Transaction::$TYPE_MINUS, Transaction::$TYPE_PLUS])]
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }
        $model->note = $request->note;
        $model->amount = $request->amount;
        $model->type = $request->type;
        $model->save();
        //Save log
        return back()->with('success', 'Cập nhập giao dịch thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        try {
            $transaction->delete();
            //Save log
            return back()->with('success', 'Xóa giao dịch thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi');
        }
    }
}
