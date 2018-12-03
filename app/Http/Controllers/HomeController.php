<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Phone;
use App\Models\PhoneBds;
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

    public function scanPhone()
    {
        $arrayPhones = [];
        for ($i = 1; $i <= 900; $i++) {
            if($i == 1){
                $url = 'https://batdongsan.com.vn/nha-dat-cho-thue-tp-hcm';
            }else{
                $url = 'https://batdongsan.com.vn/nha-dat-cho-thue-tp-hcm/p'.$i;
            }
            $text = $this->cUrl($url);
            $matches = array();
            // returns all results in array $matches
            preg_match_all('/[0-9]{4}[\.][0-9]{3}[\.][0-9]{3}|[0-9]{4}[\s][0-9]{3}[\s][0-9]{3}|[0-9]{11}|[0-9]{10}/', $text, $matches);
            $matches = array_unique($matches[0]);
            foreach ($matches as $key => $match) {
                $arrayPhones[] = str_replace(['.', '-', ' '], ['', '', ''], trim($match));
            }
            foreach ($arrayPhones as $key => $phone) {
                preg_match('/^(09[0-9]|08[0-9]|07[0-9]|05[0-9]|03[0-9])[0-9]{7}|(016[0-9]|012[0-9])[0-9]{7}$/', $phone, $matches);
                if (empty($matches)) {
                    unset($arrayPhones[$key]);
                }
            }
        }
        foreach ($arrayPhones as $item) {
            $data = new PhoneBds();
            $data->phone = $item;
            try {
                $data->save();
            } catch (\Exception $e) {

            }
        }

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
