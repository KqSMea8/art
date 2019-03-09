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
    <title>艺术号-艺术者</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.6">
    <link rel="stylesheet" type="text/css" href="/Public/css/html2app.css?v=1.4.0">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.1.4">
  </head>
  <body>
    <div v-cloak id="article-detail">
      <!-- <div v-show="isLoading" id="loading">
        <img class="hold" src="/Public/image/contentHolder.png?v=0.0.1">
      </div> -->
      <div :class="['update-wrap', isLoading? 'hide': '']">
        <div id="header">
          <div class="title-wrap">
            <h3 class="title" style="text-indent: 0;">@{{update.title}}</h3>
          </div>
          <div class="painter">
            <div class="info">
              <a class="avatar-wrap" href="javascript:;">
                <img class="avatar" v-lazy="update.userinfo.faceUrl"></img>
                <i :class="['icons', 'icon-gender-'+update.userinfo.gender]"></i>
              </a>
              <div class="det">
                <h3 class="name">@{{update.userinfo.nickname}}
                  <i v-if="update.userinfo.is_artist == 1" class="icons icon-artist"></i>
                  <i v-if="update.userinfo.is_agency == 1" :class="['icons', 'icon-agency', 'icon-agency-'+update.userinfo.AgencyType]"></i>
                  <i v-if="update.userinfo.is_planner == 1" class="icons icon-planner"></i>
                </h3>
                <span class="ellipsis" v-if="update.userinfo.category">@{{update.userinfo.category}}</span>
                <span class="ellipsis" v-else>@{{update.userinfo.motto}}</span>
              </div>
              <div @click="toggleFollow()" :class="['follow', update.follow_user == '1'? 'followed': '']">
                <i class="icons icon-follow"></i>
                <span v-if="update.follow_user == '1'" class="label">已关注</span>
                <span v-else class="label">加关注</span>
              </div>
            </div>
          </div>
        </div>
        <div id="content" class="wrap view" v-html="update.content">
        </div>
        <div class="interact">
          <div class="labels fix">
            <div class="label-l">
              <i class="icons icon-time"></i>
              <span class="label">@{{update.create_time}}</span>
            </div>
            <div class="label-r">
              <span class="label">@{{update.views}}次浏览</span>
            </div>
          </div>
          <div class="liker fix">
            <div class="like" @click="toggleLike()">
              <i :class="['icons', update.is_like=='1'?'icon-liked': 'icon-like']"></i>
            </div>
            <ul class="likers fix">
              <li v-for="(item, index) in update.like_users">
                <img :src="item">
                <p v-if="update.like_count > 10 & index == '9'" class="num">@{{update.like_count}}</p>
              </li>
            </ul>
          </div>
          <ul v-if="update.comments.commentlist.length > 0" class="comments">
            <h2><i class="icons icon-comment"></i>@{{update.comments.total}}条评论</h2>
            <li class="comment" v-for="commentItem in update.comments.commentlist">
              <div class="user-com">
                <div class="icon-r" @click="toggleZan(commentItem.commentId,commentItem.isLike)">
                  <i :class="['icons', commentItem.isLike == 'Y'?'icon-praised': 'icon-praise']"></i>
                  <span v-if="commentItem.likes>0" class="label">@{{commentItem.likes}}</span>
                </div>
                <img class="avatar" v-lazy="commentItem.faceUrl">
                <a class="name" href="javascript:;">@{{commentItem.nickname}}</a>
                <div class="time">@{{commentItem.time}}</div>
                <p class="com">@{{commentItem.content}}
                  <span class="btn-re" @click="toRepay(commentItem.commentId)" v-if="update.is_repay == '1' && commentItem.repayTime == ''">回复</span>
                </p>
              </div>
              <div class="painter-com fix" v-if="commentItem.repayContent">
                <a class="name" href="javascript:;">@{{commentItem.repayer}}</a>
                <span>回复：</span>
                <span class="com">@{{commentItem.repayContent}}</span>
                <div class="time">@{{commentItem.repayTime}}</div>
              </div>
            </li>
          </ul>
          <div v-if="update.comments.commentlist.length == 0" class="comment-holder">
            <div class="img-wrap">
              <img src="/Public/image/commentHolder.png">
              <p>@{{commentHolder}}</p>
            </div>
            <div class="btn-group">
              <a @click="toComment()" class="btnx btn-comment">去留言</a>
            </div>
          </div>
          <div v-if="update.comments.total > 5" class="btn-group">
            <a @click="gotoApp('articleComment', articleId)" class="btnx btn-see">查看@{{update.comments.total}}条评论</a>
          </div>
        </div>
        <div class="rel" v-if="update.related.length > 0">
          <h2>可能感兴趣的内容</h2>
          <ul class="rel-list">
            <li class="rel-item fix" v-for="item in update.related">
              <a @click="gotoApp('articleDetail', item.id)">
                <img v-lazy="item.cover">
                <div class="rel-info">
                  <h3 class="ellipsis" style="text-indent: 0.2rem;">@{{item.title}}</h3>
                  <!-- <p>@{{item.content}}</p> -->
                  <p v-html="item.content"></p>
                </div>
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
  <script type="text/javascript" src="/Public/js/article/html2app.js?v=1.3.4"></script>
</html>
