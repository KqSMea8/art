var share = function(obj) {

    var u = navigator.userAgent,
        app = navigator.appVersion;
    var evi = {
        device: function() {
            return {
                isAndroid: u.indexOf('Android') > -1,
                isIos: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)
            }
        }(),
        browser: function() {
            return {
                isWeixin: u.toLowerCase().match(/MicroMessenger/i) == "micromessenger",
                isUc: app.split("UCBrowser/").length > 1,
                isQQ: app.split("QQBrowser/").length > 1
            };
        }()
    }

    var shareEvent = {
        weixinEvent: function() {
            if (evi.browser.isUc) {
                if (evi.device.isIos) {
                    ucbrowser.web_share(decodeURIComponent(shareContent.title), decodeURIComponent(shareContent.summary), decodeURIComponent(shareContent.url), 'kWeixin', '', '', '');
                } else {
                    ucweb.startRequest("shell.page_share", [decodeURIComponent(shareContent.title), decodeURIComponent(shareContent.summary), decodeURIComponent(shareContent.url), 'WechatFriends', '', '', '']);
                };
            } else {
                $(".share-icons").css("display", "none");
                $(".noWeixin").css("display", "block");
            }
        },
        friendsEvent: function() {
            if (evi.browser.isUc) {
                if (evi.device.isIos) {
                    ucbrowser.web_share(decodeURIComponent(shareContent.title), decodeURIComponent(shareContent.summary), decodeURIComponent(shareContent.url), 'kWeixinFriend', '', '', '');
                } else {
                    ucweb.startRequest("shell.page_share", [decodeURIComponent(shareContent.title), decodeURIComponent(shareContent.summary), decodeURIComponent(shareContent.url), 'WechatTimeline', '', '', '']);
                };
            } else {
                $(".share-icons").css("display", "none");
                $(".noWeixin").css("display", "block");
            }
        }
    }

    var shareContent = {
        trigger: obj.trigger,
        title: encodeURIComponent(obj.title),
        summary: encodeURIComponent(obj.summary),
        img: obj.img,
        url: encodeURIComponent(obj.url)
    };

    if (evi.browser.isWeixin) {
        var alertContent = '<div id="m-share" style="display:none;"><div class="overlay" style="opacity: 0.8;"></div><img src="/Public/image/gallerydetail/share.png" style="position: fixed; left:0; top: 0; z-index: 1000;" /></div>';

        $("body").append(alertContent);

        $(shareContent.trigger).click(function() {
            $("#m-share").show();
        });

        $("#m-share").click(function() {
            $(this).hide();
        });

        // wx.config({
        //     debug: false,
        //     appId: $("#appId").val(),
        //     timestamp: $("#timestamp").val(),
        //     nonceStr: $("#nonceStr").val(),
        //     signature: $("#signature").val(),
        //     jsApiList: ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo"
        //         // 所有要调用的 API 都要加到这个列表中
        //     ]
        // });

        //分享到朋友圈操作
        wx.ready(function() {
            wx.onMenuShareTimeline({
                title: decodeURIComponent(shareContent.title), // 分享标题
                link: decodeURIComponent(shareContent.url), // 分享链接
                imgUrl: shareContent.img, // 分享图标
                success: function() {
                    // 用户确认分享后执行的回调函数
                    //share_success('bonus');
                },
                cancel: function() {
                    // 用户取消分享后执行的回调函数
                }
            });

            //发送给朋友
            wx.onMenuShareAppMessage({
                title: decodeURIComponent(shareContent.title), // 分享标题
                desc: decodeURIComponent(shareContent.summary), // 分享描述
                link: decodeURIComponent(shareContent.url), // 分享链接
                imgUrl: shareContent.img, // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function() {
                    // 用户确认分享后执行的回调函数
                    //recommend_success('bonus');
                },
                cancel: function() {
                    // 用户取消分享后执行的回调函数
                }
            });
        });

    } else {
        var alertContent = '<div id="m-share" style="display:none;"><div class="overlay"></div><div class="share-block"><ul class="share-icons fix"><li><a id="shareWeibo" href=""><div class="icon weibo"></div></a><div class="share-name">分享微博</div></li><li><div class="icon weixin" id="shareWeixin"></div><div class="share-name">分享微信</div></li><li><a id="shareQQ" href=""><div class="icon qqspace" id="qqspace"></div></a><div class="share-name">分享QQ空间</div></li><li><div class="icon friends" id="shareFriends"></div><div class="share-name">分享朋友圈</div></li></ul><div class="noWeixin" style="display:none;"><div id="qrcode" class="erweima"><p class="invitefont">邀请好友：</p><textarea readonly class="urlblock">'+decodeURIComponent(shareContent.url)+'</textarea ></div><p class="save">点击全选地址并复制，打开微信粘贴发给朋友</p></div><a class="cancel">取消</a></div></div>';

        $("body").append(alertContent);

        $(shareContent.trigger).click(function() {
            // var userid = $("#userid").val();
             var userid = 2;
            if (userid > 1 && userid != '') {
                $("#m-share").show().addClass("appear");
            } else {
                TipsShow.showtips({
                    "info": "请先登录后再分享！"
                });
            }

        });

        $("#m-share .cancel, #m-share .overlay").click(function() {
            $("#m-share").removeClass("appear").hide();
            $(".share-icons").css("display", "block");
            $(".noWeixin").css("display", "none");
        });

        $("#shareFriends").click(function() {
            shareEvent.friendsEvent();
        });

        $("#shareWeixin").click(function() {
            shareEvent.weixinEvent();
        });

        $("#shareWeibo")[0].href = "https://service.weibo.com/share/share.php?url=" +shareContent.url + "&title=" + shareContent.title + "&pic=" + shareContent.img;

        $("#shareQQ")[0].href = "https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=" + shareContent.url + "&title=" + shareContent.title + "&summary=" + shareContent.summary + "&pics=" + shareContent.img;
        
        /*var qr = new QRCode(document.getElementById("qrcode"), {
            width: 100,
            height: 100
        });
        qr.makeCode(obj.url);*/
    }
}
