[toc]
# 艺术者APP V4.2
## 1 专题
### 1.1 专题详情（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/Home/getSubjectDetail 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：shareInfo


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|subid|专题ID|int|是|-|-|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```
{
  "data": {
    "status": 1000,
    "info": {
      "subid": "1", //专题ID
      "sub_name": "微距摄影", //专题名称
      "sub_title": "微距专场", //专题标题
      "sub_cover": "专题封面",
      "html5_description": "一种光距比较近距离的摄影", //专题描述
      "data": [
        {
          "artid": "48", //作品ID
          "artname": "tsrhbthn", //作品名称
          "category": "水彩", //作品类型
          "shape": "1", //作品形状 1方形 2圆形
          "length": "80", //长
          "width": "40", //宽
          "diameter": "0", //直径
          "art_cover": "作品封面",
          "description": "dfshsdxfcghsfghfj", //描述
          "author": "abc", //作者
          "face": "作者头像"
        },
        {
          "artid": "46", //作品ID
          "artname": "dsagdf", //作品名称
          "category": "水彩", //作品类型
          "shape": "1", //作品类型 1方形 2圆形
          "length": "0", //长
          "width": "0", //宽
          "diameter": "0", //直径
          "art_cover": "作品封面",
          "description": "sdgvfasdg", //描述
          "author": "...", //作者
          "face": "作者头像"
        }
      ],
      "shareInfo":{//分享信息
        "title":"dd",//分享标题
        "image":"",//分享图片
        "link":"mobile.artzhe.com",//分享链接
      },
      "page": "1",
      "total": "2",
      "pagesize": 5,
      "maxpage": 1
    }
  },
  "code": 30000,
  "message": "success",
  "debug": false
}

```

### 1.2 专题详情H5
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/Home/getSubjectDetailH5 
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|subid|专题ID|int|是|-|-|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```
{
  "data": {
    "status": 1000,
    "info": {
      "subid": "1", //专题ID
      "sub_name": "微距摄影", //专题名称
      "sub_title": "微距专场", //专题标题
      "sub_cover": "专题封面",
      "description": "一种光距比较近距离的摄影", //专题描述
      "html5_description": "https://test-m.artzhe.com/subject/content/2",//
      "data": [
        {
          "artid": "48", //作品ID
          "artname": "tsrhbthn", //作品名称
          "category": "水彩", //作品类型
          "shape": "1", //作品形状 1方形 2圆形
          "length": "80", //长
          "width": "40", //宽
          "diameter": "0", //直径
          "art_cover": "作品封面",
          "description": "dfshsdxfcghsfghfj", //描述
          "author": "abc", //作者
          "face": "作者头像"
        },
        {
          "artid": "46", //作品ID
          "artname": "dsagdf", //作品名称
          "category": "水彩", //作品类型
          "shape": "1", //作品类型 1方形 2圆形
          "length": "0", //长
          "width": "0", //宽
          "diameter": "0", //直径
          "art_cover": "作品封面",
          "description": "sdgvfasdg", //描述
          "author": "...", //作者
          "face": "作者头像"
        }
      ],
      "page": "1",
      "total": "2",
      "pagesize": 5,
      "maxpage": 1,
      "shareInfo":{//分享信息
        "title":"dd",//分享标题
        "image":"",//分享图片
        "link":"mobile.artzhe.com",//分享链接
      },
    }
  },
  "code": 30000,
  "message": "success",
  "debug": false
}

```


## 2 艺术圈
### 2.1 发表艺术圈接口（修改）

> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/ArtCircle/add 
> 需要token：是(GET方式传token)

**修改说明**
> 修改请求参数：share_type 增加一种类型分享专题subject


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|address|地址|string|否|-|-|
|content|内容|string|是|-|-|
|images_url|图片|string|否|-|-|
|video_poster|视频封面|string|否|-|-|
|video_url|视频|string|否|-|-|
|share_type|分享类型|string|否|artwork分享画作， artwork_update分享更新， art_article分享艺术号，gallery分享画廊，subject分享专题|
|share_id|分享对应的ID|int|否|-|-|
|artworkId|关联作品id|int|否|-|-|

**响应结果示例**
```
{
    "data": {
        "status": 1000,
        
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 2.2 艺术圈列表（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V42/ArtCircle/GetList 
> 需要token：是(GET方式传token)

**修改说明**
> 修改返回参数： type 增加类型 15:分享专题


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
                    "type": 2, //1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊  15:分享专题
                    "address": "中南海",
                    "content": "更多few",
                    "artworkInfo": {//关联作品信息
                        "artworkId":"12",
                        "artworkName":"戏",
                    ｝,
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

### 2.3 个人艺术圈列表（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V42/ArtCircle/userCirlelist 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数: type 增加类型 15:分享专题


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
                    "type": 2, //1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊  15:分享专题
                    "address": "中南海",
                    "content": "更多few",
                    "artworkInfo": {//关联作品信息
                        "artworkId":"12",
                        "artworkName":"戏",
                    ｝,
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

### 2.4 艺术圈详情（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V42/ArtCircle/Detail 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数: type 增加类型 15:分享专题


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|id |艺术圈ID| int|是|-|-|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
                    "id": 24,
                    "type": 2, //1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊  15:分享专题
                    "address": "中南海",
                    "content": "更多few",
                    "artworkInfo": {//关联作品信息
                        "artworkId":"12",
                        "artworkName":"戏",
                    ｝,
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
                      "like_face": [//点赞头像
                    "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1499165502622273.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",
                    "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-10-13-165143-x6rdb364uu.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10"
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
                }
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

## 3 引导页
### 3.1 获取引导的状态
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/guide/getStatus 
> 需要token：是(GET方式传token)


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info":{
            "show_tags":1,//是否显示标签引导页面   1--显示   0--不显示
            "show_artists":1,//是否显示感兴趣的人页面   1--显示   0--不显示
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 3.2 获取引导的标签
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/guide/getTags 
> 需要token：是(GET方式传token)


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info":{
             "category":[//类型
                {
                    "id":"1",
                    "name":"油画",
                    "image":"https://ddd",
                    "sort":"1",
                },
            ],
            "subject":[//题材
                {
                    "id":"1",
                    "name":"油画",
                    "image":"https://ddd",
                    "sort":"1",
                },
            ],
        },
        
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 3.3 保存用户选择的标签
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/guide/saveTags 
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|category_ids |用户选择的类型id| string|是|逗号隔开  1,2|-|
|subject_ids |用户选择的题材id| string |是|逗号隔开  1,2|-|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info":{
            "show_artists":1,//是否显示感兴趣的人页面   1--显示   0--不显示
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 3.4 获取用户感兴趣艺术家
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/guide/getArtists 
> 需要token：是(GET方式传token)



**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info":{
           "artists":[
                    {
                        "id": "111351",//用户id
                        "name": "吴玥",//用户名称,
                        "popularity": 10,//人气值
                        "cover": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1505013326183236.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10"//画廊封面
                    },
            ],
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 3.5 一键关注艺术家
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V42/guide/followArtists 
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|artists |用户id| string|是|逗号隔开  1,2|-|



**响应结果示例**
```
{
    "data": {
       "status": 1000,
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

##4 首页
### 4.1 获取首页推荐页面信息（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/Home/getHomeRecommendation 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数： column--栏目信息   artwork--推荐作品    subject--专题  article--艺术号
> 修改返回参数： artists--艺术家榜单
> 如果栏目不存在，则对应的栏目数据字段不返回


**返回数据说明**
| 字段        | 字段描述   |  规格  |数据说明|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |
|banner.type  | 链接类型 | int|1-外部链接，需要token； 2-外部链接，不需要token； 3-内部链接，画廊详情；  4-内部链接，画作详情； 5-花絮详情； 6-艺术专题详情； 7-艺术号详情|-|
|banner.link  | 图片链接 | string|外部链接(type取值1，2)--URL; 内部链接（type取值3，4，5，6，7）--对应的id，例如：type是3，link则是画廊id||

**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "banner": [
                {
                    "id": "1",//数据id
                    "sort": "10",//排序
                    "image": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/14/15/2c1113496651f735a5db3476e278a962.png",//图片url
                    "type": "1",// 1-外部链接，需要token  2-外部链接，不需要token  3-内部链接，画廊详情  4-内部链接，画作详情  5-花絮详情  6-艺术专题详情  7-艺术号详情
                    "link": "https://www.baidu.com/index.html",//图片链接,外部链接--URL   内部链接--对应的id
                    "desc": "推荐百度"//描述
                },
            ],
             "column": [//栏目信息
                {
                    "name": "推荐作品",//栏目名称
                    "type": "1",//栏目的类型    1--艺术家   2--画作   3---花絮   4--艺术号    5--专题    
                    "sort": "1",//栏目序号,数字小的在前面
                    "show_number": "5",栏目显示内容数量
                },
            ],
            "artists":[//艺术家榜单
                {
                    "user_id": "111351",//用户id
                    "user_name": "吴玥",//用户名称,
                    "user_gender": "1",//用户性别, 1--男  2--女  3-未知
                    "user_face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1505013326183236.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",//用户头像
                    "artwork_id": "111351",//作品id
                    "artwork_name": "《雀之灵》",//作品名称,
                    "artwork_cover": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1505013326183236.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10"//作品封面图
                },
            ],
            "record": [
                {
                    "title": "《我们是未来接班人》花絮",//花絮标题
                    "artid": "395",//作品id
                    "artupid": "572",//花絮id
                    "artname": "我们是未来接班人",//画作名称
                    "uname": "許京甫",//艺术家名称
                    "faceurl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1501937332608856.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",//艺术家头像
                    "summary": "挂在工作室了",//简介
                    "category": "",//分类
                    "imgurl": [
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1505227526846478.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg"
                    ],//花絮图片
                    "video": "",//花絮视频
                    "uptime": "2017-09-12 22:46:22",//更新时间
                    "like_total": "12",//喜欢总数
                    "istop": "N"
                },
            ],
            "artwork": [//推荐作品
                {
                    "id":12,//作品id
                    "name":"《就》",//作品名字
                    "artist":"punk",//艺术家名称
                    "cover":"http://artzhe.",//作品封面图
                },
            ],
            "subject": [//专题
                {
                    "type": "1",// 1--活动h5   2--专题
                    "id": "9",//对应id
                    "subname": "test",
                    "imgurl"://封面图片 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/14/15/fc9b8e53c056d7431809a113b290f566.png",
                    "html5_description": "www",
                    "shareInfo": {//分享信息
                        "id": "1",
                        "title": "活动",
                        "content": "15544444",
                        "cover": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/14/15/fc9b8e53c056d7431809a113b290f566.png",
                        "link": "www"
                    }
                },
                ,
                {
                    "type": "2",
                    "id": "9",
                    "subname": "test",
                    "imgurl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/14/15/fc9b8e53c056d7431809a113b290f566.png",
                    "html5_description": "https://test-m.artzhe.com/subject/content/9"
                },
            ],
            "article": [//艺术号
                {
                    "id": "262",//艺术号id
                    "title": "2018.01.16",//艺术号标题
                    "excerpt": "dddddd",//文章描述
                    "like_count": "0",//喜欢数
                    "is_like": 0,//是否喜欢 1--喜欢  0--不喜欢
                    "views": "0",//浏览数量
                    "cover": "",//艺术号封面图
                    "video": 0,//1--是视频  0--不是视频
                    "user": {
                         "id": "100001",
                        "nickname": "Punk",//艺术家/机构/媒体名称
                        "faceUrl": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1492160518739919?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//艺术家/机构/媒体头像
                        "is_artist": 1,//是否艺术家
                        "is_agency": 0,//是否认证机构
                        "AgencyType": 0,//认证机构类型
                        "is_planner": 0//是否策展人
                    }
                }
            ],
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


