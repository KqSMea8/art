[toc]
# 艺术者APP V3.2
## 1 首页
### 1.1 推荐
#### 1.1.1 获取首页推荐页面信息（总）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/Home/getHomeRecommendation 
> 需要token：是(GET方式传token)

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
            "artists":[
                {
                    "id": "111351",//用户id
                    "name": "吴玥",//用户名称,
                    "gender": "1",//用户性别, 1--男  2--女  3-未知
                    "face": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1505013326183236.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10"//用户头像
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
            ]
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 1.2 花絮
#### 1.2.1 花絮- 获取花絮列表（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/Home/Record 
> 需要token：是(GET方式传token)

**返回数据说明**
> 新增返回字段：title  花絮标题

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|category|	作品种类|	int	|否|-|-|
|page|	当前页|	int|	否|	-|	-|
|pagesize|	每页记录数|	int|	否|	-|	-|

**响应结果示例**
```
{
  "data": {
    "status": 1000,
    "info": {
      "flag": 0, //显示标记 0表示无选择任何分类显示所有创作记数据,1表示选择某分类有数据显示当前分类创作记数据,2表示选择某分类无数据显示猜你喜欢数据
      "data": [
        {
          "title": "《test》花絮",
          "artid": "123", //作品ID
          "artupid": "69",  //作品更新ID
          "artname": "test", //作品名称
          "uname": "AAA", //作者名字
          "faceurl": "作者头像",
          "summary": "sdffhdsfhd", //描述
          "category": "油画", //作品类型
          "imgurl": [ //更新记录里面的图片
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test.jpg",
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test.jpg",
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test.jpg"
          ],
          "video": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/abc.mp4",
          "uptime": "2017-06-02 15:24:15", //最后更新时间
          "like_total"  "11" //喜欢人数
          "istop": "Y" //是否置顶
        },
      ],
      "page": "1", //当前页码
      "total": "21", //总共记录数
      "pagesize": 5, //每页显示几条
      "maxpage": 5 //共几页
    }
  },
  "code": 30000,
  "message": "success",
  "debug": false
}

```

#### 1.2.2 花絮- 获取我的关注花絮列表（修改）

> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Home/myfollow 
> 需要token：是(GET方式传token)

**返回数据说明**
> 新增返回字段：title  花絮标题

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|page|	当前页|	int|	否|	-|	-|
|pagesize|	每页记录数|	int|	否|	-|	

**响应结果示例**
```
{
  "data": {
    "status": 1000,
    "info": {
      "flag": 1, //1表示关注的其他艺术家有创作记录，2表示猜你喜欢创作记录
      "data": [
        {
          "title": "《test》花絮",
          "artid": "101", //作品ID
          "artupid": "60",  //作品更新ID
          "artname": "test", //作品名称
          "uname": "AAA", //作者名字
          "faceurl": "作者头像",
          "summary": "sdffhdsfhd", //描述
          "category": "油画", //作品类型
          "imgurl": [ //更新记录里面的图片
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test.jpg",
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test.jpg",
            "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test.jpg"
          ],
          "uptime": "2017-06-02 15:24:15", //最后更新时间
          "istop": "Y" //是否置顶
        },
      ],
      "page": "1",
      "total": "18",
      "pagesize": 5,
      "maxpage": 4
    }
  },
  "code": 30000,
  "message": "success",
  "debug": false
}

```

#### 1.2.3 获取作品的创作花絮详情（修改）
> 请求方法：POST
> 需要登录：是
> app请求地址：https://dev-api.artzhe.com/V32/Artwork/updateDetailSimple
> apph5请求地址：https://dev-api.artzhe.com/V32/MobileGetH5/ArtworkUpdateDetail
> 需要token：是(GET方式传token)
 
**返回数据说明**
> 新增返回字段：
> 1.title  花絮标题
> 2.artwork_cover 花絮关联作品封面
> 3.相关推荐related 修改name为title花絮标题


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|更新id|int|是|-|-|

**响应结果示例**
```javascript
{
"data": {
"status": 1000,
"info": {
    "id": "14",//更新的ID
    "title": "戏-偶然test",//花絮标题
    "artwork_id": "16",//作品的ID
    "artname": "如果打电话给发个红包发的发共产党和 v 次",//作品名称
    "artwork_cover":"http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-09-06-092730-8s6p7vvy7z.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",//花絮管理作品封面
    "time": "2017-03-17",//更新时间，用户选择的
    "wit": "hfhfhjfjfnfjfjfifirhrjfifnfjrjffngjjfnrhebdbhdhdhdhdhdhhdhduduehrhdudhdhdhhdhdhdhfhhdhdhdbdbdbbdhdhdhfhdhfhhfhfhfhfhfhhfhfjfhrhrhhdhrhfhfhfhfhfhfhhfhfhfhfhfhfhhfjfjjfhfjfjhf",//内容
    "cover": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1489747093534275",//封面
    "tags": ["风景","素描"],
    "commentTotal": "1",//评论总数
    "is_finished": "N",//是否完成
    "is_like": "N",//是否喜欢
    "is_edit": "N",//是否可以修改
    "number": "1",//第几次更新
    "like_total": "0",//喜欢总数
    "view_total": "8",//浏览总数
    "create_time": "2017-03-21"//上传时间
    "orgImages" : [
    "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1490348469526407",
    "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1490348469835405",
    "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1490348469423109"
    ],// 原图的列表
    "commentList": [
        {        
            "commentId": "11",//评论ID
            "artist": "21",//用户ID
            "faceUrl": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1489746629334636",//评论者头像
            "nickname": "李坤",//昵称
            "gender" : "1", //1.男 2.女 3.未知
            "time": "18小时26分钟前",
            "content": "wwwwwww",//内容
            "repayer": "",//回复者的用户ID，没有则没有回复者
            "repayContent": "",
            "repayTime": ""，
            "isLike" : "Y",//Y|N
            "likes" : "Y",//喜欢人数
            }

        ],
        "shareTitle": "偶然test",
        "shareDesc": "gushijianjiehhjjjkbvcxcvvbbhfdfghjvfxfjknbccvbnjbbvvvvbvvvbbvvvvvhhjjjb",
        "shareImg": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/android2017,
        "shareInfo": {
        "cover": "http://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/20/1492671642846.jpeg?x-oss-process=image/crop,w_1080,h_1080,g_center",
        "face": "https://gsy-other.oss-cn-beijing.aliyuncs.com/artzhe/image.512x512.png?x-oss-process=image/resize,m_fixed,h_180,w_180",
        "name": "艺术者",
        "category": "水彩/插画/素描",
        "link": "http://test-m.artzhe.com/artwork/detail/114",
        "motto": "kkdfg" //签名
        },
        "publisher":"艺术者",
        "is_repay" => 'Y',//Y,N
        "publisherInfo": {
            "id" : "11",//作者ID
            "nickname": "艺术者",
            "name": "艺术者",
            "gender" : "1", //性别 1男2女3未知
            "face": "https://gsy-other.oss-cn-beijing.aliyuncs.com/artzhe/image.512x512.png",
            "artTotal": "3",//作品总数
            "faceUrl": "https://gsy-other.oss-cn-beijing.aliyuncs.com/artzhe/image.512x512.png?x-oss-process=image/resize,m_fixed,h_180,w_180",
            "isFollow": "N",//当前用户是否关注
            "follower_total": "1"//粉丝数
            },//作者
        "related": [//相关推荐
            {
            "id": "182",//花絮id
            "cover": "http://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/19/1492572147270.jpeg",//花絮封面
            "summary" : "ghjgj",
            "create_date": "2017-4-19",
            "title":"《戏》花絮"    //花絮标题
            },
            ],
            "likes": [
                "http://wx.qlogo.cn/mmopen/9ueQbEiaO3eoiblC3iaQV4G4P8X8GonVJwkTwSv1zsp1TRjd2nLqx0",
                "http://wx.qlogo.cn/mmopen/9ueQbEiaO3eoiblC3iaQV4G4P8X8GonVJwkTwSv1zsp1TRjd2nLqx0"
            ],//喜欢的人头像
    }
},
"code": 30000,
"message": "success",
"debug": false
}
```

### 1.3 艺术家
#### 1.3.1 获取艺术家-搜索 推荐艺术家和搜索艺术家

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/Home/getSearchArtists 
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|name  | 用户名称 | string|否|-|如果有，则搜索艺术家；没有，则是推荐艺术家|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "100037",//艺术家id
                "gender": "2",//艺术家性别，1--男  2--女  3-未知
                "name": "gordon",//艺术家名称
                "face": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/2017/11/23/15/59d25d3f81def85822a1e2e75db012d1.png?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10"//艺术家头像
            },
        ]，
        "searchResult":0,//是否有搜索结果 0--没有搜索结果  1--有搜索结果
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

## 2 发表
### 2.1 获取艺术家可关联作品列表
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/getRelationArtwoks
> 需要token：是(GET方式传token)


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "405",//作品id
                "name": "别把对自己好的人弄丢了",//作品名称
                "update_times": "1",//花絮条数
                "cover": "beijing.aliyuncs.com/other/artzhe/user/iosapp1491986418657707?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg"//作品封面图
            },
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```
### 2.2  添加创作属性（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/addArtworkAttribute
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：artworkDate 创作年份（日期），string

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkId|艺术品Id|int|是|-|艺术品Id|
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
    "percent": 73 //百分比
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

### 2.3  获取画作属性完整度百分比（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/Artwork/getAttributePercent
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：artworkDate 创作年份，2017

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkId|艺术品Id|int|是|-|艺术品Id|

**响应结果示例**
```javascript
{
  "data": {
    "status": 1000,
    "info": {
        "name": "天空之城", //画作名称
        "state": "1", //状态 1.所有人可见 2.仅自己可见
        "cover": "beijing.aliyuncs.com/other/artzhe/user/iosapp1491986418657707",//封面
        "color_ids": [ //色调
        {
          "id": "5",
          "cn_name": "蓝色"
        },
        {
          "id": "6",
          "cn_name": "紫色"
        }
      ],
        "shape": "1", //形状 1.方形 2.圆形
        "length": "125", //长
        "width": "300", //宽
        "diameter": "0", //直径
        "panorama_ids": [ //全景图
            "http://gsy-other.oss-cn-beijing.aliyuncs.com/1.jpg",
            "http://gsy-other.oss-cn-beijing.aliyuncs.com/2.jpg",
            "http://gsy-other.oss-cn-beijing.aliyuncs.com/3.jpg"
        ],
        "topography_ids": [
            "http://gsy-other.oss-cn-beijing.aliyuncs.com/a.png",
            "http://gsy-other.oss-cn-beijing.aliyuncs.com/b.png",
            "http://gsy-other.oss-cn-beijing.aliyuncs.com/c.png"
        ],
        "category": "", //类别
        "subject": "", //题材
        "style": "", //风格
        "story": "这种毒的隐隐约约yy英国国歌哈哈哈哈哈换"，
        "artwork_date": "2017",//创作年份
        "is_finished": "N"//是否完成
    },
    "percent": 73 //百分比
  },
  "code": 30000,
  "message": "success",
  "debug": false
}
```

### 2.4  获取画作属性百分比(完成状态统计）（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/getAttributeAll
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：artworkDate 1--有  0--没有

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkId|艺术品Id|int|是|-|艺术品Id|

**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "artwork": {
            "percent": 60,
            "color_status": 0,//1--有  0--没有
            "shape_status": 1,
            "size_status": 1,
            "tag_status": 1,
            "story_status": 0,
            "panorama_status": 0,
            "topography_status": 0,
            "cover_status": 1,
            "artwork_date": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.5  临时保存文章（没有关联作品，从“+”进入，有关联作品从“我的-添加花絮”进入）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/addArticleToDraft
> 需要token：是(GET方式传token)

**接口说明**
> 1.临时保存文章（花絮和艺术号），填写标题和内容页面，点击“继续”时保存。
> 2.每个用户（可发表花絮或艺术号的用户）只能保存一条临时草稿。

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|title|文章标题|string|否|-|如果不提交，默认当前日期|
|artworkId|关联作品id|int|否|-|从“我的-添加花絮”进入，点击“继续”时提交花絮作品id|
|wit|文章内容|string|是|-|-|

**响应结果示例**
```javascript
{
  "data": {
    "status": 1000,
    "info":{
        "id":1,//草稿id
        "title":"test",//文章标题
        "wit":"deggrr",//文章内容
        "artwork_id":"",//关联作品id
        "summary":"ddddd",//文章简介
        "video":"",//视频图片
        "image":"",//文章图片
    }
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

### 2.6  保存创作记录到草稿箱（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/addArtworkToDraft
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：title 文章标题

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|drafId|草稿箱Id|int|否|-|新增草稿不需要草稿箱Id|
|artworkId|画作ID|int|否|-|-|
|createDate|创建日期|string|否|-|2017-05-06，不提交，默认是当前年月日|
|wit|创作心路|string|是|-|-|
|cover|封面|string|否|-|-|
|artworkTag|标签|string|否|-|-|
|story|摘要|string|否|-|-|
|title|文章标题|string|否|-|如果不提交，默认当前日期|

**响应结果示例**
```javascript
{
  "data": {
    "status": 1000 
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

### 2.7 获取编辑草稿箱或编辑创作记录（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V2/Artwork/getEditRecordContent
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：title 文章标题

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artworkUpdateId|艺术品更新id|int|否|-|这里是艺术品更新id，而不是艺术品id|
|drafId|草稿箱Id|int|否|-|-|

**data响应参数**
> 响应参数通用部分，请参考**公共参数说明**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:  |
|status|状态值|int|是|1000|不同的status值情形说明请参考**status说明**|

**响应结果示例**
```javascript
{
  "data": {
    "status": 1000
    "info":{
        "id":"18", //flag为1时为草稿箱Id, flag为2时为更新记录ID
        "title": "《宽阔的大海》花絮",//花絮标题
        "artist_id":"100", //创作者ID
        "artwork_name":"宽阔的大海", //画作名称
        "artwork_id":"56", //画作ID
        "number":"3", //更新编号
        "wit":"dfgfgotygdfhk", //创作心路
        "summary":"klsgfdgf", //摘要
        "create_date":"2017-05-09", //创建日期
        "cover":"http://gsywww.oss-cn-shenzhen.aliyuncs.com/test.jpeg", //封面
        "tag":"标签",
        "flag":1  //1.表示草稿箱详情 2.更新记录详情
    }
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```


### 2.8  发布文章（花絮和艺术号）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/publishArticle
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

## 3 艺术圈
### 3.1 发表艺术圈接口（修改）

> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/ArtCircle/add 
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：artworkId 关联作品id


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|address|地址|string|否|-|-|
|content|内容|string|是|-|-|
|images_url|图片|string|否|-|-|
|video_poster|视频封面|string|否|-|-|
|video_url|视频|string|否|-|-|
|share_type|分享类型|string|否|artwork分享画作， artwork_update分享更新， art_article分享艺术号，gallery分享画廊|
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

### 3.2 艺术圈列表（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/ArtCircle/GetList 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数 artworkId 关联作品id
> 添加返回参数 artworkName 关联作品名称

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

### 3.3 个人艺术圈列表（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/ArtCircle/userCirlelist 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数 artworkId 关联作品id
> 添加返回参数 artworkName 关联作品名称

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

### 3.4 艺术圈详情（修改）

> 请求方法：POST
> 需要登录：否
> 请求地址：https://dev-api.artzhe.com/V32/ArtCircle/Detail 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数 artworkId 关联作品id
> 添加返回参数 artworkName 关联作品名称

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
                    "type": 2, //1:文本 2:图片 3:视频 11:分享作品 12:分享创作记录 13:分享艺术号文章 14:分享画廊
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

## 4 画作
### 4.1 画作详情（修改）
> 请求方法：GET
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/Artwork/getArtDetail
> 需要token：是(GET方式传token)

**修改说明**
> 创作花絮列表（updateList）包含花絮（原创作记录）和艺术圈花絮两种类型，
> 根据字段（showType）区分：1--创作花絮（原创作记录）  2--艺术圈花絮

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|艺术品id|int|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": {
            "id": "37",//画作id
            "artist": "100023",//艺术家id
            "name": "轮-抉择一",//画作名称
            "story": "很久不画，因为它找回了过往创作的意义，对我而言，这是重要的代表作。",//故事简介
            "price": "-1",//价格
            "state": "1",//艺术品状态 1-- 正常  2--禁止查看
            "is_finished": "Y",//是否更新完成
            "is_for_sale": "N",//是否可购买
            "is_deleted": "N",//是否删除
            "like_total": "61",//喜欢总数  包括包括花絮的浏览数（包括艺术圈动态）
            "view_total": "1852",//画作浏览总数，包括花絮的浏览数（不包括艺术圈动态）
            "share_total": "0",//分享总数
            "comment_total": 16,//评论总数
            "DraftInfo": {//草稿花絮信息
                "id" =>1,//草稿id
                "create_date" => "2017-05-01",//时间
                "number" => "2"//花絮更新编号
            },
            "coverUrl": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491988580337988?x-oss-process=image/resize,m_fill,h_750,w_750,limit_0,image/format,jpg",//封面
            "coverThumbList": [//作品缩略图（全景图、局部图和封面图）
                "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491988580337988?x-oss-process=image/resize,m_fill,h_750,w_750,limit_0,image/format,jpg",
                "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491989075465224?x-oss-process=image/resize,w_750,limit_0,image/format,jpg",
               
            ],
            "coverList": [//加了水印的作品图片（全景图和局部图）
                "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491988580337988?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA1LzA5LzE0OTQyOTk1OTc4MDE5ODYucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10",
                "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491989075465224?x-oss-process=image/auto-orient,1/watermark,image_dXBsb2Fkcy8yMDE3LzA1LzA5LzE0OTQyOTk1OTc4MDE5ODYucG5nP3gtb3NzLXByb2Nlc3M9aW1hZ2UvcmVzaXplLFBfMTU,t_50,g_se,x_10,y_10",
            ],
            "tags": [//标签
                "观念"
            ],
            "category_name": "100cm×100cm",
            "is_like": "Y",
            "updateList": [//花絮（包括艺术圈花絮）
                {//创作花絮
                    "showType":1//1--创作花絮（原创作记录）  2--艺术圈花絮
                    "id": "63",//创作花絮id
                    "title": "ddee",//花絮标题
                    "summary": "看了很久，最后决定一点一点的，不精致的点上去在那通往另一处的未知处。点的粗糙，我觉得有点任......",
                    //摘要
                    "create_time": "2016年02月28日",//花絮创建时间
                    "video": "",//花絮里面的视频 0--不是视频， 1--是视频
                    "cover":  "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491988391459158?x-oss-process=image/resize,m_fill,h_188,w_188,limit_0,image/format,jpg",//花絮的图片
                },
                {//艺术圈花絮（分享类型不存在关联作品）
                    "showType":2//1--创作花絮（原创作记录）  2--艺术圈花絮
                    "id": 24,
                    "type": 2, //艺术圈动态内容显示类型 1:文本 2:图片 3:视频 
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
                     "create_time": "2016年02月28日",//花絮创建时间
                     "like_count": 3,//喜欢的人数
                     "isLike": "N", //是否已经点赞
                    "comment_count": 55,//评论数
                    "like_nickname": [//点赞人昵称
                        "李坤",
                        "simao"
                    ],
                    "like_face": [],//点赞人头像
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
            "commentFace": [
                "http://wx.qlogo.cn/mmopen/jEzA7MuSbHsiaianR4753xBAB30gCbLnHSGZk8RKmYcXF5cEsWKuy3XXaibanxS2yxJ2BFtnOOTpFe92mLJ6SFPiapF9dBsEkGzy/0?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",
                "http://wx.qlogo.cn/mmopen/KrXjefzSZLNn08urcuWUH29eEqz8LRlDpjKan34mw7OI9tsX4BNS8I327yML2SMgUib0mKKIlzPibRlaWB2KlFGfn0DYmyElea/0?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",
            ],
            "publisher": {//画作艺术家信息
                "id": "100023",
                "nickname": "Punk",
                "name": "Punk",
                "gender": "1",
                "face": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1492160518739919",
                "motto": "这是最好的时代，也是最坏的时代",
                "artTotal": "5",
                "isFollow": "Y",
                "follower_total": "117"
            },
            "is_edit": "Y",
            "ArtCircleSharePic": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491989075465224?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",
            "prints": {//版画信息
                "is_for_sale": 0,
                "sale_url": ""
            },
            "shareTitle": "Punk《轮-抉择一》",
            "shareDesc": "很久不画，因为它找回了过往创作的意义，对我而言，这是重要的代表作。",
            "shareImg": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491989075465224?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",
            "shareLink": "https://dev-m.artzhe.com/artwork/detail/37",
            "shareInfo": {
                "cover": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491989075465224?x-oss-process=image/resize,m_fill,h_750,w_750,limit_0,image/format,jpg",
                "face": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1492160518739919?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                "name": "Punk",
                "motto": "这是最好的时代，也是最坏的时代",
                "category": "水彩/雕塑",
                "link": "https://dev-m.artzhe.com/artwork/detail/37"
            }
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

## 5 画作
### 5.1 艺术号详情（修改）
> 请求方法：GET
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/MobileGetH5/getArticleDetail
> 需要token：是(GET方式传token)

**修改说明**
> 增加返回字段 "tag" 标签
> related增加返回字段 "video" 是否是视频

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|文章id|int|是|-|-|


**响应结果示例**
```javascript
 {
    "data": {
        "status": 1000,
        "info": {
            "is_repay": 1,//1--是本人  0--不是本人
            "title": "test",//标题
            "like_count": "0",//喜欢总数
            "create_time": "2017-12-22",//创建时间
            "views": "4",//浏览数量
            "is_like": 0,//登录用户是否喜欢文章 1--喜欢  0--不喜欢
            "follow_user": 1,//登录用户是否关注  1--关注  0--未关注
            "content": "艺术号tttt，画的都是有关儿时的记忆啊！还觉得挺开心的😊。在家乡，我们叫它笋子虫。夏天....<img src=\"https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/100/076/files/iosappSTS/2017/12/442977.jpg\" id=\"ios_worksJourney_1513698864_0\"><br><img src=\"https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/100/076/files/iosappSTS/2017/12/434925.jpg\" id=\"ios_worksJourney_1513698880_0\">\n<video controls poster=\"https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/100/076/files/iosappSTS/2017/12/442977.jpg\">视频\n</video>",//文章内容
            "tag": [//文章标签
                "风景",
                "油画"
            ],
            "userinfo": {//文章发布者信息
                "id": "100023",
                "nickname": "Punk",
                "faceUrl": "http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1492160518739919?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                "gender": "1",
                "motto": "这是最好的时代，也是最坏的时代",
                "category": "水彩/雕塑",
                "is_artist": 1,
                "is_agency": 0,
                "AgencyType": 0,
                "is_planner": 0
            },
            "like_users": [],//文章喜欢者头像
            "images": [],//文章中的图片
            "video": "",//文章中的视频
            "comments": {//文章评论
                "total": "0",
                "commentlist": []
            },
            "related": [//相关推荐
                {
                    "id": "258",
                    "cover": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/100/076/files/iosappSTS/2017/12/442977.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",
                    "title": "test",
                     "video": 1,//1--是视频  0--不是视频
                    "content": "艺术号tttt，画的都是有关儿时的记忆啊！还觉得挺开心的😊。在家乡，我们叫它笋子虫。夏天......."
                },
                {
                    "id": "257",
                    "cover": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/100/076/files/iosappSTS/2017/12/442977.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",
                    "title": "test",
                    "content": "帮一部小说配插图，画的都是有关儿时的记忆啊！还觉得挺开心的😊。在家乡，我们叫它笋子虫。夏天......"
                }
            ],
            "shareInfo": {//分享信息
                "shareTitle": "test",
                "shareDesc": "艺术号tttt，画的都是有关儿时的记忆啊！还觉得挺开心的😊。在家乡，我们叫它笋子虫。夏天.......",
                "shareImg": "",
                "shareLink": "https://dev-m.artzhe.com/article/detail/259"
            }
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 5.2 艺术号列表（修改）
> 请求方法：GET
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V32/article/getlist
> 需要token：是(GET方式传token)

**修改说明**
> 增加返回字段 "video" 是否是视频

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|page|页码|	int|是|-|-|
|pagesize|每页数量|	int|是|-|-|
	


**响应结果示例**
```javascript
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
                    "cover": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017-09-14/f3dr7GJZeF.jpg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",//封面
                    "video": 1,//1--是视频  0--不是视频
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




	


    




