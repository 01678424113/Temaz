<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScanEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:scanEmail {from} {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan email';

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
        $from = $this->argument('from');
        $to = $this->argument('to');
        $domain = 'https://batdongsan.com.vn';
        $links = [];
        $file = '/home/temaz.net/public_html/email.txt';
        for ($p = $from; $p < $to; $p++) {
            echo $p;
            $html = $this->cUrl('https://batdongsan.com.vn/nha-dat-cho-thue/p' . $p);
            preg_match_all("/<a href=\'(.*?)\' title=\'.*?\'.*?>/", $html, $result);
            $find = $result[1];
            $links = array_merge($links, $find);
        }
        $emails = [];
        $i = 1;
        foreach ($links as $link) {
            $html = $this->cUrl($domain . $link);
            preg_match_all("/<a rel=\'nofollow\' href=\'.*?\'>(.*?)<\/a>/", $html, $result);
            if (isset($result[1][0]) && !empty($result[1][0])) {
                $email = html_entity_decode($result[1][0]);
                if (strpos($email, '@gmail.com') || strpos($email, '@yahoo.com')){
                    $emails[] = $email;
                }
            }
            echo $i;
            $i++;
        }
        try{
            file_put_contents($file, implode("\n", $emails) . "\n", FILE_APPEND);
        }catch (\Exception $e){
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
