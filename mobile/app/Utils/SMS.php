<?php

namespace App\Utils;

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;

class SMS{
    private $endPoint;
    private $accessKeyId;
    private $accessKeySecret;
    private $topic;
    private $smssign;

    public function __construct($endPoint,$accessKeyId,$accessKeySecret,$topic,$smssign)
    {
        $this->endPoint = $endPoint;
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->topic = $topic;
        $this->smssign = $smssign;
    }
    public function run($mobile, $data, $templateCode = 'SMS_67126106')
    {
        //$config = config('services.aliyun');
        $endPoint = 'https://'.$this->endPoint;
        $accessId = $this->accessKeyId;
        $accessKey = $this->accessKeySecret;
        /**
         * Step 1. 初始化Client
         */

        $client = new Client($endPoint, $accessId, $accessKey);
        /**
         * Step 2. 获取主题引用
         */
        $topicName = $this->topic;
        $topic = $client->getTopicRef($topicName);
        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($this->smssign, $templateCode);
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        if ($data) {
            $batchSmsAttributes->addReceiver($mobile, $data);
            $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        }

        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
        $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try
        {
            $res = $topic->publishMessage($request);
            return $res->isSucceed();
//        echo "\n";
//        echo $res->getMessageId();
//        echo "\n";
        }
        catch (MnsException $e)
        {
            echo $e;
            echo "\n";
        }
    }
}
