<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;

class GenerateOTPController extends Controller
{
    public function sendOtp(Request $request){
       
        $cookie_name = str_replace('.', '_', $request->email);
       
        $cookie_value = sprintf("%06d", mt_rand(1, 999999));

        $encrypted_cookie_value = Crypt::encryptString($cookie_value);

        //Check if there is a cookie with the name of the email address given
        if(!isset($_COOKIE[$cookie_name])){

            Cache::forget($cookie_name);
            //cache the time and the frequency
            $time = time(); //current time
            $frequency = 1;

            Cache::put($cookie_name, [
                'time' => $time, 
                'frequency' => $frequency, 
                'encrypted_cookie' => $encrypted_cookie_value, 
                'cookie_value' => $cookie_value
            ], 2*3600);
            
            $cookie = setcookie($cookie_name, $encrypted_cookie_value, time() + (5*60), "/"); 

        }else{
           
            $timespan = time() - Cache::get($cookie_name)['time'];

            $frequency = Cache::get($cookie_name)['frequency'] + 1;
            $time = Cache::get($cookie_name)['time'];

            if( $timespan < 3600 && $frequency < 4 ){
                
                if($timespan < 300){

                        $encrypted_cookie_value = Cache::get($cookie_name)['encrypted_cookie'];

                        $cookie_value = Cache::get($cookie_name)['cookie_value'];
    
                        $cookie = setcookie($cookie_name, $encrypted_cookie_value, time() + (5*60), "/"); 
    
                        Cache::forget($cookie_name);
    
                        $time = time(); //current time
                        Cache::put($cookie_name, ['time' => $time, 'frequency' => $frequency, 'encrypted_cookie' => $encrypted_cookie_value], 2*3600);
                        
                        \Mail::to($request->email)->send(new OTPMail($cookie_value));

                        response('Your otp has been sent to your email address');
    
                    }

                Cache::forget($cookie_name);

                Cache::put($cookie_name, [
                    'time' => $time, 
                    'frequency' => $frequency, 
                    'encrypted_cookie' => $encrypted_cookie_value, 
                    'cookie_value' => $cookie_value
                ], 2*3600);

                $cookie = setcookie($cookie_name, $encrypted_cookie_value, time() + (5*60), "/"); 

                \Mail::to($request->email)->send(new OTPMail($cookie_value));

                return response('Your otp has been sent to your email address');

            }else{
                return response('You have exceeded the number of requests. Try again later');
            }
        }

        \Mail::to($request->email)->send(new OTPMail($cookie_value));

        return response('Your otp has been sent to your email address');

    }

    public function verifyOtp(Request $request){
        
        $cookie_name = str_replace('.', '_', $request->email);

        if(!isset($_COOKIE[$cookie_name])){
            return response('Your OTP is not valid');
        }
        
        $decrypted_cookie_value = Crypt::decryptString($_COOKIE[$cookie_name]);

        if($decrypted_cookie_value != $request->otp){
            return response('Your OTP is not valid');
            
        }

        //cookie expires and remove it from cache
        setcookie($cookie_name, "", time() - 3600);
        Cache::forget($cookie_name);
        
        return response('Your OTP is VALID');
    }
}