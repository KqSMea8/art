Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: true,
    loading: '/Public/image/holder.png',
    attempt: 1,
})

var VmDiscussionList = new Vue({
    el: '#discussionList',
    data: function(){
        return {
            loading: false,
            nodata: false,
            listLoading: false,
            listIsFrist: false,
            list: [],
            listNowPage: 1,
            listTotalPage: 0,
            allLoaded: false,
            wrapperHeight: 0,
            tabactive: 0,
            followClick: false,
            aDInfo: {
                isShow: true,
                height: '1.333333rem'
            },
            H5TopInfo: [],
            boxIsShow: false,
            shareIsShow: false,
            downloadIsShow: false, //下载新增代码
            boxMsg: '',
            btnShow: false,
            isLike: false,
            topHot:[],
            update: '',
        }
    },
    created: function() {
        this.getTopHot();
        this.getH5TopInfo();
    },
    mounted: function() {
        if (FastClick) {
            FastClick.attach(document.body);
        }

        this.mescroll = new MeScroll('mescrollup', {
            up: {
                use: false,
            },
            down:{
                callback: this.loadTop,
                isBounce: false,
            } //下拉刷新的配置. (如果下拉刷新和上拉加载处理的逻辑是一样的,则down可不用写了)
        });

    },
    methods: {
        getTopHot: function(){
            var that = this;
            var route = 'MobileGetH5/getTopicDetail';
            var api = window.location.origin + '/V50/' + route;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: api,
                data: {
                    id: GetLocationId(),
                },
                success: function(res){
                    if(res.code == 30000){
                        that.loading = false;
                        that.topHot = res.data.info;
                    }
                    if(that.mescroll){
                        that.mescroll.endSuccess();
                    }
                },
                error: function(err){
                    console.log(err.error)
                    if(that.mescroll){
                        mescroll.endErr();
                    }
                }
            })
        },
        linkto: function(id,type){
            if(type==4){
                window.location.href='/discussion/details/'+id;
            }else{
                window.location.href='/discussion/detailGraphic/'+id;
            }
        },
        tabfordisc: function(index){
            this.tabactive = index;
            if(index == 0){
                this.listIsFrist = false;
                this.list = [];
                this.listNowPage = 1;
                this.listTotalPage = 0;
                this.nodata = false;
            }else if(index == 1){
                this.listIsFrist = false;
                this.list = [];
                this.listNowPage = 1;
                this.listTotalPage = 0;
                this.nodata = false;
            }
            this.loadMore();
        },
        loadTop: function(){ //下拉刷新fn
            this.tabactive = 0;
            this.getTopHot();
            this.listIsFrist = false;
            this.list = [];
            this.listNowPage = 1;
            this.listTotalPage = 0;
            this.nodata = false;
            this.loadMore();
        },
        toggleFollow: function (msg) {
            var that = this;
            console.log('关注 clicked')
                this.boxMsg = '下载艺术者APP即可点进行关注操作~';
                this.boxIsShow = true;
                this.downloadIsShow = true;
                return false;
        },
        checkUA: function () {
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
        closeAD: function () {
            this.aDInfo = {
                isShow: false,
                height: '0'
            };
        },
        getH5TopInfo: function () {
            var that = this;
            artzheAgent.call('Ad/getH5Top', {}, function (res) {
                // console.log('H5顶部广告位.res', res);
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
        hideBox: function () {
            this.boxIsShow = false;
            this.shareIsShow = false;
            this.downloadIsShow = false; //下载新增代码
        },
        loadMore: function(){
            console.log(1211)
            var that = this;
            var type = 'hot';
            this.loading = true;
            this.listLoading = true;
            if(this.tabactive == 0){
                type = 'hot';
            }else if(this.tabactive == 1){
                type = 'date';
            }
            if(this.listIsFrist){
                if(this.listNowPage >this.listTotalPage){
                    this.loading = false;
                    this.listLoading = false;
                    this.nodata = true;
                    return false
                }
            }
            var route = 'MobileGetH5/getTopicDiscuss';
            var api = window.location.origin + '/V50/' + route;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: api,
                data: {
                    id: GetLocationId(),
                    type: type,
                    page: that.listNowPage++,
                    pagesize: 8
                },
                success: function (res) {
                    if (res.code == 30000) {
                        var list = [];
                        that.loading = false;
                        that.listLoading = false;
                        that.listIsFrist = true;
                        that.listTotalPage = res.data.info.maxpage;
                        for (var i = 0; i < res.data.info.data.length; i++) {
                            that.list.push(res.data.info.data[i]);
                        }
                       
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })

        },
    }
})

function GetLocationId() {
    var path = window.location.pathname; //获取url中路径
    var ids = path.split('/');
    var id = ids[ids.length - 1];
    return id;
}
function GetRequest() {
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
}