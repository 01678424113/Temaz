<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class ScanWithKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:scanWithKey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan with key';

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
        $key = 'chữa cháy';
        $key = str_replace(' ', '+', $key);
        $links = [];
        for ($i = 1; $i < 39; $i++) {

            $link = 'https://doanhnghiepmoi.vn/tim-kiem/auto/' . $key . '/trang-' . $i;
            $html = $this->cUrl($link);
            preg_match_all('/<h3 class=\"company\-name\"><a href=\"(.*?)\">.*?<\/a><\/h3>/', $html, $result);
            if (isset($result[1]) && !empty($result[1])) {
                $links = array_merge($links,$result[1]);
            }
        }
        $phones = [];
        $i = 0;
        foreach ($links as $link) {
            $html = $this->cUrl($link);
            preg_match('/<div class=\"col\-xs\-12 col\-md\-3\">Điện thoại\:<\/div><div class=\"col\-xs\-12 col\-md\-9">(.*?)<\/div><\/div>/', $html, $result);
            if (isset($result[1]) && !empty($result[1])) {
                $phones[] = $result[1];
            }
            echo $i;
            $i++;
        }

        foreach ($phones as $item) {
            $check = substr($item, 0, 2); 
            if($check != '02' && $check != '04'){
                $item = $this->changePhone($item);
                if (strlen($item) == 10) {
                    $list_phones[] = $item;
                }
            }
        }
        File::put('withKey.txt', implode("\n", $list_phones));
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
    public function changePhone($phone)
    {
        $phone = strip_tags($phone);
        $phone = preg_replace("/[\/,.,?,*,' ']/", "", $phone);
        $change = substr($phone, 0, 2);
        if($change == "84"){
            $phone = '+'.$phone;
            $phone = str_replace("+84","0",$phone);
        }
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
