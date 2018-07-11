<?php
/**
 * Created by PhpStorm.
 * User: itboye
 * Date: 2018/7/11
 * Time: 13:32
 */

namespace by\component\sms\qcloud;


use by\component\sms\SmsManageInterface;
use by\infrastructure\helper\CallResultHelper;
use Qcloud\Sms\SmsSingleSender;

class QcloudSmsManage implements SmsManageInterface
{
    private static $instance = null;
    private $appId;
    private $appKey;
    private $tmplId;
    private $smsSign;
    private $mobile;
    private $params;
    private $msg;

    public static function instance(){
        if (self::$instance == null) {
            self::$instance = new QcloudSmsManage();
        }
        return self::$instance;
    }

    /**
     * 格式
     *  app_id：app_id
     *  app_key ：app_key
     *  template_id：模板ID
     * sms_sign: 短信签名
     *  mobile : 发给谁
     * msg: 短信内容
     * @param $data
     * @return QcloudSmsManage
     */
    public function setData($data)
    {
        if (array_key_exists('app_id', $data)) {
            $this->appId = $data['app_id'];
        }
        if (array_key_exists('app_key', $data)) {
            $this->appKey = $data['app_key'];
        }
        if (array_key_exists('template_id', $data)) {
            $this->tmplId = $data['template_id'];
        }
        if (array_key_exists('sms_sign', $data)) {
            $this->smsSign = $data['sms_sign'];
        }
        if (array_key_exists('mobile', $data)) {
            $this->mobile = $data['mobile'];
        }
        if (array_key_exists('msg', $data)) {
            $this->msg = $data['msg'];
        }
        if (array_key_exists('params', $data)) {
            $this->params = $data['params'];
        }
        return $this;
    }


    public function send()
    {
        try {
            $sender = new SmsSingleSender($this->appId, $this->appKey);
            if (is_array($this->mobile)) {
                $ret = [
                ];
                foreach ($this->mobile as $one) {
                    if (is_array($one) && count($one) == 2) {
                        if (!empty($this->msg)) {
                            $result = $sender->send(0, $one[0], $one[1],
                            $this->msg, "", "");
                        } else {
                            $result = $sender->sendWithParam($one[0], $one[1], $this->tmplId, $this->params, $this->smsSign);
                        }

                        $obj = json_decode($result, JSON_OBJECT_AS_ARRAY);
                        array_push($ret, [
                            'success' => $obj['result'],
                            'msg' => $obj['errmsg']
                        ]);
                    } else {
                        array_push($ret, [
                            'success' => -1,
                            'msg' => 'mobile is invalid'
                        ]);
                        continue;
                    }
                }
                return CallResultHelper::success($ret);
            } else {
                $result = $sender->send(0, $this->mobile[0], $this->mobile[1],
                    $this->msg, "", "");
                $obj = json_decode($result, JSON_OBJECT_AS_ARRAY);
                return CallResultHelper::success($obj);
            }
        } catch(\Exception $e) {
            return CallResultHelper::fail($e->getMessage());
        }
    }

    public function sendAll()
    {
        // TODO: Implement sendAll() method.
    }


}