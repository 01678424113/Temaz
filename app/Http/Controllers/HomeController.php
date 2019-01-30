<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Phone;
use App\Models\PhoneBds;
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
        return view('admin.page.index');
    }

    public function import()
    {
        $campaigns = Campaign::select('id', 'name')->pluck('name', 'id')->toArray();
        $title = 'Import';
        return view('admin.page.import.create', compact('campaigns','title'));
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
                            $check = Phone::where('phone', $phone)->where('campaign_id', $campaign_id)->first();
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

    public function logout()
    {
        \Auth::logout();
        return redirect()->back();
    }

    public function cUrl($url)
    {
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST => "GET",        //set request type post or get
            CURLOPT_POST => false,        //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING => "",       // handle all encodings
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $content;
    }
}
