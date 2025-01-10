<?php

namespace App\Http\Controllers;

use App\Enums\ServiceOTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\ChangeStatusServiceOTP;
use Carbon\Carbon;

class StorageSimController extends Controller
{
    public function listStorageSim()
    {
        $storageSim = DB::table('storage_sim')->paginate(100);

        return view('admin.storage-sim.index', ['storageSim' => $storageSim]);
    }

    public function listStorageCheckSim (Request $request)
    {
        $status = $request->get('status');
        $storageCheckSim = DB::table('storage_sim');
        if($status ==1)
        {
            $storageCheckSim = $storageCheckSim->where('is_online', 1);

        }elseif ($status ==2)
        {
            $storageCheckSim = $storageCheckSim->where('is_online', 0);
        }elseif ( $status ==4 )
        {
            $storageCheckSim = $storageCheckSim->where('is_online', 1);
        }

        $storageCheckSim = $storageCheckSim->paginate();
        return response()->json($storageCheckSim);
    }

    public function listOTP()
    {
        $otp = DB::table('service_otp')->paginate(30);

        return view('admin.storage-sim.otp', ['otp' => $otp]);
    }

    public function getMessageSim($phoneID)
    {
        $phone = DB::table('service_otp')->where('storage_sim_id', $phoneID)->first();

        if(isset($phone) )
        {
            $getPhone = $phone->storage_sim_id;
            $listMessages =  DB::table('history_sim')
                ->select(['history_sim.history_opt', 'history_sim.history_date', 'service_otp.phone', 'service_otp.otp', 'service_otp.sender_name' ])
                ->join('service_otp', 'service_otp.storage_sim_id', '=', 'history_sim.storage_sim_id')
                ->where('history_sim.storage_sim_id', $getPhone)
                ->get();
            return response()->json($listMessages);
        }
        $response['message'] = 'Số điện thoại này không tồn tại';
        $response['success'] = 'false';
    }

    public function storeStorageSim(Request $request)
    {
        $phone = $request->get('phone');
        $network = $request->get('network');
        $estimate_date = $request->get('estimate_date');
        $last_online_date =	round(microtime(true) * 1000);
        $note = $request->get('note');
        $time_to_use = $request->get('time_to_use');
        $is_online = $request->get('is_online');
        $amount = $request->get('amount');
        $end_date = $request->get('end_date');
        $response = [
            'code' => '200',
        ];

        if (isset($phone)) {
            $data['phone'] = $phone;
        } else {
            $response['message'] = "phone không được để trống.";
            $response['success'] = "false";

            return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($network)) {
            $data['network'] = $network;
        } else {
            $response['message'] = "network không được để trống.";
            $response['success'] = "false";

            return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($estimate_date)) {
            $data['estimate_date'] = $estimate_date;
        }

        if (isset($last_online_date)) {
            $data['last_online_date'] = $last_online_date;
        } else {
            $data['last_online_date'] = strtotime(date('Y-m-d H:i:s ')) * 1000;
        }

        if (isset($note)) {
            $data['note'] = $note;
        }

        if (isset($is_online)) {
            if ((int) $is_online == 1 || (int) $is_online == 0) {
                $data['is_online'] = $is_online;
            } else {
                $response['message'] = "is_online sai định dạng. Bắt buộc is_online chỉ được phép là 0 hoặc 1.";
                $response['success'] = "false";

                return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }

        if (isset($time_to_use)) {
            $regex = '/^[0-9]*$/';
            $pre_match = preg_match($regex, $time_to_use);
            if (!$pre_match) {
                $response['message'] = "time_to_use sai định dạng. Bắt buộc time_to_use chỉ được phép là số.";
                $response['success'] = "false";

                return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }

            $data['time_to_use'] = $time_to_use;
        }

        if (isset($amount)) {
            $data['amount'] = $amount;
        }

        if (isset($end_date)) {
            $data['end_date'] = $end_date;
        }

        $getStorageSim = DB::table('storage_sim')->where('phone', $phone)->where('network', $network)->first();

        if (!$getStorageSim) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $idInsert = DB::table('storage_sim')->insertGetId($data);
            $getService = DB::table('services')->where('name', 'google')->first();
            $dataServiceSim = [
                'storage_sim_id' => $idInsert,
                'services_id' => $getService->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $phone_id = DB::table('service_sim')->insertGetId($dataServiceSim);

            $dataHistory = [
                'storage_sim_id' => $phone_id,
                'history_date' => date('Y-m-d H:i:s'),
                'history' => 'Sim được khởi tạo thành công.'
            ];

            DB::table('history_sim')->insert($dataHistory);

            $response['message'] = "Tạo sim thành công.";
            $response['success'] = "true";
        } else {
            $getPhone = DB::table('storage_sim')->where('phone', $phone)->where('network', $network)->first();
            $dataHistory = [
                'storage_sim_id' => $getPhone->id,
                'history_date' => date('Y-m-d H:i:s'),
                'history' => 'Sim được cập nhật thành công.'
            ];

            DB::table('history_sim')->insert($dataHistory);
            DB::table('storage_sim')->where('phone', $phone)->where('network', $network)->update($data);

            $response['message'] = "Cập nhật sim thành công.";
            $response['success'] = "true";
        }

        $response['data'] = $data;

        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getPhoneInStorageSim(Request $request)
    {
        $service = $request->get('service');
        if (!isset($service)) {
            $response['message'] = 'service bắt buộc không được để trống';
            $response['success'] = 'false';

            return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        $getService = DB::table('services')->join('service_sim', 'services.id', '=', 'service_sim.services_id')->where('services.name', $service)->get();
        $response = [
            'code' => 200
        ];

        if (empty($getService)) {
            $response['message'] = 'Dịch vụ này không tồn tại';
            $response['success'] = 'false';
        } else {
            $listSimID = [];
            foreach ($getService as $item) {
                $listSimID[] = $item->storage_sim_id;
            }

            foreach ($listSimID as $simID) {
                $checkInList = DB::table('service_otp')
                    ->join('storage_sim', 'service_otp.storage_sim_id', '=', 'storage_sim.id')
                    ->where('storage_sim.id', $simID)
                    ->where('service_otp.service', $service)
                    ->where(function ($query) {
                        $query->where('service_otp.status', 0)
                            ->orWhere('service_otp.status', 3);
                    })
                    ->orderBy('service_otp.id', 'DESC')
                    ->first();

                if (!isset($checkInList)) {
                    $nowDate = strtotime(date('Y-m-d')) * 1000;
                    $getPhone = DB::table('storage_sim')->where('id', $simID)->where('is_online', 1)->whereDate('last_online_date', $nowDate)->first();

                    if (isset($getPhone)) {
                        $choicePhone = $getPhone;
                        break;
                    }
                }
            }

            if (!isset($choicePhone)) {
                $response['message'] = 'Các sim đều đang bận';
                $response['success'] = 'false';
            } else {
                $data = [
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'storage_sim_id' => $choicePhone->id,
                    'phone' => $choicePhone->phone,
                    'create_otp_time' => date('Y-m-d H:i:i'),
                    'service' => $service
                ];

                $dataHistory = [
                    'storage_sim_id' => $choicePhone->id,
                    'history_date' => date('Y-m-d H:i:s'),
                    'history' => 'Được gọi để lấy OTP'
                ];

                $task_id = DB::table('service_otp')->insertGetId($data);
                DB::table('history_sim')->insert($dataHistory);
                ChangeStatusServiceOTP::dispatch($task_id)->onQueue('change_status_service_otp')->delay(Carbon::now()->addMinutes(5));

                $response['success'] = 'true';
                $response['message'] = 'Lấy số phone thành công';
                $response['data'] = [
                    'phone' => $choicePhone->phone,
                    'task_id' => $task_id
                ];
            }
        }

        return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function createSmsOtpStorageSim(Request $request)
    {

        $phone = $request->get('phone');
        $otp = $request->get('otp');
        $raw_data = $request->get('raw_data');
        $phone_sender = $request->get('phone_sender');
        $sender_name = $request->get('sender_name');
        $data = [];
        $response = [
            'code' => '200',
        ];

        if (isset($phone)) {
            $data['phone'] = $phone;
        } else {
            $response['message'] = "phone bắt buộc không được để trống";
            $response['success'] = "false";

            return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($otp)) {
            $data['otp'] = $otp;
        }

        if (isset($raw_data)) {
            $data['raw_data'] = $raw_data;
        }

        if (isset($phone_sender)) {
            $data['phone_sender'] = $phone_sender;
        }

        if (isset($sender_name)) {
            $data['sender_name'] = $sender_name;
        }
        $getOTP = DB::table('service_otp')->where('phone', $phone)->orderBy('id', 'DESC')->where('status', ServiceOTP::STATUS_WAITING)->first();
        if (isset($getOTP)) {
            if($getOTP->otp != null) {
                $getPhone = DB::table('storage_sim')->where('phone', $phone)->first();
                DB::table('service_otp')->where('id', $getOTP->id)->update($data);

                $dataHistory = [
                    'storage_sim_id' => $getPhone->id,
                    'history_date' => date('Y-m-d H:i:s'),
                    'history' => 'Khởi tạo OTP từ tool thành công',
                    'history_opt' =>  $getOTP->raw_data
                ];
            } else {
                $getPhone = DB::table('storage_sim')->where('phone', $phone)->first();
                $dataHistory = [
                    'storage_sim_id' => $getPhone->id,
                    'history_date' => date('Y-m-d H:i:s'),
                    'history_opt' =>  $getOTP->raw_data

                ];
            }

            $getPhone = DB::table('storage_sim')->where('phone', $phone)->first();
            DB::table('service_otp')->where('id', $getOTP->id)->update($data);


            $dataHistory = [
                'storage_sim_id' => $getPhone->id,
                'history_date' => date('Y-m-d H:i:s'),
                'history' => 'Khởi tạo OTP từ tool thành công',
                'history_opt' =>  $getOTP->raw_data
            ];

            DB::table('history_sim')->insert($dataHistory);

            $response['message'] = "Thêm otp tác vụ tool thành công.";
            $response['success'] = "true";
        } else {
            $getOTPOther = DB::table('service_otp')->where('phone', $phone)->orderBy('id', 'DESC')->where('status', ServiceOTP::STATUS_OTHER)->first();

            if (isset($getOTPOther)) {
                $getPhone = DB::table('storage_sim')->where('phone', $phone)->first();
                DB::table('service_otp')->where('id', $getOTPOther->id)->update($data);

                $dataHistory = [
                    'storage_sim_id' => $getPhone->id,
                    'history_date' => date('Y-m-d H:i:s'),
                    'history' => 'Cập nhật OTP từ tác vụ khác thành công',
                    'history_opt' =>  $getOTPOther->raw_data
                ];

                DB::table('history_sim')->insert($dataHistory);

                $response['message'] = "Cập nhật otp tác vụ khác thành công.";
                $response['success'] = "true";
            } else {
                $getPhone = DB::table('storage_sim')->where('phone', $phone)->first();
                if (isset($getPhone)) {
                    $data['storage_sim_id'] = $getPhone->id;
                }

                if (!array_key_exists('otp', $data)) {
                    $regex = '/[G][-][0-9]{6}/';
                    preg_match($regex, $raw_data, $matches);
                    if (empty($matches)) {
                        $data['otp'] = '';
                    } else {
                        $otpRAW = $matches[0];
                        $explodeOTP = explode('-', $otpRAW);
                        $data['otp'] = $explodeOTP[1];
                    }
                }

                $data['create_otp_time'] = date('Y-m-d H:i:s');
                $data['status'] = ServiceOTP::STATUS_OTHER;
                $data['service'] = 'other';

                DB::table('service_otp')->insert($data);

                $dataHistory = [
                    'storage_sim_id' => $getPhone->id,
                    'history_date' => date('Y-m-d H:i:s'),
                    'history' => 'Thêm OTP từ tác vụ khác thành công',
                    'history_opt' =>  $getOTPOther->raw_data
                ];

                DB::table('history_sim')->insert($dataHistory);

                $response['message'] = "Thêm sms otp tác vụ khác thành công.";
                $response['success'] = "true";
            }
        }

        $response['data'] = $data;

        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getOTP(Request $request)
    {
        $task_id = $request->get('task_id');
        $now = date('Y-m-d H:i:s');
        $response = [
            'code' => '200',
        ];

        if (!isset($task_id)) {
            $response['message'] = "task_id bắt buộc không được để trống";
            $response['success'] = "false";
            $response['time_out'] = 'false';
            $response['data'] = [
                'otp' => ''
            ];

            return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        $getVerify = DB::table('service_otp')->where('id', $task_id)->first();
        if (!isset($getVerify)) {
            $response['message'] = 'Task_id không tồn tại.';
            $response['success'] = 'false';
            $response['time_out'] = 'false';
            $response['data'] = [
                'otp' => ''
            ];

            return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            if ($getVerify->status == 1) {
                $response['message'] = 'OTP đã được trả về trước đó.';
                $response['success'] = 'true';
                $response['time_out'] = 'false';
                $response['data'] = [
                    'otp' => $getVerify->otp
                ];

                return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }

            $timeOutTimestamp = strtotime($getVerify->create_otp_time . ' + 5 minute');
            $formatTime = date('Y-m-d H:i:s', $timeOutTimestamp);
            $strToTimeFormatTime = strtotime($formatTime);
            $nowTimestamp = strtotime($now);

            if ($strToTimeFormatTime < $nowTimestamp) {
                $response['message'] = 'Hết thời gian xác thực OTP.';
                $response['success'] = 'false';
                $response['time_out'] = 'true';
                $response['data'] = [
                    'otp' => $getVerify->otp
                ];

                return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            } else {

                if (isset($getVerify->otp)) {
                    $response['message'] = 'Lấy OTP thành công.';
                    $response['success'] = 'true';
                    $response['time_out'] = 'false';
                    $response['data'] = [
                        'otp' => $getVerify->otp
                    ];

                    $getPhone = DB::table('storage_sim')->where('id', $getVerify->storage_sim_id)->first();
                    DB::table('service_otp')->where('id', $task_id)->update(['status' => ServiceOTP::STATUS_ACTIVE]);
                    if (isset($getPhone)) {
                        $dataUpdateGetSim = [
                            'time_to_use' => (int) $getPhone->time_to_use + 1,
                            'last_online_date' => date('Y-m-d')
                        ];
                        DB::table('storage_sim')->where('id', $getPhone->id)->update($dataUpdateGetSim);

                        $dataHistory = [
                            'storage_sim_id' => $getPhone->id,
                            'history_date' => date('Y-m-d H:i:s'),
                            'history' => 'Lấy OTP thành công'
                        ];

                        DB::table('history_sim')->insert($dataHistory);
                    }
                } else {
                    $time = $strToTimeFormatTime - $nowTimestamp;
                    $check = date('i:s', $time);
                    $response['message'] = 'Đang chờ lấy OTP, ' . ' Thời gian chờ còn lại : ' . $check . '...';
                    $response['success'] = 'false';
                    $response['time_out'] = 'false';
                    $response['data'] = [
                        'otp' => ''
                    ];
                }
            }
        }

        return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function updateHistorySim(Request $request)
    {
        $phone = $request->get('phone');
        $history = $request->get('history');
        $data = [];
        $response = [
            'code' => 200
        ];

        if (isset($phone)) {
            $getPhone = DB::table('storage_sim')->where('phone', $phone)->first();
            $data['storage_sim_id'] = $getPhone->id;
        } else {
            $response['message'] = "phone bắt buộc không được để trống";
            $response['success'] = "false";

            return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($history)) {
            $data['history'] = $history;
        }

        $data['history_date'] = date('Y-m-d H:i:s');
        DB::table('history_sim')->insert($data);

        $response['message'] = "Thêm lịch sử cho phone thành công.";
        $response['success'] = "true";
        $response['data'] = $data;

        return \response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getListHistorySim(Request $request)
    {
        $id = $request->get('id');
        $date = $request->get('date');

        if (isset($date)) {
            $listHistory = DB::table('history_sim')->where('storage_sim_id', $id)->whereDate('history_date', $date)->get();
        } else {
            $listHistory = DB::table('history_sim')->where('storage_sim_id', $id)->get();
        }

        return \response()->json($listHistory);
    }

    public function deleteStorageSim($id)
    {
        DB::table('storage_sim')->where('id', $id)->delete();

        $data = [
            'status' => 'success',
            'message' => 'Sim deleted successfully'
        ];

        return response()->json($data);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table('storage_sim')->whereIn('id', $ids)->delete();

        return response()->json([  'success' => 'Sims deleted successfully']);

    }

}
