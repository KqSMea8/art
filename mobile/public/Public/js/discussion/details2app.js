Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: false,
    loading: '/Public/image/holder.png',
    attempt: 1,
})

var OCModel;

var VmDiscussion = new Vue({
    el: '#discussion',
    data: function() {
        return {
            isFollow: false,
            likeClick: false,
            followClick: false,
            zanClick: false,
            isLike: false,
            update: {
                userinfo: {
                    id: "",
                    nickname: "",
                    faceUrl: "",
                    gender: "1",
                    is_artist: 0,
                    is_agency: 0,
                    is_planner: 0
                },
            },
            id: '',
            sharelink: '',
            selected:'1',
            loading: false,
            replaylist: {
                maxpage: 1,
                page: 1,
                list: [],
            },
            likeslist: {
                maxpage: 1,
                page: 1,
                list: [],
            },
            zhuanlist: {
                maxpage: 1,
                page: 1,
                list: [],
            },
            isloading1: false,
            isloading2: false,
            isloading3: false,
            isnoData1: false,
            isnoData2: false,
            isnoData3: false,
            listhieght:0, //list高度
            artStr: {},
        }

    },
    // watch: {
    //     likeslist: function(){

    //     },
    //     replaylist: function(){
            
    //     }
    // },
    created: function() {
        this.init(); //
    },
    mounted: function() {
        if (FastClick) {
            FastClick.attach(document.body);
        }
        this.loadMore({num:1,size:6})
        // this.listhieght = window.innerHeight - document.getElementsByClassName('distab')[0].offsetTop-110 + 'px'
    },
    methods: {
        init: function (h5_token, updateId) {
            var that = this;
            this.updateId = this.GetLocationId() || '-1';

            var data = {
                h5_token: h5_token ? h5_token : this.GetRequest().h5_token,
                id: updateId ? updateId : this.updateId
            };


            var route = 'MobileGetH5/getTopicDiscussDetail';
            var api = window.location.origin + '/V50/' + route;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: api,
                data: data,
                success: function (res) {
                    if (res.code == 30000) {
                        document.title = res.data.info.artname;
                        var update = res.data.info;

                        // 去除为空的tag
                        // if(update.tags.length>0){
                        //   var u = update.tags.length;
                        //   while(u--){
                        //     if(arr[u]==''){
                        //       update.tags.splice(u,1);
                        //     }
                        //   }
                        // }
                    
                        var artObj = {
                            type: 'artworkDetail',
                            id: update.artwork_id
                        };
                        that.artStr = JSON.stringify(artObj);
                        update.content = that.px2rem(update.content);

                        that.sharelink = update.shareLink;
                        that.id = update.id;
                        that.update = update;

                        //图片懒加载
                        var el = document.createElement('div');
                        el.innerHTML = update.content;
                        var $el = $(el);
                        var imgs = $el.find('img');
                        imgNum = $("img").length,
                            imgs.each(function () {
                                var src = $(this).attr("src");
                                $(this).attr("data-original", src);
                                $(this).attr('src', '/Public/image/holder.png');
                            });
                        update.content = el.innerHTML;
                        that.$nextTick(function () {
                            $(".discontent img").lazyload({
                                threshold: 200,
                                event: "scroll", //滚动加载
                                effect: "fadeIn" //淡入
                            });
                            var $imgList = $('.discontent img');
                            $imgList.click(function (event) { //绑定图片点击事件
                                var index = $imgList.index(this);
                                that.gotoApp('image', index);
                            });

                            function pauseAll() {
                                $('.audioPlayBox').attr('data-flag', false);
                                for (var i = 0, len = $('audio').length; i < len; i++) {
                                    // $('audio')[i].currentTime=0;
                                    $('audio')[i].volume = 0.5; // 声音音量。1为最大
                                    $('audio')[i].pause();
                                    $('.playImgBox').removeClass('playPause').addClass('playimg'); // 重置播放图标
                                }
                            }

                            $('.audioPlayBox').on('click', function () {
                                var thisIndex = $('.audioPlayBox').index($(this));
                                if ($(this).attr('data-flag') == 'true') { // 通过判断$('.audioPlayBox')的data-flag来做操作
                                    pauseAll();
                                    $('.audioPlayBox').attr('data-flag', false);
                                    $(this).children(1).children('.playImgBox').removeClass('playPause').addClass('playimg'); // 为当前播放的加上暂停图标
                                } else {
                                    pauseAll();
                                    $(this).attr('data-flag', true);
                                    $(this).children(1).children('.playImgBox').removeClass('playimg').addClass('playPause'); // 为当前播放的加上暂停图标
                                    $('audio')[thisIndex].play();
                                }
                            })

                            //APP交互跳转
                            var $consList = $('[data-artzhe-type=link]');

                            //阻止默认事件函数
                            function stopDefault(e) {
                                if (e && e.preventDefault)
                                    e.preventDefault();
                                else
                                    window.event.returnValue = false; //兼容IE
                            }

                            $consList.click(function (event) {
                                stopDefault(event);
                                var index = $consList.index(this);
                                var type = $(this).attr('data-artzhe-typeDetail');
                                var id = $(this).attr('data-artzhe-id');

                                that.gotoApp(type, id);
                            });


                        });

                        that.fadeOut();

                        //islike状态传给app端
                        var ocData = {
                            api: 'islike',
                            type: update.is_like,
                        };
                        that.jsToNative(ocData);

                        //传入分享数据给app
                        var shareobj ={
                            api: 'share',
                            id:update.id,
                            shareTitle: update.title!='' ? update.title : update.shareContent,
                            shareUrl: update.shareLink,
                            shareImgUrl: update.thumbnails.length>0 ? update.thumbnails[0] : '',
                            shareContent: update.shareContent
                        }
                        that.jsToNative(shareobj);

                        //传入话题title给app
                        var htData = {
                            api: 'topictitle',
                            id: update.topic.id,
                            type: update.topic.title
                        }
                        that.jsToNative(htData);
                    }
                }
            });
        },
        tabacitve : function (val) {
            this.selected = val;
            /********
             * 1.点击切换tab
             * 2.重置tab列表
             * 3.重置没有数据flag
             *
             */
            this.replaylist = {
                maxpage: 1,
                page: 1,
                list: [],
            }
            this.likeslist ={
                maxpage: 1,
                page: 1,
                list: [],
            }
            this.zhuanlist = {
                maxpage: 1,
                page: 1,
                list: [],
            }

            if(val == 1){
                this.isnoData1 = false;
                this.loadMore({num:1,size:6})
            }
            if(val == 2) {
                this.isnoData2 = false;
                this.loadMore2({num: 1, size: 6})

            }
            if(val == 3) {
                this.isnoData3 = false;
                this.loadMore3({num: 1, size: 6})
            }
        },
        golist: function(){
            var z = switchDomin('m');
            if(z){
                window.location.href = z+'/discussion/discussionList';
            }
        },
        toggleFollow: function (msg) {
            var that = this;
            if (this.followClick) {
                return false;
            }
            this.followClick = true;

            $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('anim-zooming');
            }); //放大缩小动画效果

            var ocData = {
                artistId: this.update.userinfo.id
            };
            
            if (this.update.userinfo.is_follow == 'Y') {
                ocData.api = 'unfollow';
            } else {
                ocData.api = 'follow';
            }

            this.jsToNative(ocData);
        },
        gotoApp: function (type, id) {
            var that = this;
            var ocData = {
                api: 'link',
                type: type,
                id: id
            };

            this.jsToNative(ocData);
        },
        commentClick: function(id,isdel){ //第一层回复
            var commentObj = {
                api: 'comment',
                id: id,
                isAllowDelete: isdel
            }
            this.jsToNative(commentObj);

        },
        replyClick : function (id, isdel) { //第二层回复
            var replyObj = {
                api: 'reply',
                id: id,
                isAllowDelete: isdel
            }
            this.jsToNative(replyObj);

        },
        fadeOut: function () {
            var that = this;
            var ocData = {
                api: 'fadeOut',
            };

            this.jsToNative(ocData);
        },
        loadMore: function () { //回复列表的数据fn
            var that = this;
            // getTopicDiscussComment
            this.$nextTick(function(){ //使用v-if切换tab，若不加$nexttick则无法获取到$refs
                this.$refs.loadmore.onBottomLoaded(); //mint的loadmore组件关闭loading
            })
            if(that.replaylist.page>that.replaylist.maxpage){ //请求数据没有时
                that.isnoData1 = true;
                return false
            }
            var route = 'MobileGetH5/getTopicDiscussComment';
            var api = window.location.origin + '/V50/' + route;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: api,
                data: {
                    id: that.GetLocationId(),
                    page: that.replaylist.page++,
                    pagesize: 6
                },
                success: function(res){
                    if(res.code == 30000){
                        that.replaylist.maxpage = res.data.info.maxpage;
                        
                        if(res.data.info.data.length >0){
                            for(var i=0; i<res.data.info.data.length; i++){
                                that.replaylist.list.push(res.data.info.data[i])
                            }
                        } 
                    }   
                    
                },
                error: function(err){
                    console.log(err.error)
                }
            })
        },
        loadMore2: function(){ //点赞列表的数据fn
            var that = this;
            this.$nextTick(function(){
                if(this.$refs.loadmore2){
                    this.$refs.loadmore2.onBottomLoaded();
                }
            })
            if (that.likeslist.page > that.likeslist.maxpage) {
                that.isnoData2 = true;
                return false
            }
            // getTopicDiscussComment
            var route = 'MobileGetH5/getTopicDiscussLike';
            var api = window.location.origin + '/V50/' + route;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: api,
                data: {
                    id: that.GetLocationId(),
                    page: that.likeslist.page++,
                    pagesize: 6
                },
                success: function(res){
                    if(res.code == 30000){
                        // console.log(res)
                        that.likeslist.maxpage = res.data.info.maxpage;
                        
                        if(res.data.info.data.length >0){
                            for(var i=0; i<res.data.info.data.length; i++){
                                that.likeslist.list.push(res.data.info.data[i])
                            }
                        }
                    }   
                },
                error: function(err){
                    console.log(err.error)
                }
            })
        },
        loadMore3: function () { // 转发列表的数据fn
            var that = this;
            this.$nextTick(function(){
                if(this.$refs.loadmore3){
                    this.$refs.loadmore3.onBottomLoaded();
                }
            })
            if (that.zhuanlist.page > that.zhuanlist.maxpage) {
                that.isnoData3 = true;
                return false
            }
            // getTopicDiscussComment
            var route = 'MobileGetH5/getTopicDiscussShare ';
            var api = window.location.origin + '/V50/' + route;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: api,
                data: {
                    id: that.GetLocationId(),
                    page: that.zhuanlist.page++,
                    pagesize: 6
                },
                success: function(res){
                    if(res.code == 30000){
                        that.zhuanlist.maxpage = res.data.info.maxpage;
                        if(res.data.info.data.length >0){
                            for(var i=0; i<res.data.info.data.length; i++){
                                that.zhuanlist.list.push(res.data.info.data[i])
                            }
                        }
                    }   
                },
                error: function(err){
                    console.log(err.error)
                }
            })
        },
        getmorerep: function(repid){ // 查看更多btn
            
            var repObj = {
                api: 'seemore',
                moreid: repid
            }
            this.jsToNative(repObj);
        },
        jsToNative: function (ocData) {
            if (this.checkUA().isAndroid) {
                ocData = JSON.stringify(ocData);
                OCModel.jsCallNative(ocData);
            }

            if (this.checkUA().isIOS) {
                try {
                    window.webkit.messageHandlers[ocData.api].postMessage(ocData);
                } catch (ex) {
                    OCModel.jsCallNative(ocData);
                }
            }
        },
        interact: function(obj) {
            var that = this;

            if (obj.api == 'unlike') { //取消喜欢
                that.likeClick = false;
                if (obj.code == 30000) {
                    that.likeslist  = {
                        maxpage: 1,
                        page: 1,
                        list: []
                    };

                    that.loadMore2();
                    that.update.like_num--;
                }
            }
            if (obj.api == 'like') { //喜欢
                if (obj.code == 30000) {
                    //like_num
                    that.likeslist  = {
                        maxpage: 1,
                        page: 1,
                        list: []
                    };
                    that.loadMore2();
                    that.update.like_num++;
                }
            }
            if (obj.api == 'unfollow') { //取消关注
                that.followClick = false;
                if (obj.code == 30000) {
                    that.$nextTick(function(){
                        that.update.userinfo.is_follow = 'N';
                    })
                }
            }
            if (obj.api == 'follow') { //关注
                that.followClick = false;
                if (obj.code == 30000) {
                    that.$nextTick(function(){
                        that.update.userinfo.is_follow = 'Y';
                    })
                }
            }
            if (obj.api == 'comment') { //接收第一层评论
                if (obj.code == 30000) {
                    that.replaylist = {
                        maxpage: 1,
                        page: 1,
                        list: [],
                    };
                    that.loadMore();
                    that.update.comment_num++;
                    // if(obj.comment_response!='undefined'){
                    // }
                    /**
                    * 
                    *h5需要的数据格式
                    *
                    comment_num : 0
                    content : "孤鸿寡鹄脚后跟几个霍建华进货价很快就考虑过很快就被开奖号客户即可不喝酒六年级进尽快尽快"
                    create_time : "2018-12-06"
                    id : "44"
                    isAllowDelete : 1
                    list : [],
                    userinfo : {
                        face : "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/100/028/files/2018/01/sth90dpbp" +
                            "i.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg"
                        gender : "2"
                        id : "44"
                        nickname : "羅小画"
                    }
                    
                    //app返回的格式
                    {
                        "data": {
                            "status": 1000,
                            "info": {
                                "id": "61",
                                "commenter": "\u7f85\u5c0f\u753b",
                                "commenter_user_id": "100028",
                                "comment_to": "100001",
                                "content": "\u6cd5\u56fd\u7684\u53d1\u8fc7\u7684\u5206",
                                "datetime": "2018-12-10 10:38:08"
                            }
                        },
                        "code": 30000,
                        "message": "success",
                        "debug": false
                    }
                        * 
                        * TODO: 待优化：不刷新列表将回复添加到列表
                        *  需要将app返回的数据整理成需要的数据
                        * 
                        */
                    // var getcomment = JSON.parse(obj.comment_response);
                    // getcomment.data.comment_num = 0;
                    // getcomment.data.create_time = 
                    // getcomment.data.content = getcomment.data.info.content;
                    // getcomment.data.id = 
                    // getcomment.data.isAllowDelete = 1;
                    // getcomment.data.list = [];
                    // getcomment.data.userinfo={
                    //     face : getcomment.data.info.face,
                    //     gender : "1",
                    //     id : getcomment.data.info.id,
                    //     nickname : getcomment.data.info.commenter
                    // }
                    // that.replaylist.list.unshift(obj.comment_response);
                }
            }

            if (obj.api == 'reply') { //接收第二层评论
                if (obj.code == 30000) {
                    that.replaylist = {
                        maxpage: 1,
                        page: 1,
                        list: [],
                    };
                    that.loadMore();
                }
            }
            if (obj.api == 'delete') { //接收删除评论
                if (obj.code == 30000) {
                    that.replaylist = {
                        maxpage: 1,
                        page: 1,
                        list: []
                    };
                    that.loadMore();
                    if(obj.type == 'comment'){ // 若是最外层评论删除，总数减1
                        that.update.comment_num--;
                    }
                    // if(obj.type == 'comment'){
                    //     that.replaylist.list.forEach(function(item,index){
                    //         if(item.id == obj.id){
                    //             that.$nextTick(function(){
                    //                 that.update.comment_num--;
                    //                 that.replaylist.list.slice(index,1);
                    //                 that.replaylist = JSON.parse(JSON.stringify(that.replaylist))
                    //             })
                    //             //that.$set(that.replaylist)
                    //         }
                    //     })
                    // }
                    // if(obj.type == 'reply'){
                    //     that.replaylist.list.list.forEach(function(item,index){
                    //         if(item.id == obj.id){
                    //             that.$nextTick(function(){
                    //                 that.replaylist.comment_num--;
                    //                 that.replaylist.list.list.slice(index,1)
                    //                 that.replaylist = JSON.parse(JSON.stringify(that.replaylist))
                    //             })
                    //         }
                    //     })
                    // }
                }
            }
            if (obj.api == 'share') { //分享
                if (obj.code == 30000) {
                    that.zhuanlist = {
                        maxpage: 1,
                        page: 1,
                        list: [],
                    }
                    that.loadMore3();
                    that.update.share_num++;
                    console.log(that.update.share_num)
                }
            }

            if (obj.api == 'reload') { //重载页面
                that.init(obj.h5_token, obj.articleId);
            }
        },
        checkUA: function() {
            var isIOS, isAndroid;
            var ua = navigator.userAgent.toLowerCase();
            if (/iphone|ipad|ipod/.test(ua)) {
                isIOS = true;
                isAndroid = false;
            } else if (/android/.test(ua)) {
                isIOS = false;
                isAndroid = true;
            }
            return {
                isIOS: isIOS,
                isAndroid: isAndroid
            };
        },
        px2rem: function(con) {
            con = con.replace(/(\d)+\.?[0-9]+(px)|(\d)+(px)/gi, function (s, t) {
                s = s.replace('px', '');
                var value = parseInt(s) * 0.0266667; //   此处 1rem = 75px
                return value + "rem";
            });
            return con;
        },
        GetLocationId: function() {
            var path = window.location.pathname; //获取url中路径
            var ids = path.split('/');
            var id = ids[ids.length - 1];
            return id;
        },
        GetRequest: function() {
            var url = location.search; //获取url中"?"符后的字串
            var theRequest = {};
            if (url.indexOf("?") != -1) {
                var str = url.substr(1);
                strs = str.split("&");
                for (var i = 0; i < strs.length; i++) {
                    theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
                }
            }
            return theRequest;
        },
        formatTimeNoTime: function (timespan) {
            var mdateTime = Date.parse(timespan); // 例： 2018-12-13 15:30:00 或者 2018/12/13 15:30:00
            var dateTime = new Date(timespan);
            var year = dateTime.getFullYear();
            var month = dateTime.getMonth() + 1;
            var day = dateTime.getDate();
            var hour = dateTime.getHours();
            var minute = dateTime.getMinutes();
            var second = dateTime.getSeconds();
            var now = new Date();
            var now_new = Date.parse(now);
            var milliseconds = 0;
            var timeSpanStr;
            milliseconds = now_new - mdateTime;
            if (milliseconds <= 1000 * 60 * 1) {
                timeSpanStr = '刚刚';
            } else if (1000 * 60 * 1 < milliseconds && milliseconds <= 1000 * 60 * 60) {
                timeSpanStr = Math.round((milliseconds / (1000 * 60))) + '分钟前';
            } else if (1000 * 60 * 60 * 1 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24) {
                timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60)) + '小时前';
            } else if (1000 * 60 * 60 * 24 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24 * 15) {
                timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60 * 24)) + '天前';
            } else {
                timeSpanStr = year + '-' + (month > 9 ? month : '0' + month) + '-' + (day > 9 ? day : ('0' + day));
            }
            return timeSpanStr;
        }
    },
});

var interact = VmDiscussion.interact;