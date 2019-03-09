<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/26
 * Time: 14:54
 */

namespace Activity\Controller;

use Activity\Base\ApiBaseController;
use Custom\Helper\Crypt3Des;
use Custom\Define\Cache;
use Custom\Define\Time;

class UserController extends ApiBaseController
{

    public function login()
    {//从passport获取登陆 ,返回loginCallback， js同步登陆
        $go_url = I('get.go_url');//登录后跳转地址
        $url = C('passport_mobilelogin') . '?az_back=' . C('login_callback') . '&back_act=' . urlencode($go_url);
        header("Location: " . $url);
        exit;
    }

//    public function loginMall()
//    {//从passport获取登陆,跳转到mall登陆接口实现商城单个登陆
//        $go_url = urldecode(I('get.go_url'));//登录后跳转地址
//        $az_back = C('Mall_login_url');
//        $url = C('passport_mobilelogin') . '?az_back=' . urlencode($az_back) . '&back_act=' . urlencode($go_url);
//        header("Location: " . $url);
//        exit;
//    }

    public function loginCallback()
    {

        $go_url = I('get.back_act');
        $passport_validate_token = I('get.passport_validate_token');

        //加密
        $DES = new Crypt3Des();
        $post_data = ['token' => $passport_validate_token, 'user_ip' => $_SERVER['REMOTE_ADDR']];
        $param = $DES->encrypt(json_encode($post_data));
        //加密end


        $url_data = ['param' => $param];
        $url = 'https://test-passport.artzhe.com/passport/user/AccessToken';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);


        if ($arr['errno'] === 0) {

            $isArtist = $arr['data']['type'] == 3 ? 1 : -1;
            S(Cache::TOKEN_PREFIX . $this->token,
                ['userInfo' => $arr['data'],
                    'thirdInfo' => [],
                    'thirdFullInfoJson' => [],
                    'isLogin' => true,
                    'isArtist' => $isArtist
                ],
                Time::TOKEN_EXPIRE_1_DAY
            );
        }

        echo '<span style="font-size:18px;"> </span><span style="font-size:24px;"><meta http-equiv="refresh" content="3;URL=' . $go_url . '"> </span><span style="font-size:24px;">跳转</span>';
        echo '
 <script type="text/javascript">
//同步maill seller
var script = document.createElement(\'script\');
script.src = "' . C('Mall_url') . '/seller/privilege.php?act=signin&az_from=mpartzhe";
document.body.appendChild(script);
//同步maill seller end
</script>

 ';
    }

}