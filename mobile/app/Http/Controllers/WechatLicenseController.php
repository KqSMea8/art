<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class WechatLicenseController extends Controller
{

    //微信授权回调
    public function callback()
    {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $state = $_GET['state'];
            header("Location:https://test-www.artzhe.com/Api/WechatLicense/CodeCallback?code={$code}&state={$state}");
            exit();
        } else {
            //echo "NO CODE";
            return ['status'=>30001,'msg'=>'NO CODE'];
        }
    }

}
