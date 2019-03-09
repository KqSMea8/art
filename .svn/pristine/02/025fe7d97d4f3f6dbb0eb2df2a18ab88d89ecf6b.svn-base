<?php
Route::get('/test', function () {
    return view('test');
});
Route::get('/ceshi', function () {
    return view('ceshi');
});

Route::get('/template', function () {
    return view('template');
});

Route::get('/download', function () {
    return view('download');
});

Route::any('/{param1?}/{param2?}/{param3?}', function (Illuminate\Http\Request $request, $param1 = 'index', $param2 = 'index', $param3 = null) {

    $input = $request->except(['_token', 's']);
    $cookie = $request->cookie();

    //不需要登陆的页面
    $nologin = [
        'index/index',
        'index/template2',
        'forget/first',
        'forget/second',
        'forget/third',
        'register/first',
        'register/second',
        'passport/checkPhone',
        'passport/checkPhoneWithCode',
        'passport/checkLogin',
        'public/sendCode',
        'passport/checkPhoneWithCaptcha',
        'captcha/',
        'passport/logout',
    ];

    $islogin = [
        'index/index',
        'index/template2',
        'forget/first',
        'forget/second',
        'forget/third',
        'register/first',
        'register/second',
        'register/third',
        'passport/checkPhone',
        'passport/checkPhoneWithCode',
        'passport/checkLogin',
        'public/sendCode',
        'public/upload',
        'public/getOSS',
        'public/getOssH5UploadServer',
        'passport/checkPhoneWithCaptcha',
        'captcha/',
        'auth/index',
        'auth/first',
        'auth/second',
        'auth/rule',
        'auth/third',
        'auth/invite',
        'autharts/first',
        'autharts/second',
        'autharts/rule',
        'autharts/third',
        'authcurator/first',
        'authcurator/second',
        'authcurator/rule',
        'authcurator/third',
        'passport/logout',
        'public/ossH5uploadjsForm',
        'user/loadinfo',
    ];

    $artist_allow = [
        'index/index',
        'index/template2',
        'forget/first',
        'forget/second',
        'forget/third',
        'register/first',
        'register/second',
        'register/third',
        'passport/checkPhone',
        'passport/checkPhoneWithCode',
        'passport/checkLogin',
        'public/sendCode',
        'public/upload',
        'public/getOSS',
        'passport/checkPhoneWithCaptcha',
        'captcha/',
        'auth/index',
        'auth/first',
        'auth/second',
        'auth/rule',
        'auth/third',
        'auth/invite',
        'autharts/first',
        'autharts/second',
        'autharts/rule',
        'autharts/third',
        'authcurator/first',
        'authcurator/second',
        'authcurator/rule',
        'authcurator/third',
        'passport/logout',
        'article/manage',
        'article/edit',
        'auth/manage',
        'public/ossH5uploadjsForm',
        'public/getOssH5UploadServer',
        'upload/record',
        'upload/addupdate',
        'upload/edit',
        'promote/index',
        'topic/index',
        'promote/apply',
        'topic/apply',
        'invite/index',
        'trade/apply',
        'upload/manage',
        'trade/artwork',
        'upload/addartwork',
        'user/setcover',
        'upload/series',
    ];

    $agency_allow = [
        'index/index',
        'index/template2',
        'forget/first',
        'forget/second',
        'forget/third',
        'register/first',
        'register/second',
        'register/third',
        'passport/checkPhone',
        'passport/checkPhoneWithCode',
        'passport/checkLogin',
        'public/sendCode',
        'public/upload',
        'public/getOSS',
        'passport/checkPhoneWithCaptcha',
        'captcha/',
        'auth/index',
        'auth/first',
        'auth/second',
        'auth/rule',
        'auth/third',
        'auth/invite',
        'autharts/first',
        'autharts/second',
        'autharts/rule',
        'autharts/third',
        'authcurator/first',
        'authcurator/second',
        'authcurator/rule',
        'authcurator/third',
        'passport/logout',
        'article/manage',
        'article/edit',
        'auth/manage',
        'artorganization/arter',
        'public/ossH5uploadjsForm',
        'public/getOssH5UploadServer',
        'upload/manage',
    ];

    $planner_allow = [
        'index/index',
        'index/template2',
        'forget/first',
        'forget/second',
        'forget/third',
        'register/first',
        'register/second',
        'register/third',
        'passport/checkPhone',
        'passport/checkPhoneWithCode',
        'passport/checkLogin',
        'public/sendCode',
        'public/upload',
        'public/getOSS',
        'passport/checkPhoneWithCaptcha',
        'captcha/',
        'auth/index',
        'auth/first',
        'auth/second',
        'auth/rule',
        'auth/third',
        'auth/invite',
        'autharts/first',
        'autharts/second',
        'autharts/rule',
        'autharts/third',
        'authcurator/first',
        'authcurator/second',
        'authcurator/rule',
        'authcurator/third',
        'passport/logout',
        'article/manage',
        'article/edit',
        'auth/manage',
        'public/ossH5uploadjsForm',
        'public/getOssH5UploadServer',
    ];



    //全部转小写
    foreach($nologin as &$item){
        $item = strtolower($item);
    }

    foreach($islogin as &$item){
        $item = strtolower($item);
    }

    foreach($artist_allow as &$item){
        $item = strtolower($item);
    }

    foreach($agency_allow as &$item){
        $item = strtolower($item);
    }

    foreach($planner_allow as &$item){
        $item = strtolower($item);
    }
    //全部转小写 end

    //自动获取token
    $token_expire=86400;
    if ((isset($cookie['web_token']) && trim($cookie['web_token']) == '') || !isset($cookie['web_token'])) {
        $token = generateUid();
        $redis = Illuminate\Support\Facades\Redis::connection('cache');//artzhe api 和pcwww里面都是用db_index=1的库
        $redis->set(env('TOKEN_PREFIX', 'token.') . $token,'[]');
        $redis->expire(env('TOKEN_PREFIX', 'token.') . $token,$token_expire);
        \Cookie::queue('web_token', $token, $minutes = 0, $path = null, $domain = 'artzhe.com', $secure = false, $httpOnly = true);
    } elseif (isset($cookie['web_token']) && trim($cookie['web_token']) != '') {
        if (!preg_match("/^[0-9A-Z]{32}$/", $cookie['web_token'])) {
            $token = generateUid();
            $redis = Illuminate\Support\Facades\Redis::connection('cache');//artzhe api 和pcwww里面都是用db_index=1的库
            $redis->set(env('TOKEN_PREFIX', 'token.') . $token,'[]');
            $redis->expire(env('TOKEN_PREFIX', 'token.') . $token,$token_expire);
            \Cookie::queue('web_token', $token, $minutes = 0, $path = null, $domain = 'artzhe.com', $secure = false, $httpOnly = true);
        } else {
            $redis = Illuminate\Support\Facades\Redis::connection('cache');//artzhe api 和pcwww里面都是用db_index=1的库
            $tokenInfo = $redis->get(env('TOKEN_PREFIX', 'token.') . $cookie['web_token']);
            //print_r($tokenInfo);
            if (!is_array($tokenInfo) && empty($tokenInfo)) {
                $token = generateUid();
                $redis = Illuminate\Support\Facades\Redis::connection('cache');//artzhe api 和pcwww里面都是用db_index=1的库
                $redis->set(env('TOKEN_PREFIX', 'token.') . $token,'[]');
                $redis->expire(env('TOKEN_PREFIX', 'token.') . $token,$token_expire);
                \Cookie::queue('web_token', $token, $minutes = 0, $path = null, $domain = 'artzhe.com', $secure = false, $httpOnly = true);
            }

        }
    }

    if (isset($cookie['web_token'])) {
        $loginFlag = \App\Models\User::checkLogin($cookie['web_token']);

        $adrr = strtolower("$param1/$param2");

        if (!$loginFlag && !in_array($adrr, $nologin)) {
            header('Location:/');
            exit;
        }

                // /////////////////////////////////////////
            if ($loginFlag) {
                $user_role = \App\Models\User::getRole($cookie['web_token']);

                // $artistFlag = \App\Models\User::isArtist($cookie['web_token']);
                // $AgencyFlag = \App\Models\User::isAgency($cookie['web_token']);
                // $PlannerFlag = \App\Models\User::isPlanner($cookie['web_token']);
                $artistFlag = $user_role['isArtister'];
                $AgencyFlag = $user_role['isAgencyer'];
                $PlannerFlag = $user_role['isPlanner'];
                $adrr2 = strtolower("$param1/$param2");
                if (! in_array($adrr2, $islogin)) {

                    if (($artistFlag && in_array($adrr2, $artist_allow)) || ($AgencyFlag && in_array($adrr2, $agency_allow)) || ($PlannerFlag && in_array($adrr2, $planner_allow))) {
                        //
                    } else {
                        //header('Location:/');
                        echo '<head><meta http-equiv="refresh" content="5"><meta http-equiv="refresh" content="5;url=/"> </head>没有权限，5秒后跳转首页';
                        exit();
                    }
                }


            }


    }

    //$device = new \Utils\UserAgent();
    $device = new Mobile_Detect();//  包"mobiledetect/mobiledetectlib" Mobile_Detect

    if ($device->isMobile()) {
        // header('Location:http://'.config('app.mdomain'));
        $url = config('app.mdomain') . '/';
        header('Location:' . $url);
        exit;
    }


    if (!in_array(strtolower($param1), ['public', 'passport', 'user'])) {
        $url = url()->full();
        cookie()->queue(config('app.env') . config('app.name') . '_HistoryUrl', $url, 99999, null, config('app.domain'), false, false);
    }

    // \Log::info(date('Y-m-d H:i:s',time()).'请求：'.url()->full(),$input);

    //获取系统参数
    $syslist = \Cache::get(config('app.env') . '_' . config('app.name') . '_syslist');
    if (empty($syslist)) {
        $list = \App\Models\Sysparam::get()->toArray();
        foreach ($list as $item) {
            $syslist[$item['name']] = $item;
        }
        \Cache::put(config('app.env') . '_' . config('app.name') . '_syslist', $syslist, 120);
    }
    view()->share('syslist', $syslist);

    $third = $user = [];
    if (!empty($input['token'])) {
        $token = $input['token'];
        unset($input['token']);
    } else {
        $token = empty($cookie['web_token']) ? '' : $cookie['web_token'];
    }
    $userid = session('userid');
    $utype = 'ph';
    $userid = empty($userid) ? 1 : $userid;
    $loginFlag = \App\Models\User::checkLogin($token);
    if (!$loginFlag) {
        //取消自动判断登陆 20180129
//        if ($userid > 1) {
//            $user = \App\Models\User::getUserById($userid);
//            $third = \App\Models\Third::getThirdByUserId($userid);
//            \App\Models\User::synclogin($third, $token);
//        }
    } else {
        $res = \App\Models\User::getUserAsync($token);
        if (isset($res['code']) && $res['code'] == 30000 && isset($res['data']['status']) && $res['data']['status'] == 1000) {
            $utype = 'ph';
            $userid = $res['data']['info']['artist'];
            $request->session()->put('utype', $utype);
            $request->session()->put('userid', $userid);
            $user = \App\Models\User::getUserById($userid);
            $third = \App\Models\Third::getThirdByUserId($userid);
        }
    }

    $user_data = \Cache::get(config('app.env') . '_' . config('app.name') . '_user_' . $utype . '_' . $userid);
    if (empty($user_data) && !empty($user)) {
        $user_data = $user;
        \Cache::put(config('app.env') . '_' . config('app.name') . '_user_' . $utype . '_' . $userid, $user_data);
    }
    $user = $user_data;
    view()->share('user', $user);
    // var_dump($user);die();

    $class = 'App\\Http\\Controllers\\' . ucfirst(strtolower($param1)) . 'Controller';
    if (class_exists($class)) {
        $classObject = new $class($request);
        if (method_exists($classObject, $param2)) {
            if (is_null($param3)) {
                return $classObject->$param2($request);
            } else {
                return $classObject->$param2($request, $param3);
            }
        }
    } else {
        $class = 'App\\Http\\Controllers\\Controller';
        $classObject = new $class($request);
    }

    if (\View::exists($param1 . '.' . $param2)) {
        return view($param1 . '.' . $param2);
    }

    return abort(404);
});
