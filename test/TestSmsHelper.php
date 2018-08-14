<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/7/11
 * Time: 11:31
 */

require_once __DIR__."/../vendor/autoload.php";

use by\component\sms\juhe\SmsManage;

class TestSmsHelper
{
    public function testIndex()
    {
        $data = [
            'key' => '',
            'mobile' => '18557515452',
            'tpl_id' => '62520',
            'tpl_value' =>urlencode('#code#=123456')
        ];
        $result = SmsManage::instance()->setData($data)->send();
        var_dump($result);
    }

    public function testQcloud()
    {
        $data = [
            //测试用
            'app_id' => '',
            'app_key' => '',
//            'sms_sign' =>'小鲤智能',
//            'template_id' => '31528',
//            'params'=>[
//                '测试',\by\component\string_extend\helper\StringHelper::randAlphabet(6),'其它'
//            ],
            'mobile' => [
                ['86', '18557515452']
            ],
            'msg' => '【小鲤智能】您正在进行[单发]操作，您的验证码是xxxx。44如非本人操作，请忽略本短信',
        ];
        $result = \by\component\sms\qcloud\QcloudSmsManage::instance()->setData($data)->send();
        var_dump($result);
    }

    public function testAliyun() {
        $data = [
            'phone'=>'18557515452',
            'sign' => '登录验证',
            'template' => 'SMS_8145826',
            'template_params' => '{"customer":"何必都"}',
            'access_key_id' => '',
            'access_key_secret' => '',
            'region' => 'cn-beijing',
            'end_point_name' => 'cn-beijing',
            'api_uri' => 'dysmsapi.aliyuncs.com',
        ];

        $sms = new \by\component\sms\aliyun\AliyunSmsManage();
        $resp = $sms->setData($data)->send();
        var_dump($resp);
    }
}

$helper = new TestSmsHelper();
//$helper->testIndex();
//$helper->testQcloud();
$helper->testAliyun();