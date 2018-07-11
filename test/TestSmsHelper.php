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
            'key' => 'd0a80f63a24995a84361604fa2ab14c5',
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
            'app_id' => '1400036784',
            'app_key' => '2e803b14a72d6aeab3e8528b14792d96',
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
}

$helper = new TestSmsHelper();
//$helper->testIndex();
$helper->testQcloud();