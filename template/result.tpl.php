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
<!-- 引入适配方案-->
<script src="/web/lib/lib-flexible/flexible.js"></script>
<script type="text/javascript" src="http://coach.samesamechina.com/api/v1/js/2f515ea7-bbbb-45a5-aed2-4988576b856d/wechat"></script>
<body>
<!--http://fakeimg.pl/30x40-->
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
                    <?php print $item->date;?>，<?php print $item->shop;?>店铺期待您的莅临！
                </div>
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
<script type="text/javascript">
    wx.ready(function(){
        /* ----------- 禁用分享 开始 ----------- */
        wx.hideMenuItems({
          menuList: [
            'menuItem:share:appMessage', // 分享到朋友
            'menuItem:share:timeline', // 分享到朋友圈
            'menuItem:copyUrl' // 复制链接
          ],
          success: function (res) {
            // alert('已隐藏“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
          },
          fail: function (res) {
              //alert(JSON.stringify(res));
          }
        });
    });
</script>
</body>
</html>