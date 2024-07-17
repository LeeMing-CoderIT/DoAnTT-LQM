<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SettingUser;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:user {root} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $root = $this->argument('root');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if ($root=='admin' || $root=='user') {
            $validator = \Validator::make(
                ['email' => $email],
                ['email' => 'required|email|unique:users']
            );
    
            if ($validator->fails()) {
                $this->error('Email không hợp lệ hoặc đã tồn tại người dùng.');
            } else {
                $data = [
                    'email' => $email,
                    'fullname' => $email,
                    'password' => bcrypt($password),
                    'root' => ($root=='admin'?1:0)
                ];
                if($user = User::create($data)){
                    SettingUser::create(['user_id'=>$user->id]);
                    $this->info('Đăng ký thành công.'); 
                }else{
                    $this->error('Đăng ký thất bại.');
                }
            }
        } else {
            $this->error('Lỗi loại người dùng.');
        }

        return 0;
    }
}
