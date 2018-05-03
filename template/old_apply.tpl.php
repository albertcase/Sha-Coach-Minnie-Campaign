<?php 
	echo "已经导入用户的预约页面\n";
	echo "预约状态: {$isAplly}";
	echo "<pre>";
	var_dump($quota);exit;
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

        <div class="form-table">
            <ul>
                 <li>
                     <input type="text" class="form-shop" name="shop" placeholder="店铺 / SHOP">
                 </li>
                 <li>
                     <input type="text" class="form-date" name="date" placeholder="日期 / DATE">
                 </li>
             </ul> 

             <a href="javascript:void(0);" class="btn reserve-btn">
                 一键预约
             </a>
        </div>
        
    </div>

</section>

<script type="text/javascript">

    function formErrorTips(alertNodeContext){
        var alertInt,
            alertEvent = document.querySelectorAll('.alertNode');
        clearTimeout(alertInt);
        if(alertEvent.length > 0){
            alertEvent.innerHTML = alertNodeContext;
        }else{
            var alertNode = document.createElement("div");
                alertNode.setAttribute("class","alertNode");
                alertNode.innerHTML = alertNodeContext;
                document.body.appendChild(alertNode);
        }
        alertInt = setTimeout(function(){
            alertEvent = document.querySelector('.alertNode');
            alertEvent.remove();
        },1600);
    }


    function CheckForm(){
        var ele = document;
        var formVal = {
            shop: ele.querySelector('.form-shop').value,
            date: ele.querySelector('.form-date').value
        }

        if(!formVal.shop || formVal.shop == '店铺 / SHOP'){
            formErrorTips('请选择您需要预约的店铺！');
        }else if(!formVal.date || formVal.date == '日期 / DATE'){
            formErrorTips('请选择您需要预约的日期！');
        }else{
            // console.log(formVal);
            submitForm();
            return formVal;
        }
    }

    var reserveBtn = document.getElementById('reserve-btn');
    reserveBtn.addEventListener("click", function(){
        CheckForm('form-1');
    }, false);




    var selectShop = document.querySelector('.select-shop');
    selectShop.addEventListener('change', function(){
        document.querySelector('.form-shop').value = selectShop.value;
        // console.log(data.value);
    })

    var selectData = document.querySelector('.select-date');
    selectData.addEventListener('change', function(){
        document.querySelector('.form-date').value = selectData.value;
    })



    function submitForm(){
        console.log('success!');
    }




</script>


</body>
</html>