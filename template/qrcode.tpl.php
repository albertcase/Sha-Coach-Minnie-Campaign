<?php 
	echo "预约结果页面";
	echo "<pre>";
	var_dump($applys);
?>


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
<body>
<!--http://fakeimg.pl/30x40-->
<section data-page="index">

    <div class="logo"></div>

    <div class="form-reserve clearfix">
        <div class="logo-brand"></div>   


        <div class="reserve-success">
            <div class="success-theme">
                预约成功
            </div>
            <div class="success-text">
                亲爱的XXX <br />
                X月X日XX时，XXX店铺期待您的莅临！
            </div>
        </div>
        
    </div>

</section>

</body>
</html>