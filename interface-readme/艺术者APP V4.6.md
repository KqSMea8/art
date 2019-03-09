[toc]
# 艺术者APP V4.6
## 1 艺术号
### 1.1 发表文章接口（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/publishArticle
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|updateId|花絮id|int|否|-|如果提交，是修改花絮，并发布|
|updateDraftId|花絮草稿箱id|int|否|-|如果提交，是修改草稿，并发布|
|artworkId|关联作品id|int|否|-|如果提交，是发布花絮；不提交，是发布艺术号文章|
|title|文章标题|string|否|-|如果不提交，默认当前日期|
|wit|文章内容|string|是|-|-|
|articleTag|文章标签|string|是|-|多个标签以逗号,分隔|
|createDate|创作日期，2016-3-12形式|string|否|2016-3-12|原创作记录艺术家选择的时间，现在默认是当前日期|
|shareToArtCircle|是否分享到艺术圈|int|是|1|0--不分享，1--分享|

**响应结果示例**
> 1.发布花絮返回结果
```javascript
{
  "data": {
    "status": 1000,
    "EditLockEnable":0,//0--不限制24小时可编辑，1--限制
    "shareTitle": "铃兰《海阔天空》更新3",
    "shareDesc": "作品描述",
    "shareImg": "http://gsywww.oss-cn-shenzhen.aliyuncs.com/test.jpg"
    "shareLink": "https://dev-m.artzhe.com/artwork/update/700",
    "shareInfo": {
        "face": "https://gsy-other.oss-cn-beijing.aliyuncs.com/face.jpg",
        "name": "艺术者",//用户名称
        "category": "水彩,插画,素描",
        "cover": "http://gsywww.oss-cn-shenzhen.aliyuncs.com/test.jpg",
        "link": "http://test-m.artzhe.com/artwork/update/10",
        "motto": "kkdfg" //签名
        } 
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

> 1.发布艺术号返回结果
```javascript
{
  "data": {
    "status": 1000,
    "articleId": 1,//艺术号id
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```


## 2 专题
### 2.1 喜欢
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V44/Subject/like  
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|专题id|int|是|-|-|



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "faceUrl":"https://gsy-other.oss-cn-beijing.aliyuncs.com/artzhe/image.512x512.png"//头像
    
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}

```


### 2.2 取消喜欢
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V44/Subject/unlike  
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|专题id|int|是|-|-|



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "faceUrl":"https://gsy-other.oss-cn-beijing.aliyuncs.com/artzhe/image.512x512.png"//头像
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```

### 2.3 评论
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V44/Subject/comment
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|专题id|int|是||-|
|content|评论内容|string|是||-|

**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "commentInfo": {
            "commentId ": "21",//评论id
             "artist": "1111",//评论者id
            "faceUrl ": "",//头像
            "nickname": "gg",//评论者昵称 
            "time": "2017-11-08 16:40:45",//评论时间
            "content": "tttttt4",//评论内容
        }
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```

### 2.4 评论点赞
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V44/Subject/commentLike
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|commentId|要点赞的评论ID|int|是||-|

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

### 2.5 取消评论点赞
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V44/Subject/commentUnlike
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|commentId|要点赞的评论ID|int|是||-|

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

### 2.6 专题详情（修改）
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V44/Home/getSubjectDetail 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：
> is_like  //1--喜欢  0--不喜欢
> like_total //喜欢总数
> comment_total //评论总数


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
      "sub_images": [//专题内容的图片
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/12/18/1de8e8e55af752e1b90498994a2d8eb3.png",
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/12/18/e6249ce50b27c0c19815c9b6da7e8c6b.png",
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/09/12/18/0f929391af1179ed6c93d4c4bc9005ad.png",
            ],
      "html5_description": ""https://test-m.artzhe.com/subject/content/6", //H5链接
       "is_like": 1,//1--喜欢  0--不喜欢
        "like_total": "1",//喜欢总数
        "comment_total": "0",//评论总数
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

### 2.7 获取专题评论列表
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V44/subject/getCommentList 
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|专题ID|int|是|-|-|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "list": [
                 {
                    "commentId": "10",//评论的ID
                    "artist": "21",//用户ID
                    "faceUrl": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1489746629334636",
                    "nickname": "李坤",
                    "time": "1分钟前",
                    "content": "wwwwwww",//内容
                    "gender": "2",//性别 1--男 2--女 3--未知
                    "isLike" : "Y",//Y|N
                    "likes" : "Y",//喜欢人数
                },
            ],
            "page": 1,
            "total": "4",
            "pagesize": 20,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}


```

### 2.8 获取用户发表的艺术号文章
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V44/Article/getUserArticleByUid
> 需要token：是(GET方式传token)


**修改说明**
> 添加请求参数：
> type  //类型  取值：self--用户自己看的；不传则是艺术号列表中公开的用户的文章列表




**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|user_id|用户ID|int|是|-|-|
|type|类型|string|否|取值：self--用户自己看的|-|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "articles": [
                {
                    "id": "271",
                    "title": "444444",
                    "excerpt": "淡淡的",
                    "like_count": "0",
                    "is_like": 0,
                    "views": "55",
                    "cover": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/112/534/files/iosappSTS/2018/1/487921.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",
                    "video": 0,
                    "user": {
                        "id": "111295",
                        "nickname": "lilygg",
                        "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                        "is_artist": 0,
                        "is_agency": 0,
                        "AgencyType": 0,
                        "is_planner": 0
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


## 3 H5
### 3.1 专题详情（修改）
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V44/MobileGetH5/getSubjectContent 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：
> is_like  //1--喜欢  0--不喜欢
> like_total //喜欢总数
> comment_total //评论总数
> like_list //喜欢人头像列表
> comment_list //评论列表


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|subid|专题ID|int|是|-|-|


**响应结果示例**
```
{
  "data": {
    "status": 1000,
    "info": {
      "id": "1", //专题ID
      "sub_name": "微距摄影", //专题名称
      "sub_title": "微距专场", //专题标题
       "description": "创作类型以油画、插画为主目前致力于互联网艺术的发展探索，是一位热爱手绘艺术的互联网人",
      "cover": "专题封面",
      "is_like": 1,//1--喜欢  0--不喜欢
        "like_total": "1",//喜欢总数
        "comment_total": "0",//评论总数
      "like_list": [//喜欢人头像列表
                "https://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/08/30/1504077186934.png?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10"
            ],
       "comment_list": [//评论列表
            {
                "commentId ": "21",//评论id
                "artist": "1111",//评论者id
                "faceUrl ": "",//头像
                "nickname": "gg",//评论者昵称 
                "time": "2017-11-08 16:40:45",//评论时间
                "content": "tttttt4",//评论内容
                "gender": "2",//性别 1--男 2--女 3--未知
                "isLike": "N", //是否点赞 Y--点赞  N--没有点赞
                "likes": "0"//评论喜欢人数
            },
        ],
    }
  },
  "code": 30000,
  "message": "success",
  "debug": false
}

```




