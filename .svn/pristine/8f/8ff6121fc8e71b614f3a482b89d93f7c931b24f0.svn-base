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
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.4">
    <link rel="stylesheet" type="text/css" href="/Public/css/html32app.css?v=1.4.4">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.1.4">
    <style>
      .view p{
        white-space: normal;
      }
      .user-type{
        font-weight: 100;
      }
      .search-user {
        width: 92%!important;
        padding: 0.267rem;
        box-sizing: content-box!important;
        background: #f2f2f2!important;
      }
      .search-user .search-user-info {
        float: left;
        padding-left: .27rem;
      }
      .rel .rel-item{
        max-width:100%;
        box-sizing: border-box;
      }
      .mabelike{
        display: block;
        width: 100%;
        position: relative;
      }
      .rel_cover{
        float: none;
        position: absolute;
        right: 0;
        top: 0;
      }
      .rel .rel-item .rel_div{
        float: none;
        width: 100%;
        padding-right: 2.8rem;
        position: relative;
      }
      /* .rel .rel-item img {
          float: none;
          width: 2.16rem;
          height: 2.16rem;
      } */
      .rel_cover {
          float: none;
          position: absolute;
          right: 0;
          top: 0;
      }

      .imgcoverbox{
        float: right;
        width: 1.6rem;
        height: 1.6rem;
        overflow: hidden;
      }

      .rel .rel-item img{
        float: none;
        max-width: 100%;
        width: 100%;
        height: auto;
      }
      .imgcover{
        float: right;
        width: 2.16rem;
        height: 2.16rem;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        background-origin: border-box;
        background-clip: border-box;
      }
    </style>
  </head>
  <body>
    <div v-cloak id="article-detail">
      <!-- <h1 data-artzhe-type="link" :data-artzhe-params="articleDetail">articleDetail</h1> -->
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
          <div v-if="update.tag.length > 0" class="flags">
            <i class="icons icon-flag"></i>
            <span v-for="(tagItem, index) in update.tag" :class="['label', 'flag', 'flag-' + index]">@{{tagItem}}</span>
          </div>
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
                <img v-lazy="item">
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
                <div class="hfbox fix">
                    <p class="com hf">@{{commentItem.content}}</p>
                    <span class="btn-re hfbtn" @click="toRepay(commentItem.commentId)" v-if="update.is_repay == '1' && commentItem.repayTime == ''">回复</span>
                </div>
                <!-- <p class="com">@{{commentItem.content}}
                  <span class="btn-re" @click="toRepay(commentItem.commentId)" v-if="update.is_repay == '1' && commentItem.repayTime == ''">回复</span>
                </p> -->
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
           <!--  <li class="rel-item fix" v-for="item in update.related">
              <a @click="gotoApp('articleDetail', item.id)" class="mabelike fix">
                <div :class="['rel-info', item.cover == ''? 'all': '']">
                  <h3 class="ellipsis" style="text-indent: 0.2rem;">@{{item.title}}</h3>
                  <p v-html="item.content"></p>
                </div>
                <img v-if="item.cover" v-lazy="item.cover">
              </a>
            </li> -->

            <li class="rel-item fix" v-for="item in update.related">
              <a @click="gotoApp('articleDetail', item.id)" class="mabelike fix">
                <div :class="['rel-info' , 'all' ,item.cover == ''? '': 'rel_div']">
                  <h3 class="ellipsis" style="text-indent: 0.2rem;">@{{item.title}}</h3>
                  <p v-html="item.content"></p>
                </div>
                <!-- <img v-if="item.cover" v-lazy="item.cover" class="rel_cover"> -->
                <div v-if="item.cover" class="imgcover rel_cover" :style="{backgroundImage:'url('+item.cover+')'}"></div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="/Public/js/lib/jquery.min.js"></script> <!-- //1.11.3 -->
  <!-- <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script> -->
  <script src="/Public/js/plugins/jquery.lazyload.min.js"></script>
  <script src="/Public/js/plugins/jquery.scrollstop.min.js"></script>
  <script type="text/javascript" src="/Public/js/article/html32app.js?v=1.3.7"></script>
</html>
