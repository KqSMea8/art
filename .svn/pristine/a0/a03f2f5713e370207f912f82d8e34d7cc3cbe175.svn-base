// Vue.use(VueLazyload, {     preLoad: 1.3,     error: false,     loading:
// '/Public/image/holder.png',     attempt: 1, })

var VmDiscussionList = new Vue({
    el: '#discussionList',
    data: function () {
        return {
            loading: false,
            list: [],
            listTotalPage: 0,
            list2: [],
            list2TotalPage: 0,
            topStatus: '',
            bottomStatus: '',
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
            commentContent: '',
            btnShow: false,
            isLike: false,
            topHot: [],
            update: '',
            initscrollArr: []
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
    created: function () {
        // this.init() for (let i = 1; i <= 60; i++) {     this.list.push(i); }
        this.getTopHot();
        this.getH5TopInfo();
    },
    mounted: function () {
        if (FastClick) {
            FastClick.attach(document.body);
        }

        this.mescroll = new MeScroll('mescrollup', {
            up: {
                use: false
            },
            down: {
                callback: this.loadTop,
                isBounce: false
            } //下拉刷新的配置. (如果下拉刷新和上拉加载处理的逻辑是一样的,则down可不用写了)
        });

        // this.mescroll3 = new MeScroll('mescroll1', {
        // //在mounted初始化mescroll,确保此处配置的ref有值     up: {         callback: this.loadTop,
        //        isBounce: false,         // 以下是一些常用的配置,当然不写也可以的.         page: {
        //       num: 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始             size: 10,
        // //每页数据条数,默认10         },         lazyLoad: {             use :true         },
        //     },     down:{         use: false,     } //下拉刷新的配置.
        // (如果下拉刷新和上拉加载处理的逻辑是一样的,则down可不用写了) });
        this.initMescroll('mescroll1', 0); //
    },
    methods: {
        getTopHot: function () {
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
                    page: 1,
                    pagesize: 2
                },
                success: function (res) {
                    if (res.code == 30000) {
                        that.loading = false;
                        that.topHot = res.data.info;
                    }
                    if (that.mescroll) {
                        that
                            .mescroll
                            .endSuccess();
                    }
                },
                error: function (err) {
                    console.log(err.error)
                    if (that.mescroll) {
                        mescroll.endErr();
                    }
                }
            })
        },
        linkto: function (id) {
            window.location.href = '/discussion/details/' + id;
        },
        tabfordisc: function (index) {
            this.tabactive = index;
            if (index == 0) {
                if (this.initscrollArr[index] == null) {
                    this.initMescroll('mescroll1', index)
                }

            }
            if (index == 1) {
                if (this.initscrollArr[index] == null) {
                    this.initMescroll('mescroll2', index)
                }
            }

        },
        loadTop: function () { //下拉刷新fn
            this.tabactive = 0;
            this.getTopHot();
            // this.list =[]; this.list2 = []; this.initscrollArr[0].resetUpScroll(false);
            // //下拉刷新重置 按热门 列表 if(this.initscrollArr[1] != null){ //可能有未初始化 按时间 的mescroll
            //  this.initscrollArr[1].resetUpScroll(false); //重置 按时间 列表 }
        },
        getHotHotData: function (page) {
            var self = this;
            var tab = this.tabactive
            mgetHotData(tab, page.num, page.size, function (curPageData, totalpage) {
                console.log(tab)
                if (tab == 0) {
                    self.list = self
                        .list
                        .concat(curPageData);
                    self
                        .mescroll
                        .endByPage(curPageData.length, totalpage);
                }
                if (tab == 1) {
                    self.list2 = self
                        .list2
                        .concat(curPageData);
                    self
                        .mescroll
                        .endByPage(curPageData.length, totalpage);
                    console.log(self.list2)
                }
                // console.log("page.num="+page.num+", page.size="+page.size+",
                // curPageData.length="+curPageData.length+", self.list.length==" +
                // self.list.length+", self.totalpage==" +totalpage);
            }, function () {
                self
                    .mescroll
                    .endErr();
            })
        },
        getHotHotData2: function (page) {
            var self = this;
            var tab = this.tabactive
            mgetHotData(tab, page.num, page.size, function (curPageData, totalpage) {
                if (tab == 0) {
                    self.list = self
                        .list
                        .concat(curPageData);
                    self
                        .initscrollArr[0]
                        .endByPage(curPageData.length, totalpage);
                }
                if (tab == 1) {
                    self.list2 = self
                        .list2
                        .concat(curPageData);
                    self
                        .initscrollArr[1]
                        .endByPage(curPageData.length, totalpage);
                }

                // console.log("page.num="+page.num+", page.size="+page.size+",
                // curPageData.length="+curPageData.length+", self.list.length==" +
                // self.list.length+", self.totalpage==" +totalpage);
            }, function () {
                if (tab == 0) {
                    self
                        .initscrollArr[0]
                        .endByPage(curPageData.length, totalpage);
                }
                if (tab == 1) {
                    self
                        .initscrollArr[1]
                        .endByPage(curPageData.length, totalpage);
                }
            })
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
            var isIOS,
                isAndroid;
            var ua = navigator
                .userAgent
                .toLowerCase();
            if (/iphone|ipad|ipod/.test(ua)) {
                isIOS = true;
                isAndroid = false;
            } else if (/android/.test(ua)) {
                isIOS = false;
                isAndroid = true;
            }
            return {isIOS: isIOS, isAndroid: isAndroid};
        },
        formatTime: function (timespan) {
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
                timeSpanStr = year + '.' + (month > 9
                    ? month
                    : '0' + month) + '.' + (day > 9
                    ? day
                    : ('0' + day));
            }
            return timeSpanStr;
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
                H5TopInfo.desc = info.category + '艺术家';
            }
            that.H5TopInfo[0] = H5TopInfo;
        },
        hideBox: function () {
            this.boxIsShow = false;
            this.shareIsShow = false;
            this.downloadIsShow = false; //下载新增代码
        },
        initMescroll: function (mescrollId, id) {
            var that = this;
            this.initscrollArr[id] = new MeScroll(mescrollId, { //在mounted初始化mescroll,确保此处配置的ref有值
                up: {
                    auto: true,
                    callback: that.getHotHotData2,
                    // 以下是一些常用的配置,当然不写也可以的.
                    page: {
                        num: 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始
                        size: 2, //每页数据条数,默认10
                    },
                    lazyLoad: {
                        use: true
                    }
                },
                down: {
                    use: false
                } //下拉刷新的配置. (如果下拉刷新和上拉加载处理的逻辑是一样的,则down可不用写了)
            });

        }
    }
})
function mgetHotData(curNavIndex, pageNum, pageSize, successCallback, errorCallback) {
    // type  hot/date
    var typeis = curNavIndex == 0
        ? 'hot'
        : 'date'
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
            type: typeis,
            page: pageNum,
            pagesize: pageSize
        },
        success: function (res) {
            if (res.code == 30000) {
                var list = [];
                var list2 = [];
                // for (var i = (pageNum - 1) * pageSize; i < pageNum * pageSize; i++) {     if
                // (i == data.length) break;     list.push(res.data.info); }
                if (curNavIndex == 0) {
                    for (var i = 0; i < res.data.info.data.length; i++) {
                        if (i == res.data.info.data.length) 
                            break;
                        list.push(res.data.info.data[i]);
                    }
                } else {
                    for (var i = 0; i < res.data.info.data.length; i++) {
                        if (i == res.data.info.data.length) 
                            break;
                        list2.push(res.data.info.data[i]);
                    }
                }
                if (curNavIndex == 0) {

                    successCallback && successCallback(list, res.data.info.maxpage); //成功回调
                }
                if (curNavIndex == 1) {

                    successCallback && successCallback(list2, res.data.info.maxpage); //成功回调
                }
            }
        },
        error: function (err) {
            console.log(err.error)
        }
    })
}

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