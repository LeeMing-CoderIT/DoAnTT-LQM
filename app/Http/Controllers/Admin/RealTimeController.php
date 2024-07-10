<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RealTimeController extends Controller
{
    public function logoutUser(){
        $response = []; $response['change'] = false;
        $users = User::select('users.*')
            ->join('setting_users', 'users.id', '=', 'setting_users.user_id')
            ->where('setting_users.status', 1)->get();
        foreach ($users as $user){
            $offline = strtotime(date('Y-m-d H:i:s')) > strtotime('+10 minute',strtotime ($user->settings()->updated_at));
            if($offline){
                $response['change'] = true;
                $user->settings()->update(['status' => 0]);
            }
        }
        return response()->json($response);
    }
}
