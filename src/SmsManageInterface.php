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
    /**
     * 设置配置信息
     * @param $data
     * @return mixed
     */
    public function setData($data);

    /**
     * 单发
     * @return mixed
     */
    public function send();

    /**
     * 群发
     * @return mixed
     */
    public function sendAll();
}