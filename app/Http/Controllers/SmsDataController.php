<?php

namespace App\Http\Controllers;

use App\Models\SmsData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SmsDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SmsData::cursor();
        return view('page.sms-data.index', compact('data'));
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
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new SmsData();
        $model->phone = $request->phone;
        $model->status = $request->status;
        try{
            $model->save();
            return redirect()->back()->with('success','Thêm mới thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error','Đã xảy ra lỗi');
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

    public function import()
    {
        return view('page.sms-data.import');
    }

    public function doImport(Request $request)
    {
        $file = $request->file('file');
        $type = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'];
        if (!empty($file)) {
            if (in_array($file->getMimeType(), $type)) {
                $path = $file->getRealPath();
                $fileContent = Excel::load($path)->get();
                if (!empty($fileContent[0])) {
                    foreach ($fileContent[0] as $key => $value) {
                        if (!empty($value)) {
                            $phone = 0 . (int)$value;
                            $check = SmsData::where('phone', $phone)->first();
                            if (empty($check)) {
                                $insert[] = [
                                    'phone' => $phone,
                                    'created_at' => date('Y-m-d H:i:s'),
                                ];
                            }
                        }
                    }
                }
                try {
                    if (!empty($insert)) {
                        SmsData::insert($insert);
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

    public function sampleSms()
    {

    }

    public function doSampleSms(Request $request)
    {

    }

    public function sendSms(Request $request)
    {

    }

    protected function cUrl($url)
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
