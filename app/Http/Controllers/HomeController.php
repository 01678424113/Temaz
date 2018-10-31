<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
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
        $campaigns = Campaign::select('id', 'name')->pluck('name', 'id')->toArray();
        return view('page.import.create', compact('campaigns'));
    }

    public function doImport(Request $request)
    {
        $file = $request->file('file');
        $campaign_id = $request->campaign_id;
        $type = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'];
        if (!empty($file)) {
            if (in_array($file->getMimeType(), $type)) {
                $path = $file->getRealPath();
                $fileContent = Excel::load($path)->get();
                if (!empty($fileContent[0])) {
                    foreach ($fileContent[0] as $key => $value) {
                        if (!empty($value->sdt)) {
                            $phone = 0 . (int)$value->sdt;
                            $check = Phone::where('phone', $phone)->where('campaign_id',$campaign_id)->first();
                            if (empty($check)) {
                                $insert[] = [
                                    'name' => $value->ho_va_ten,
                                    'phone' => (int)$value->sdt,
                                    'campaign_id' => $campaign_id,
                                    'email' => (!empty($value->email) ? $value->email : ''),
                                    'source' => $value->nguon,
                                    'time' => $value->ngay,
                                    'status' => $value->check,
                                    'id' => $value->ip,
                                    'note' => $value->ghi_chu,
                                    'sale' => $value->sales,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => '',
                                ];
                            }
                        }
                    }
                }
                try {
                    if (!empty($insert)) {
                        Phone::insert($insert);
                        return redirect()->back()->with('success', 'Import thành công');
                    }
                    return redirect()->back()->with('error', 'File này đã được sử dụng');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Đã xảy ra lỗi');
                }
            }
        } else {
            return redirect()->back()->with('success', 'Không thể import file rỗng');
        }
    }
}
