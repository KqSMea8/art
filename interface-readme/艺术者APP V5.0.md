[toc]
# 艺术者APP V5.0
## 1 话题
### 1.1 创建新话题
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/addTopic
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|title|话题标题|string|是|-|-|
|content|话题背景|string|否|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "id": "2",//话题id
            "title": "dedddd"//话题标题
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.2 获取包含关键字已存在的话题（包含关键字的浏览量最多的20条话题）
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/getKeyTopic
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|title|话题标题|string|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "2",//话题id
                "title": "dedddd"//话题标题
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.3 获取我关注的话题
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/getMyFollowTopic
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "2",//话题id
                "title": "dedddd"//话题标题
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.4 获取热门话题
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/getHotTopic
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-| 

**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "2",//话题id
                "title": "dedddd"//话题标题
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.5 话题详情基本信息

> 请求方法：POST
> 需要登录：否
> app请求地址：https://test-api.artzhe.com/V50/Topic/getTopicDetail
> h5请求地址：https://test-api.artzhe.com/V50/MobileGetH5/getTopicDetail
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|id  | 话题id| int|是|-||


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "id": "1",//话题id
            "title": "最爱",//话题标题
            "content": "ttt",//话题背景
            "view_num": "3",//话题浏览量
            "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1500357868258091.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//用户头像
            "nickname": "潇潇",//用户昵称
            "gender": "2",//1--男  2--女 3--未知
            "is_follow": "Y"//是否关注  Y--是   N--否
             "shareLink": "https://test-m.artzhe.com/topic/detail/1",//分享链接
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```


### 1.6 话题详情讨论列表

> 请求方法：POST
> 需要登录：否
> app请求地址：https://dev-api.artzhe.com/V50/Topic/getTopicDiscuss
> h5请求地址：https://test-api.artzhe.com/V50/MobileGetH5/getTopicDiscuss
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|id  | 话题id| int|是|-||
|type  | 讨论列表类型| string|是|hot|hot--热门，date--时间|
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
                    "id": 1,//讨论id
                    "title": 'ddd,//讨论标题
                    "type": 1,//1--文本 2--图片 3--视频  4--文章（类似艺术号）
                    "is_top": 1,//是否置顶  1--是  0--否
                    "datetime": "2017-08-25",//创建时间
                    "like_count": 0,//喜欢数量
                    "isLike": 0,//是否喜欢 1--喜欢  0--不喜欢
                    "comment_count": 0,//评论数量
                    "share_count": 0,//分享数量
                    "userinfo": {//发表讨论者信息
                        "id": "111295",//用户id
                        "nickname": "lilygg",//用户昵称
                        "gender": 1,//1--男  2--女 3--未知
                        "faceUrl"://用户头像 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                        "is_artist": 0,//是否是艺术家  1--是  0--不是
                        "is_agency": 0,//是否是机构  1--是  0--不是
                        "AgencyType": 0,//机构类型
                        "is_planner": 0,//是否是策展人  1--是  0--不是
                        "is_follow": "Y"//是否关注
                    },
                    "content": "3ddd",//描述文字
                    "thumbnails": [
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/resize,w_300,limit_0,image/format,jpg"//缩略图
                    ],
                    "images_url": [
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10"//大图
                    ],
                    "video_poster": "",//视频封面
                    "video_url": "",//视频url
                    "shareLink": "https://test-m.artzhe.com/topicDiscuss/detail/1"
                }
            ],
            "page": 1,
            "total": "1",
            "pagesize": 20,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 1.7 关注话题
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/followTopic
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题id|int|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.8 取消关注话题
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/unfollowTopic
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题id|int|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.9 分享话题和话题讨论
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/addShare
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题id或讨论id|int|是|-|-|
|type|id类型|string|是|topic|topic--话题  discuss--讨论|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

## 2 话题讨论
### 2.1 创建话题讨论
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V50/Topic/addTopicDiscuss
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|topic_id|话题id|int|是|-|-|
|type|话题讨论类型|int|是|-|1--短文（类似艺术圈）  2--文章（类似艺术号）|
|title|文章标题|string|否，type为2时传入|-|-|
|content|文章内容|string|否，type为2时传入|-|
|desc|短文内容|string|否，type为1时传入|-|-|
|images_url|短文图片|string|否，type为1时传入|-|-|
|video_poster|短文视频封面|string|否，type为1时传入|-|-|
|video_url|短文视频|string|否，type为1时传入|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```
### 2.2 讨论详情

> 请求方法：POST
> 需要登录：否
> app请求地址：http://test-api.artzhe.com/V50/Topic/getTopicDiscussDetail
> h5请求地址：https://test-api.artzhe.com/V50/MobileGetH5/getTopicDiscussDetail
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|id  | 讨论id | int|是|-||


**响应结果示例**
```
{
    "data"      : {
    "status"    : 1000,
    "info"      : {
    "id"        : "1",//讨论id
    "type"      : "4",//1--文本 2--图片 3--视频  4--文章（类似艺术号）
    "title"     : "",//文章标题
    "content"   : "帮一部小说配插图，画的都是有关儿时的记忆啊",//短文内容或文章内容
    "thumbnails": [//缩略图
    "http       ://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/resize,w_300,limit_0,image/format,jpg"
            ],
            "images_url": [//原图
            "http       ://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10"
            ],
            "video_poster": "",//视频封面
            "video_url": "",//视频
            "view_num": "8",//浏览数
            "like_num": "0",//喜欢数
            "comment_num": "0",//评论数
            "share_num": "0",//转发数
            "is_top": "1",//是否置顶 1--置顶  0--否
            "datetime": "2017-08-25",//时间
            "topic": {//相关话题
                "id": "3",//话题id
                "title": "最爱额画"//话题标题
            },
            "userinfo": {//用户信息
                "id": "111295",//用户id
                "nickname": "lilygg",//用户昵称
                "faceUrl"://头像 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                "gender": "1",//性别  1--男 2--女  3--未知
                "is_artist": 0,//是否是艺术家  1--是 0--否
                "is_agency": 0,//是否是机构  1--是 0--否
                "AgencyType": 0,//机构类型
                "is_planner": 0,//是否是策展人  1--是 0--否
                "is_follow": "N"//是否关注用户  Y--是 N--否
            },
            "is_like": "N",//是否喜欢讨论
            "shareLink": "https://test-m.artzhe.com/topic/detail/1",//分享链接
            "shareContent":"ddddd",
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.3 话题讨论点赞列表
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/getTopicDiscussLike
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/getTopicDiscussLike
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题讨论id|int|是|-|-|
|page  | 页码 | int|是|-||
|pagesize  | 每页获取条数 | int|是|-||


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "create_time": "2017-08-25",//时间
                    "userid": "111295",//用户id
                    "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//用户头像
                    "nickname": "lilygg",//用户昵称
                    "gender": "1"//用户性别  1--男  2--女  3--未知
                }
            ],
            "page": 1,
            "total": "1",
            "pagesize": 20,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.4 话题讨论转发列表
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/getTopicDiscussShare
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/getTopicDiscussShare
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题讨论id|int|是|-|-|
|page  | 页码 | int|是|-||
|pagesize  | 每页获取条数 | int|是|-||


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "create_time": "2017-08-25",//时间
                    "userid": "111295",//用户id
                    "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//用户头像
                    "nickname": "lilygg",//用户昵称
                    "gender": "1"//用户性别  1--男  2--女  3--未知
                }
            ],
            "page": 1,
            "total": "1",
            "pagesize": 20,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.5 话题讨论评论列表
> 请求方法：POST
> 需要登录：否
> app请求地址：http://test-api.artzhe.com/V50/Topic/getTopicDiscussComment
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/getTopicDiscussComment
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题讨论id|int|是|-|-|
|page  | 页码 | int|是|-||
|pagesize  | 每页获取条数 | int|是|-||


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "id": "1",//评论id
                    "content": "dddd",//评论内容
                    "status": "1",//评论状态  0删除 1正常
                    "create_time": "2018-11-30",//评论时间
                    "isAllowDelete": 1,//0--否  1-是
                    "comment_num": 3,//子评论数量
                    "list": [//子评论
                        {
                            "id": "6",//子评论id
                            "content": "red2222ddd",//子评论内容
                            "status": "1",//评论状态  0删除 1正常
                            "create_time": "2018-11-30",//子评论时间
                            "isAllowDelete": 1,//0--否  1-是
                            "userid": "111295",//子评论评论者id
                            "comment_to": "simao",//子评论被评论者id
                            "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//子评论用户头像
                            "nickname": "lilygg",//子评论用户昵称
                            "gender": "1"//子评论用户性别1--男  2--女  3--未知
                        },
                    ],
                    "userinfo": {
                        "id": "1",//用户id
                        "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//用户头像
                        "nickname": "simao",//用户昵称
                        "gender": "3"//用户性别1--男  2--女  3--未知
                    }
                }
            ],
            "page": 1,
            "total": "1",
            "pagesize": 20,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.6 话题讨论评论详情
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V50/Topic/getTopicDiscussCommentDetail
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题讨论评论id|int|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "id": "1",//评论id
            "content": "dddd",//评论内容
            "create_time": "2018-11-30",//评论时间
            "isAllowDelete": 1,//0--否  1-是
            "userid": "100028",//评论用户id
            "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",//评论用户头像
            "nickname": "simao",//评论用户昵称
            "gender": "3",//评论用户性别1--男  2--女  3--未知
            "list": [//评论的下级评论
                {
                    "id": "6",//下级评论id
                    "content": "red2222ddd",//下级评论内容
                    "create_time": "2018-11-30",//下级评论时间
                    "isAllowDelete": 1,//0--否  1-是
                    "userid": "111295",//下级评论评论者id
                    "comment_to": "simao",//子评论被评论者id
                    "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg",//下级评论用户头像
                    "nickname": "lilygg",//下级评论用户昵称
                    "gender": "1"//下级评论用户性别1--男  2--女  3--未知
                },
              
            ]
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.7 喜欢话题讨论
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/likeTopicDiscuss
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/likeTopicDiscuss
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题id|int|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "faceurl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg"//用户头像
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.8 取消喜欢话题讨论
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/unlikeTopicDiscuss
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/unlikeTopicDiscuss
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|话题id|int|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.9 评论讨论
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/commentDiscuss
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/commentDiscuss
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|讨论id|int|是||-|
|content|评论内容|string|是||-|

**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "id": "21",//评论id
            "commenter": "gg",//评论者
            "commenter_user_id": "1111",//评论者id
            "comment_to": "",//评论对象
            "content": "tttttt4",//评论内容
            "datetime": "2017-11-08 16:40:45"//评论时间
        }
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```

### 2.10 回复评论
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/replyComment
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/replyComment
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|commentId|要回复的评论ID|int|是||-|
|content|内容|string|是||-|

**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "id": "22",//评论id
            "commenter": "dd",//评论者
            "commenter_user_id": "1111",//评论者id
            "comment_to": "dd",//评论对象
            "content": "tttttt4rr",//评论内容
            "datetime": "2017-11-08 16:46:59"//评论时间
        }
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```

### 2.11 删除评论
> 请求方法：POST
> 需要登录：是
> app请求地址：http://test-api.artzhe.com/V50/Topic/deleteComment
> h5请求地址：http://test-api.artzhe.com/V50/MobileGetH5/deleteComment
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|评论id|int|是||-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "commentId": "22"//评论id
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```



## 3 搜索
### 3.1 获取搜索页面的热搜关键字和搜索推荐
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V47/Search/getSearchKey
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|name|关键字|string|否|-|有--搜索推荐  无--热搜关键字|

**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [//搜索关键字
            "画",
            "游记"
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```



### 3.2 获取搜索结果(艺术家、作品、艺术号、话题)
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V47/Search/getSearchResult
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|name|关键字|string|是|-|-|
|type|类型|string|是|-|all--综合 artist--艺术家  artwork--作品  article--艺术号  topic--话题|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|

**响应结果示例**
```javascript
//综合
{
    "data": {
        "status": 1000,
        "info": [
            {
                "type": 1,//1--艺术家  2--作品  3--艺术号 4--话题
                "id": "110628",//id
                "title": "全富绘画",//艺术家昵称，作品名称，艺术号标题
                "cover": "http://wx.qlogo.cn/mmhead/Q3auHgzwzM6bHmZH2fqokribBtt87aVNlQ23oWXeQBf3aicyxtbrEeAg/0?x-oss-process=image/resize,m_fill,h_50,w_50,limit_0,image/format,jpg",//艺术家头像，作品封面，艺术号封面
                "gender": "1"//艺术家性别  1男2女3未知
                "update_times": "1",//作品更新次数
                "views": "227",//艺术号浏览数
                "nickname": "艺术者新闻号",//艺术号用户名称
                "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png?x-oss-process=image/resize,m_fill,h_50,w_50,limit_0,image/format,jpg"//艺术号用户头像
            }
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

//艺术家
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "110628",//艺术家id
                "nickname": "全富绘画",//昵称
                "face": "http://wx.qlogo.cn/mmhead/Q3auHgzwzM6bHmZH2fqokribBtt87aVNlQ23oWXeQBf3aicyxtbrEeAg/0?x-oss-process=image/resize,m_fill,h_50,w_50,limit_0,image/format,jpg",//头像
                "gender": "1",//性别  1男2女3未知
            }
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

//作品
{
    "data": {
        "status": 1000,
        "info": [
             {
                "id": "332",//作品id
                "name": " 《漂流者》原创油画 ",//作品名称
                "cover": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017-08-21/h4FScH5yFf.jpg?x-oss-process=image/resize,m_fill,h_50,w_50,limit_0,image/format,jpg",//作品封面  
                 "update_times": "1"//更新次数
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

//艺术号
{
    "data": {
        "status": 1000,
        "info": [
             {
                "id": "251",//艺术号id
                "title": "艺趣 | 当世界名画动起来，根本停不下来！",//艺术号标题
                "cover": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/auto/2017/11/10/07/0ucfIxd7/1436330453.png?x-oss-process=image/resize,m_fill,h_50,w_50,limit_0,image/format,jpg",//艺术号封面
                "views": "227",//浏览数
                "nickname": "艺术者新闻号",//用户名称
                "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png?x-oss-process=image/resize,m_fill,h_50,w_50,limit_0,image/format,jpg"//用户头像
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

//话题
{
    "data": {
        "status": 1000,
        "info": [
             {
                "id": "332",//话题id
                "title": " 《漂流者》原创油画 ",//话题标题
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```



# 艺术者APP V5.1
## 1 画作
### 1.1 评论列表
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V51/Artwork/getCommentList
> 需要token：是(GET方式传token)

**返回说明**
> list添加返回参数：
> "type": "1"//1--画作评论  2--话题讨论评论
> "topicInfo": {话题信息
                        "id": "142",
                        "title": "雕塑"
                    }

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|画作id|int|是|-|-|
|type|类型|int|是|1|1--画作评论  2--创作花絮评论|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "list": [
                 {
                    "type": 1,//1--画作评论  2--话题讨论评论
                    "content": "饿鬼",
                    "time": "23小时前",
                    "likes": "1",
                    "artist": "111550",
                    "nickname": "arta",
                    "faceurl": "https://tvax2.sinaimg.cn/crop.0.0.996.996.50/665b1c54ly8fh3pmo477vj20ro0roq5k.jpg",
                    "gender": "3",
                    "commentId": "9357",
                    "repayer": "arta",
                    "repayContent": "巡考",
                    "repayTime": "23小时前",
                    "isLike": "Y",
                     "topicInfo": {
                        "id": "142",
                        "title": "雕塑"
                    }
                }
            ],
            "shareInfo": {
                "name": "arta",
                "face": "https://tvax2.sinaimg.cn/crop.0.0.996.996.50/665b1c54ly8fh3pmo477vj20ro0roq5k.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",
                "motto": "",
                "category": "插画/工笔/雕塑"
            },
            "page": 1,
            "total": "2",
            "pagesize": 10,
            "maxpage": 1,
            "is_repay": "Y"
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

## 2 艺术圈
### 1.1 艺术圈列表列表
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V51/ArtCircle/GetList 艺术圈列表
https://test-api.artzhe.com/V51/ArtCircle/userCirlelist 个人艺术圈列表
> 需要token：是(GET方式传token)

**返回说明**
> 添加返回参数：
> type：新增type类型，数据使用share_link中的数据， 101 --同步话题   102--同步话题讨论   201--同步画作
> 修改topicInfo，以前是对象，现在是数组，
> "topicInfo": [
                {
                    "id": 143,
                    "title": "静物"
                },
            ],

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|画作id|int|是|-|-|
|type|类型|int|是|1|1--画作评论  2--创作花絮评论|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "id": 1150,
                    "type": 2,//1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊   15:分享专题    16:分享话题  17：分享话题讨论  101：同步话题   102：同步话题讨论   201：同步画作
                    "address": "",
                    "content": "《二富贵花》",
                    "thumbnails": [
                        "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/111/550/files/2019/01/4hdra0adac.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg"
                    ],
                    "images_url": [
                        "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/111/550/files/2019/01/4hdra0adac.jpg?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10"
                    ],
                    "video_poster": "",
                    "video_url": "",
                    "datetime": "2天前",
                    "like_count": 0,
                    "isLike": 0,
                    "comment_count": 0,
                    "isAllowDelete": 1,
                    "userinfo": {
                        "id": "111550",
                        "nickname": "arta",
                        "gender": 3,
                        "faceUrl": "https://tvax2.sinaimg.cn/crop.0.0.996.996.50/665b1c54ly8fh3pmo477vj20ro0roq5k.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                        "is_artist": 1,
                        "is_agency": 0,
                        "AgencyType": 0,
                        "is_planner": 0
                    },
                    "share_link": {
                        "type": "artwork",
                        "id": "977",
                        "title": "《二富贵花》",
                        "content": "想回家卡罗拉",
                        "thumbnail": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/111/550/files/2019/01/4hdra0adac.jpg?x-oss-process=image/resize,w_700,limit_0,image/format,jpg",
                        "image_url": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/111/550/files/2019/01/4hdra0adac.jpg?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10",
                        "thumbnails": [
                            "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/111/550/files/2019/01/4hdra0adac.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg"
                        ],
                        "image_urls": [
                            "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/111/550/files/2019/01/4hdra0adac.jpg?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10"
                        ],
                        "video_poster": "",
                        "video_url": ""
                    },
                    "like_nickname": [],
                    "comment_list": [],
                    "artworkInfo": {
                        "artworkId": "",
                        "artworkName": ""
                    },
                    "topicInfo": [
                        {
                            "id": 143,
                            "title": "静物"
                        },
                    ],
                },
            ],
            "page": 1,
            "total": "910",
            "pagesize": 20,
            "maxpage": 46
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

## 3 话题
### 3.1 话题详情讨论列表

> 请求方法：POST
> 需要登录：否
> app请求地址：https://dev-api.artzhe.com/V51/Topic/getTopicDiscuss
> h5请求地址：https://test-api.artzhe.com/V51/MobileGetH5/getTopicDiscuss
> 需要token：是(GET方式传token)

**返回说明**
> 添加返回参数：
> 新增relation_info
>  "relation_info": {
                        "type": "artwork",//关联类型：artwork--画作   artwork_update--花絮  art_article--艺术号  subject--专题
                        "relation_id": "868",//对应id
                        "title": "《yuki's test》"//标题
                    },

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|id  | 话题id| int|是|-||
|type  | 讨论列表类型| string|是|hot|hot--热门，date--时间|
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
                    "id": 1,//讨论id
                    "title": 'ddd,//讨论标题
                    "type": 1,//1--文本 2--图片 3--视频  4--文章（类似艺术号）
                    "is_top": 1,//是否置顶  1--是  0--否
                    "datetime": "2017-08-25",//创建时间
                    "like_count": 0,//喜欢数量
                    "isLike": 0,//是否喜欢 1--喜欢  0--不喜欢
                    "comment_count": 0,//评论数量
                    "share_count": 0,//分享数量
                    "userinfo": {//发表讨论者信息
                        "id": "111295",//用户id
                        "nickname": "lilygg",//用户昵称
                        "gender": 1,//1--男  2--女 3--未知
                        "faceUrl"://用户头像 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                        "is_artist": 0,//是否是艺术家  1--是  0--不是
                        "is_agency": 0,//是否是机构  1--是  0--不是
                        "AgencyType": 0,//机构类型
                        "is_planner": 0,//是否是策展人  1--是  0--不是
                        "is_follow": "Y"//是否关注
                    },
                     "relation_info": {
                        "type": "artwork",//关联类型：artwork--画作   artwork_update--花絮  art_article--艺术号  subject--专题
                        "relation_id": "868",//对应id
                        "title": "《yuki's test》"//标题
                    },
                    "content": "3ddd",//描述文字
                    "thumbnails": [
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/resize,w_300,limit_0,image/format,jpg"//缩略图
                    ],
                    "images_url": [
                        "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10"//大图
                    ],
                    "video_poster": "",//视频封面
                    "video_url": "",//视频url
                    "shareLink": "https://test-m.artzhe.com/topicDiscuss/detail/1"
                }
            ],
            "page": 1,
            "total": "1",
            "pagesize": 20,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 3.2 讨论详情

> 请求方法：POST
> 需要登录：否
> app请求地址：http://test-api.artzhe.com/V51/Topic/getTopicDiscussDetail
> h5请求地址：https://test-api.artzhe.com/V51/MobileGetH5/getTopicDiscussDetail
> 需要token：是(GET方式传token)

**返回说明**
> 添加返回参数：
> 新增relation_info
>  "relation_info": {
                        "type": "artwork",//关联类型：artwork--画作   artwork_update--花絮  art_article--艺术号  subject--专题
                        "relation_id": "868",//对应id
                        "title": "《yuki's test》"//标题
                    },


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|id  | 讨论id | int|是|-||


**响应结果示例**
```
{
    "data"      : {
    "status"    : 1000,
    "info"      : {
    "id"        : "1",//讨论id
    "type"      : "4",//1--文本 2--图片 3--视频  4--文章（类似艺术号）
    "title"     : "",//文章标题
    "content"   : "帮一部小说配插图，画的都是有关儿时的记忆啊",//短文内容或文章内容
    "relation_info": {
                        "type": "artwork",//关联类型：artwork--画作   artwork_update--花絮  art_article--艺术号  subject--专题
                        "relation_id": "868",//对应id
                        "title": "《yuki's test》"//标题
                    },
    "thumbnails": [//缩略图
    "http       ://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/resize,w_300,limit_0,image/format,jpg"
            ],
            "images_url": [//原图
            "http       ://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/10/23/18/4a3e21e05d8015a3b15dbe1e23291fb7.png?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA2LzE0LzE0OTc0MTExMDg2MjkzODIucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10"
            ],
            "video_poster": "",//视频封面
            "video_url": "",//视频
            "view_num": "8",//浏览数
            "like_num": "0",//喜欢数
            "comment_num": "0",//评论数
            "share_num": "0",//转发数
            "is_top": "1",//是否置顶 1--置顶  0--否
            "datetime": "2017-08-25",//时间
            "topic": {//相关话题
                "id": "3",//话题id
                "title": "最爱额画"//话题标题
            },
            "userinfo": {//用户信息
                "id": "111295",//用户id
                "nickname": "lilygg",//用户昵称
                "faceUrl"://头像 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                "gender": "1",//性别  1--男 2--女  3--未知
                "is_artist": 0,//是否是艺术家  1--是 0--否
                "is_agency": 0,//是否是机构  1--是 0--否
                "AgencyType": 0,//机构类型
                "is_planner": 0,//是否是策展人  1--是 0--否
                "is_follow": "N"//是否关注用户  Y--是 N--否
            },
            "is_like": "N",//是否喜欢讨论
            "shareLink": "https://test-m.artzhe.com/topic/detail/1",//分享链接
            "shareContent":"ddddd",
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```