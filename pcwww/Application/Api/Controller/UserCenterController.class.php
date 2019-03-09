<?php
namespace Api\Controller;

use Api\Base\ApiBaseController;
use Api\Logic\AgencyLogic;
use Api\Logic\ArtistApplyLogic;
use Api\Logic\ArtworkLikeLogic;
use Api\Logic\AssetsLogic;
use Api\Logic\GalleryLogic;
use Api\Logic\InviteLogLogic;
use Api\Logic\MessageLogic;
use Api\Logic\PlannerLogic;
use Api\Logic\UserFollowerLogic;
use Api\Logic\ArtworkCategoryLogic;
use Api\Logic\UserLogic;
use Api\Model\UserModel;
use Api\Model\ArtworkModel;
use Api\Model\ArtworkCategoryModel;
use Custom\Define\Cache;
use Custom\Define\Code;
use Custom\Define\Image;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Custom\Manager\Token;
use Custom\Helper\Oss;
use Custom\Helper\Crypt3Des;
use Api\Logic\ArtworkLogic;

//my profile
class UserCenterController extends ApiBaseController
{
    //获取首页个人信息
    public function getMyHomeDetail()
    {
        $this->checkLogin();  //检查用户是否登录
        $tokenInfo = Token::getTokenInfo($this->token); //获取用户token信息
        if (empty($tokenInfo) || empty($tokenInfo['userInfo'])) {
            Util::jsonReturn(null, Code::SYS_ERR, 'System error!');
        }

        $userLogic = new UserLogic(); //实例化用户模块
        $userInfo = $userLogic->getUserInfoById($tokenInfo['userInfo']['id']); //根据用户id获取用户信息

        $messageLogic = new MessageLogic(); //获取用户未读信息数
        $unreadMessageTotal = $messageLogic->getMessageTotal(['is_deleted' => 'N', 'is_read' => 'N', 'to_user_id' => $this->loginUserId]);

        $assetsLogic = new AssetsLogic(); //获取用户头像
        $faceUrl = $assetsLogic->getUrl($userInfo['face']);

        $applyLogic = new ArtistApplyLogic(); //获取用户申请艺术家信息
        $agencyLogic = new AgencyLogic(); //获取用户艺术机构信息
        $plannerLogic = new PlannerLogic(); //策展人认证模块

        if ($userInfo['type'] == 3 || $userInfo['type'] == 7) {
            $isArtist = 1;
        } else {
            $isArtist = -1;
        }
        //获取用户申请艺术家信息
        $applyInfo = $applyLogic->field('user_id,verify_memo,verify_state')->where(['user_id' => $this->loginUserId])->find();
        //申请认证机构认证信息
        $agencyInfo = $agencyLogic->field('memo,status')->where(['uid' => $this->loginUserId])->find();
        //申请策展人认证信息
        $plannerInfo = $plannerLogic->field('memo,status')->where(['uid' => $this->loginUserId])->find();
        $total = M('Artwork')->where(['is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0], 'artist' => $tokenInfo['userInfo']['id']])->count();

        $info = [
            'artist' => $userInfo['id'], //艺术者编号
            'mobile' => $userInfo['mobile'], //手机号
            'name' => $userInfo['nickname'], //用户昵称
            'gender' => $userInfo['gender'], //用户昵称
            'faceUrl' => empty($faceUrl) ? '' : $faceUrl, //用户头像
            'motto' => $userInfo['motto'], //用户签名
            'resume' => empty($userInfo['resume']) ? '' : $userInfo['resume'], //艺术家履历
            'isArtist' => $isArtist, //是否艺术家
            'isSetCover' => empty($userInfo['cover']) ? 'N' : 'Y', //是否设置画廊封面
            'applyStatus' => !empty($applyInfo) ? $applyInfo['verify_state'] : '0', //审核状态
            'applyRemark' => strval($applyInfo['verify_memo']), //审核艺术家备注
            'agencyStatus' => !empty($agencyInfo) ? $agencyInfo['status'] : '0', //认证机构审核状态
            'agencyRemark' => strval($agencyInfo['memo']), //审核认证机构备注信息
            'isAgency' => $agencyInfo['status'] == 2 ? 1 : -1,
            'plannerStatus' => !empty($plannerInfo) ? $plannerInfo['status'] : '0', //策展人审核状态
            'plannerRemark' => strval($plannerInfo['memo']), //审核策展人备注信息
            'isPlanner' => $plannerInfo['status'] == 2 ? 1 : -1
        ];

        $galleryLogic = new GalleryLogic();
        $artLikeLogic = new ArtworkLikeLogic();
        $followLogic = new UserFollowerLogic();
        $inviteLogLogic = new InviteLogLogic();
        $galleryInfo = $galleryLogic->getDetailByArtist($userInfo['id']);

        $inviteCode = $inviteLogLogic->getInvite($userInfo['id']);
        $likeInfo = $artLikeLogic->field('type,artwork_id')->where(['like_user_id' => $this->loginUserId, 'is_like' => 'Y'])->select();
        $likeTemp = [];
        foreach ($likeInfo as $k => $v) {
            if ($v['type'] == '1') {
                $likeTemp[$k] = $v['artwork_id'];
            } else {
                $res = M('ArtworkUpdate')->field('artwork_id')->find($v['artwork_id']);
                $likeTemp[$k] = $res['artwork_id'];
            }
        }
        $likeTemp = array_unique($likeTemp);

        $info['inviteCode'] = $inviteCode;
        $info['artTotal'] = $userInfo['art_total'];
        $info['realtotal'] = $total;
        $info['viewTotal'] = (int)$galleryInfo['view_total'];
        $info['inviteTotal'] = $userInfo['invite_total'];
        $info['cover'] = $userInfo['cover'];
        $info['unreadMessageTotal'] = (int)$messageLogic->getMessageTotal(['is_deleted' => 'N', 'is_read' => 'N', 'to_user_id' => $this->loginUserId]);
        $info['unreadLikeMessageTotal'] = (int)$messageLogic->getMessageTotal(['type[in]' => '9,12', 'is_deleted' => 'N', 'is_read' => 'N', 'to_user_id' => $this->loginUserId]);
        $info['unreadCommentMessageTotal'] = (int)$messageLogic->getMessageTotal(['type[in]' => '10,13', 'is_deleted' => 'N', 'is_read' => 'N', 'to_user_id' => $this->loginUserId]);
        $info['unreadSystemMessageTotal'] = (int)$messageLogic->getMessageTotal(['is_deleted' => 'N', 'is_read' => 'N', 'from_user_id' => -1, 'to_user_id' => $this->loginUserId]);
        $info['likeTotal'] = count($likeTemp);
        $info['followerTotal'] = $followLogic->where(['user_id' => $this->loginUserId, 'is_follow' => 'Y'])->count();
        $info['followTotal'] = $followLogic->where(['follower' => $this->loginUserId, 'is_follow' => 'Y'])->count();




        //订单

        //加密
        $DES = new Crypt3Des();
        $post_data = [ 'userid' => $this->loginUserId];
        $param = $DES->encrypt(json_encode($post_data));
        //加密end

        $url_data = ['param' => $param];
        $url = C('Mall_api_url').'Orders/Statistics';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
//        print_r($json);exit;
        if(is_array($arr)){
            $info['mall_orders']=$arr;
        }
        //订单end

        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }

//get user's like artwork list我的喜欢
    public function getMyLikeArtworkList()
    {
        $this->checkLogin();
        $tokenInfo = Token::getTokenInfo($this->token);
        $userId = $tokenInfo['userInfo']['id'];
        $artworkLikeLogic = new ArtworkLikeLogic();
        $page = I('post.page', 1,'int');
        $pagesize = I('post.pagesize', 10,'int');

        $list = $artworkLikeLogic->getList($userId, $page, $pagesize);
        $total = $artworkLikeLogic->myLikeTotal($userId);
        $maxpage = $total % $pagesize == 0 ? $total / $pagesize : intval($total / $pagesize) + 1; //最大页数
        $info = [
            'data' => empty($list) ? [] : $list,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }

    //get the artist's follower list我的粉丝
    public function getMyFollowerList()
    {
        $this->checkLogin();
        $tokenInfo = Token::getTokenInfo($this->token);
        $userId = $tokenInfo['userInfo']['id'];
        $page = I('post.page', 1,'int');
        $pagesize = I('post.pagesize', 10,'int');
        if ($pagesize > 50) {
            $pagesize = 10;
        }
        $userFollowerLogic = new UserFollowerLogic();
        $userLogic = new UserLogic();
        $categoryLogic = new ArtworkCategoryLogic();
        $followerList = $userFollowerLogic->getFollowerList($userId, $page, $pagesize);
        $total = $userFollowerLogic->getFollowerTotal($userId);
        $maxpage = ceil($total / $pagesize); //最大页数
        $retList = [];

        $userid_arr = [];
        foreach ($followerList as $followInfo) {
            array_push($userid_arr, $followInfo['follower']);
        }

        $AgencyTypeList = $userLogic->getAgencyTypeList_byUids($userid_arr);//机构列表

        foreach ($followerList as $followInfo) {
            $user = $userLogic->getUserInfo($followInfo['follower']);
            $retList[] = [
                'id' => $followInfo['id'],
                'name' => $user['nickname'],
                'followerId' => $followInfo['follower'],
                'faceUrl' => $user['face'],
                'categoryNames' => $categoryLogic->getCategoryByUser($user['id']),
                'motto' => $user['motto'],
                'followTime' => date('Y-m-d', $followInfo['follow_time']),
                'is_artist' => $userLogic->isArtist($followInfo['follower']) ? 1 : 0,
                'is_agency' => $AgencyTypeList[$followInfo['follower']] > 0 ? 1 : 0,
                'AgencyType' => (int)$AgencyTypeList[$followInfo['follower']],
                'is_planner' => $userLogic->isPlann($followInfo['follower']) ? 1 : 0,
            ];
        }

        $info = [
            'data' => empty($retList) ? [] : $retList,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }

    //get my follow artist list我的关注
    public function getMyFollowList()
    {
        $this->checkLogin();
        $tokenInfo = Token::getTokenInfo($this->token);
        $followerId = $tokenInfo['userInfo']['id'];
        $page = I('post.page', 1,'int');
        $pagesize = I('post.pagesize', 10,'int');
        if ($pagesize > 50) {
            $pagesize = 10;
        }
        $userFollowerLogic = new UserFollowerLogic();
        $userLogic = new UserLogic();
        $categoryLogic = new ArtworkCategoryLogic();
        $followList = $userFollowerLogic->getFollowList($followerId, $page, $pagesize);
        $total = $userFollowerLogic->getFollowTotal($followerId);
        $maxpage = $total % $pagesize == 0 ? $total / $pagesize : intval($total / $pagesize) + 1; //最大页数
        $retList = [];


        $userid_arr = [];
        foreach ($followList as $followInfo) {
            array_push($userid_arr, $followInfo['user_id']);
        }

        $AgencyTypeList = $userLogic->getAgencyTypeList_byUids($userid_arr);//机构列表


        foreach ($followList as $followInfo) {
            $user = $userLogic->getUserInfo($followInfo['user_id']);
            $retList[] = [
                'id' => $followInfo['id'],
                'userId' => $followInfo['user_id'],
                'name' => $user['nickname'],
                'faceUrl' => $user['face'],
                'categoryNames' => $categoryLogic->getCategoryByUser($user['id']),
                'motto' => $user['motto'],
                'followTime' => date('Y-m-d', $followInfo['follow_time']),
                'is_artist' => $userLogic->isArtist($followInfo['user_id']) ? 1 : 0,
                'is_agency' => $AgencyTypeList[$followInfo['user_id']] > 0 ? 1 : 0,
                'AgencyType' => (int)$AgencyTypeList[$followInfo['user_id']],
                'is_planner' => $userLogic->isPlann($followInfo['user_id']) ? 1 : 0,
            ];
        }

        $info = [
            'data' => empty($retList) ? [] : $retList,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }

    //get my message list我的消息
    public function getMyMessageList()
    {

        $this->checkLogin();

        $page = I('post.page', 1,'int');
        $pagesize = I('post.pagesize', '', 'number_int');
        $page = $page <= 0 ? 1 : $page;
        $pagesize = $pagesize <= 0||$pagesize > 20 ? 20 : $pagesize;


        $type = addslashes(I('post.type',''));
        $perPageCount = I('post.pagesize', 10,'int');
        if ($perPageCount > 50) {
            $perPageCount = 10;
        }

        $messageLogic = new MessageLogic();

        $where_message['to_user_id'] = $this->loginUserId;
        if(!empty($type)){
            $arr = explode(',',$type);
            $where_message['type'] = ['IN',$arr];
        }
        $total = $messageLogic->where($where_message)->count();
        $maxpage=ceil($total/$pagesize);

       

        if ($total<=0) {
            Util::jsonReturn(['status' => 1000, 'info' => []]);
        }

        $messageList = $messageLogic->getMessageListByPage($this->loginUserId, $type, $page, $perPageCount);


        $userLogic = new UserLogic();

        $retList = [];
        foreach ($messageList as $message) {
            $faceUrl = $message['from_user_id'] == '-1' ? C('ADMIN_FACE') : $userLogic->getUserField('face', $message['from_user_id']);
            $name = $message['from_user_id'] == '-1' ? C('ADMIN_NAME') : $userLogic->getUserField('nickname', $message['from_user_id']);
            $res = M('Comment')->field('flag,content')->find($message['comment_id']);
            if (strpos($message['content'], '：')) {
                $arr = explode('：', $message['content']);
                if ('2' == $res['flag']) {
                    if (empty($arr[1])) {
                        $content = $message['content'];
                    } else {
                        $content = $arr[0] . '：' . "“" . base64_decode($res['content']) . "”";
                    }

                } else {
                    $content = $message['content'];
                }
            } else {
                $content = $message['content'];
            }

            $retList[] = [
                'name' => empty($name) ? C('ADMIN_NAME') : $name,
                'faceUrl' => empty($faceUrl) ? '' : $faceUrl,
                'content' => $content,
                'isRead' => $message['is_read'],
                'createTime' => date('Y-m-d H:i:s', $message['create_time']),
                'topicId' => $message['topic_id'],
                'type' => $message['type'],//message type
                'isRepay' => $message['is_repay'],
                'showType' => $message['show_type'],
                'comment_id' => $message['comment_id'],
                'link' => $messageLogic->getLink($message['id'])
            ];
        }

        $info = [
            'message' => $retList,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];

        $messageLogic->where(['is_deleted' => 'N', 'is_read' => 'N', 'to_user_id' => $this->loginUserId])->save(['is_read' => 'Y']);
        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }

//get the specified artist's invite artist list.我的邀请
    public function getMyInviteList()
    {
        $this->checkLogin();
        $retList = [];
        $userLogic = new UserLogic();
        $page = I('post.page', 1,'int');
        $pagesize = I('post.pagesize', 10,'int');
        $inviteLogLogic = new InviteLogLogic();
        $cateModel = new ArtworkCategoryModel();
        $artModel = new ArtworkModel();
        $total = $inviteLogLogic->where(['invited_user_id' => $this->loginUserId])->count('distinct(invite_user_id)');
        $maxpage = $total % $pagesize == 0 ? $total / $pagesize : intval($total / $pagesize) + 1; //最大页数
      /* $invitedList = $inviteLogLogic
            ->field('id,invite_user_id,invited_user_id,invite_code,invite_time')
            ->where(['invited_user_id' => $this->loginUserId])
            ->order('invite_time DESC')
            ->page($page, $pagesize)
            ->select();*/
        $start = $page-1<0?0:$page-1;
        $invitedList = $inviteLogLogic->query(
            "SELECT max(id) as id,invite_user_id,invite_time as invite_time
            FROM az_invite_log WHERE invited_user_id = ".$this->loginUserId."
            GROUP BY invite_user_id
            ORDER BY invite_time DESC
            LIMIT ".$start*$pagesize.",".$pagesize);
        foreach ($invitedList as $invitedInfo) {
            $userinfo = $userLogic->where(['is_deleted' => 'N', 'id' => $invitedInfo['invite_user_id']])->find();
            $faceUrl = $userinfo['face'];
            $category_content = $cateModel->getContent(implode(',', $artModel->getFields(['artist' => $invitedInfo['invite_user_id']], 'category')));
            $categoryNames = implode('/', array_values($category_content));
            $retList[] = [
                'id' => $invitedInfo['id'],
                'name' => $userinfo['nickname'],
                'invitedUserId' => $invitedInfo['invite_user_id'],
                'faceUrl' => $faceUrl,
                'categoryNames' => $categoryNames,
                'motto' => $userinfo['motto'],
                'followTime' => date('Y-m-d', $invitedInfo['invite_time'])
            ];
        }

        $info = [
            'data' => empty($retList) ? [] : $retList,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }

    //修改个人资料
    public function saveUserInfo()
    {
        $this->checkLogin();
        $userInfo = [];
        $userInfo['nickname'] = I('post.nickname','');
        $userInfo['name'] = I('post.nickname','');
        $userInfo['motto'] = I('post.motto','');
        $userInfo['resume'] = I('post.resume','');
        $userInfo['gender'] = I('post.gender','');
        $userInfo['face'] = I('post.face','');
        $userInfo['email'] = I('post.email','');
       // $userInfo['mobile'] = I('post.mobile','');
        $userInfo['cover'] = I('post.cover','');

        $userInfo = array_values_by_key($userInfo,[
            'nickname','name','motto','resume','gender','face','email','cover'
        ],function($k,$v){
            if(is_null($v) || empty($v)){
                return false;
            }else{
                return true;
            }
        });
        D('user')->where(['id' => $this->loginUserId])->save($userInfo);
        Util::jsonReturnSuccess();
    }

    /**
     * 上传图片
     */
    public function uploadImage()
    {
        if ($_FILES['file']['error'] == 4) {
            $response = ['error' => 2, 'message' => '没有上传图片'];
            Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $response]);
        } else {
            //处理上传图片
            $imgbuff = file_get_contents($_FILES['file']['tmp_name']);
            $info = Oss::upload($imgbuff, 'png');
            if(Code::SUCCESS == $info['status']){
                $result = $info['result'];
                $picture = $result['info']['url'];
                $data = [
                    'url' => $picture,
                ];
                Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $data]);
            }else{
                Util::jsonReturn(['status' => Code::SYS_ERR, 'info' => $info['result']]);
            }

        }
    }

    //获取我的认证信息
    public function getApplyState()
    {
        $uid = $this->loginUserId;
        $artistInfo = M('ArtistApply')->field('verify_state,verify_memo')->where(['user_id' => $uid])->find();
        $agencyInfo = M('Agency')->field('status,memo')->where(['uid' => $uid])->find();
        $plannerInfo = M('Planner')->field('status,memo')->where(['uid' => $uid])->find();

        $data = [
            'artistState' => empty($artistInfo['verify_state']) ? 0 : $artistInfo['verify_state'],
            'artistMemo' => empty($artistInfo['verify_memo']) ? '' : $artistInfo['verify_memo'],
            'agencyState' => empty($agencyInfo['status']) ? 0 : $agencyInfo['status'],
            'agencyMemo' => empty($agencyInfo['memo']) ? '' : $agencyInfo['memo'],
            'plannerState' => empty($plannerInfo['status']) ? 0 : $plannerInfo['status'],
            'plannerMemo' => empty($plannerInfo['memo']) ? '' : $plannerInfo['memo']
        ];

        Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $data]);
    }


    //获取我的创作花絮
    public function getMyArtistRecord(){
        $this->checkLogin();

        $artistId = $this->loginUserId;
        $page = I('post.page','1','int'); //分页页码
        $pagesize = I('post.pagesize', '10', 'int'); //每页显示条数

        $artworkLogic = new ArtworkLogic();
        $artworkLogic->getArtistRecord($artistId, $page, $pagesize,$this->loginUserId);
    }


    //获取我的作品集
    public function getMyArtistArtworkList()
    {
        $this->checkLogin();

        $userid = $this->loginUserId;
        $artistId = $userid;

        $page = I('post.page', 1, 'int');
        $pagesize = I('post.pagesize', 10, 'int');

        $artworkLogic = new ArtworkLogic();
        $artworkLogic->showArtworkListByPage($artistId, $page, $pagesize,$userid);
    }

    public function getMyInfo()
    {
        $this->checkLogin();
        $tokenInfo = Token::getTokenInfo($this->token);
        $userId = $tokenInfo['userInfo']['id'];

        $userLogic = new UserLogic();
        $userInfo = $userLogic->getUserInfoById($userId);



        $assetsLogic = new AssetsLogic();
        $faceUrl = $assetsLogic->getUrl($userInfo['face']);

        if ($userInfo['type'] == 3 || $userInfo['type'] == 7) {
            $isArtist = 1;
        } else {
            $isArtist = -1;
        }


        $agencyLogic = new AgencyLogic(); //获取用户艺术机构信息
        $plannerLogic = new PlannerLogic(); //策展人认证模块

        //申请认证机构认证信息
        $agencyInfo = $agencyLogic->field('memo,status,type')->where(['uid' => $this->loginUserId])->find();
        //申请策展人认证信息
        $plannerInfo = $plannerLogic->field('memo,status')->where(['uid' => $this->loginUserId])->find();

        $retInfo = [
            'id' => $userInfo['id'],
            'faceUrl' => Util::getFillImage($faceUrl, Image::faceWidth, Image::faceHeight),
            'nickname' => $userInfo['nickname'],
            'gender' => UserModel::GENDER_CN_LIST[$userInfo['gender']],
            'birthday' => $userInfo['birthday'],
            'motto' => html_entity_decode($userInfo['motto'], ENT_QUOTES),
            'isArtist' => $isArtist, //是否艺术家
            'isAgency' => $agencyInfo['status'] == 2 ? 1 : -1,
            'AgencyType' => $agencyInfo['status'] == 2 ? (int)$agencyInfo['type'] : 0,
            'plannerStatus' => !empty($plannerInfo) ? $plannerInfo['status'] : '0', //策展人审核状态
            'plannerRemark' => strval($plannerInfo['memo']), //审核策展人备注信息
            'isPlanner' => $plannerInfo['status'] == 2 ? 1 : -1
        ];


        Util::jsonReturn(['status' => 1000, 'info' => $retInfo]);
    }
}
