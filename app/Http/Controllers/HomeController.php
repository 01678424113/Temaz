<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if (count($user->getRoleNames()) == 0) {
            $user->syncRoles('user');
        }
        return view('home');
    }

    public function import()
    {
        return view('page.import.create');
    }

    public function doImport(Request $request)
    {
        $file = $request->file('file');
        $type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        if (!empty($file)) {
            if ($file->getMimeType() == $type) {
                $path = $file->getRealPath();
                $fileContent = Excel::load($path)->get();
                if (!empty($fileContent)) {
                    $i = 1;
                    foreach ($fileContent as $key => $value) {
                        $source = $request->source;
                        if ($request->source == 'viettel') {
                            if (!empty($value->so_dien_thoai)) {
                                if (gettype($value->so_dien_thoai) == 'double') {
                                    $phone = 0 . (int)$value->so_dien_thoai;
                                    $check = Phone::where('phone', $phone)->first();
                                    if (empty($check)) {
                                        $insert[] = [
                                            'phone' => $phone,
                                            'time' => $value->thoi_gian,
                                            'link' => $value->duong_link,
                                            'ip' => $value->dia_chi_ip,
                                            'source' => $source,
                                            'created_at' => date('Y-m-d')
                                        ];
                                    }
                                }
                            }
                        }
                        $i++;
                    }
                }
                try {
                    Phone::insert($insert);
                    return redirect()->back()->with('success', 'Import thành công');
                } catch (\Exception $e) {
                    return redirect()->back()->with('success', 'Đã xảy ra lỗi');
                }
            }
        }else{
            return redirect()->back()->with('success', 'Không thể import file rỗng');
        }
    }
}
