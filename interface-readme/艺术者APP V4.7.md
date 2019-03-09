[toc]
# 艺术者APP V4.7
## 1 消息
### 1.1 获取“我的”首页信息(修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V47/UserCenter/getMyGalleryDetail
> 需要token：是(GET方式传token)


**返回说明**
> 添加返回参数：unreadArtcircleMessageTotal  艺术圈未读消息总数

**响应结果示例**
```javascript
{
  "data": {
    "status": 1000, //正确时只有这一种情况
    "info": {
      "artist": "100", //用户uid
      "mobile": "13632654885", //手机号
      "name": "张三", //名字
      "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test1.png", //头像
      "motto": "个性签名",
      "isArtist": 1, //1表示是艺术家,-1表示非艺术家
      "isSetCover": "Y", //是否设置画廊封面，Y=设置了，N=没设置
      "applyStatus": "2", //艺术家审核状态,0未申请,-1不通过,1审核中,2审核通过
      "applyRemark": "abc", //审核艺术家的备注
      "agencyStatus": "2", //认证机构审核,0未申请,-1不通过,1审核中,2审核通过
      "agencyRemark": "pdfdfg", //审核认证机构备注信息
      "isAgency": 1, //1表示是认证机构,-1表示非认证机构
      "plannerStatus": "0", //策划者审核,0未申请,-1不通过,1审核中,2审核通过
      "plannerRemark": "ghjk", //审核策划者备注
      "isPlanner": -1, //1表示是策划者,-1表示非策划者
      "inviteCode": "a8bdba", //邀请码
      "artTotal": "1", //艺术品总数
      "realtotal": "1", //艺术品真实总数
      "viewTotal": 10, //浏览总数
      "inviteTotal": "0", //邀请成为艺术家的总人数
      "cover": "http://gsy-other.oss-cn-beijing.aliyuncs.com/uploads/2017/05/31/1496199190575.png", //艺术品封面
      "unreadMessageTotal": 1, //未读消息总数
      "unreadLikeMessageTotal": 0, //未读消息总数(喜欢)
      "unreadCommentMessageTotal": 0, //未读消息总数(评论和回复)
      "unreadSystemMessageTotal": 1, //未读消息总数(系统消息)
      "unreadConsultationTotal": 0,//未读消息总数(咨询消息)
      "unreadArtcircleMessageTotal": 0,//未读消息总数(艺术圈消息)
      "likeTotal": "0", //喜欢的艺术品总数
      "followerTotal": "0", //fans总数
      "followTotal": "0" //我关注的艺术家总数
    }
  },
  "code": 30000, //其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```


## 2 搜索
### 2.1 获取搜索页面的热搜关键字和搜索推荐
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

### 2.2 添加搜索关键字
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V47/Search/addSearchKey
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|name|关键字|string|是|-|-|

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

### 2.3 获取搜索结果(艺术家、作品、艺术号)
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V47/Search/getSearchResult
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|name|关键字|string|是|-|-|
|type|类型|string|是|-|all--综合 artist--艺术家  artwork--作品  article--艺术号|
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
                "type": 1,//1--艺术家  2--作品  3--艺术号
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

```


## 3 发现
### 3.1 专题列表（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V47/Home/getSubjectList
> 需要token：是(GET方式传token)


**返回说明**
> 添加q请求参数：type  类型  1--微画展  2--微专访及其他

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|type|类型|int|是|-|1--微画展  2--微专访及其他|
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
                    "type": "1",//专题类型  -1-活动  1-微画展   2-微专访  3-PA画展
                    "id": "1",
                    "subname": "艺术家专访",//专题名称
                    "imgurl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/7c9ce7812e5a2b1ba54453bb5e3b43bb.png",//封面图
                    "html5_description": "https://test-m.artzhe.com/ArtActivity/content/1"//h5链接
                }
            ],
            "page": "1",
            "total": "1",
            "pagesize": 5,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```