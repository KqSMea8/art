// plugins/dumpimage.js
///import core
///commands 远程图片抓取
///commandsName  dumpImage,dumpImageEnable
///commandsTitle  远程图片抓取
/**
 * 远程图片抓取,当开启本插件时所有不符合本地域名的图片都将被抓取成为本地服务器上的图片
 */
UE.plugins['dumpimage'] = function () {
    var me = this,
        ajax = UE.ajax,
        utils = UE.utils,
        domUtils = UE.dom.domUtils;
        var fet_index=0;
        var lock=0;
        var myInterval;

    /* 设置默认值 */
    if (me.options.dumpImageEnable === false) return;
    me.setOpt({
        dumpImageEnable: false
    });

    me.addListener("afterpaste", function () {

        me.fireEvent("dumpImage");
    });

    me.addListener("dumpImage", function () {



        var catcherLocalDomain = me.getOpt('catcherLocalDomain'),
            catcherActionUrl = me.getActionUrl(me.getOpt('catcherActionName')),
            catcherUrlPrefix = me.getOpt('catcherUrlPrefix'),
            catcherFieldName = me.getOpt('catcherFieldName');

        clearInterval(myInterval);
        fet_index = 0;
            
        console.log(catcherLocalDomain,catcherActionUrl,catcherUrlPrefix,catcherFieldName);

        var remoteImages = [],
            imgs = domUtils.getElementsByTagName(me.document, "img"),
            test = function (src, urls) {
                if (src.indexOf(location.host) != -1 || /(^\.)|(^\/)/.test(src)) {
                    return true;
                }
                if (urls) {
                    for (var j = 0, url; url = urls[j++];) {
                        if (src.indexOf(url) !== -1) {
                            return true;
                        }
                    }
                }
                return false;
            };

        for (var i = 0, ci; ci = imgs[i++];) {
            if (ci.getAttribute("word_img")) {
                continue;
            }
            var src = ci.getAttribute("_src") || ci.src || "";
            src = src.replace(/&tp=webp/g, '');
            if (/^(https?|ftp):/i.test(src) && !test(src, catcherLocalDomain)) {
                domUtils.setAttributes(ci, {
                    "src": 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/loading.gif', 
                });
                remoteImages.push(src);
            }
        }

        if (remoteImages.length) {

            myInterval = setInterval(function(){
                if(lock==0){
                    lock=1;
                    dumpimage([remoteImages[fet_index]], {
                    //成功抓取
                    success: function (r) {
                        lock=0;
                        fet_index=fet_index+1;
                        if (fet_index >= remoteImages.length) {
                            fet_index = 0;
                            clearInterval(myInterval);
                        }
                        try {
                            var info = r.state !== undefined ? r:eval("(" + r.responseText + ")");
                        } catch (e) {
                            return;
                        }

                        /* 获取源路径和新路径 */
                        var i, j, ci, cj, oldSrc, newSrc, list = info.list;

                        for (i = 0; ci = imgs[i++];) {
                            oldSrc = ci.getAttribute("_src") || ci.src || "";
                            oldSrc = oldSrc.replace(/&tp=webp/g, '');
                            for (j = 0; cj = list[j++];) {
                                if (oldSrc == cj.source && cj.state == "SUCCESS") {  //抓取失败时不做替换处理
                                    newSrc = catcherUrlPrefix + cj.url;
                                    domUtils.setAttributes(ci, {
                                        "src": newSrc,
                                        "_src": newSrc
                                    });
                                    break;
                                } else if (oldSrc == cj.source && cj.state != "SUCCESS") {  //抓取失败
                                    newSrc = 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/error.jpeg';
                                    domUtils.setAttributes(ci, {
                                        "src": newSrc
                                    });
                                    break;
                                }
                            }
                        }
                        me.fireEvent('catchremotesuccess')
                    },
                    //回调失败，本次请求超时
                    error: function () {
                        lock=0;
                        clearInterval(myInterval);
                        /* 获取源路径和新路径 */
                        var i, j, ci, cj, oldSrc, newSrc;

                        for (i = 0; ci = imgs[i++];) {
                            oldSrc = ci.getAttribute("_src") || ci.src || "";
                            oldSrc = oldSrc.replace(/&tp=webp/g, '');
                            if (oldSrc == remoteImages[fet_index]) {  //抓取失败
                                newSrc = 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/error.jpeg';
                                domUtils.setAttributes(ci, {
                                    "src": newSrc
                                });
                                break;
                            }
                        }
                        me.fireEvent("catchremoteerror");
                    }
                });
            
                }

            },100);

            // for (var k = 0; k < remoteImages.length; k++) {
            //     dumpimage([remoteImages[k]], {
            //         //成功抓取
            //         success: function (r) {
            //             try {
            //                 var info = r.state !== undefined ? r:eval("(" + r.responseText + ")");
            //             } catch (e) {
            //                 return;
            //             }

            //             /* 获取源路径和新路径 */
            //             var i, j, ci, cj, oldSrc, newSrc, list = info.list;

            //             for (i = 0; ci = imgs[i++];) {
            //                 oldSrc = ci.getAttribute("_src") || ci.src || "";
            //                 for (j = 0; cj = list[j++];) {
            //                     if (oldSrc == cj.source && cj.state == "SUCCESS") {  //抓取失败时不做替换处理
            //                         newSrc = catcherUrlPrefix + cj.url;
            //                         domUtils.setAttributes(ci, {
            //                             "src": newSrc,
            //                             "_src": newSrc
            //                         });
            //                         break;
            //                     }
            //                 }
            //             }
            //             me.fireEvent('catchremotesuccess')
            //         },
            //         //回调失败，本次请求超时
            //         error: function () {
            //             /* 获取源路径和新路径 */
            //             var i, j, ci, cj, oldSrc, newSrc, list = info.list;

            //             for (i = 0; ci = imgs[i++];) {
            //                 oldSrc = ci.getAttribute("_src") || ci.src || "";
            //                 for (j = 0; cj = list[j++];) {
            //                     if (oldSrc == cj.source && cj.state == "SUCCESS") {  //抓取失败时不做替换处理
            //                         domUtils.setAttributes(ci, {
            //                             "src": ''
            //                         });
            //                         break;
            //                     }
            //                 }
            //             }
            //             me.fireEvent("catchremoteerror");
            //         }
            //     });
            // }

        }

        function dumpimage(imgs, callbacks) {
            var params = utils.serializeParam(me.queryCommandValue('serverparam')) || '',
                url = utils.formatUrl(catcherActionUrl + (catcherActionUrl.indexOf('?') == -1 ? '?':'&') + params),
                isJsonp = utils.isCrossDomainUrl(url),
                opt = {
                    'method': 'POST',
                    'dataType': isJsonp ? 'jsonp':'',
                    // 'async': false,
                    'timeout': 60000, //单位：毫秒，回调请求超时设置。目标用户如果网速不是很快的话此处建议设置一个较大的数值
                    'onsuccess': callbacks["success"],
                    'onerror': callbacks["error"]
                };
            opt[catcherFieldName] = imgs;
            ajax.request(url, opt);
        }

    });
};