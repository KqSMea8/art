<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 10:58
 */

namespace App\Utils;

require_once public_path(). '/../vendor/aliyun/aliyun-dysms-php-sdk/api_sdk/vendor/autoload.php';


use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

// 加载区域结点配置
Config::load();

class AliyunDysms
{



    static $acsClient = null;

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient()
    {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = config('services.aliyun')['accessKeyId']; // AccessKeyId

        $accessKeySecret = config('services.aliyun')['accessKeySecret']; // AccessKeySecret

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if (static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public static function sendCode($to,$msg_type,$code)
    {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($to);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName("艺术者");

        switch ($msg_type) {
            case 'reg':
                // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
                $request->setTemplateCode('SMS_71670187');

                // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
                $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
                    "code" => $code,
//                    "product" => "dsd"
                ), JSON_UNESCAPED_UNICODE));

                break;

            case 'forget_password':
                // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
                $request->setTemplateCode('SMS_71670187');

                // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
                $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
                    "code" => $code,
//                    "product" => "dsd"
                ), JSON_UNESCAPED_UNICODE));

                break;
        }

        // 可选，设置流水号
//        $request->setOutId("yourOutId");

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
//        $request->setSmsUpExtendCode("1234567");

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;

    }


}