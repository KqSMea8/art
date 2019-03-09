<?php

namespace App10\Controller;

use App10\Base\ApiBaseController;
use App10\Logic\AgencyLogic;
use App10\Logic\ArtistApplyLogic;
use App10\Logic\ArtworkLikeLogic;
use App10\Logic\AssetsLogic;
use App10\Logic\GalleryLogic;
use App10\Logic\InviteLogLogic;
use App10\Logic\MessageLogic;
use App10\Logic\PlannerLogic;
use App10\Logic\UserFollowerLogic;
use App10\Logic\ArtworkCategoryLogic;
use App10\Logic\ArtworkLogic;
use App10\Logic\UserLogic;
use App10\Model\UserModel;
use App10\Model\ArtworkModel;
use App10\Model\ArtworkCategoryModel;
use Custom\Define\Cache;
use Custom\Define\Code;
use Custom\Define\Image;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Custom\Manager\Token;
use App10\Logic\ArticleLogic;
use App10\Logic\ArtworkConsultationLogic;
use Common\Logic\ArtworkCategoryLogic as ArtworkCategory;
use App10\Logic\WxAppGalleryLogic;
//my profile
class UserCenterController extends ApiBaseController
{

    public function testtttttt()
    {

//        $token_info=S(Cache::TOKEN_PREFIX . $this->token);
//
//        S(Cache::VERIFY_CODE_PREFIX . '13878830694','abcd');
//        print_r(S(Cache::VERIFY_CODE_PREFIX . '13878830694'));
//        if(!$token_info['userInfo']&&$token_info['thirdInfo']) {
//
//        }

    }



    //on the edit my profile page view, include the artist and appreciator.
    public function getMyProfile()
    {
        $this->checkLogin();
        $tokenInfo = Token::getTokenInfo($this->token);
        $unionId = $tokenInfo['userInfo']['unionId'];


        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $Gallery_info = $wxAppGalleryLogic->getOneGalleryByUnionId($unionId);



        $GENDER_CN_LIST = [
            1 => '男',
            2 => '女',
            3 => '未知'
        ];

        $retInfo = [
            'faceUrl' => Util::getFillImage($Gallery_info['user_face'], Image::faceWidth, Image::faceHeight),
            'nickname' => $Gallery_info['user_nickname'],
            'gender' => $GENDER_CN_LIST[$Gallery_info['user_gender']],
            'motto' => html_entity_decode($Gallery_info['user_summary'], ENT_QUOTES),
        ];


        Util::jsonReturn(['status' => 1000, 'info' => $retInfo]);
    }

}
