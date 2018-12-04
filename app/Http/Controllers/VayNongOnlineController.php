<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VayNongOnlineController extends Controller
{
    //
    public function campaign(Request $request)
    {
        $table = $request->table;
        $data = file_get_contents('https://vaynongonline.com/api/api-temaz.php?table='.$table);
        $data = json_decode($data);
        return view('page.vaynongonline.campaign.index',compact('data'));
    }

    public function customer(Request $request)
    {
        $table = $request->table;
        $from = $request->from;
        $to = $request->to;
        $where = $request->where;
        $address = $request->address;
        $data = file_get_contents('https://vaynongonline.com/api/api-temaz.php?table='.$table.'&from='.$from.'&to='.$to.'&where='.$where.'&address='.$address);
        $data = json_decode($data);
        $campaigns = file_get_contents('https://vaynongonline.com/api/api-temaz.php?table=campaign');
        $campaigns = json_decode($campaigns);
        return view('page.vaynongonline.customer.index',compact('data','campaigns','where','to'));
    }
}
