Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: false,
    loading: '/Public/image/holder.png',
    attempt: 1,
})

var VmDiscussion = new Vue({
    el: '#discussion',
    data: function() {
        return {
            time:'',
            isFollow: false,
            showinput: false,
            update: {
                userinfo : {
                    id: "",
                    nickname: "",
                    faceUrl: "",
                    gender: "1",
                    is_artist: 0,
                    is_agency: 0,
                    AgencyType: 0,
                    is_planner: 0,
                    is_follow: "N",
                },
                video_url: '',
                topic: '',
            },
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
            listhieght:'', //list高度
            aDInfo: {
                isShow: true,
                height: '1.333333rem'
            },
            H5TopInfo: [],
            boxIsShow: false,
            shareIsShow: false,
            downloadIsShow: false, //下载新增代码
            boxMsg: '',
            commentContent: '',
            btnShow: false,
            isLike: false,
    
        }
    },
    watch: {
        // 如果 发生改变，这个函数就会运行
        commentContent: function () {
            if (this.commentContent == '') {
                this.btnShow = false;
            } else {
                this.btnShow = true;
            }
        }
    },
    created: function() {
        this.getH5TopInfo();
        this.init();
    },
    mounted: function() {
        if (FastClick) {
            FastClick.attach(document.body);
        }

        this.loadMore(); //初始化第一个tab
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
                        document.title = res.data.info.title !='' ? res.data.info.title : '讨论详情';
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
                        //
                        that.update = update;
                        wx.ready(function () {
                            wx.onMenuShareTimeline({
                                title: shareInfo.shareTitle, 
                                link: shareInfo.shareLink, 
                                imgUrl: shareInfo.shareImg
                            });
                            wx.onMenuShareAppMessage({
                                title: shareInfo.shareTitle,
                                desc: shareInfo.shareDesc,
                                link: shareInfo.shareLink,
                                imgUrl: shareInfo.shareImg,
                                type: 'link',
                                dataUrl: ''
                            });
                        });

                        //设置广告位信息
                        that.newGetH5AD(that.update.userinfo);
                        
                        that.$nextTick(function () {
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
                        });
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
                var listId = this.update.topic.id;
                window.location.href = z+'/discussion/discussionList/'+listId;
            }
        },
        toggleFollow: function (msg) {

            $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('anim-zooming');
            }); //放大缩小动画效果
            this.commentUpdate('更多操作请下载艺术者APP~');
        },
        loadMore: function () { //回复列表的数据fn
            console.log('loadmorefn')
            var that = this;
            // getTopicDiscussComment
            this.$nextTick(function(){ //使用v-if切换tab，若不加$nexttick则无法获取到$refs
                 if(this.$refs.loadmore){//mint的loadmore组件关闭loading
                    this.$refs.loadmore.onBottomLoaded();
                }
            })
            if(that.replaylist.page>that.replaylist.maxpage){ //请求数据没有时
                that.isnoData1 = true; //
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
        loadMore3: function () { //转发列表的数据fn
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
        closeAD: function () {
            this.aDInfo = {
                isShow: false,
                height: '0'
            };
        },
        getH5TopInfo: function () {
            var that = this;
            artzheAgent.call('Ad/getH5Top', {}, function (res) {
                that.H5TopInfo = res.data.info;
                that.$nextTick(function () {
                    var mySwiperH5 = new Swiper("#swiper-container-t", {
                        loop: true,
                        autoplay: 4000,
                        speed: 1000,
                        slidesPerView: "auto",
                        pagination: '#swiper-pagination-t',
                        paginationClickable: true,
                        centeredSlides: !0,
                        observer: true, //修改swiper自己或子元素时，自动初始化swiper
                        observeParents: true, //修改swiper的父元素时，自动初始化swiper
                        
                    });
                });
            });
        },
        newGetH5AD: function (shareInfo) {
            var that = this;
            var info = shareInfo;
            var H5TopInfo = {};
            H5TopInfo.img = info.faceUrl;
            H5TopInfo.title = info.nickname;
            if (info.motto) {
                H5TopInfo.desc = info.motto;
            } else {
                H5TopInfo.desc = info.nickname + '艺术家';
            }
            that.H5TopInfo[0] = H5TopInfo;
        },
        showShare: function () {
            this.boxIsShow = true;
            this.shareIsShow = true;
        },
        hideBox: function () {
            this.boxIsShow = false;
            this.shareIsShow = false;
            this.downloadIsShow = false; //下载新增代码
        },
        commentUpdate: function (msg) {
            this.boxMsg = msg;
            this.boxIsShow = true;
            this.downloadIsShow = true;
            this.showinput = false;
            return false;
        },
        toggleLike: function (msg) {
            this.boxMsg = msg;
            this.boxIsShow = true;
            this.downloadIsShow = true;
            return false; //下载新增代码
        },
    }
})
//各环境domain转换
function switchDomin(str) { //str:mp|m|www|api
    var myDomin, aDomin, aFirst, sFirst, sFirstNew;

    aDomin = window.location.host.split('.'); //域名数组
    sFirst = aDomin[0]; //获取二级域名前缀
    if (aDomin.length > 2) {
        aDomin.shift();
    }
    sMain = aDomin.join('.');
    aFirst = sFirst.split('-');
    sFirstNew = '';

    if (aFirst.length > 1) {
        sFirstNew = aFirst[0] + '-';
    }
    myDomin = 'https:' + '//' + sFirstNew + str + '.' + sMain;

    return myDomin;
}
