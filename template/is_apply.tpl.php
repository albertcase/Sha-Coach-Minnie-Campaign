<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
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

        <div class="logo"></div>

        <div class="form-reserve clearfix">
            <div class="logo-brand"></div> 
            <div class="reserve-success">
               <div class="success-theme">
                          您已成功预约!
              </div>
            	 <div class="success-text">
                    亲爱的<?php print $data->name;?> <br />
                    <?php print $data->date;?><br /><?php print $data->shop;?>店铺期待您的莅临！
                </div>
            </div>  
    	</div>

    </section>
</div>
<script src="http://cdn.minnie.coach.samesamechina.com/web/build/js/common.js"></script>
</body>
</html>