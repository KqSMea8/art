<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>艺术家免费认证</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/auth.css?v=2.0.0" rel="stylesheet">
  </head>
  <body>
    <div id="app">
      <header class="ysz-header">
        <div class="y-header">
          <div class="w clearfix">
            <a href="/index">
              <h1 class="y-head fl">
              <img class="logo" src="/image/logo.png" alt="logo">
              <span class="y-title">创作平台</span>
              </h1>
            </a>
            <div class="user fr">
              <div class="info">
                <img :src="myInfo.face">
                <span>@{{myInfo.name}}</span>
                <change-user-btn></change-user-btn>
                <a href="/passport/logout">退出</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div id="main">
        <div class="w clearfix">
          <div class="main-wrap">
            <h2 class="title">艺术家免费认证</h2>
            <div class="rule-wrap" v-show="ruleShow">
              <ul class="rules">
                <li class="rule">
                  <h3>艺术者认证是什么？</h3>
                  <p>艺术者认证服务是针对艺术家的真实性证明，认证成功后，从而曝光艺术家的作品以及艺术故事，艺术者平台将宣传推广艺术家艺术品牌，形成艺术家的粉丝群体。</p>
                </li>
                <li class="rule">
                  <h3>艺术家特权</h3>
                  <p>
                    1.艺术家网络画廊：上传艺术作品，曝光艺术家的作品以及艺术故事，宣传推广艺术家艺术品牌，形成艺术家的粉丝群体；<br>
                    2.增值服务：认证成为平台艺术家后，可直观统计画廊访问数据、互动数据，交易数据，更好的给艺术家呈现粉丝、收藏家的行为特征。<br>
                    3.原图存储：认证艺术家上传作品时，服务器将免费为您保存原图；<br>
                    4.更多特权：可在平台获得打赏、交易作品等其他个人服务。
                  </p>
                </li>
                <li class="rule">
                  <h3>如何申请认证？</h3>
                  <p>
                    想要获得认证需满足以下基本条件：<br>
                    a.个人资料完善，账号内头像必须为本人的真实头像；<br>
                    b.需要邀请码；<br>
                    目前艺术者接受从事绘画创作的艺术家（油画、水粉、插画、素描、工笔、水彩等…）。<br>
                    按照要求填写资料内容，并保证填写内容真实有效。提交资料后，艺术者团队将会在2个工作日内容完成认证处理，并将最后的结果以电话或站内消息的形式告知您。
                  </p>
                </li>
                <li class="rule">
                  <h3>如何提高审核通过率？</h3>
                  <p>
                    a.上传个人相关获奖，展览，以及相关荣誉情况以及图片；<br>
                    b.上传个人与创作艺术作品合影；<br>
                    c.填写个人信息，如：个人微信公众号，微博，博客信息。
                  </p>
                </li>
                <li class="rule">
                  <h3>如何获得邀请码？</h3>
                  <P>
                    1.找认识的已入驻艺术家索要；<br>
                    2.公众号 “艺术者空间”每天将公布一个邀请码，一个邀请码仅限当天可以申请认证。
                  </P>
                </li>
                <li class="rule">
                  <h3>认证是否收费？会不会泄露我的隐私？</h3>
                  <P>
                    艺术者平台申请认证艺术家是完全免费的。我们郑重承诺，您提交的任何资料仅用于您的账号认证，绝不泄露或他用，绝对保证您所提交材料的保密性和安全性。
                  </P>
                </li>
              </ul>
              <div class="agree-bar">
                <p class="agree-check" @click="agreeToggle"><input type="checkbox"><label for="agree"><i :class="['icons', isAgree? 'icon-agreed': 'icon-agree']"></i>同意<a @click.stop="showXieyi" href="javascript:;">《艺术者认证服务协议》</a></label></p>
                <p class="agree-btn">
                  <input @click="goToFirst" class="btn btn-24" type="button" value="下一步">
                  <p v-cloak class="error-text">@{{errorTip}}</p>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ysz-footer2></ysz-footer2>
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div class="thirdLayerIn anim-scale message-box" id="xieyi">
            <h1>艺术者认证服务协议<em @click="hideBox" title="关闭" >×</em></h1>
            <div class="content">
              <p class="aboutContent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;感谢使用艺术者。</p>
              <p class="aboutContent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;艺术者平台的各项服务所有权和运营权归深圳市艺者科技有限公司（以下简称：艺术者）所有。艺术者平台所提供的各项服务将按照其发布的服务条款和相关规定严格执行。用户需要完全同意用户协议以及相关规定，并且完成注册，通过审核后，才能成为艺术者的合作会员。</p>
              <p class="aboutContent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本协议将是用户（下称“艺术家”、“策展人”、“艺术机构”）和艺术者在艺术者平台上达成的全部共识。当用户在任何情形下进入或者使用艺术者时，就意味着用户同意并且接受此协议的约束。请用户认真阅读如下的条款。</p>
              <p class="aboutContent"><strong>1.艺术家特权</strong></p>
              <p class="aboutContent">1)  建立艺术家网络画廊：自主设定该封面的使用图片。从而曝光艺术家的作品以及艺术故事，宣传推广艺术家艺术品牌，形成艺术家的粉丝群体；</p>
              <p class="aboutContent">2)  增值服务：认证成为平台艺术家后，可直观统计画廊访问数据、互动数据，交易数据，更好的给艺术家呈现粉丝、收藏家的行为特征；</p>
              <p class="aboutContent">3)  原图存储：认证艺术家上传作品时，服务器将免费为您保存原图；</p>
              <p class="aboutContent">4)  更多特权：可在平台获得打赏、交易作品等其他个人服务。</p>
              <p class="aboutContent"><strong>2.艺术机构特权</strong></p>
              <p class="aboutContent">1)  艺术者词条：以百科形式展示机构信息。</p>
              <p class="aboutContent">2)  签约艺术家授权管理：开放艺术机构入驻，与艺术机构签约了的艺术家，可将作品信息托管给艺术机构在艺术者的用户账号进行管理，在线简单授权操作即可完成。</p>
              <p class="aboutContent">3)  艺术机构网络平台：曝光艺术机构的艺术家、作品、发布机构资讯动态，宣传艺术机构品牌。</p>
              <p class="aboutContent">4)  增值服务：认证成为艺术者平台的艺术机构后，可直观统计艺术机构访问数据、互动数据，交易数据，更好的给艺术机构呈现用户行为特征。</p>
              <p class="aboutContent"><strong>3.策展人特权</strong></p>
              <p class="aboutContent">1)  策展人词条：以百科形式展示策展人信息。</p>
              <p class="aboutContent">2)  发布展览：策展人可在艺术者策展人后台发布展览。</p>
              <p class="aboutContent">3)  增值服务：认证成为艺术者平台策展人后，可直观统计展览访问数据、互动数据，交易数据，更好的给策展人呈现用户行为特征。</p>
              <p class="aboutContent">4)  更多特权正在开放中。</p>
              <p class="aboutContent"><strong>4. 所有权</strong></p>
              <p class="aboutContent">艺术者平台或者授予艺术者所有权的个人或者机构的所有内容的所有权均受中华人民共和国和全球的知识产权法与其他财产权法律的保护。艺术者亦受中华人民共和国知识产权法的保护。在用户和艺术者平台之间，艺术者平台拥有并保留全部的权利，包括创建或者提供给用户服务中的界面、设计、排版、功能等内容，这些权利包括但不限于所有的版权、注册商标权、保守商业秘密的权利，专利权、著作权、数据保密权和其他的知识产权和所有权。艺术者展示的网站商标、服务标志、网站logo、网站名称均是艺术者在中华人民共和国的商标。在用户使用艺术者时，并不意味着用户拥有除了本协议中规定的权利以外的其他支配权，尤其是用户对艺术者的版权、商标或者其他知识产权的支配权。在本协议中保留明确授予用户某些权利的权利。</p>
              <p class="aboutContent"><strong>5. 作品交易说明</strong></p>
              <p class="aboutContent">申请认证一旦通过，即代表同意在艺术者平台上销售作品。所有认证艺术家、艺术机构在线销售的作品，或策展人发布展览信息等，不得绕过艺术者平台使用淘宝、微信支付等其他第三方渠道完成购买。一旦发现用户有引导藏家进行第三方渠道交易的行为，艺术者则有理由认为该用户存在信用问题，并与之结束全部合作（包括但不限于认证及站内推广曝光等），或剥夺其艺术者平台使用权。</p>
              <p class="aboutContent"><strong>6．认证费用说明</strong></p>
              <p class="aboutContent">艺术者平台申请认证是完全免费的。我们郑重承诺，您提交的任何资料仅用于您的账号认证，绝不泄露或他用，绝对保证您所提交材料的保密性和安全性。</p>
            </div>
            <div class="btn_agreen">
              <input type="button" @click="agreeRule" value="同意认证服务协议" class="btnRegister">
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.0"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/auth/rule.js?v=2.0.0"></script>
</html>
