<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术者</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.3">
    <link rel="stylesheet" type="text/css" href="/Public/css/html32app.css?v=1.4.6">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.4.6">
    <style>
      .view img {
        display: block;
        margin-top: 0.24rem;
        width: 100%;
      }
    </style>
    <!-- <script src="https://jic.talkingdata.com/app/h5/v1?appid=CC91C1C415594DFC9B2DE0776ECA2EA0&vn=4.2.0&vc=artzhe"></script> -->
  </head>
  <body>
    <div v-cloak id="artwork-update">
      <!-- <div v-show="isLoading" id="loading">
        <img class="hold" src="/Public/image/contentHolder.png?v=0.0.1">
      </div>  -->
      <div :class="['update-wrap', isLoading? 'hide': '']">
        <div id="header">
          <div class="title-wrap">
            <h3 class="title">@{{update.title}}</h3>
          </div>
          <div class="art-info">
            <!-- <i class="icons icon-time"></i> --><span class="creat-date">@{{update.time}}</span>
          </div>
          <div class="painter">
            <div class="info">
              <a class="avatar-wrap" @click="gotoApp('galleryDetail', update.publisherInfo.id)">
                <img class="avatar" v-lazy="update.publisherInfo.faceUrl" >
                <i :class="['icons', 'icon-gender-'+update.publisherInfo.gender]"></i>
              </a>
              <div class="det">
                <h3 class="name">@{{update.publisherInfo.name}}
                  <i class="icons icon-artist"></i>
                  <!-- <i class="icons icon-agency"></i> -->
                  <!-- <i class="icons icon-planner"></i> -->
                </h3>
                <span class="ellipsis">@{{update.shareInfo.category}}</span>
              </div>
              <div @click="toggleFollow()" :class="['follow', update.publisherInfo.isFollow == 'Y'? 'followed': '']">
                <i class="icons icon-follow"></i>
                <span v-if="update.publisherInfo.isFollow == 'Y'" class="label">已关注</span>
                <span v-else class="label">加关注</span>
              </div>
            </div>
          </div>
        </div>
        <div id="wit" class="wrap view" v-html="update.wit">
        </div>
        <div class="art-parent">
          <p class="rel-info">关联作品</p>
          <a class="art-name" data-artzhe-type="link" data-artzhe-typeDetail="artworkDetail" :data-artzhe-id="update.artwork_id" :href="'/artwork/detail/' + update.artwork_id">@{{update.artname}}</a>
        </div>
        <div class="interact">
          <div v-if="update.tags.length > 0" class="flags">
            <i class="icons icon-flag"></i>
            <span v-for="(tag, index) in update.tags" :class="['label', 'flag', 'flag-' + index]">@{{tag}}</span>
          </div>
          <div class="labels fix">
            <div class="label-l">
              <i class="icons icon-time"></i>
              <span class="label">@{{update.create_time}}</span>
            </div>
            <div class="label-r">
              <span class="label">@{{update.view_total}}次浏览</span>
            </div>
          </div>

          <div class="liker fix">
            <div class="like" @click="toggleLike()">
              <i :class="['icons', update.is_like=='Y'?'icon-liked': 'icon-like']"></i>
            </div>
            <ul class="likers fix">
              <li v-for="(item, index) in update.likes">
                <img :src="item">
                <p v-if="update.like_total > 10 & index == '9'" class="num">@{{update.like_total}}</p>
              </li>
            </ul>
          </div>
          <ul v-if="update.commentList.length > 0" class="comments">
            <h2>
              <i class="icons icon-comment"></i>
              @{{update.commentTotal}}条评论
            </h2>
            <li class="comment" v-for="commentItem in update.commentList">
              <div class="user-com">
                <div class="icon-r" @click="toggleZan(commentItem.commentId,commentItem.isLike)">
                  <i :class="['icons', commentItem.isLike == 'Y'?'icon-praised': 'icon-praise']"></i>
                  <span v-if="commentItem.likes>0" class="label">@{{commentItem.likes}}</span>
                </div>
                <img class="avatar" v-lazy="commentItem.faceUrl">
                <a class="name" href="javascript:;">@{{commentItem.nickname}}</a>
                <div class="time">@{{commentItem.time}}</div>

                <div class="hfbox fix">
                    <p class="com hf">@{{commentItem.content}}</p>
                    <span class="btn-re hfbtn" @click="toRepay(commentItem.commentId)" v-if="update.is_repay == 'Y' && commentItem.repayTime == ''">回复</span>
                </div>
              </div>
              <div class="painter-com fix" v-if="commentItem.repayContent">
                <a class="name" href="javascript:;">@{{commentItem.repayer}}</a>
                <span>回复：</span>
                <span class="com">@{{commentItem.repayContent}}</span>
                <div class="time">@{{commentItem.repayTime}}</div>
              </div>
            </li>
          </ul>
          <div v-if="update.commentList.length == 0" class="comment-holder">
            <div class="img-wrap">
              <img src="/Public/image/commentHolder.png">
              <p>@{{commentHolder}}</p>
            </div>
            <div class="btn-group">
              <a @click="toComment()" class="btnx btn-comment">去留言</a>
            </div>
          </div>
          <div v-if="update.commentTotal > 5" class="btn-group">
            <a @click="gotoApp('artworkComment', update.id)" class="btnx btn-see">查看@{{update.commentTotal}}条评论</a>
          </div>

        </div>
        <div class="rel" v-if="update.related.length > 0">
          <h2>可能感兴趣的内容</h2>
          <ul class="rel-list">
            <li class="rel-item fix" v-for="item in update.related">
              <a @click="gotoApp('artworkUpdate', item.id)" class="mabelike fix">
                <div :class="['rel-info' , 'all' ,item.cover == ''? '': 'rel_div']">
                  <h3><span class="ellipsis">@{{item.title}}</span></h3>
                  <p>@{{item.summary}}</p>
                </div>
                <img v-if="item.cover" v-lazy="item.cover" class="rel_cover">
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/plugins/jquery.lazyload.min.js"></script>
  <script src="/Public/js/plugins/jquery.scrollstop.min.js"></script>
  <script type="text/javascript" src="/Public/js/gallery/html32app.js?v=1.3.6"></script>
</html>
