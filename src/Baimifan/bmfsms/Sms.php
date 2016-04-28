<?php
// +----------------------------------------------------------------------
//            -------------------------
//           /   / ----------------\  \
//          /   /             \  \
//         /   /              /  /
//        /   /    /-------------- /  /
//       /   /    /-------------------\  \
//      /   /                   \  \
//     /   /                     \  \
//    /   /                      /  /
//   /   /      /----------------------- /  /
//  /-----/      /---------------------------/
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://baimifan.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: lawyi
// | Date: 2016/4/28
// | Time: 21:05
// +----------------------------------------------------------------------

namespace Baimifan;

/**
 * Class Sms
 * @package Baimifan
 */
class Sms
{

    /**
     * @var
     */
    protected $config;

    /**
     * @var
     */
    protected $mobile;

    /**
     * @var
     */
    protected $callback;

    /**
     * Sms constructor.
     */
    public function __construct()
    {
    }

    /**
     * Author: chenyifan
     * Des: -make-
     *
     * @param array $config
     *
     * @return Sms
     */
    public static function make($config = [ ])
    {
        $sms = new self();

        foreach ($config as $key => $value) {
            $sms->config[$key] = $value;
        }

        return $sms;
    }

    /**
     * Author: chenyifan
     * Des: -to-
     *
     * @param $mobile
     *
     * @return $this
     */
    public function to($mobile)
    {

        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Author: chenyifan
     * Des: -baichuan-
     *
     * @param array $config
     *
     * @return Sms
     */
    public static function baichuan($config = [ ])
    {
        $sms = new self();

        foreach ($config as $key => $value) {
            $sms->config[$key] = $value;
        }

        $sms->callback = function () use ($sms) {

            date_default_timezone_set('Asia/Shanghai');

            $c            = new \TopClient();
            $c->appkey    = $sms->config['appkey'];
            $c->secretKey = $sms->config['secret'];
            $c->format    = 'json';

            $req = new \OpenSmsSendmsgRequest;

            $send_message_request               = new \SendMessageRequest();
            $send_message_request->template_id  = $sms->config['template_id'];
            $send_message_request->signature_id = $sms->config['signature_id'];
            $send_message_request->mobile       = $sms->mobile;
            $send_message_request->context      = $sms->config['context'];

            $req->setSendMessageRequest(json_encode($send_message_request));
            $resp = $c->execute($req);

            $result = $resp->result;

            if ($result->successful == true) {
                return true;
            }

            return $result;
        };

        return $sms;
    }

    /**
     * Author: chenyifan
     * Des: -send-
     */
    public function send()
    {
        $func = $this->callback;

        return $func();
    }
}