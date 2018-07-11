<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/7/11
 * Time: 11:48
 */

namespace by\component\sms;


interface SmsManageInterface
{
    public function setData($data);

    public function send();
}