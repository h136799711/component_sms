<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * @author    hebidu<346551990@qq.com>
 * @copyright 2017 www.itboye.com Boye Inc. All rights reserved.
 * @link      http://www.itboye.com/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-12-20 16:53
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace by\component\sms\aliyun;

use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Core\Config;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Profile\DefaultProfile;
use by\component\sms\SmsManageInterface;
use by\infrastructure\helper\CallResultHelper;


class AliyunSmsManage implements SmsManageInterface
{

    protected $phoneNumbers = '13484379290';
    protected $sign = '登录验证';
    protected $template = 'SMS_8145826';
    protected $templateParams = '{"customer":"何必都"}';
    protected $accessKeyId = '';
    protected $accessKeySecret = '';
    protected $region = 'cn-hangzhou';
    protected $endPointName = 'cn-hangzhou';
    protected $outIdPrefix = 'prefix_';
    protected $api_uri = "dysmsapi.aliyuncs.com";

    /**
     * 数组结构
     * [
     * 'phone'=>'13484379290,15858199064'
     * 'sign' => '登录验证',
     * 'template' => 'SMS_8145826',
     * 'templateParams' => '{"customer":"何必都"}',
     * 'accessKeyId' => '',
     * 'accessKeySecret' => '',
     * 'region' => 'cn-hangzhou',
     * 'endPointName' => 'cn-hangzhou'
     * ]
     * @param array $data
     * @return AliyunSmsManage
     */
    public function setData($data)
    {
        if (array_key_exists('prefix', $data)) {
            $this->outIdPrefix = $data['prefix'];
        }
        if (array_key_exists('api_uri', $data)) {
            $this->api_uri = $data['api_uri'];
        }
        if (array_key_exists('template', $data)) {
            $this->template = $data['template'];
        }
        if (array_key_exists('template_params', $data)) {
            $this->templateParams = is_array($data['template_params']) ? json_encode($data['template_params'], JSON_UNESCAPED_UNICODE) : $data['template_params'];
        }
        if (array_key_exists('access_key_id', $data)) {
            $this->accessKeyId = $data['access_key_id'];
        }
        if (array_key_exists('access_key_secret', $data)) {
            $this->accessKeySecret = $data['access_key_secret'];
        }
        if (array_key_exists('region', $data)) {
            $this->region = $data['region'];
        }
        if (array_key_exists('end_point_name', $data)) {
            $this->endPointName = $data['end_point_name'];
        }
        if (array_key_exists('phone', $data)) {
            $this->phoneNumbers = $data['phone'];
        }
        if (array_key_exists('sign', $data)) {
            $this->sign = $data['sign'];
        }

        return $this;
    }

    public function sendAll()
    {
        // TODO: Implement sendAll() method.
    }

    /**
     * 发送短信
     */
    public function send() {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($this->phoneNumbers);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($this->sign);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($this->template);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam($this->templateParams);
        $outId = uniqid($this->outIdPrefix, true);
        // 可选，设置流水号
        $request->setOutId($outId);

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        $request->setSmsUpExtendCode("");

        // 发起访问请求
        $acsResponse = $this->getAcsClient()->getAcsResponse($request);
        $acsResponse = json_decode(json_encode($acsResponse, JSON_UNESCAPED_UNICODE), JSON_OBJECT_AS_ARRAY);
        $acsResponse['out_id'] = $outId;
        if (array_key_exists('Code', $acsResponse) && strtoupper($acsResponse['Code']) == 'OK') {
            return CallResultHelper::success($acsResponse);
        }

        return CallResultHelper::fail($acsResponse['Message'], $acsResponse);
    }

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public function getAcsClient() {
        Config::load();
        //产品名称:云通信短信服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //初始化acsClient,暂不支持region化
        $profile = DefaultProfile::getProfile($this->region, $this->accessKeyId, $this->accessKeySecret);
        // 增加服务结点
        DefaultProfile::addEndpoint($this->endPointName, $this->region, $product, $this->api_uri);
        return new DefaultAcsClient($profile);
    }



}