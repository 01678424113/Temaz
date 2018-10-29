<?php

namespace App\Http\Controllers;

use App\Models\AdminPhone;
use App\Models\Category;
use App\Models\Phone;
use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;
use Mockery\Exception;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Phone::select('phones.*', 'categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'phones.category_id')
            ->orderBy('phones.created_at', 'DESC')
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
        //
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
        $categories = Category::select('name', 'id')->pluck('name', 'id')->toArray();
        return view('page.phone.edit', compact('model', 'categories'));
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
        $model = Phone::findOrFail($id);
        $model->category_id = $request->category_id;
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
        return redirect()->back()->with('error', 'Tính năng này không được sử dụng');
    }

    public function buyNewNumberPhone()
    {
        $data = Phone::select('phones.*', 'categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'phones.category_id')
            ->orderBy('phones.created_at', 'DESC')
            ->cursor();
        $user = \Auth::user();
        $listNumberBought = AdminPhone::select('phone_id')->where('admin_id', $user->id)->pluck('phone_id')->toArray();
        return view('page.phone.buyNewNumberPhone', compact('data', 'listNumberBought'));
    }

    public function doBuyNewNumberPhone($id)
    {
        $user = \Auth::user();
        $check = AdminPhone::where('admin_id', $user->id)->where('phone_id', $id)->first();
        if (empty($check)) {
            //Price phone number
            $price = env('PRICE_PHONE');
            //Sub money user
            $amount = (int)$user->amount;
            if ($amount >= $price) {
                $user->amount = $amount - $price;
                $user->save();
                //Save transaction
                $transaction = new Transaction();
                $transactionId = 'RENEW' . time() . rand(111, 9999);
                $transaction->user_id = $user->id;
                $transaction->transaction_id = $transactionId;
                $transaction->note = 'Mua số điện thoại';
                $transaction->amount = $price;
                $transaction->type = Transaction::$TYPE_MINUS;
                $transaction->status = Transaction::$STATUS_SUCCESS;
                $transaction->save();
                //Save phone in list bought
                $adminPhone = new AdminPhone();
                $adminPhone->admin_id = $user->id;
                $adminPhone->phone_id = $id;
                $adminPhone->save();
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }

    }

    public function listNumberBought()
    {
        $user = \Auth::user();
        $data = Phone::select('phones.*', 'categories.name as category_name')
            ->join('categories', 'categories.id', '=', 'phones.category_id')
            ->join('admin_phones', 'admin_phones.phone_id', '=', 'phones.id')
            ->where('admin_phones.admin_id', $user->id)
            ->orderBy('phones.created_at', 'DESC')
            ->cursor();
        return view('page.phone.listNumberBought', compact('data'));
    }

    public function deleteCycle()
    {
        $time = date('Y-m-d', time());
        $timeCycle = env('DELETE_CYCLE');
        $phones = Phone::select(DB::raw("id, DATEDIFF('{$time}',created_at) as check_time"))->get();
        foreach ($phones as $phone){
            if($phone->check_time > $timeCycle){
                $model = Phone::find($phone->id);
                $model->status = -1;
                $model->save();
            }
        }
        return 'OK';
    }
}

