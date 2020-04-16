<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use App\Model\Goods;

class ApiController extends Controller
{
    //注册接口
    public function apiReg(Request $Request)
    {
        $data=$Request->input();
        if($data['pass'] != $data['passs']){
            echo "密码不一致";die;
        }
        
        $url='http://'.env('PASSPROT').'/api/reg';
        
        $client=new client();
        $response=$client->request('POST',$url,[
            'form_params'=>[
                'name'=>$data['name'],
                'email'=>$data['email'],
                'mibble'=>$data['mibble'],
                'pass'=>$data['pass']
            ]    
        ]);        
        return $response->getBody();     
    }

    //登录接口
    public function apiLogin(Request $Request)
    {
        $data=$Request->input();
        $url='http://'.env('PASSPROT').'/api/login';
        
        $client=new client();
        $response=$client->request('POST',$url,[
            'form_params'=>[
                'name'=>$data['name'],
                'pass'=>$data['pass']
            ]    
        ]);

        return $response->getBody();
    }

    //退出接口
    public function apiQuit(Request $Request)
    {
        $id=$Request->id;
        $key='str:user:token:app'.$id;
        $a=Redis::del($key);
        // echo $a;
        if($a==1){
            echo "退出成功";
        }
    }

    //商品详情
    public function apiGoods(Request $Request)
    {
        $id=$Request->id;
        $data=Goods::where('goods_id','=',$id)->first()->toArray();
        print_r($data);
    }
}
