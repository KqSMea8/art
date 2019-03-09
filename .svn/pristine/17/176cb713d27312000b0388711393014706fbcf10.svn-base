<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>艺术家管理</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/global.css?v=0.0.1" rel="stylesheet">
    <link href="/css/arter.css?v=0.0.1" rel="stylesheet">
</head>

<body>
    <div id="atrerorg" v-cloak>
    <!-- <az-header></az-header> -->
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
                            <span class="text1line">{{myInfo.name}}</span>
                            <a href="/passport/logout">退出</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="main">
            <div class="w">
                <div class="main-wrap mb-72 clearfix" id="upload">
                    <ysz-upload-nav></ysz-upload-nav>
                    <div class="upload-right">
                        <h2 class="upload-rH">艺术家（{{haveArterNum}}）</h2>
                        <el-button class="el-button btn-24 el-button--primary upload-button" @click="addNewArter">+ 新艺术家</el-button>
                        <div class="upload-rCon clearfix" v-loading.body="loading" style="min-height: 300px; height: 100%">
                            <el-table
                                :data="tableData"
                                border
                                stripe
                                >
                                <!-- <el-table-column
                                label="序号"
                                type="index"
                                width="80">
                                </el-table-column> -->
                                <el-table-column
                                align="center"
                                label="头像"
                                width="100">
                                <template scope="scope" style="posiition:relative;">
                                    <img :src="scope.row.face" class="artericon"/>
                                </template>
                                </el-table-column>
                                <el-table-column
                                align="center"
                                property="nickname"
                                label="昵称"
                                >
                                <!-- <template scope="scope">
                                    {{ scope.row.nickname | split24word}}
                                </template> -->
                                <!-- <template scope="scope">
                                <el-popover trigger="hover" placement="top">
                                <p>住址: {{ scope.row.address }}</p>
                                <div slot="reference" class="name-wrapper">
                                    <el-tag>{{ scope.row.name }}</el-tag>
                                </div>
                                </el-popover>
                                </template> -->
                                </el-table-column>
                                <el-table-column
                                align="center"
                                property="address"
                                label="地址"
                                >
                                </el-table-column>
                                <el-table-column
                                align="center"
                                property="category_names"
                                label="艺术种类"
                                width="170">
                                </el-table-column>
                                <el-table-column
                                align="center"
                                property="artwork_count"
                                label="作品数"
                                width="80">
                                </el-table-column>
                                <el-table-column
                                align="center"
                                property="login_time"
                                width="120"
                                label="最后活跃时间">
                                </el-table-column>
                                <el-table-column
                                align="center"
                                property="artwork_count"
                                label="审核状态"

                                >
                                <template scope="scope">
                                    <p v-if="scope.row.check_status== -1">未通过</p>
                                    <p v-if="scope.row.check_status== 1">未审核</p>
                                    <p v-if="scope.row.check_status== 2">已通过</p>
                                    <p v-if="scope.row.check_status== 0">未提交审核</p>
                                    <p v-if="scope.row.check_status== -2">资料提交中</p>
                                </template>
                                </el-table-column>
                                <el-table-column
                                align="center"
                                label="操作"
                                width="120">
                                <template scope="scope">
                                    <el-button
                                    size="small"
                                    @click="gouTuArter(scope.row.id,scope.row.check_status)">进入用户</el-button>
                                </template>
                                </el-table-column>
                            </el-table>

                            <div class="upload-page el-pagination" v-if='totalpage > 1'>
                                <button type="button" :class="[ curpage == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev()"><</button>
                                <span class="upload-num">{{curpage}}/{{totalpage}}</span>
                                <button type="button" :class="[ curpage == totalpage ? 'disabled' : '','btn-next']" @click="pageNext()">></button>
                                <span class="el-pagination__jump ">
                                    <input type="number" min="1" number="true" v-model='inputpage' class="el-pagination__editor el-pagination__editor2"
                                        style="width: 58px;">
                                    <a href="javascript:;" @click="gotopage()" class="el-button el-button--info is-plain upload-jump">
                                        <span>跳转</span>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="addartboxbg" v-show="addArtDialog">
            <div class="addartbox">
                <div class="closebox"><div class="el-icon-close fr addArterClose" @click="addArterClose"></div></div>
                <el-table
                border
            :data="addArter"
            style="width: 100%">
            <el-table-column
                align="center"
                prop="mobile"
                label="手机号/邮箱"
                >
                <template scope="scope">
                    <el-input v-model="newArtI.mobile" placeholder="手机号/邮箱"></el-input>
                </template>
            </el-table-column>
            <el-table-column
                align="center"
                prop="nickname"
                label="昵称"
                width="150"
                >
                <template scope="scope">
                    <el-input v-model="newArtI.nickname"></el-input>
                </template>
            </el-table-column>
            <el-table-column
                align="center"
                prop="face"
                label="头像"
                width="110">
                <template scope="scope">
                    <div class="avatarbox" @click="openUploadImg=true" @mouseover="imgorbtn = true" @mouseout="imgorbtn = false">
                        <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
                        <!-- <el-button size="small" @click="openUploadImg=true" class="avatarbtn">上传</el-button> -->
                        <img :src="newArtI.face" class="avatar" id="upface">
                        <p class="hvp" :class="[imgorbtn ? 'hvpshow' : '']">更换头像</p>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                align="center"
                prop="gender"
                label="性别"
                width="140">
                <template scope="scope">
                    <el-select v-model="newArtI.gender" placeholder="请选择">
                        <el-option
                        v-for="item in addgendersel"
                        :label="item.label"
                        :value="item.value"
                        :disabled="item.disabled"
                        >
                        </el-option>
                    </el-select>
                </template>
            </el-table-column>
            <el-table-column
                align="center"
                prop="password"
                label="密码">
                <template scope="scope">
                    <el-input v-model="newArtI.password" placeholder="密码6-16位"></el-input>
                </template>
            </el-table-column>
            </el-table>
            <!-- <div id="uploadbox" style="width:100%;height:300px;display:none;">
                <iframe id="uploadifr" src="" style="width:100%;height:300px;"></iframe>
            </div> -->
            <el-button type="primary" class="sureaddart" @click="willAddArter">确定添加</el-button>
            </div>
        </div>

        <!-- 头像上传弹窗 -->
        <div v-cloak v-show="openUploadImg" class="addimglayer" id="j_layerShow">
            <div class="addimglayerbox" v-show="openUploadImg">
                <div class="layermain">
                    <div class="closebox"><div class="el-icon-close fr addArterClose" @click="openUploadImg= false"></div></div>
                    <div class="thirdLayerIn anim-scale clearfix upload-wrap">
                        <div class="uploadPics">
                            <div class="picCont" style="width:300px;height:300px;margin:20px auto 0;padding:0;" >
                                <div id="imgfield"  style=overflow:hidden;width:100%;height:100% ></div>
                            </div>
                            <div class="picFooter">
                            <input type="file" id="fileimg" name="fileimg" style="display:none" @change="imgchange" />
                            <span class="btn confirm" @click="$('#fileimg').click()">选择图片</span>
                            <span class="btn confirm" @click="uploadImg">{{uploadText}}</span>

                        </div>
                    </div>
                    <div class="img-preview">
                        <h3>上传头像</h3>
                        <canvas id="myCan" width="400" height="400"></canvas>
                    </div>
                    <p style="color:red;margin:10px 0 0 20px;clear:both;">头像上传格式为JPG,JPEG,GIF,PNG</p>
                </div>
            </div>
        </div>
    </div>
    <ysz-footer2></ysz-footer2>
</body>
<script src="/js/lib/vue.min.js"></script>
<script src="/js/lib/element/index.js"></script>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="/js/plugin/jquery.Jcrop.min.js"></script>
<!-- <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script> -->
<script src="/js/service/agent.js?v=2.1.0"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script src="/js/artorganization/arter.js"></script>
</html>
