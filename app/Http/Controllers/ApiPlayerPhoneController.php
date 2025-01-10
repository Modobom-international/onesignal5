<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

class ApiPlayerPhoneController extends Controller
{
    public function getPlayerPhone()
    {
        $getPhone = \DB::table('players_phones')->where('status', 1)->orderBy('id', 'desc')->first();
        $data = [];
        if (!$getPhone) {
            $data['status_code'] = 200;
            $data['message'] = 'Not exist phone number!';
            $data['success'] = false;
        } else {
            $data['status_code'] = 200;
            $data['success'] = true;
            $data['message'] = 'Get player and phone successful!';
            $data['data'] = [
                "phone_number" => $getPhone->phone,
                "player_id" => $getPhone->player_id,
            ];

            $dataUpdate = [
                'status' => 0,
                'status_time_modified' => date('Y-m-d H:i:s'),
            ];

            \DB::table('players_phones')->where('phone', $getPhone->phone)->where('player_id', $getPhone->player_id)->update($dataUpdate);
        }

        return \response()->json($data);
    }

    public function getSmsOtp(Request $request)
    {
        $player_id = $request->get('player_id');
        $now = date('Y-m-d H:i:s');

        if (!$player_id) {
            $data['status_code'] = 200;
            $data['message'] = 'Param player is empty!';
            $data['time_out'] = false;
            $data['success'] = false;
            $data['code'] = '';

            return \response()->json($data);
        }

        $getPhone = \DB::table('players_phones')->where('status', 0)->where('player_id', $player_id)->first();
        if (!isset($getPhone->status_time_modified)) {
            $data['status_code'] = 200;
            $data['message'] = 'Player_id is not set!';
            $data['time_out'] = false;
            $data['success'] = false;
            $data['code'] = '';

            return \response()->json($data);
        }

        $timeOutTimestamp = strtotime($getPhone->status_time_modified . ' + 1 minute');
        $formatTime = date('Y-m-d H:i:s', $timeOutTimestamp);
        $strToTimeFormatTime = strtotime($formatTime);
        $nowTimestamp = strtotime($now);
        $getOtp = \DB::table('sms_otp')->where('player_id', $player_id)->orderBy('id', 'desc')->first();
        if (isset($getOtp->otp)) {
            $pre_match = '/[0-9]{6}/';
            $regex = preg_match($pre_match, $getOtp->otp, $matches);
            if ($regex > 0) {
                $getOtp->otp = $matches[0];
            }

            if ($strToTimeFormatTime < $nowTimestamp) {
                $data['status_code'] = 200;
                $data['message'] = 'Timeout for get OTP!';
                $data['success'] = false;
                $data['time_out'] = true;
                $data['code'] = $getOtp->otp;

                return \response()->json($data);
            }

            $data['status_code'] = 200;
            $data['success'] = true;
            $data['message'] = 'Get OTP successful!';
            $data['time_out'] = false;
            $data['code'] = $getOtp->otp;

            $dataUpdate = [
                'status' => 0,
            ];

            \DB::table('sms_otp')->where('id', $getOtp->id)->update($dataUpdate);
        } else {
            if ($strToTimeFormatTime < $nowTimestamp) {
                $data['status_code'] = 200;
                $data['message'] = 'Timeout for get OTP!';
                $data['success'] = false;
                $data['time_out'] = true;
                $data['code'] = '';

                return \response()->json($data);
            } else {
                $time = $strToTimeFormatTime - $nowTimestamp;
                $check = date('i:s', $time);
                $data['status_code'] = 200;
                $data['message'] = 'Waiting for OTP, ' . ' Timeout in : ' . $check . '...';
                $data['time_out'] = false;
                $data['success'] = false;
                $data['code'] = '';
            }
        }

        return \response()->json($data);
    }

    public function createSmsOtp(Request $request)
    {
        $phone = $request->get('phone');
        $player_id = $request->get('player_id');
        $otp = $request->get('otp');
        $raw_data = $request->get('raw_data');
        $data = [];
        $response = [
            'code' => '200',
        ];

        if (isset($phone)) {
            $regex = '/^[0-9]*$/';
            $pre_match = preg_match($regex, $phone);
            if (!$pre_match) {
                $response['message'] = "phone sai định dạng. Bắt buộc phone chỉ được phép là số";
                $response['success'] = "false";

                return response()->json($response);
            } else {
                $data['phone'] = $phone;
            }
        }

        if (isset($player_id)) {
            $data['player_id'] = $player_id;
        }

        if (isset($otp)) {
            $regex = '/^[G][-][\d]{6}/';
            $pre_match = preg_match($regex, $otp);
            if (!$pre_match) {
                $response['message'] = "OTP sai định dạng. Bắt buộc phone phải bắt đầu bằng G- và phía sau bắt buộc là 6 số";
                $response['success'] = "false";

                return response()->json($response);
            } else {
                $data['otp'] = $otp;
            }
        }

        if (isset($raw_data)) {
            $data['raw_data'] = $raw_data;
        }

        \DB::table('sms_otp')->insert($data);

        $response['message'] = "Thêm sms otp thành công.";
        $response['success'] = "true";
        $response['data'] = $data;

        return response()->json($response);
    }

    public function getDeviceStatus(Request $request)
    {
        $msgConfig = [
            '0' => 'Thiết bị chưa được kích hoạt, vui lòng liên hệ support!',
            '1' => 'Đang hoạt động',
            '-1' => 'Đã bị khóa',
        ];

        $deviceId = $request->get('device_id');
        $status = $request->get('status');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $response = [];

        if (empty($deviceId)) {
            $response['status'] = 0;
            $response['message'] = 'Device ID trống';
        } else {
            $getDeviceId = \DB::table('device_status')->where('device_id', $deviceId)->first();

            if ($getDeviceId) {
                $dataUpdate = [];
                if (isset($start_date)) {
                    if (DateTime::createFromFormat('Y-m-d', $start_date) !== false) {
                        $dataUpdate['start_date'] = $start_date;
                    } else {
                        $response['error'] = 'Start date không đúng định dạng Y-m-d';
                    }
                }

                if (isset($end_date)) {
                    if (DateTime::createFromFormat('Y-m-d', $end_date) !== false) {
                        $dataUpdate['end_date'] = $end_date;
                    } else {
                        $response['error'] = 'End date không đúng định dạng Y-m-d';
                    }
                }

                if (isset($status)) {
                    $dataUpdate['status'] = $status;
                    $current_status = $status;
                } else {
                    $current_status = $getDeviceId->status;
                }

                if (!empty($dataUpdate)) {
                    \DB::table('device_status')->where('device_id', $deviceId)->update($dataUpdate);
                }

                $response['status'] = $current_status;
                $response['message'] = $msgConfig[$current_status];
                $response['note'] = $getDeviceId->note;
            } else {
                $data = [
                    'device_id' => $deviceId
                ];

                if (isset($start_date)) {
                    if (DateTime::createFromFormat('Y-m-d', $start_date) !== false) {
                        $data['start_date'] = $start_date;
                    } else {
                        $response['error'] = 'Start date không đúng định dạng Y-m-d';
                    }
                } else {
                    $data['start_date'] = date('Y-m-d');
                }

                if (isset($end_date)) {
                    if (DateTime::createFromFormat('Y-m-d', $end_date) !== false) {
                        $data['end_date'] = $end_date;
                    } else {
                        $response['error'] = 'End date không đúng định dạng Y-m-d';
                    }
                } else {
                    $data['end_date'] = '2999-12-30';
                }

                if (isset($status)) {
                    $data['status'] = $status;
                } else {
                    $data['status'] = 0;
                }

                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');

                \DB::table('device_status')->insert($data);

                $response['status'] = $data['status'];
                $response['message'] = $msgConfig[$data['status']];
                $response['note'] = '';
            }
        }

        return response()->json($response);
    }

    public function listDeviceStatus()
    {
        $deviceStatus = \DB::table('device_status')->paginate(100);

        return view('admin.device-status.index', ['deviceStatus' => $deviceStatus]);
    }

    public function lockDeviceStatus($id)
    {
        $status = \DB::table('device_status')->where('id', $id)->update(['status' => -1]);

        if ($status == 1) {
            $response = [
                'status' => 'success',
                'message' => 'Lock Device successful.'
            ];
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Lock Device failed.'
            ];
        }

        return response()->json($response);
    }

    public function activeDeviceStatus($id)
    {
        $status = \DB::table('device_status')->where('id', $id)->update(['status' => 1]);

        if ($status == 1) {
            $response = [
                'status' => 'success',
                'message' => 'Active Device successful.'
            ];
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Active Device failed.'
            ];
        }

        return response()->json($response);
    }

    public function deleteDeviceStatus($id)
    {
        $status = \DB::table('device_status')->delete($id);

        if ($status == 1) {
            $response = [
                'status' => 'success',
                'message' => 'Delete Device successful.'
            ];
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Delete Device failed.'
            ];
        }

        return response()->json($response);
    }

    public function saveNoteDeviceStatus($id, Request $request)
    {
        $note = $request->get('note');
        \DB::table('device_status')->where('id', $id)->update(['note' => $note]);

        $response = [
            'status' => 'success',
            'message' => 'Update note successful.',
            'note' => $note
        ];

        return response()->json($response);
    }

    public function createUserSocial(Request $request)
    {
        $getAllRequest = $request->all();
        $response = [
            'code' => '200',
        ];

        if (empty($getAllRequest)) {
            $response['message'] = "Tất cả param đếu trống.";
            $response['success'] = "false";

            return response()->json($response);
        }

        $type = $request->get('type');
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $username = $request->get('username');
        $password = $request->get('password');
        $fa_status = $request->get('fa_status');
        $fa_value = $request->get('fa_value');
        $app_password = $request->get('app_password');
        $recovery_phone = $request->get('recovery_phone');
        $recovery_mail = $request->get('recovery_mail');
        $date_of_birth = $request->get('date_of_birth');
        $device_id = $request->get('device_id');
        $key = '';

        if (!isset($type)) {
            $response['message'] = "Param type bắt buộc không được để trống.";
            $response['success'] = "false";

            return response()->json($response);
        }

        if (!isset($username)) {
            $response['message'] = "Param username bắt buộc không được để trống.";
            $response['success'] = "false";

            return response()->json($response);
        }

        if (isset($recovery_phone)) {
            $regex = '/^[0-9]*$/';
            $pre_match = preg_match($regex, $recovery_phone);
            if (!$pre_match) {
                $response['message'] = "recovery_phone sai định dạng phone. Bắt buộc recovery_phone chỉ được phép là số";
                $response['success'] = "false";

                return response()->json($response);
            }
        }

        if (isset($recovery_mail)) {
            if (!filter_var($recovery_mail, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = "recovery_mail sai định dạng mail";
                $response['success'] = "false";

                return response()->json($response);
            }
        }

        if (isset($date_of_birth)) {
            if (DateTime::createFromFormat('Y-m-d', $date_of_birth) == false) {
                $response['message'] = "date_of_birth sai định dạng date. Định dạng date_of_birth Y-m-d";
                $response['success'] = "false";

                return response()->json($response);
            }
        }

        if (isset($fa_status)) {
            if ((int) $fa_status == 1 || (int) $fa_status == 0) {
            } else {
                $response['message'] = "fa_status sai định dạng. fa_status chỉ chấp nhận 1 hoặc 0";
                $response['success'] = "false";

                return response()->json($response);
            }
        }

        if (isset($password)) {
            $key = $this->generateRandomKey();
            $password = $this->encrypt($password, $key);
        }

        $data = [
            'type' => $type,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $username,
            'password' => $password,
            'fa_status' => $fa_status,
            'fa_value' => $fa_value,
            'recovery_phone' => $recovery_phone,
            'recovery_mail' => $recovery_mail,
            'date_of_birth' => $date_of_birth,
            'app_password' => $app_password,
            'device_id' => $device_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $getUserSocial = \DB::table('manager_user_social')->where('username', $username)->where('type', $type)->first();
        if ($getUserSocial) {
            $response['message'] = "username là " . $username . " với type là " . $type . " đã tồn tại.";
            $response['success'] = "false";
            $response['data'] = $data;

            return response()->json($response);
        }

        $status = \DB::table('manager_user_social')->insert($data);

        $data['key'] = $key;

        if ($status == 1) {
            $response['message'] = "Tạo user social thành công.";
            $response['success'] = "true";
            $response['data'] = $data;
        } else {
            $response['message'] = "Tạo user social không thành công.";
            $response['success'] = "false";
            $response['data'] = $data;
        }

        return response()->json($response);
    }

    public function updateUserSocial(Request $request)
    {
        $getAllRequest = $request->all();
        $response = [
            'code' => '200',
        ];

        if (empty($getAllRequest)) {
            $response['message'] = "Tất cả param đếu trống.";
            $response['success'] = "false";

            return response()->json($response);
        }

        $type = $request->get('type');
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $username = $request->get('username');
        $password = $request->get('password');
        $fa_status = $request->get('fa_status');
        $fa_value = $request->get('fa_value');
        $app_password = $request->get('app_password');
        $recovery_phone = $request->get('recovery_phone');
        $recovery_mail = $request->get('recovery_mail');
        $date_of_birth = $request->get('date_of_birth');
        $device_id = $request->get('device_id');
        $dataUpdate = [];
        $key = '';

        if (isset($recovery_phone)) {
            $regex = '/^[0-9]*$/';
            $pre_match = preg_match($regex, $recovery_phone);
            if (!$pre_match) {
                $response['message'] = "recovery_phone sai định dạng phone. Bắt buộc recovery_phone chỉ được phép là số";
                $response['success'] = "false";

                return response()->json($response);
            }

            $dataUpdate['recovery_phone'] = $recovery_phone;
        }

        if (isset($recovery_mail)) {
            if (!filter_var($recovery_mail, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = "recovery_mail sai định dạng mail";
                $response['success'] = "false";

                return response()->json($response);
            }

            $dataUpdate['recovery_mail'] = $recovery_mail;
        }

        if (isset($date_of_birth)) {
            if (DateTime::createFromFormat('Y-m-d', $date_of_birth) == false) {
                $response['message'] = "date_of_birth sai định dạng date. Định dạng date_of_birth Y-m-d";
                $response['success'] = "false";

                return response()->json($response);
            }

            $dataUpdate['date_of_birth'] = $date_of_birth;
        }

        if (isset($fa_status)) {
            if ((int) $fa_status == 1 || (int) $fa_status == 0) {
                $dataUpdate['fa_status'] = (int) $fa_status;
            } else {
                $response['message'] = "fa_status sai định dạng. fa_status chỉ chấp nhận 1 hoặc 0";
                $response['success'] = "false";

                return response()->json($response);
            }
        }

        if (isset($username)) {
            $dataUpdate['username'] = $username;
        } else {
            $response['message'] = "Param username bắt buộc không được để trống.";
            $response['success'] = "false";

            return response()->json($response);
        }

        if (isset($type)) {
            $dataUpdate['type'] = $type;
        } else {
            $response['message'] = "Param type bắt buộc không được để trống.";
            $response['success'] = "false";

            return response()->json($response);
        }

        if (isset($first_name)) {
            $dataUpdate['first_name'] = $first_name;
        }

        if (isset($last_name)) {
            $dataUpdate['last_name'] = $last_name;
        }

        if (isset($device_id)) {
            $dataUpdate['device_id'] = $device_id;
        }

        if (isset($password)) {
            $key = $this->generateRandomKey();
            $password = $this->encrypt($password, $key);
            $dataUpdate['password'] = $password;
        }

        if (isset($fa_value)) {
            $dataUpdate['fa_value'] = $fa_value;
        }

        if (isset($app_password)) {
            $dataUpdate['app_password'] = $app_password;
        }

        $dataUpdate['updated_at'] = date('Y-m-d H:i:s');

        $getUserSocial = \DB::table('manager_user_social')->where('username', $username)->where('type', $type)->first();
        if (!$getUserSocial) {
            $response['message'] = "Không tìm thấy username là " . $username . " với type là " . $type;
            $response['success'] = "false";
            $response['data'] = $dataUpdate;

            return response()->json($response);
        }

        \DB::table('manager_user_social')->where('username', $username)->where('type', $type)->update($dataUpdate);

        $dataUpdate['key'] = $key;

        $response['message'] = "Cập nhật user social thành công.";
        $response['success'] = "true";
        $response['data'] = $dataUpdate;

        return response()->json($response);
    }

    function encrypt($str, $key)
    {
        return base64_encode(openssl_encrypt($str, 'aes-128-ecb', $key));
    }

    public function generateRandomKey()
    {
        return 'base64:' . base64_encode(\Crypt::encrypt(config('app.cipher')));
    }
}
