# Sha-Coach-Minnie-Campaign`s API

###发布注意
db: db/coach_minnie_campaign.sql
初始化操作：
初始化预约场次：php script/creare_quota.php 

---

**url:** : 
###1. /apply ：预约页面 [1./template/oldApply.tpl/php:已经导入用户的预约页面模版，2.／template/apply.tpl.php: 未导入用户的预约页面]

###2. /qrcode: 预约结果页面（二维码页面）
---

### 获取预约场次API
**url:** /api/quota

**Method:** GET

**param:**

{
	
}

**feedbacks:**

[
    {
        "name": "2018-05-01",
        "num": "20"
    },
    {
        "name": "2018-05-02",
        "num": "10"
    }
]	

---

###预约接口
**url:** /api/submit

**Method:** POST

**param:**

{
	callnumber: '123456'
}

**feedbacks:**

{
	code: '10',
	msg: '注册成功'
}		