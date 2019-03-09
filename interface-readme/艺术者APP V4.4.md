[toc]
# 艺术者APP V4.4
## 1 app
### 1.1 添加新画作（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/addArtworkInfo
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：series_id  //画作系列id

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
|series_id|画作系列id|int|否|-|默认是0-不是系列画作|


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

### 1.2  添加画作属性（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/addArtworkAttribute
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：series_id 画作系列id

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
|series_id|画作系列id|int|否|-|-|


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

### 1.3  获取画作属性（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/Artwork/getAttributePercent
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：series_id 画作系列id
> 添加返回参数：series_name 画作系列名称

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
        "is_finished": "N",//是否完成
        "series_id": "2",//画作系列id
        "series_name": "ff"//画作系列名称
    },
    "percent": 73 //百分比
  },
  "code": 30000,
  "message": "success",
  "debug": false
}
```

### 1.4  添加画作系列
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/addArtworkSeries
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_name|画作系列名称|string|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "series_id": "1",//系列id
        "series_name": "紧紧"//系列
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.5  获取艺术家的画作系列
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/getArtworkSeries
> 需要token：是(GET方式传token)



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "1",//系列id
                "name": "紧紧"//系列名称
            }
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.6  获取画作系列中艺术家最近添加的画作的画作属性
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/V44/Artwork/getSeriesAttribute
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_id|系列id|int|是|-|-|

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
        "is_finished": "N",//是否完成
        "series_id": "2"//画作系列id
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 1.7  获取艺术家画廊作品列表
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V44/Gallery/getArtworkDetailList 
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：
    series_id ：画作系列id，如果画作不是序列作品则值为0
    series_name ：画作系列名称，如果画作不是序列作品则值为""

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|artistId|艺术家ID|int|是|-|-|
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
                    "id": "298",//作品编号
                    "name": "黑熊与野兔",//作品名称
                    "updatetimes": "1",//更新次数
                    "shape": "1",//形状1方形2圆形
                    "length": "0",//长
                    "width": "0",//宽
                    "diameter": "0",//直径
                    "story": "喜欢从中找到自己并且表达出来",//作品故事
                    "last_update_time": "2017-08-11 17:10",//最后更新时间
                    "isfinished": "N",
                    "liketotal": "25",//喜欢人数
                    "viewtotal": "39",//浏览人数
                    "category_name": "",//作品类型
                    "coverUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1502442634243311.jpg",//作品封面
                    "is_like": "N",//是否喜欢
                    "series_id": "1",//系列id
                    "series_name": "紧紧"//系列名称
                },
            ],
            "page": 1,
            "total": "3",
            "pagesize": 10,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 1.8  获取作品集（修改）
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/V44/home/getArtList 
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：series_id ：画作系列id
   

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|category|作品种类|int|否|-|-|
|series_id|系列id|int|否|-|-|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```javascript
{
  "data": {
    "status": 1000,
    "info": {
      "flag": 3,//0--表示所有作品集   1--表示分类下作品集 2--表示猜你喜欢数据  3--系列作品
      "data": [
        {
          "id": "37", //作品ID
          "imgname": "lala", //作品名称
          "imgurl": "作品URL",
          "width": 500, //作品宽度
          "height": 274 //作品高度
        },
      ],
      "page": "1",
      "total": "3",
      "pagesize": 5,
      "maxpage": 1
    }
  },
  "code": 30000,
  "message": "success",
  "debug": false
}

```



## 2 pc
### 2.1 添加新画作（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/addArtworkInfo
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：series_id  //画作系列id

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
|series_id|画作系列id|int|否|-|默认是0-不是系列画作|


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

### 2.2  添加画作属性（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/addArtworkAttribute
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：series_id 画作系列id

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
|series_id|画作系列id|int|否|-|-|


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

### 2.3  获取画作属性（修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/getAttributePercent
> 需要token：是(GET方式传token)

**修改说明**
> 添加返回参数：series_id 画作系列id
> 添加返回参数：series_name 画作系列名称

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
        "is_finished": "N",//是否完成
        "series_id": "2",//画作系列id
        "series_name": "紧紧3"//画作系列名称
    },
    "percent": 73 //百分比
  },
  "code": 30000,
  "message": "success",
  "debug": false
}
```

### 2.4  添加画作系列
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/addArtworkSeries
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_name|画作系列名称|string|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "series_id": "1",//系列id
        "series_name": "紧紧"//系列
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.5  修改画作系列
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/editArtworkSeries
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_id|画作系列id|int|是|-|-|
|series_name|画作系列名称|string|是|-|-|


**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "series_id": "1",//系列id
        "series_name": "紧紧"//系列
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.6  获取艺术家的画作系列（全部）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/getArtworkSeries
> 需要token：是(GET方式传token)



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "info": [
            {
                "id": "1",//系列id
                "name": "紧紧"//系列名称
            }
        ]
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.7  获取艺术家的画作系列（分页）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/getArtworkSeriesPage
> 需要token：是(GET方式传token)



**响应结果示例**
```javascript
    "data": {
        "status": 1000,
        "info": {
            "list": [
                {
                    "id": "1",//系列id
                    "name": "紧紧3",//系列名称
                    "create_time": "2018-08-10",//创建时间
                    "cover"://封面图 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/iosapp1503916322985599.jpg"
                }
            ],
            "page": 1,
            "total": "1",
            "pagesize": 10,
            "maxpage": 1
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.8  获取画作系列中艺术家最近添加的画作的画作属性
> 请求方法：POST
> 需要登录：是
> 请求地址：https://test-api.artzhe.com/mp/Artwork/getSeriesAttribute
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_id|系列id|int|是|-|-|

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
        "is_finished": "N",//是否完成
        "series_id": "2"//画作系列id
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

### 2.9  获取我的所有作品（修改）
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/mp/artwork/getMyUpdateArtworkList
> 需要token：是(GET方式传token)

**修改说明**
> 添加请求参数：series_id ：画作系列id
   

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_id|系列id|int|否|-|-|
|page|当前页|int|否|-|-|
|pagesize|每页记录数|int|否|-|-|


**响应结果示例**
```javascript
{
  "data": {
    "status": 1000 
    "info":[
       {
        "artistId": "51", //艺术品ID
        "coverUrl": "http://gsy-other.oss-cn-beijing.aliyuncs.com/test.jpg", //封面
        "name": "风景", //艺术品名称
        "updateId": "66", //更新ID
        "state": "1", //状态 1.所有人可见 2.仅自己可见
        "story": "dfhfhggfjghjhbnmmgwegdfhfghgfhfhss", //作品故事
        "updateTimes": "1", //更新次数
        "isEdit": "Y", //是否可编辑
        "is_finished": "Y", //是否已完成
        "last_update_time": "2017-05-31 10:59", //最后更新时间
        "finish_percent": 50//属性百分比
      }
    ]
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}
```

### 2.10  删除画作系列中的画作
> 请求方法：POST
> 需要登录：否
> 请求地址：http://test-api.artzhe.com/mp/artwork/delSeriesArtwork
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|series_id|系列id|int|是|-|-|
|artwork_id|画作id|int|是|-|-|



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "artworkId": 38
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

