<?php 
	echo "已经导入用户的预约页面\n";
	echo "预约状态: {$isAplly}";
	echo "<pre>";
	var_dump($quota);exit;
?>

<?php echo"已经导入用户的预约页面";
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
<link href = "/build/css/style.css" rel="stylesheet" type="text/css">
<!-- 引入适配方案-->
<script src="/lib/lib-flexible/flexible.js"></script>
<body>
<!--http://fakeimg.pl/30x40-->
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
        
        <div class="form-table">
            <ul>
                 <li class="selectArr">
                     <select name="shop" class="select-shop">
                         <option>店铺 / SHOP</option>
                         <option>上海</option>
                         <option>北京</option>
                         <option>深圳</option>
                     </select>
                     <input type="text" name="shop" class="form-shop" placeholder="店铺 / SHOP">
                 </li>
                 <li class="selectArr">
                    <select name="shop" class="select-date">
                         <option>日期 / DATE</option>
                         <option>2017</option>
                         <option>2016</option>
                         <option>2015</option>
                     </select>
                     <input type="text" name="date" class="form-date" placeholder="日期 / DATE">
                 </li>
             </ul> 

             <a href="javascript:void(0);" class="btn" id="reserve-btn">
                 一键预约
             </a>
        </div>



        <!-- <div class="reserve-success">
            <div class="success-theme">
                预约成功
            </div>
            <div class="success-text">
                亲爱的XXX <br />
                X月X日XX时，XXX店铺期待您的莅临！
            </div>
        </div> -->


        <!-- <div class="form-table" id="form-2">
            <ul>
                 <li>
                     <input type="text" class="form-shop" name="shop" placeholder="店铺 / SHOP">
                 </li>
                 <li>
                     <input type="text" class="form-date" name="date" placeholder="日期 / DATE">
                 </li>
             </ul> 

             <a href="javascript:void(0);" class="btn">
                 一键预约
             </a>
        </div> -->
        
    </div>

</section>

<script type="text/javascript">
    var int, count = 10, countdownEl = document.querySelector('.countdown');


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


    function CheckForm(el){
        var ele = document.getElementById(el);
        var reg = /^1\d{10}$/;
        var formVal = {
            name: ele.querySelector('.form-name').value,
            tel: ele.querySelector('.form-tel').value,
            shop: ele.querySelector('.form-shop').value,
            date: ele.querySelector('.form-date').value
        }

        if(!formVal.name){
            formErrorTips('姓名选项不能为空!');
        }else if(!reg.test(formVal.tel)){
            formErrorTips('手机号码输入有误！');
        }else if(!formVal.shop || formVal.shop == '店铺 / SHOP'){
            formErrorTips('请选择您需要预约的店铺！');
        }else if(!formVal.date || formVal.date == '日期 / DATE'){
            formErrorTips('请选择您需要预约的日期！');
        }else{
            // console.log(formVal);
            countdownEl.innerHTML = "(10s)";
            int = self.setInterval("countdown(submitForm)",1000);
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
        // console.log(data.value);
    })


    function countdown(fn){
        count--;
        if(count === 0 || count < 0){
            clearInterval(int);
            int = null;
            
            fn();
        }else{
            countdownEl.innerHTML = "(" + count + "s)";
        }
    }

    function submitForm(){
        countdownEl.innerHTML = "";
        console.log('success!');
    }


    var pactLink = document.querySelector('.pact-link');
    var rulePup = document.querySelector('.rule-pup');
    var close = document.querySelector('.close');

    pactLink.addEventListener('click', function(){
        rulePup.style.visibility = 'visible';
    }, true)
    
    close.addEventListener('click', function(){
        rulePup.style.visibility = 'hidden';
    }, true)





</script>


</body>
</html>