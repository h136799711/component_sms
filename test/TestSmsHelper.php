<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/7/11
 * Time: 11:31
 */

require_once "../vendor/autoload.php";

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
}

$helper = new TestSmsHelper();
$helper->testIndex();