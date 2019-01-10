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
    protected $signature = 'auto:scanPhone';

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
        $links = [];
        for ($p = 1; $p < 200; $p++) {
            echo $p;
            $html = $this->cUrl('https://ha-noi.congtydoanhnghiep.com/quan-ha-dong/trang-' . $p);
            preg_match_all('/<h4><a
                 href=\"(.*?)\">.*?<\/a><\/h4>/', $html, $result);
            $find = $result[1];
            $links = array_merge($links, $find);
        }

        $i = 1;
        foreach ($links as $link) {
            echo $i;
            $html = $this->cUrl($link);
            preg_match_all('/<th>Điện thoại\:<\/th><td>(.*?)<\/td>/', $html, $result);
            preg_match_all('/<th class=\"w128\">Tên công ty: <\/th><td>(.*?)<\/td>/', $html, $nameCompany);
            if (isset($result) && !empty($result[1])) {
                $phone = new Phone();
                $phone->phone = str_replace(' ','',$result[1][0]);
                $phone->name_company = $nameCompany[1][0];
                try {
                    $phone->save();
                } catch (\Exception $e) {
                }
            }
            $i++;
        }
        echo 'Done';
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
