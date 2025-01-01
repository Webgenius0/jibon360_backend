<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleUser;
use App\Models\User;
use App\Traits\Traits\SMS;
use Illuminate\Http\Request;
use App\Models\Sos;

class SosController extends Controller
{
    use SMS;
    public function index($lat, $long)
    {
        $user = auth('api')->user()->id;
        $circles = CircleUser::where('user_id', $user)->pluck('circle_id')->unique();
        $members = CircleUser::whereIn('circle_id', $circles)->pluck('user_id')->unique();
        $circleUsers = User::whereIn('id', $members)->get();
        $sos = Sos::create(['user_id' => $user, 'lat' => $lat, 'long' => $long]);
        if ($sos) {
            foreach ($circleUsers as $cu) {
                if ($cu->id != $user) {
                    $phone = $cu->phone;
                    $link = "http://jibon360.com/sos/" . $sos->id;
                    //$this->twilioSms($phone, 'this sms for testing.');
                    //$this->bdSms($phone, 'this sms for testing. thard sms');
                }
            }
        }
        return response()->json([
            'status'     => true,
            'message'    => 'SOS Send Successfully',
            'code'       => 200,
            'data'       => $sos,
        ], 200);
    }

    public function sosApi($sos_id)
    {
        $sos = Sos::where('id', $sos_id)->where('status', 1)->first();
        if ($sos) {
            return response()->json([
                'status'     => true,
                'message'    => 'SOS Send Successfully',
                'code'       => 200,
                'data'       => $sos,
            ], 200);
        }else{
            return response()->json([
                'status'     => false,
                'message'    => 'SOS Not Found',
                'code'       => 200,
                'data'       => $sos,
            ], 200);
        }  
    }

    public function sosWeb($sos_id)
    {
        $sos = Sos::where('id', $sos_id)->where('status', 1)->first();
        return view('frontend.sos', compact('sos'));
    }


}

