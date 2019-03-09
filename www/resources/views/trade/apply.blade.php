<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请交易</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/trade/apply.css?v=2.0.0" rel="stylesheet">
  </head>
  <body>
    <div v-cloak id="app">
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
        <div class="w">
          <div class="main-wrap mb-72 clearfix">
            <ysz-upload-nav></ysz-upload-nav>
            <div class="con-wrap">
              <h2 class="title">申请交易</h2>
              <div class="protocol-wrap" v-if="!applyMallInfo.isApplyed && !isAgree && applyMallInfo.Mallstatus == -1">
                <ol class="pro-list">
                  <li>
                    <h3><span class="num">1</span>本协议的订立</h3>
                    <p>在本网站（www.artzhe.com）依据《艺术者用户注册协议》登记注册，且符合本网站商家入驻标准(详见链接：http://www.ecmoban.com/contact/joinin.aspx）的用户（以下简称"商家"），在同意本协议全部条款后，方有资格使用"商创商城商家在线入驻系统"（以下简称"入驻系统"）申请入驻。一经商家点击"同意以上协议，下一步"按键，即意味着商家同意与本网站签订本协议并同意受本协议约束。
                    </p>
                  </li>
                  <li>
                    <h3><span class="num">2</span>入驻系统使用说明</h3>
                    <ul>
                      <li>商家通过入驻系统提出入驻申请，并按照要求填写商家信息、提供商家资质资料后，由 本网站审核并与有合作意向的商家联系协商合作相关事宜，经双方协商一致线下签订书面《开放平台供应商合作运营协议》（以下简称"运营协议"），且商家按照"运营协议"约定支付相应平台使用费及保证金等 必要费用后，商家正式入驻本网站。本网站将为入驻商家开通商家后台系统，商家可通过商家后台系统在本网站运营 自己的入驻店铺。</li>
                      <li>商家以及本网站通过入驻系统做出的申请、资料提交及确认等各类沟通，仅为双方合作的意向以及本网站对商家资格审核的必备程序，除遵守本协议各项约定外，对双方不产生法律约束力。双方间最终合作事宜及运营规则均以"运营协议"的约定及商家后台系统公示的各项规则为准。</li>
                    </ul>
                  </li>
                  <li>
                    <h3><span class="num">3</span>商家权利义务</h3>
                    <p>用户使用"商创商城商家在线入驻系统"前请认真阅读并理解本协议内容，本协议内容中以加粗方式显著标识的条款，请用户着重阅读、慎重考虑。</p>
                  </li>
                </ol>
                <div class="btn-group">
                  <div @click="agree" class="btn-agree">同意协议，下一步</div>
                </div>
              </div>
              <div class="step-first" v-if="isAgree && applyMallInfo.Mallstatus != 0">
                <p class="info"><i class="icons icon-info"></i>以下信息必须真实可靠</p>
                <div class="second-wrap form">
                  <div class="item clearfix">
                    <div class="tit"><label for="certImageIds">手持身份证照片</label></div>
                    <div class="con">
                      <div class="box" >
                        <el-upload
                          class="avatar-uploader"
                          action="/public/upload"
                          :headers="{'X-CSRF-TOKEN': '{{csrf_token()}}'}"
                          :show-file-list="false"
                          :before-upload="beforeIdCardUpload"
                          :on-success="handleIdCardSuccess">
                          <input type="button" class="btn-s" value="上传">
                          <ul v-if="list.idCardList.length > 0" class="img-list clearfix">
                            <li class="img-item"><img :src="list.idCardList[0].url"></li>
                          </ul>
                          <div class="el-loading-mask3" v-show="uploadloading"><div class="el-loading-spinner"><svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg><!----></div></div>
                        </el-upload>
                        <div class="img-demo">
                          <p>查看示例图&gt;</p>
                          <img src="/image/auth/idcard.png">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="btn-group">
                    <input @click="joinMall" class="btn-submit" type="button" :value="btnText">
                  </div>
                </div>
              </div>
              <div class="state-wrap" v-if="applyMallInfo.isApplyed && applyMallInfo.Mallstatus == 0">
                <img src="https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/ico_auditing.png">
                <p class="msg">正在审核中...</p>
                <p class="remark">您的信息已提交，艺术者工作人员将在1~2个工作日内与您联系，<br>请您耐心等候，谢谢！</p>
              </div>
              <div class="state-wrap" v-if="applyMallInfo.isApplyed && applyMallInfo.Mallstatus == 2 && !isAgree">
                <img src="https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/ico_fail.png">
                <p class="msg fail">审核失败</p>
                <p class="remark">您的信息由于@{{applyMallInfo.checkMsg}}的原因并没有成功<br>请您重新申请，谢谢！</p>
                <div class="btn-group">
                  <div @click="agree" class="btn-agree">重新申请</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ysz-footer2></ysz-footer2>
    </div>
  </body>
  <script src="/js/lib/vue.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.6"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/trade/apply.js?v=2.0.0"></script>
</html>