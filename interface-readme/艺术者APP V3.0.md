[toc]
# 艺术者APP V3.0
## 1 艺术圈
### 1.1 获取头部信息

> 请求方法：POST
> 需要登录：否
> 请求地址：http://api.artzhe.com/V30/ArtCircle/getHeader 
> 需要token：是(GET方式传token)


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
    }
  },
  "code": 30000, //其它非30000表示错误的情况
  "message": "success",
  "debug": false
}

```

### 1.2 获取消息列表

> 请求方法：POST
> 需要登录：是
> 请求地址：http://api.artzhe.com/V30/ArtCircle/getMyMessageList
> 需要token：是(GET方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|page  | 页码 | int|是|-||
|pagesize  | 每页获取条数 | int|是|-||


**响应结果示例**
```
{
  "data": {
    "status": 1000 
    "info":[
       {
        "id": "46696",//消息id
        "actionId" : "11"//评论或喜欢的ID
        "isRead":"Y",//Y or N是否已读
        "createTime":"2017.8.12",//消息产生时间
        "type":1,//消息类型:14--用户收到发表艺术圈动态的评论，15--用户收到评论艺术圈动态的回复，16--用户收到发表艺术圈动态的喜欢
        "content":"消息内容",//评论内容
        "userInfo":{//评论或喜欢的人的信息
            "uid":"12232",//用户id
            "name":"老王",//消息发出者
            "gender": "1", //用户性别1男2女3未知
            "faceUrl": "http://artzhe.oss-cn-shenzhen.aliyuncs.com/test1.png", //头像
            "isArtist": 1, //1表示是艺术家,0表示非艺术家
            "isAgency": 1, //1表示是认证机构,0表示非认证机构
            "isPlanner": 0, //1表示是策划者,0表示非策划者
            "agencyType":7,//机构类型
         },
        "dynamic" : {//动态的信息
            "type" : 1,//1纯文字2有图片3链接4视频
            "id" : "111",//动态id
            "content":"", //动态显示内容(type为1--文本前9个，type为2--图片链接，type为3--链接标题前9个，type为4--视频封面图缩略图链接)
             'isShow' => 1,//动态是否正常1-正常，0-删除
            },
        }
    ],
    "page": 1,
    "total": 43,
    "pagesize": 10,
    "maxpage": 5
  },
  "code": 30000,//其它非30000表示错误的情况
  "message": "success",
  "debug": false
}

```

### 1.3 喜欢动态
> 请求方法：POST
> 需要登录：是
> 请求地址：http://api.artzhe.com/V30/ArtCircle/like
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|动态id|int|是|-|-|



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "faceUrl": "http://wx.qlogo.cn/mmopen/dW5CPiaKPfeS3axwc1AUuYFrVLEOproBWHcBwyzicG2PAC935H8hEb23IbricJwHmBia2s8B5EocrXoyJ1ZN5Mu4Zby8vOkCDiazW/0?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",//用户的头像
        "name": "lilygg"//用户昵称
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}

```


### 1.4 取消喜欢动态
> 请求方法：POST
> 需要登录：是
> 请求地址：http://api.artzhe.com/V30/ArtCircle/unlike  
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|动态id|int|是|-|-|



**响应结果示例**
```javascript
{
    "data": {
        "status": 1000,
        "faceUrl": "http://wx.qlogo.cn/mmopen/dW5CPiaKPfeS3axwc1AUuYFrVLEOproBWHcBwyzicG2PAC935H8hEb23IbricJwHmBia2s8B5EocrXoyJ1ZN5Mu4Zby8vOkCDiazW/0?x-oss-process=image/resize,m_fixed,h_180,w_180,P_10",//用户的头像
        "name": "lilygg"//用户昵称
    },
    "code": 30000,//其它非30000表示错误的情况
    "message": "success",
    "debug": false
}
```

### 1.5 评论动态
> 请求方法：POST
> 需要登录：是
> 请求地址：http://api.artzhe.com/V30/ArtCircle/comment
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |:----:|
|id|动态id|int|是||-|
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

### 1.6 回复评论
> 请求方法：POST
> 需要登录：是
> 请求地址：http://www.artzhe.com/Api/ArtCircle/replyComment
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

### 1.7 删除评论
> 请求方法：POST
> 需要登录：是
> 请求地址：http://api.artzhe.com/V30/ArtCircle/deleteComment
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




