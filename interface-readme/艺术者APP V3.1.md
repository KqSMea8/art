[toc]
# 艺术者APP V3.1
## 1 艺术圈
### 1.1 获取头部信息修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/ArtCircle/getHeader 
> 需要token：是(GET方式传token)

**说明**
> 增加返回字段：isShowGallery，1-可以进入艺术家画廊，0-不可以进入艺术家画廊

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|uid  | 用户id | int|否|-|如果有，则是个人艺术圈动态列表头部信息,返回uid的用户信息；没有，则是艺术圈列表头部信息。另，如果没有登录，艺术圈列表头部信息只有banner|


**响应结果示例**
```
{
  "data": {
    "status": 1000, //正确时只有这一种情况
    "info": {
      "uid": "100", //用户uid
      "name": "张三", //名字
      "gender": "1", //用户性别1男2女3未知
      "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test1.png", //头像
      "isArtist": 1, //1表示是艺术家,0表示非艺术家
      "isAgency": 1, //1表示是认证机构,0表示非认证机构
      "agencyType":7,//机构类型
      "isPlanner": 0, //1表示是策划者,0表示非策划者
      "banner": "http://gsy-other.oss-cn-beijing.aliyuncs.com/uploads/2017/05/31/1496199190575.png", //banner
      "unreadMessageTotal": 1, //未读消息总数
      "isShowGallery": 1, //1-可以进入艺术家画廊，0-不可以进入艺术家画廊
    }
  },
  "code": 30000, //其它非30000表示错误的情况
  "message": "success",
  "debug": false
}

```

### 1.2 艺术圈列表修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/ArtCircle/GetList 
> 需要token：是(GET方式传token)

**说明**
> 增加返回字段：isAllowDelete,1-允许删除，0-不允许删除

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|page  | 页码 | int|是|-||
|pagesize  | 每页获取条数 | int|是|-||


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "id": 24,
                    "type": 2, //1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊
                    "address": "中南海",
                    "content": "更多few",
                     "thumbnails": [//缩略图
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png"
                    ],
                    "images_url": [//大图
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png"
                    ],
                    "video_poster": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",//视频封面
                    "video_url": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.mp4",//视频
                    "datetime": "7分钟前",
                     "like_count": 3,//喜欢的人数
                     "isLike": 1 //是否已经点赞
                    "comment_count": 55,//评论数
                    "isAllowDelete": 1,//1-允许删除，0-不允许删除
                    "userinfo": {//用户信息
                        "id": "100028",
                        "nickname": "simao",
                        "gender": 2//性别 1男，2女，3未知
                        "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-10-13-165143-x6rdb364uu.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                       
                        "is_artist": 0,//是否艺术家
                        "is_agency": 1,//是否认证机构
                        "AgencyType": 7,//认证机构类型
                        "is_planner": 0//是否策展人
                    },
                    "share_link": {
                            "type": "artwork_update",//分享类型：artwork画作 artwork_update更新 art_article艺术号
                            "id": "102",//对应的ID
                            "title": "尖叫《斩七，斩鸡》记录2",
                            "content": "勾线，猫表情有点凶，加点闪电呼应，丰富画面，颜色暂时没想好怎么配",
                            "thumbnail": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1493345112791161?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",//缩略图
                            "image_url": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1493345112791161?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA1LzA5LzE0OTQyOTk1OTc4MDE5ODYucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10",//大图
                            "video_poster": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",//视频封面
                          "video_url": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.mp4"//视频
                        },
                       "like_nickname": [//点赞昵称
                        "李坤",
                        "simao"
                    ],
                     "comment_list": [//评论列表
                        {
                            "id": 1,
                            "commenter": "高浮雕",
                            "comment_to": "高浮雕",
                            "content": "高浮雕高浮雕高浮雕高浮雕高浮雕高浮雕",
                            "comment_to_content": "热望热望热望",//对应回复的那条内容
                            "datetime": "2017-4-55"
                        },
                        {
                            "id": 2,
                            "commenter": "高浮雕",
                            "comment_to": "高浮雕",
                            "content": "高浮雕高浮雕高浮雕高浮雕高浮雕高浮雕",
                            "comment_to_content": "热望热望热望",
                            "datetime": "2017-4-55"
                        }
                    ]
                },
                
            ],
            "page": 1,
            "total": "21",
            "pagesize": 20,
            "maxpage": 2
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 1.3 个人艺术圈列表修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/ArtCircle/userCirlelist 
> 需要token：是(GET方式传token)

**说明**
> 增加返回字段：isAllowDelete,1-允许删除，0-不允许删除

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|user_id  | 用户id | int|是|-||
|page  | 页码 | int|是|-||
|pagesize  | 每页获取条数 | int|是|-||


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "id": 24,
                    "type": 2, //1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊
                    "address": "中南海",
                    "content": "更多few",
                     "thumbnails": [//缩略图
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png"
                    ],
                    "images_url": [//大图
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png"
                    ],
                    "video_poster": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",//视频封面
                    "video_url": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.mp4",//视频
                    "datetime": "7分钟前",
                     "like_count": 3,//喜欢的人数
                      "isLike": 1 //是否已经点赞
                    "comment_count": 55,//评论数
                    "isAllowDelete": 1,//1-允许删除，0-不允许删除
                    "userinfo": {//用户信息
                        "id": "100028",
                        "nickname": "simao",
                        "gender": 2//性别 1男，2女，3未知
                        "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-10-13-165143-x6rdb364uu.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                       
                        "is_artist": 0,//是否艺术家
                        "is_agency": 1,//是否认证机构
                        "AgencyType": 7,//认证机构类型
                        "is_planner": 0//是否策展人
                    },
                    "share_link":{
                            "type": "artwork_update",//分享类型：artwork画作 artwork_update更新 art_article艺术号
                            "id": "102",//对应的ID
                            "title": "尖叫《斩七，斩鸡》记录2",
                            "content": "勾线，猫表情有点凶，加点闪电呼应，丰富画面，颜色暂时没想好怎么配",
                            "thumbnail": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1493345112791161?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",//缩略图
                            "image_url": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1493345112791161?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA1LzA5LzE0OTQyOTk1OTc4MDE5ODYucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10",//大图
                            "video_poster": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",//视频封面
                          "video_url": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.mp4"//视频
                        },
                      "like_nickname": [//点赞昵称
                        "李坤",
                        "simao"
                    ],
                     "comment_list": [//评论列表
                        {
                            "id": 26,
                            "commenter": "高浮雕",
                            "comment_to": "高浮雕",
                            "content": "高浮雕高浮雕高浮雕高浮雕高浮雕高浮雕",
                            "comment_to_content": "热望热望热望",//对应回复的那条内容
                            "datetime": "2017-4-55"
                        },
                        {
                            "id": 27,
                            "commenter": "高浮雕",
                            "comment_to": "高浮雕",
                            "content": "高浮雕高浮雕高浮雕高浮雕高浮雕高浮雕",
                            "comment_to_content": "热望热望热望",
                            "datetime": "2017-4-55"
                        }
                    ]
                },
            
            ],
            "page": 1,
            "total": "21",
            "pagesize": 20,
            "maxpage": 2
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 1.4 删除艺术圈动态
> 请求方法：POST
> 需要登录：是
> 请求地址：http://dev-api.artzhe.com/V31/ArtCircle/delete
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|艺术圈动态id|int|是||-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "id": "22"//艺术圈动态id
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```

### 1.5 设置个人艺术圈封面
> 请求方法：POST
> 需要登录：是
> 请求地址：http://dev-api.artzhe.com/V31/ArtCircle/setCover
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|cover|个人艺术圈封面url|string|是||-|


**响应结果示例**
```javascript
{
  "data": {
    "status": 1000 //正确时只有这一种情况
    "CoverUrl":"https://artzhe.oss-cn-shenzhen.aliyuncs.com/test1.png"//封面url
  },
  "code": 30000,//其它非30000表示系统错误
  "message": "success",
  "debug": false
}
```

## 2 画作
### 2.1 获取画作标签

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/Artwork/getArtworkTag 
> 需要token：是(GET方式传token)


**响应结果示例**
```
{
  "data": {
        "status": 1000 //正确时只有这一种情况
        "info":{
             "category":[//类别标签
                {"id":1, "sort":1, "name":"油画"},
                {"id":2, "sort":2, "name":"水彩"},
                {"id":3, "sort":3, "name":"插画"},
                {"id":4, "sort":4, "name":"素描"},
                {"id":5, "sort":5, "name":"工笔"},
                {"id":6, "sort":6, "name":"国画"},
                {"id":7, "sort":7, "name":"版画"},
            ]，
            "subject ":[//题材标签
                {"id":1, "sort":1, "name":"人物"},
                {"id":2, "sort":2, "name":"风景"},
                {"id":3, "sort":3, "name":"静物"},
                {"id":4, "sort":4, "name":"动植物"},
                {"id":5, "sort":5, "name":"萌化"},
                {"id":6, "sort":6, "name":"宗教"},
            ]，
            "style":[//风格标签
                {"id":1, "sort":1, "name":"具象"},
                {"id":2, "sort":2, "name":"抽象"},
                {"id":3, "sort":3, "name":"古典"},
                {"id":4, "sort":4, "name":"观念"},
                {"id":5, "sort":5, "name":"表现"},
            ]
        }
  },
  "code": 30000,//其它非30000表示系统错误
  "message": "success",
  "debug": false
}

```

### 2.2 获取创作记录标签

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/Artwork/getUpdateTag 
> 需要token：是(GET方式传token)


**响应结果示例**
```
{
  "data": {
        "status": 1000 //正确时只有这一种情况
        "info":[
            {"id":1, "sort":1, "name":"油画"},
            {"id":2, "sort":2, "name":"水彩"},
            {"id":3, "sort":3, "name":"插画"},
            {"id":4, "sort":4, "name":"素描"},
            {"id":5, "sort":5, "name":"工笔"},
            {"id":6, "sort":6, "name":"国画"},
            {"id":7, "sort":7, "name":"版画"},
        ]
  },
  "code": 30000,//其它非30000表示系统错误
  "message": "success",
  "debug": false
}

```

## 3 登录信息统计
### 3.1 启动页接口修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/Extension/getNext 
> 需要token：是(GET方式传token)

**说明**
> 增加请求参数，返回数据不变：device,system,version

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|device|设备信息|string|是||-|
|system|系统信息|string|是||-|
|version|APP版本|string)|是||-|

**响应结果示例**
```
{
    "data": {
    "status": 1000,
    "info": {
        "id": "1",
        "artist": "1",
        "img": "https://img6.bdstatic.com/img/image/smallpic/x1.jpg",
        "url": "gallery-1-艺术家"
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 3.2 帐号密码登录接口修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/user/accountLogin  
> 需要token：是(GET方式传token)

**说明**
> 增加请求参数，返回数据不变：device,system,version

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|mobile|手机号码|正则：^1[34578]{1}\d{9}$|是|"18588260188"|-|
|verifyCode  | 验证码 |-|否，如果是登陆，不要传入此字段|-|-|
|password  | 密码 |-|否|-|-|
|from  | 来源 |-|否，字符串，约定取值范围{pc,h5,ios,android}|"pc"|-|
|device|设备信息|string|是||-|
|system|系统信息|string|是||-|
|version|APP版本|string)|是||-|

**响应结果示例**
```
{
  "data": {
    "status": 1000//跟code参数一起用来判断是否增加新的微信成功
    "inviteCode":"100001",登录成功后的邀请码
    "isArtist":1//1、艺术家，-1，非艺术家
    "userid" : "111"
  },
  "code": 30000,//其它非30000表示系统错误
  "message": "success",
  "debug": false
}

```

### 3.3 第三方登录接口修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/user/login 
> 需要token：是(GET方式传token)

**说明**
> 增加请求参数，返回数据不变：device,system,version

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|thirdInfo|第三方的登录信息|string(json object)|是|参考thirdInfo示例|-|
|thirdFullInfo|第三方登录的完整信息|string(json object)|否|"{}"|-|
|device|设备信息|string|是||-|
|system|系统信息|string|是||-|
|version|APP版本|string)|是||-|

**thirdInfo示例**
```
{
  "partnerCode":"合作方编码。WECHAT：微信；QQ：QQ；WEIBO：新浪微博",
  "openId":"合作方登录账号开放ID",
  "unionId":"合作方登录账号联合ID",
  "nickname":"昵称，为空值时，从合作方用户信息里取相应的nickname",
  "gender":"性别。1：男；2：女；3：保密",
  "faceUrl":"头像Url"
}
```

**响应结果示例**
```
{
  "data": {
    "status": 1000,
    "inviteCode":"100001",登录成功后的邀请码
    "userid" : "111",
    "isArtist" => true
  },
  "code": 30000,//其它非30000表示系统错误
  "message": "success",
  "debug": false
}

```











