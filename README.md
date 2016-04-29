# baimifan

> ...

## bmfsms

- 支持 baichuan 发送短信

```
$code   = rand(1000, 9999);
$time   = 5;
$name   = ''; // 尾巴
$mobile = '18267xxxxxx';

$config = [
    'appkey'       => '',
    'secret'       => '',
    'template_id'  => '57', // 模版ID
    'signature_id' => '293', // 签名ID
    'context'      => [  // 模版变量
        'code' => $code,
        'time' => $time,
        'name' => $name,
    ]
];

$res = \Baimifan\Sms::baichuan($config)->to($mobile)->send();

```
