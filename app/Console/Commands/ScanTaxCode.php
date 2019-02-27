<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class ScanTaxCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:scanTaxCode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan TaxCode';

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
        $listTaxCodes = '';
        $listTaxCodes = explode("\n", $listTaxCodes);
        $links = [];
        $i = 0;
        foreach ($listTaxCodes as $taxCode) {

            $link = 'https://doanhnghiepmoi.vn/tim-kiem/auto/' . $taxCode;
            $html = $this->cUrl($link);
            preg_match('/<h3 class=\"company\-name\"><a href=\"(.*?)\">.*?<\/a><\/h3>/', $html, $result);
            if (isset($result[1]) && !empty($result[1])) {
                $links[] = $result[1];
            }
            echo $i;
            $i++;
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
        File::put('taxCode.txt', implode("\n", $phones));
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
