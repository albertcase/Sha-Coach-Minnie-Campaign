# Sha-Coach-Minnie-Campaign`s API

###发布注意
db: db/coach_minnie_campaign.sql
初始化操作：
初始化预约场次：php script/creare_quota.php 

---

**url:** : 

###1. /apply ：预约页面 

```
1./template/old_apply.tpl/php:已经导入用户的预约页面模版，
2./template/apply.tpl.php: 未导入用户的预约页面
```
---

```
页面值：
$isAplly [1, 0] 1:已经预约 0:未预约
$quota：场次数组

```

###2. /qrcode: 预约结果页面（二维码页面）

###3. http://127.0.0.1:9222/wechat/coach/callback?openid=123  模拟登陆

###4. /clear: 清除用户缓存

###5. jssdk: http://coach.samesamechina.com/api/v1/js/2f515ea7-bbbb-45a5-aed2-4988576b856d/wechat

---

###预约接口
**url:** /api/submit

**Method:** POST

**param:**

{
    "qid":1,
    "name":"anke",
    "phone":"13112311231"
}

**feedbacks:**

{
    "status: '10',
    "msg": '预约成功'
}  

{
    "status": "101",
    "msg": "API参数不是json格式！"
}      

{
    "status": "102",
    "msg": "预约场次不能为空！"
} 

{
    "status": "103",
    "msg": "您已经预约过！"
} 

{
    "status": "104",
    "msg": "预约名额已经全部预约完！"
} 

{
    "status": "104",
    "msg": "预约失败！"
} 
---

### 获取预约场次API
**url:** /api/quota (暂时未用)

**Method:** GET

**param:**

{
	
}

**feedbacks:**

[
    {
        "id": "1",
        "shop": "店铺1",
        "date": "2018年5月2日14时",
        "num": "10"
    },
    {
        "id": "2",
        "shop": "店铺1",
        "date": "2018年5月2日19时",
        "num": "20"
    },
    {
        "id": "3",
        "shop": "店铺2",
        "date": "2018年5月2日14时",
        "num": "20"
    },
    {
        "id": "4",
        "shop": "店铺2",
        "date": "2018年5月2日19时",
        "num": "20"
    }
]	

--- 