<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Phone;
use Illuminate\Console\Command;

class AutoUpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto update data from api';

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
        $campaigns = Campaign::where('status', Campaign::$ACTIVE)->get();
        if (!empty($campaigns)) {
            foreach ($campaigns as $campaign) {
                $api = $campaign->api;
                if (!empty($api)) {
                    $this->updateData($api, $campaign->id);
                }
            }
        }
    }

    protected function updateData($api, $campaign_id)
    {
        $data = file_get_contents($api);
        $data = json_decode($data, true);
        if (!empty($data)) {
            foreach ($data as $value) {
                if (!empty($value['phone'])) {
                    $phone = 0 . (int)$value['phone'];
                    $check = Phone::where('phone', $phone)->where('campaign_id', $campaign_id)->first();
                    if (empty($check)) {
                        $insert[] = [
                            'name' => $value['name'],
                            'phone' => (int)$phone,
                            'campaign_id' => $campaign_id,
                            'email' => $value['email'],
                            'source' => $value['source'],
                            'time' => $value['time'],
                            'status' => $value['status'],
                            'ip' => $value['ip'],
                            'note' => $value['note'],
                            'sale' => $value['sales'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => '',
                        ];
                    }
                }
            }
            try {
                if (!empty($insert)) {
                    Phone::insert($insert);
                    \Log::info(date('Y-m-d H:i:s') . ' Lấy dữ liệu thành công từ api ' . $api);
                }
            } catch (\Exception $e) {
                \Log::info(date('Y-m-d H:i:s') . ' Đã xảy ra lỗi khi lấy dữ liệu từ api ' . $api . ' ERROR: ' . $e->getMessage());
            }
        }
    }
}
