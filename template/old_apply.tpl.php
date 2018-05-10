<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <title>Coach蔻驰</title>
</head>
<link href = "/web/build/css/style.css" rel="stylesheet" type="text/css">
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
<script src="/web/lib/lib-flexible/flexible.js"></script>
<script type="text/javascript" src="http://coach.samesamechina.com/api/v1/js/2f515ea7-bbbb-45a5-aed2-4988576b856d/wechat"></script>

<body>
<div id="wrapper">
    <section data-page="index">

        <div class="logo"></div>

        <div class="form-reserve clearfix">
            <div class="logo-brand"></div>   

            <div class="form-table">
                <ul>
                     <li class="selectArr">
                        <span></span>
                        <select name="shop" class="select-shop form-blur">
                             <!-- <option>店铺 / SHOP</option>
                             <option>上海</option>
                             <option>北京</option>
                             <option>深圳</option> -->
                        </select>
                        <input type="text" name="shop" data-error="请选择您需要预约的店铺！" class="form-check form-shop" placeholder="店铺 / SHOP">
                     </li>
                     <li class="selectArr">
                        <span></span>
                        <input type="hidden" name="data" data-error="请选择您需要预约的日期！" class="form-check select-date-value">
                        <select name="date" class="select-date form-blur" disabled>
                             <option>日期 / DATE</option>
                             <!-- <option>2017</option>
                             <option>2016</option>
                             <option>2015</option> -->
                         </select>
                         <input type="text" name="date" class="form-date" placeholder="日期 / DATE">
                     </li>
                 </ul> 
        

                <a href="javascript:void(0);" class="btn disabled" id="reserve-btn">
                     一键预约
                 </a>
                 
            </div>
            
        </div>

    </section>
</div>
<script src="/web/build/js/common.js"></script>
<script src="/web/build/js/public.js"></script>
<script src="/web/build/js/old_apply.js"></script>

</body>
</html>