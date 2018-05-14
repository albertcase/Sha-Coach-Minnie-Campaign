<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="x5-orientation" content="portrait">
    <meta name="screen-orientation" content="portrait">
    <meta name="viewport"   content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Coach X Disney 限时嘉年华</title>
</head>

<link href = "http://cdn.minnie.coach.samesamechina.com/web/build/css/style.css" rel="stylesheet" type="text/css">
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?af79bb9343e57f0fd2c393165d9cbbd4";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

<!-- 引入适配方案-->
<script src="http://cdn.minnie.coach.samesamechina.com/web/lib/lib-flexible/flexible.js"></script>
<script type="text/javascript" src="http://coach.samesamechina.com/api/v1/js/2f515ea7-bbbb-45a5-aed2-4988576b856d/wechat"></script>

<body>
<div id="wrapper">
    
    <!-- 横屏代码 -->
    <div id="orientLayer" class="mod-orient-layer">
        <div class="mod-orient-layer__content">
            <i class="icon mod-orient-layer__icon-orient"></i>
            <div class="mod-orient-layer__desc">为了更好的体验，请使用竖屏浏览<br><em>建议全程在wifi环境下观看</em></div>
        </div>
    </div>



    <section data-page="index">


        <div class="rule-pup">
            <div class="rule-con">
                <a href="javascript:void(0);" class="close"></a>
                COACH将收集您的个人资料以便管理和提
                升顾客体验，并向您提供有关COACH商
                品和服务的信息、COACH活动邀请、
                COACH（或与合作方协作）于本地或海外
                进行的优惠及市场推广活动信息或进行统
                计和调查活动。COACH为了上述目的可能
                会将您的个人资料透露、发送给于本地或
                海外的关联机构或其他相关机构，或与之
                共享。您可自愿选择是否提供以上个人资
                料。若您需要查看、更改或删除您的个人资料，请联系<a href="mailto:contactus@coach.com">contactus@coach.com</a>
            </div>
        </div>

        <div class="logo"></div>

        <div class="form-reserve clearfix">
            <div class="logo-brand"></div>   
            
            <div class="section form-table" id="form">
                <ul>
                     <li>
                         <input type="text" name="name" data-error="姓名选项不能为空!" class="form-check form-blur form-name" placeholder="姓名 / NAME">
                     </li>
                     <li>
                         <input type="tel" maxlength="11" data-error="手机号码输入有误！" name="tel" class="form-check form-blur form-tel" placeholder="手机 / MOBIlE PHONE">
                     </li>
                     <li class="selectArr">
                         <span></span>
                         <select name="shop" class="form-blur select-shop">
                             <!-- <option>店铺 / SHOP</option>
                             <option>上海</option>
                             <option>北京</option>
                             <option>深圳</option> -->
                         </select>
                        <input type="text" name="shop" data-error="请选择您需要预约的店铺！" class="form-check form-shop" placeholder="店铺 / SHOP">
                     </li>
                     <li class="selectArr">
                        <input type="hidden" name="data" data-error="请选择您需要预约的日期！" class="form-check select-date-value">
                        <span></span>
                        <select name="date" class="form-blur select-date" disabled>
                             <option>日期 / DATE</option>
                             <!-- <option>2017</option>
                             <option>2016</option>
                             <option>2015</option> -->
                         </select>
                         <input type="text" name="date" class="form-date" placeholder="日期 / DATE">
                     </li>
                 </ul> 
                 <div class="pact">
                     <a href="javascript:void(0)" class="pact-link"></a>
                 </div>
                
                <a href="javascript:void(0);" class="btn disabled" id="reserve-btn">
                     一键预约 <span class="countdown"></span>
                </a>
            </div>

            <div class="section reserve-success hide" id="result">
                <div class="success-theme">
                            您已成功预约!
                </div>
                 <div class="success-text">
                    ...
                </div>
            </div>


        </div>

    </section>
</div>
<script src="http://cdn.minnie.coach.samesamechina.com/web/build/js/common.js"></script>
<script src="http://cdn.minnie.coach.samesamechina.com/web/build/js/public.js"></script>
<script src="http://cdn.minnie.coach.samesamechina.com/web/build/js/apply.js"></script>

</body>
</html>