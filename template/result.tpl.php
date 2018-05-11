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

            <div class="reserve-success">
                <?php if($status == 200): ?>
                    <div class="success-theme">
                        预约成功
                    </div>
                    <div class="success-text">
                        亲爱的<?php print $item->name;?> <br />
                        <?php print $item->date;?><br /><?php print $item->shop;?>店铺期待您的莅临！
                    </div>
                    
                    <div class="codeConfirm">
                      <input type="tel" maxlength="3" class="checkInCode">
                      <a href="javascript:void(0);" class="checkinBtn">打卡</a>
                    </div>

                    <script src="/web/build/js/common.js"></script>
                    <script src="/web/build/js/checkin.js"></script>

                <?php endif;?>
                
                

                <?php if($status == 0): ?>
                    <div class="success-text"> 您还未预约当前！<!-- 预约活动已结束！ --></div>
                <?php endif;?>
                <?php if($status == 1): ?>
                    <div class="success-text"> 您已经核销！<!-- 预约活动已结束！ --></div>
                <?php endif;?>
                
            </div>
            
        </div>

    </section>
</div>
<script src="/web/build/js/common.js"></script>
</body>
</html>