[toc]
# 艺术者APP V4.3
## 1 申请封面
### 1.1 获取申请封面的状态
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V43/Extension/getApplyStatus 
> 需要token：是(GET方式传token)

**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
        //0、未申请 1、审核中，2、审核失败，3、审核成功，4、用户终止推广，5、下线（过期或其他原因）
            "status": 0,
            "remaining_day": 0,//剩余天数
            "reason": ""//审核失败原因
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 1.2 提交封面申请
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V43/Extension/apply 
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|desc|艺术家名言|string|是|-|-|
|img|封面图片|string|是|-|-|


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



##2 艺术号
### 2.1 获取艺术号显示栏目

> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V43/Article/getColumn 
> 需要token：是(GET方式传token)


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info":  [//栏目信息
            {
                "id": "1",//栏目id
                "name": "推荐作品",//栏目名称
                "tags_id": "1，4",//栏目显示的标签 英文逗号隔开,用于获取该栏目的列表数据
                "sort": "1",//栏目序号,数字小的在前面
            },
        ],
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 2.2 获取艺术号栏目列表
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V43/Article/getlist 
> 需要token：是(GET方式传token)



**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|page|	当前页|	int|	否|	-|	没有提交，返回的是最近10条数据|
|pagesize|	每页记录数|	int|否|	-|	-|
|tags_id|	栏目显示的标签|	string|否|	1,2|-|


**响应结果示例**
```
  {
    "data": {
        "status": 1000,
        "info": {
            "articles": [
                {
                    "id": "113",//文章id
                    "title": "艺学 | 齐白石《放牛图》，真的把牛给“放”了",//标题
                    "excerpt": "齐白石《放牛图》",//文章描述
                    "like_count": "0",//喜欢数
                    "is_like": 0,//是否喜欢
                     "views": "4",//浏览数量
                    "cover": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017-09-14/f3dr7GJZeF.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",//封面
                    "user": {//用户信息
                        "id": "100001",
                        "nickname": "艺术者媒体号",
                        "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png",
                        "is_artist": 0,//是否艺术家
                        "is_agency": 1,//是否认证机构
                        "AgencyType": 7,//认证机构类型
                        "is_planner": 0//是否策展人
                    }
                },
            ],
            "page": 1,
            "total": "43",
            "pagesize": "10",
            "maxpage": 5
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


## 3 信息统计
### 3.1 统计用户浏览页面信息
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-api.artzhe.com/V43/Statistics/addUserVisit 
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|param|json字符串|string|是|-|事例如下|

```
{
	"recommend":2000,//推荐列表
	"update":2000,//花絮列表
	"artist":2000,//艺术家列表
	"artwork":2000,//作品列表
	"subject":3000,//专题列表
	"artcircle":2000,//艺术圈列表
	"mall":4000,//商城列表
	"app":4000,//app
	"article":1000,//艺术号列表（总）
	"article-1":1000,//艺术号列表（id为1的栏目列表）
	"article-2":1000,//艺术号列表（id为2的栏目列表）
	"article_detail":1000,//艺术号详情
	"update_detail":5000,//花絮详情
	"subject_detail":5000,//专题详情
}
```



**响应结果示例**
```
{
    "data": {
        "status": 1000
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```




# 艺术者V4.4
## 1 创作中心
### 1.1 修改作品状态
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/changeState
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkId|艺术品ID|int|是|-|-|
|state|作品状态|int|是|1|取值：1-所有人可见  2-仅自己可见|


**响应结果示例**
```
{
    "data": {
        "status": 1000
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 2.2  添加新画作（包括画作属性）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/addArtworkInfo
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkName|艺术品名称|string|否|-|-|
|state|作品权限|int|否|-|1.所有人可见 2.仅自己可见|
|color|色调|string|是|-|1,2,3|
|shape|形状|int|是|-|1.方形 2.圆形|
|length|长|int|否|-|-|
|width|宽|int|否|-|-|
|diameter|直径|int|否|-|-|
|panorama|全景图|string|是|-|-|
|topography|局部图|string|是|-|-|
|category|类别|string|否|-|油画,风景|
|subject|题材|string|否|-|自然,素描|
|style|风格|string|否|-|自然,素描|
|story|创作描述|string|是|-|-|
|cover|封面图|string|是|-|-|
|artworkDate|创作年份（日期），|string|否|2017|-|


**响应结果示例**
```javascript
{
  "data": {
    "status": 1000,
    "percent": 73, //百分比
    "id": 73, //画作id
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

## 2 app
### 2.1 添加新画作（包括画作属性）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V43/Artwork/addArtworkInfo
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkName|艺术品名称|string|是|-|-|
|state|作品权限|int|否|-|1.所有人可见 2.仅自己可见，默认1|
|color|色调|string|否|-|1,2,3|
|shape|形状|int|否|-|1.方形 2.圆形|
|length|长|int|否|-|-|
|width|宽|int|否|-|-|
|diameter|直径|int|否|-|-|
|panorama|全景图|string|否|-|-|
|topography|局部图|string|否|-|-|
|category|类别|string|否|-|油画,风景|
|subject|题材|string|否|-|自然,素描|
|style|风格|string|否|-|自然,素描|
|story|创作描述|string|否|-|-|
|cover|封面图|string|否|-|-|
|artworkDate|创作年份（日期），|string|否|2017|-|


**响应结果示例**
```javascript
{
  "data": {
    "status": 1000,
    "percent": 73, //百分比
    "id": 73, //画作id
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

### 2.2 专题详情（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V43/Home/getSubjectDetail 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：sub_images  //专题内容的图片


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