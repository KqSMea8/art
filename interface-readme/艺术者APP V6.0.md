[toc]
# 艺术者APP V6.0
## 艺术者
### 名片
#### 设置通讯录
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V60/UserCenter/setMobileList
> 需要token：是(GET方式传token)

**请求参数列表**

| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|mobileList|通讯录内容|string|是|13048825664,13048825665,13048825666|参数是电话号码的列表，中间以逗号隔开|


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


#### 获取通讯录
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V60/UserCenter/getMobileList
> 需要token：是(GET方式传token)

**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "info": {
                "id": "1",
                "link_id": "114518",
                "content": "13048825664,13048825665,13048825666,13048825667,13048825668,13048825669",
                "create_time": "2019-03-05 15:28:40",
                "update_time": "2019-03-05 15:28:40"
            }
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```

#### 增加收藏
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V60/collection/insertCollection
> 需要token：是(GET方式传token)


**请求参数列表**

| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|type|收藏的内容类型|int|是|701|701:文本，702：图片，703：视频，704：文章，705：语音，706：链接，707：作品|
|fromName|来自|str|是|ch||
|content|内容|str|否|this is the way，about the world|文本的时候，必填哦|
|img|图片，视屏，语音等的链接|str|否|https://artzhe.oss-cn-shenzhen.aliyuncs.com/user/114/104/files/2019/01/hjka2mxfi1.jpg?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10|图片，视频，语音的时候必填|
|linkId|艺术者平台的文章|int|是|1607|当是本平台文章或者作品的时候必填|
|url|外部的链接|int|否|http://www.ruanyifeng.com/blog/2011/12/ssh_remote_login.html||
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

#### 删除收藏
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V60/collection/delCollection
> 需要token：是(GET方式传token)

**请求参数列表**

| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|收藏的序列号|int|是|ch||

**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": null
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```


#### 查看收藏
> 请求方法：POST
> 需要登录：是
> 请求地址：http://test-api.artzhe.com/V60/collection/getCollection
> 需要token：是(GET方式传token)

**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "page": 1,
            "pageSize": 15,
            "total": "13",
            "maxPage": 1,
            "arrColl": [
                {
                    "id": "14",
                    "uid": "114518",
                    "type": "706",
                    "from_name": "ch",
                    "create_time": "2019-03-07 16:02:18",
                    "link_id": "0",
                    "img": "",
                    "title": null,
                    "content": "",
                    "url": "www.baidu.com",
                    "is_show": "1"
                },
                {
                    "id": "13",
                    "uid": "114518",
                    "type": "706",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:50:04",
                    "link_id": "0",
                    "img": "",
                    "title": null,
                    "content": "",
                    "url": "www.baidu.com",
                    "is_show": "1"
                },
                {
                    "id": "12",
                    "uid": "114518",
                    "type": "704",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:49:37",
                    "link_id": "111111",
                    "img": "",
                    "title": null,
                    "content": "",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "11",
                    "uid": "114518",
                    "type": "705",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:49:03",
                    "link_id": "0",
                    "img": "sssssssssssssss",
                    "title": null,
                    "content": "",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "10",
                    "uid": "114518",
                    "type": "703",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:48:43",
                    "link_id": "0",
                    "img": "sssssssssssssss",
                    "title": null,
                    "content": "",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "9",
                    "uid": "114518",
                    "type": "701",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:47:47",
                    "link_id": "0",
                    "img": "",
                    "title": null,
                    "content": "hii,how s going？",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "8",
                    "uid": "114518",
                    "type": "702",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:43:50",
                    "link_id": "0",
                    "img": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/other_all/2018/01/31/14/f63ceca68ed5c7deaa623e9db9148f7e.jpg",
                    "title": null,
                    "content": "",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "7",
                    "uid": "114518",
                    "type": "702",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:40:12",
                    "link_id": "0",
                    "img": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/other_all/2018/01/31/14/f63ceca68ed5c7deaa623e9db9148f7e.jpg",
                    "title": null,
                    "content": "",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "6",
                    "uid": "114518",
                    "type": "702",
                    "from_name": "ch",
                    "create_time": "2019-03-07 15:34:29",
                    "link_id": "0",
                    "img": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/other_all/2018/01/31/14/f63ceca68ed5c7deaa623e9db9148f7e.jpg",
                    "title": null,
                    "content": "",
                    "url": "",
                    "is_show": "1"
                },
                {
                    "id": "5",
                    "uid": "114518",
                    "type": "702",
                    "from_name": "ch",
                    "create_time": "2019-03-07 14:27:47",
                    "link_id": null,
                    "img": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/other_all/2018/01/31/14/f63ceca68ed5c7deaa623e9db9148f7e.jpg",
                    "title": null,
                    "content": null,
                    "url": null,
                    "is_show": "1"
                },
                {
                    "id": "4",
                    "uid": "114518",
                    "type": "701",
                    "from_name": "ch",
                    "create_time": "2019-03-07 11:57:27",
                    "link_id": null,
                    "img": null,
                    "title": null,
                    "content": "nihao ",
                    "url": null,
                    "is_show": "1"
                },
                {
                    "id": "2",
                    "uid": "114518",
                    "type": "0",
                    "from_name": "798手绘网",
                    "create_time": "2019-03-07 10:33:08",
                    "link_id": "1766",
                    "img": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/other_all/2018/01/31/14/f63ceca68ed5c7deaa623e9db9148f7e.jpg",
                    "title": "18万只铅笔装修楼梯间，千张明信片铺地板，这群艺术家玩大了",
                    "content": null,
                    "url": null,
                    "is_show": "1"
                },
                {
                    "id": "1",
                    "uid": "114518",
                    "type": "0",
                    "from_name": "",
                    "create_time": "2019-03-07 10:30:57",
                    "link_id": "1766",
                    "img": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/article/other_all/2018/01/31/14/f63ceca68ed5c7deaa623e9db9148f7e.jpg",
                    "title": "18万只铅笔装修楼梯间，千张明信片铺地板，这群艺术家玩大了",
                    "content": null,
                    "url": null,
                    "is_show": "1"
                }
            ]
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```
