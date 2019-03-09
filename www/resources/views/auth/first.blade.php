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
        <div class="w clearfix">
          <div class="main-wrap mb-72" id="auth">
            <h2 class="title">艺术家免费认证</h2>
            <div class="stage-wrap">
              <ul class="step-nav clearfix">
                <li class="active">
                  <span>个人信息</span><br>
                  <i class="dot"></i>
                </li>
                <li>
                  <span>认证图片</span><br>
                  <i class="dot dot2"></i>
                </li>
              </ul>
              <p class="info"><i class="icons icon-info"></i>以下信息必须真实可信</p>
              <div class="first-wrap form">
                  <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="457px" class="demo-ruleForm">
                    <el-form-item label="真实姓名" prop="name">
                      <el-input class="w-350" v-model="ruleForm.name" placeholder="请填写您的真实姓名"></el-input>
                    </el-form-item>
                    <el-form-item label="手机号码" prop="mobile">
                      <el-input class="w-350" v-model="ruleForm.mobile" placeholder="请填写您的手机号码" :maxlength="11"></el-input>
                    </el-form-item>
                    <!-- <el-form-item label="所在地区" prop="pos">
                      <el-cascader class="w-350"
                        :options="positions"
                        v-model="ruleForm.pos"
                        :props="cityProps"
                        @active-item-change="handleItemChange"
                      ></el-cascader>
                    </el-form-item> -->
                    <el-form-item label="所在地区" prop="pos">
                      <el-cascader class="w-435"
                        placeholder="请选择所在地区"
                        :options="positions"
                        v-model="ruleForm.pos"
                      ></el-cascader>
                    </el-form-item>
                    <el-form-item label="毕业院校" prop="college">
                      <el-select class="w-435" v-model="ruleForm.college" placeholder="请选择毕业院校">
                        <el-option 
                        v-for="item in colleges"
                        :label="item.label" 
                        :value="item.value"></el-option>
                      </el-select>
                      <el-input v-show="ruleForm.college == '其他'" class="w-350 mt14" v-model="ruleForm.inputCollege" placeholder="请填写毕业院校"></el-input>
                    </el-form-item>
                    <el-form-item v-if="!hasInvite" label="邀请码" prop="inviteCode">
                      <el-input class="w-350" v-model="ruleForm.inviteCode" placeholder="已入驻艺术家的邀请码（选填）"></el-input>
                    </el-form-item>
                    <el-form-item class="mb0" label="个人介绍" prop="resume">
                      <el-input class="w-435" type="textarea" :rows="10" v-model="ruleForm.resume" placeholder="1.个人介绍&#10;2.获奖情况&#10;3.参展情况&#10;"></el-input>
                    </el-form-item>
                    <div :class="[otherIsActive? 'active': '', 'other']">
                      <h4 @click="toggleActive" class="other-tit">看看别人怎么写<i class="icon-narrow"></i></h4>
                      <div class="other-con">
                        职业画家<br>
                        2010年毕业于中国美术学院油画系获学士学位<br>
                        2013年毕业于中国美术学院油画系获硕士学位<br>
                        2015年结业于中国艺术研究院“中国·俄罗斯油画艺术创作高级研修班”<br>
                        2011年～2016年中国艺术研究院中国油画院油画研究课题组研究员<br>
                        <br>
                        主要参展与荣誉：<br>
                        2010年6月，毕业创作（本科）获E-LAND奖学金“优秀毕业创作奖” <br>
                        2010年12月，参加“罗中立奖学金”获奖作品展，重庆美术馆 重庆<br>
                        2010年12月，参加“现实·超越”2010年中国百家金陵画展（油画）并获金奖，江苏省美术馆 南京<br>
                        2011年4月，中国油画院第二届“挖掘·发现——中国油画新人展”，获二等奖，中国油画院美术馆 北京<br>
                        2011年7月，获首届“凤凰艺术奖学金”<br>
                        2012年4月，参加“2012新写实油画展览”，中国美术馆 北京<br>
                        2012年6月，参加“最绘画”中国青年油画作品展，中国美术馆 北京<br>
                        2013年12月，参加“天天向上—筑中美术馆2013年度名师提名展”，筑中美术馆 北京<br>
                        2014年12月，参加“折桂枝—2014中国新锐绘画奖作品展”， Hi艺术中心·北京<br>
                        2015年9月，参加第二届南京国际美术展，南京国际展览中心   南京<br>
                        2015年11月，参加“INTER-YOUTH：国际高等艺术学院青年绘画展”，中国美术学院美术馆  杭州<br>
                        2016年10月，参加“澄怀观道”：语言与精神的表现力研究——中国油画院课题组学术研究结题作品展（暨国家艺术基金项目——“艺以载道”当代青年油画艺术作品展）   中国油画院美术馆  北京<br>
                        2016年11月，参加“天天向上”2011-2016名师提名五年回顾展  筑中美术馆  北京<br>
                      </div>
                    </div>
                    <div class="btn-group next">
                      <p class="error-text">@{{errorTip}}</p>
                      <el-button class="btn-24" type="primary" @click="submitForm('ruleForm')">@{{btnText}}</el-button>
                    </div>
                  </el-form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ysz-footer2></ysz-footer2>
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.6"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/plugin/area-json.js"></script>
  <script src="/js/auth/first.js?v=2.0.5"></script>
</html>