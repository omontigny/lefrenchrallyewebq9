<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ConnectionCheckerController extends Controller
{
    //
    public static function redisTest()
    {
        
        try
        {
            $redis = Redis::connection();
            var_dump($redis->ping());
        } catch(Exception $e)
        {
            $e->getMessage();
        }
    }
}
