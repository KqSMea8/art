<?php

namespace Api\Base;


class AdminBaseController extends BaseController
{
    const NO_LOGIN_LIST = ['Auth/login', 'Auth/getVerifyCode'];
    protected function _initialize()
    {
        if (!$this->isLogin()) {
            $controllerActionPair = CONTROLLER_NAME."/".ACTION_NAME;
            if (!in_array($controllerActionPair, self::NO_LOGIN_LIST)) {
                $this->redirect(U('Admin/Auth/login'));
            }
        }
        $this->_nav();
    }
    public function isLogin()
    {
        $isLogin = cookie('isLogin');
        return !empty($isLogin);
    }
    public function _nav(){
      $menu = [
        '认证管理' => [
          'data' => [
            'Artist/index' => ['name' => '艺术家认证','url'=>'/Admin/Artist/index'],
            'Agency/index' => ['name' => '机构管理','url'=>'/Admin/Agency/index'],
            'Planner/index' => ['name' => '策展人管理','url'=>'/Admin/Planner/index']
          ]
        ],
        '用户管理' => [
          'data' => [
            'User/index' => ['name' => '普通用户管理','url'=>'/Admin/User/index'],
            'User/artist' => ['name' => '艺术家管理','url'=>'/Admin/User/artist']
          ]
        ],
        '艺术品管理' => [
          'data' => [
            'Art/index' => ['name' => '艺术品管理','url'=>'/Admin/Art/index'],
            'Art/category' => ['name' => '艺术品类别管理','url'=>'/Admin/Art/category'],
            'Art/artUpdate' => ['name' => '更新管理','url'=>'/Admin/Art/artUpdate'],
            'Art/tag' => ['name' => '标签管理','url'=>'/Admin/Art/tag']
          ]
        ],
        '统计信息' => [
          'data' => [
            'Statistics/index' => ['name' => '用户统计','url'=>'/Admin/Statistics/index']
          ]
        ],
        '创作平台' => [
          'data' => [
            'Extension/index' => ['name' => '推广申请','url'=>'/Admin/Extension/index']
          ]
        ],
        'SEO管理' => [
          'data' => [
            'Seo/index' => ['name' => '首页','url'=>'/Admin/Seo/index']
          ]
        ],
        '专题管理' => [
          'data' => [
            'Subject/index' => ['name' => '艺术专题','url'=>'/Admin/Subject/index'],
            'Subject/add_sub' => ['name' => '添加专题','url'=>'/Admin/Subject/addSubject'],
            'Subject/applylist' => ['name' => '专题申请列表','url'=>'/Admin/Subject/applylist'],
            // 'Subject/view' => ['name' => '查看详情','url'=>'/Admin/Subject/view'] ,
            // 'Subject/add_pro' => ['name' => '添加作品','url'=>'/Admin/Subject/add_pro']
          ],
          
        ]
      ];
      $action = CONTROLLER_NAME.'/'.ACTION_NAME;
      foreach ($menu as $key => $value) {
        foreach ($value['data'] as $k => $v) {
          if($k == $action){
            $menu[$key]['data'][$k]['select'] = '1';
            $menu[$key]['select'] = '1';
          }
        }
      }
      $this->assign('_nav',$menu);
    }
}
