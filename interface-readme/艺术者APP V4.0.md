[toc]
# 艺术者APP V4.0
## 1 画作
### 1.1 画作详情-咨询
#### 咨询的信息列表（所有咨询信息）

> 请求方法：POST
> 需要登录：是
> 请求地址https://dev-api.artzhe.com/V40/MobileGetH5/getUserConsultation
> 需要token：是(post方式传token)

**说明**
> 1.如果提交参数userTo 则是艺术家回复用户的界面显示信息 
> 2.没有提交参数userTo 则是用户咨询艺术家的界面显示信息


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|h5_token	|token|	string|	是	|验证token|	-|
|artworkId|	画作id	|int|	是|	咨询的画作id|-|
|userTo	|艺术家回复时，咨询用户的id	|int|	否|	-|	如果提交则是艺术家回复用户的界面显示信息 艺术家--100023，|
|page|	当前页|	int|	否|	-|	没有提交，返回的是最近10条数据|
|pagesize|	每页记录数|	int|否|	-|	-|


**响应结果示例**
```
 {
    "data": {
        "status": 1000,
        "artworkInfo": {//画作信息
            "id": "37",//画作id
            "artist": "100023",//艺术家id
            "artistName": "Punk",//艺术家名称
            "artworkName": "《轮-抉择一》",//画作名称
            "cover": "http://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/20/1492660370234.jpeg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",//画作封面图
            "story": ""//画作故事简介
        },
        "consultationInfo": {//咨询信息
            "data": [
                {
                "id": "5",//数据id
                "user_to": "100023",//咨询时艺术家id或艺术家回复时咨询用户id
                "content": "wen23",//咨询或回复内容
                "create_time": "2018-01-15 17:42:31"，//咨询或回复时间
                "userInfo": {//咨询时咨询用户信息或艺术家回复时艺术家信息
                        "id": "111295",//用户id
                        "face"://用户头像 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                        "name": "lilygg"//用户昵称
                    }
            },
            ],
            "page": 0,
            "total": 10,
            "pagesize": 3,
            "maxpage": 4
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

#### 1.1.2 咨询或回复

> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V40/MobileGetH5/consultationAndReply （h5）
            https://dev-api.artzhe.com/V40/Artwork/consultationAndReply （app）
> 需要token：是(h5:post方式传token;app:get方式传taken)

**说明**
> 1.如果提交参数userTo  则是艺术家回复用户
> 2.没有提交参数userTo  则是用户咨询艺术家


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|h5_token|	token|	string	|是|验证token|h5需要传，app不需要|
|artworkId|	画作id|	int	|是|咨询的画作id|-|
|userTo | 艺术家回复时，咨询用户的id | int|否|-|-如果提交则是艺术家回复用户的界面显示信息|
|content|咨询或回复内容|string|	是|	-|	-|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "id": "8",//数据id
            "user_to": "100023",//咨询时艺术家id或艺术家回复时咨询用户id
            "content": "价格打折",//咨询或回复内容
            "create_time": "2018-01-15 17:42:31",//咨询或回复内容
            "topic_id": "37",//画作id
            "userInfo": {//咨询时咨询用户信息或艺术家回复时艺术家信息
                        "id": "111295",//用户id
                        "face"://用户头像 "http://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-30-165736-4m7ey8spvc.jpg?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg",
                        "name": "lilygg"//用户昵称
                    }
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


## 2 我的-消息
### 2.1  获取“我的”首页信息(修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V40/UserCenter/getMyGalleryDetail
> 需要token：是(GET方式传token)

**返回说明**
> 添加返回参数：unreadConsultationTotal

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


### 2.2 咨询消息列表
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V40/userCenter/getMyConsultationList 
> 需要token：是(GET方式传token)

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|page|	当前页|	int|	否|	-|	没有提交，返回的是最近10条数据|
|pagesize|	每页记录数|	int|否|	-|	-|


**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "data": [
                {
                    "id": "47424",//消息id
                    "fromUserInfo": {//发送消息用户信息
                        "fromUserId": "111295",//用户id
                        "isArtist": 0,//1--是艺术家   0--不是艺术家
                        "isAgency": 0,//1--是机构家   0--不是机构
                        "agencyType": 0,//机构类型
                        "isPlanner": 0,//1--是策展人   0--不是策展人
                        "name": "lilygg",//用户名称
                        "faceUrl"://用户头像 "http://wx.qlogo.cn/mmopen/dW5CPiaKPfeS3axwc1AUuYFrVLEOproBWHcBwyzicG2PAC935H8hEb23IbricJwHmBia2s8B5EocrXoyJ1ZN5Mu4Zby8vOkCDiazW/0?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg"
                    },
                    "content": "wen234",//咨询或回复内容
                    "unread": "2",//未读数量
                    "createTime": "2018-01-15 17:42",//创建时间
                    "artworkInfo": {//咨询的画作信息
                        "id": "37",//画作id
                        "artist": "100023",//艺术家id
                        "artistName": "Punk",//艺术家名称
                        "artworkName": "《轮-抉择一》",//画作名称
                        "cover"://画作封面 "beijing.aliyuncs.com/other/artzhe/user/iosapp1491986418657707?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",
                        "story": ""，//故事
                    },
                    "type": "17"，//消息类型  17--用户咨询艺术家(画作)    18--艺术家回复用户咨询
                    "totalMessage": 9，//用户和艺术家对同一件作品咨询和回复的信息总数
                },
            ],
            "page": "2",
            "total": 10,
            "pagesize": "5",
            "maxpage": 2
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

## 3 艺术者和商城交互
### 3.1 艺术品和商品关联（添加和修改）
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/mp/ArtworkGoods/relateGoods 
> 需要token：否

**说明**
> 修改时，不能修改goodsId，artworkId，

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|goodsId|	商品id|	int	|是|对应商城中的商品id|-|
|artworkId|	画作id|	int	|是|咨询的画作id|-|
|goodsType | 商品类型 | int|否|-|-|
|mallName | 商城名称 | string|否|-|-|
|status | 关联状态  1--有效   2--无效 | int|否|-|默认1|



**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "id": "1",
            "artwork_id": "37",//画作id
            "goods_id": "123",//商品id
            "goods_type": "1",//商品类型  原作：1488，版画：1483
            "mall_name": "大创商d",//商城名称
            "status": "0",//关联状态  1--有效   2--无效
            "create_time": "1516257842",//创建时间
            "modify_time": "1516258382"//修改时间
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


### 3.2 获取艺术品列表
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/mp/ArtworkGoods/getArtworkList 
> 需要token：否

**说明**
> 艺术家所有可见，有花絮的艺术品,百分比100%，只关联了版画或没有关联原作和版画的作品

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|artist|	艺术家id|	int	|否|-|-|
|artworkName|	画作名称|	stirng	|否|-|-|
|goods_id|	商品id|	int	|否|-|-|
|page|	当前页|	int|	否|	-|默认1|
|pagesize|	每页记录数|	int|否|	-|默认5条|



**响应结果示例**
```
{
    "data": {
        "status": 1000,
        "info": {
            "list": [
                {
                    "id": "405",//画作id
                    "name": "别把对自己好的人弄丢了",//画作名称
                    "update_times": "1",//花絮次数
                    "finish_percent": "100",//完成百分比
                     "goods_ids": "123,127",
                    "goods_status": 2,//1--关联了原作  2--关联了版画  3--关联了原作和版画  4--没有关联原作和版画
                    "cover": "beijing.aliyuncs.com/other/artzhe/user/iosapp1491986418657707"//画作图片  封面图》全景图》局部图
                }
            ],
            "page": "2",
            "total": "3",
            "pagesize": "2",
            "maxpage": 2
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

### 3.3 商城发送系统消息
> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/mp/ArtworkGoods/sendMessage 
> 需要token：否


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|userId|接收用户id|	int	|否|-|-|
|content|消息内容|	stirng	|否|-|-|




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



## 4 画作
### 4.1 画作详情（修改）
> 请求方法：GET
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V40/Artwork/getArtDetail
> 需要token：是(GET方式传token)

**修改说明**
> 

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
            "hasConsultation": 1,//0--没有咨询过艺术家   1--咨询过艺术家
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
            }，
            "goodsInfo": {//作品的商品信息
                "prints": {//版画
                    "goods_id": "915",//商品id
                    "price": "0.00",//商品价格
                    "ship_price": 10,//运费
                     "framed" :1, // 装裱 1-有 0-无
                    "certificate":0, // 证书 1-有 0-无
                    "link": "http://test-mall.artzhe.com/mobile/index.php?m=goods&id=915"//跳转链接
                    },
                "raw": {//原作
                    "goods_id": "912",
                    "price": "0.00",
                    "ship_price": 10,
                     "framed" :1, // 装裱 1-有 0-无
                     "certificate":0, // 证书 1-有 0-无
                    "link": "http://test-mall.artzhe.com/mobile/index.php?m=goods&id=915"
                    "sold": 1,//1--已售  0--未售
                    "user": {
                        "user_id": "100028",
                        "user_face": "",
                        "user_name": "13544178362"
                    }
                }
            }
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}
```



# 艺术者APP V4.1
## 1 艺术号
### 1.1 艺术号列表

> 请求方法：POST
> 需要登录：是
> 请求地址：https://dev-api.artzhe.com/V41/article/getlist 
> 需要token：是(post方式传token)

**说明**
> 1.添加返回参数views  浏览次数


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|page|	当前页|	int|	否|	-|	没有提交，返回的是最近10条数据|
|pagesize|	每页记录数|	int|否|	-|	-|


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


## 2 艺术圈
### 2.1 获取头部信息修改

> 请求方法：POST
> 需要登录：否
> 请求地址：http://dev-api.artzhe.com/V31/ArtCircle/getHeader 
> 需要token：是(GET方式传token)


**返回数据说明**
| 字段        | 字段描述   |  规格  |数据说明|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  |
|bannerType  | 链接类型 | int|1-外部链接，需要token； 2-外部链接，不需要token； 3-内部链接，画廊详情；  4-内部链接，画作详情； 5-花絮详情； 6-艺术专题详情； 7-艺术号详情|-|
|bannerLink  | 图片链接 | string|外部链接(type取值1，2)--URL; 内部链接（type取值3，4，5，6，7）--对应的id，例如：type是3，link则是画廊id||


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
      "bannerType": "1",// 1-外部链接，需要token  2-外部链接，不需要token  3-内部链接，画廊详情  4-内部链接，画作详情  5-花絮详情  6-艺术专题详情  7-艺术号详情
       "bannerLink": "https://www.baidu.com/index.html",//图片链接,外部链接--URL  内部链接--对应的id
      "unreadMessageTotal": 1, //未读消息总数
      "isShowGallery": 1, //1-可以进入艺术家画廊，0-不可以进入艺术家画廊
    }
  },
  "code": 30000, //其它非30000表示错误的情况
  "message": "success",
  "debug": false
}

```



# 女王节活动
## 1 获取用户所有商品的抵扣金额
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-www.artzhe.com/Activity/Queen/getUserBargains
> 需要token：否(post方式传token)

**提交请求参数格式**
> 3DES-CBC加解密 
> $postStr = des_encode(json_encode(array('goodsId'=>'123'))); 
> post:  'param':$postStr

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|uid|用户id|int|是|-|-|


**响应结果示例**
```
 {
    "data": {
        "status": 1000,
        "info": {
            "uid": 10,//用户id
            "data": [
                {
                    "goods_id": "101010",//商品id
                    "money": "60"//砍价金额
                },
                {
                    "goods_id": "101011",
                    "money": "20"
                }
            ]
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```

## 2 添加售卖记录
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-www.artzhe.com/Activity/Queen/sales
> 需要token：否(post方式传token)

**提交请求参数格式**
> 3DES-CBC加解密 
> $postStr = des_encode(json_encode(array('goodsId'=>'123'))); 
> post:  'param':$postStr

**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|user_id|用户id|int|是|-|-|
|goods_id|商品id|string|是|-|多个商品id,逗号隔开|



**响应结果示例**
```
 {
    "data": {
        "status": 1000,
        "insertId": "1"
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```


## 3 支持好友（抵扣）
> 请求方法：POST
> 需要登录：否
> 请求地址：https://test-www.artzhe.com/Activity/Queen/bargain
> 需要token：否(post方式传token)


**请求参数列表**
| 字段        | 字段描述   |  规格  |必须 |示例|备注|
| --------   | :-----:  | :----:  | :----:  | :----:  | :----:  |
|share_id|分享id|int|是|-|-|
|union_id|支持者微信用户id|string|是|-|-|
|wx_face|支持者微信用户头像|string|是|-|-|
|wx_name|支持者微信用户昵称|string|是|-|-|



**响应结果示例**
```
 {
    "data": {
        "status": 1000,
        "info": {
            "wx_face": "",//支持者微信头像
            "wx_name":"yyy",//支持者微信昵称
            "bargain_value": 10,//抵扣金额
        }
    },
    "code": 30000,
    "message": "success",
    "debug": false
}

```






