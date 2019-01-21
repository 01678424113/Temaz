<?php

namespace App\Http\Controllers;

use App\Libs\Helpers;
use App\Models\Campaign;
use App\Models\Phone;
use App\Models\SmsContent;
use App\Models\SmsCronjob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Excel;
use Validator;

class SmsCronjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SmsCronjob::select('id', 'time', 'status', 'created_at', 'name')->get();
        return view('page.sms-cronjob.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        if ($user->getRoleNames()[0] == 'admin') {
            $arrayCampaigns = Campaign::select('*')
                ->pluck('name', 'id')->toArray();
        } else {
            $arrayCampaigns = Campaign::select('campaigns.*')
                ->join('categories', 'categories.id', '=', 'campaigns.category_id')
                ->where('campaigns.category_id', $user->category_id)
                ->pluck('name', 'id')->toArray();
        }
        return view('page.sms-cronjob.create', compact('arrayCampaigns'));
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
            'time' => ['required'],
            'text_phone' => ['required'],
            'campaign_id' => ['required'],
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }
        //Lay sdt o file
        $file = $request->file('file_phone');
        $type = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'];
        $list_phones = [];
        if (!empty($file)) {
            if (in_array($file->getMimeType(), $type)) {
                $path = $file->getRealPath();
                $fileContent = Excel::load($path)->get();
                if (!empty($fileContent[0])) {
                    foreach ($fileContent as $key => $value) {
                        if (!empty($value->sdt)) {
                            $phone = $this->changePhone($value->sdt);
                            if (empty($check)) {
                                $list_phones[] = $phone;
                            }
                        }
                    }
                }
            }
        }
        //Lay sdt
        if (!empty($request->text_phone)) {
            $data = explode("\r\n", $request->text_phone);
            if (!empty($data)) {
                foreach ($data as $item) {
                    $item = $this->changePhone($item);
                    if (strlen($item) == 10) {
                        $list_phones[] = $item;
                    }
                }
            }
        }
        $smsCronjob = new SmsCronjob();
        $smsCronjob->time = $request->time;
        $smsCronjob->name = $request->name;
        $smsCronjob->campaign_id = $request->campaign_id;
        $smsCronjob->list_phones = json_encode($list_phones);
        $smsCronjob->status = SmsCronjob::$ACTIVE;
        $smsCronjob->created_at = time();

        $smsCronjob->save();
        return redirect()->back()->with('success', 'Đặt lịch thành công');
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
        return view('page.sms-cronjob.show', compact('cronjob'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
            'time' => ['required'],
            'text_phone' => ['required'],
            'campaign_id' => ['required'],
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }

        $cronjob = SmsCronjob::find($id);
        if (isset($cronjob)) {
            $cronjob->name = $request->name;
            $cronjob->content = $request->content_sms;
            $cronjob->save();
            return redirect()->back()->with('success', 'Lưu thành công');
        } else {
            return redirect()->back()->with('error', 'Cronjob không tồn tại');
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
        $smsCronjob = SmsContent::find($id);
        if(isset($smsCronjob)){
            $smsCronjob->delete();
            return redirect()->back()->with('success','Xóa cronjob thành công');
        }else{
            return redirect()->back()->with('error','Đã xảy ra lỗi');
        }
    }

    public function activeCronjobSMS($id)
    {
        $cronjobSMS = SmsCronjob::find($id);
        if ($cronjobSMS->status == SmsCronjob::$UNACTIVE) {
            $cronjobSMS->status = SmsCronjob::$ACTIVE;
        } else {
            $cronjobSMS->status = SmsCronjob::$UNACTIVE;
        }
        $cronjobSMS->save();
        return redirect()->back()->with('success', 'Cập nhập thành công');
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

    public function smsCronjob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content_sms' => ['required'],
            'time' => ['required'],
        ]);
        if ($validator->fails()) {
            $error = Helpers::getValidationError($validator);
            return back()->with(['error' => $error])->withInput(Input::all());
        }
        $content = $request->content_sms;
        //Lay sdt o file
        $file = $request->file('file_phone');
        $type = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'];
        $list_phones = [];
        if (!empty($file)) {
            if (in_array($file->getMimeType(), $type)) {
                $path = $file->getRealPath();
                $fileContent = Excel::load($path)->get();
                if (!empty($fileContent[0])) {
                    foreach ($fileContent as $key => $value) {
                        if (!empty($value->sdt)) {
                            $phone = 0 . (int)$value->sdt;
                            if (empty($check)) {
                                $list_phones[] = $phone;
                            }
                        }
                    }
                }
            }
        }

        //Lay sdt o chien dich
        if ($request->campaign_id != 0) {
            $data = Phone::select('phone')->where('campaign_id', $request->campaign_id)->cursor();
            if (!empty($data)) {
                foreach ($data as $item) {
                    $list_phones[] = $item->phone;
                }
            }
        }

        if (!empty($request->text_phone)) {
            $data = explode("\r\n", $request->text_phone);
            if (!empty($data)) {
                foreach ($data as $item) {
                    $list_phones[] = $item;
                }
            }
        }
        $smsCronjob = new SmsCronjob();
        $smsCronjob->time = $request->time;
        $smsCronjob->name = $request->name;
        $smsCronjob->content = $content;
        $smsCronjob->campaign_id = $request->campaign_id;
        $smsCronjob->list_phones = json_encode($list_phones);
        $smsCronjob->status = SmsCronjob::$ACTIVE;
        $smsCronjob->created_at = time();

        $smsCronjob->save();
        return redirect()->back()->with('success', 'Đặt lịch thành công');
    }

    public function sendSmsReport(Request $request)
    {
        $source = $request->source;
        $phone_customer = $request->phone_customer;
        $name_customer = $request->name_customer;
        $content = $request->CONTENT . ' Website: ' . $source . ' Tên: ' . $name_customer . ' SDT: ' . $phone_customer;
        $phones = $request->phones;
        $content_customer = $request->content_customer;

        if (!empty($phone_customer)) {
            $sim = $this->checkPhone($phone_customer);
            if ($sim == 'viettel') {
                $sim = rand(1, 2);
            } elseif ($sim == 'vinaphone') {
                $sim = 3;
            } elseif ($sim == 'mobiphone') {
                $sim = 4;
            }
            $url = 'http://temaz2018.ddns.net/cgi/WebCGI?1500101=account=apiuser&password=apipass&port=' . $sim . '&destination=' . $phone_customer . '&content=' . urlencode($content_customer);
            $response = $this->cUrl($url);
        }
        if (!empty($phones)) {
            foreach ($phones as $phone) {
                $sim = $this->checkPhone($phone);
                if ($sim == 'viettel') {
                    $sim = rand(1, 2);
                } elseif ($sim == 'vinaphone') {
                    $sim = 3;
                } elseif ($sim == 'mobiphone') {
                    $sim = 4;
                }
                $url = 'http://temaz2018.ddns.net/cgi/WebCGI?1500101=account=apiuser&password=apipass&port=' . $sim . '&destination=' . $phone . '&content=' . urlencode($content);
                $response = $this->cUrl($url);
            }
        }
        return 1;
    }

    protected function checkPhone($phone)
    {
        $dauso = substr($phone, 0, 3);
        if ($dauso == '086' || $dauso == '096' || $dauso == '097' || $dauso == '098' || substr($phone, 0, 2) == '03') {
            return 'viettel';
        } elseif ($dauso == '089' || $dauso == '090' || $dauso == '093' || substr($phone, 0, 2) == '07') {
            return 'mobiphone';
        } elseif ($dauso == '088' || $dauso == '091' || $dauso == '094' || $dauso == '083' || $dauso == '084' || $dauso == '085' || $dauso == '081' || $dauso == '082') {
            return 'vinaphone';
        } else {
            return 'KXD';
        }
    }

    protected function changePhone($phone)
    {
        $phone = strip_tags($phone);
        $phone = preg_replace("/[\/,.,?,*,' ']/","",$phone);
        $firstNumber = substr($phone, 0, 4);
        $array = [
            '0120' => '070',
            '0121' => '079',
            '0122' => '077',
            '0126' => '076',
            '0128' => '078',
            '0123' => '083',
            '0124' => '084',
            '0125' => '085',
            '0127' => '081',
            '0129' => '082',
            '0162' => '032',
            '0163' => '033',
            '0164' => '034',
            '0165' => '035',
            '0166' => '036',
            '0167' => '037',
            '0168' => '038',
            '0169' => '039',
            '0186' => '056',
            '0188' => '058',
            '0199' => '059',
        ];
        if (isset($array[$firstNumber])) {
            $phone = str_replace($firstNumber, $array[$firstNumber], $phone);
        }
        return $phone;
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
