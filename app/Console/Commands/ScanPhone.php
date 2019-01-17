<?php

namespace App\Console\Commands;

use App\Models\Phone;
use Illuminate\Console\Command;

class ScanPhone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:scanPhone {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan Phone';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $code = $this->argument('code');
        if ($code == 100000) {
            $address = 'Hà Nội';
            $link = 'https://ha-noi.congtydoanhnghiep.com/trang-';
        }
        $links = [];
        for ($p = 750; $p < 751; $p++) {
            echo $p;
            $html = $this->cUrl($link . $p);
            preg_match_all('/<h2><a href=\"(.*?)\">.*?<\/a><\/h2>/', $html, $result);
            $find = $result[1];
            $links = array_merge($links, $find);
        }
        $i = 1;
        $count_phone = 0;
        foreach ($links as $link) {
            echo $i;
            $html = $this->cUrl($link);
            preg_match_all('/<th>Điện thoại\:<\/th><td>(.*?)<\/td>/', $html, $result);
            preg_match_all('/<th class=\"w128\">Tên công ty: <\/th><td>(.*?)<\/td>/', $html, $nameCompany);
            if (isset($result) && !empty($result[1])) {
                $str_phone = $result[1][0];
                $str_phone = str_replace('.', '', $str_phone);
                $str_phone = str_replace(' ', '', $str_phone);
                $str_phone = str_replace('/', '', $str_phone);
                $check = substr($str_phone, 0, 2);
                if ($check != '02' && $check != '04' && $check != '84' && strlen($str_phone) > 11) {
                    $check = Phone::where('phone', $str_phone)->first();
                    if (empty($check)) {
                        $phone = new Phone();
                        $phone_number = $str_phone;
                        $phone->phone = $this->changePhone($phone_number);
                        $phone->name_company = $nameCompany[1][0];
                        $phone->address = $address;
                        try {
                            $phone->save();
                            $count_phone++;
                        } catch (\Exception $e) {
                        }
                    }
                }
            }
            $i++;
        }
        echo 'Done ' . $count_phone . ' SDT';
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

    protected function changePhone($phone)
    {
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
}
