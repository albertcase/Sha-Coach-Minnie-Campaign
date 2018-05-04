<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="viewport"   content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Coach蔻驰</title>
</head>
<link href = "/web/build/css/style.css" rel="stylesheet" type="text/css">
<!-- 引入适配方案-->
<script src="/web/lib/lib-flexible/flexible.js"></script>
<body>

<!--http://fakeimg.pl/30x40-->
<section data-page="index">
    <?php if($isAplly == 1) { ?>
        <div class="applyStatus">您已成功预约!</div>
    <?php }?>
    

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
        
        <div class="form-table" id="form-1">
            <ul>
                 <li>
                     <input type="text" name="name" class="form-name" placeholder="姓名 / NAME">
                 </li>
                 <li>
                     <input type="tel" maxlength="11" name="tel" class="form-tel" placeholder="手机 / MOBIlE PHONE">
                 </li>
                 <li class="selectArr">
                     <select name="shop" class="select-shop">
                         <!-- <option>店铺 / SHOP</option>
                         <option>上海</option>
                         <option>北京</option>
                         <option>深圳</option> -->
                     </select>
                     <input type="text" name="shop" class="form-shop" placeholder="店铺 / SHOP">
                 </li>
                 <li class="selectArr">
                    <select name="date" class="select-date" disabled>
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
            
            <?php if($isAplly == 1) { ?>
                <a href="javascript:void(0);" class="btn disabled" id="reserve-btn">
                     一键预约 <span class="countdown"></span>
                </a>
             <?php } else {?>
                <a href="javascript:void(0);" class="btn disabled" id="reserve-btn">
                     一键预约 <span class="countdown"></span>
                </a>
             <?php }?>
        </div>


    </div>

</section>

<script type="text/javascript">

    var queryData = <?php echo json_encode($quota);?>;
    var isAplly = <?php echo json_encode($isAplly);?>;
    var int, count = 10, countdownEl = document.querySelector('.countdown'), subdate;

    if(isAplly){
        formErrorTips('您已预约!');
    }


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
        var reg = /^1\d{10}$/;
        var formVal = {
            name: ele.querySelector('.form-name').value,
            tel: ele.querySelector('.form-tel').value,
            shop: ele.querySelector('.form-shop').value,
            date: ele.querySelector('.select-date').value
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
            subdate = { qid: formVal.date, name: formVal.name, phone: formVal.tel };
            ajax('POST', '/api/submit', subdate);
        }
    }

    var reserveBtn = document.getElementById('reserve-btn');
    reserveBtn.addEventListener("click", function(){
        if(this.className.indexOf('disabled') < 0){
            CheckForm();
        }
    }, false);




    var cdStatus = 0;
    function countdown(){
        cdStatus = 1;
        count--;
        if(count === 0 || count < 0){
            clearInterval(int);
            int = null;
            document.getElementById('reserve-btn').className = 'btn';
            countdownEl.innerHTML = "";
            cdStatus = 0;
        }else{
            countdownEl.innerHTML = "(" + count + "s)";
        }
    }


    



    function DataBox(){
        this.getShop = function(){
            var shopHTML = ['<option>店铺 / SHOP</option>'], selectShop = document.querySelector('.select-shop');
            for(var i = 0; i < queryData.length; i++){
                shopHTML.push('<option>'+ queryData[i].shop +'</option>');
            }
            selectShop.innerHTML = shopHTML.join('');
        }

        this.getDate = function(val){

            var dateHTML = ['<option>日期 / DATE</option>'], selectDate = document.querySelector('.select-date');
            for(var b = 0; b < queryData.length; b++){
                var timeArr = queryData[b].date;
                if(queryData[b].shop == val){
                    for(var a = 0; a < timeArr.length; a++){
                        if(timeArr[a].has_quota){
                            dateHTML.push('<option value="'+ timeArr[a].id +'">'+ timeArr[a].name +'</option>');
                        }  
                    }
                    selectDate.innerHTML = dateHTML.join('');
                };
            }


            
            
        }
    }


    var databox = new DataBox()
    databox.getShop();



    var selectShop = document.querySelector('.select-shop');
    selectShop.addEventListener('change', function(){
        document.querySelector('.form-shop').value = selectShop.value;
        if(selectShop.value && selectShop.value != "店铺 / SHOP"){
            document.querySelector('.select-date').removeAttribute('disabled');
            databox.getDate(selectShop.value);
        }else{
            document.querySelector('.select-date').innerHTML = "";
            document.querySelector('.form-date').value = "";
            document.querySelector('.form-shop').value = "";
        }
        // console.log(data.value);
    })

    var selectData = document.querySelector('.select-date');
    selectData.addEventListener('change', function(){
        var index = selectData.selectedIndex;
        var selectValue = selectData.options[index].value;
        var selectText = selectData.options[index].text;

    
        if(selectText == "日期 / DATE"){
            document.querySelector('.form-date').value = "";
        }else{
            document.querySelector('.form-date').value = selectText;
        }
        
        // console.log(selectText ,selectValue);
    })



    function ajax(method, url, data) {
        var request = new XMLHttpRequest();
        var data = JSON.stringify(data);
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    var result = JSON.parse(request.responseText);
                    formErrorTips(result.msg);
                    window.location.reload()
                } else {
                    formErrorTips(request.status);
                }
            }
        };
        request.open(method, url);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
        request.send(data);
    }
    








    // 失去焦点时检测
    var ele = document, formVal;
    var reg = /^1\d{10}$/;
    function check(){
        
        formVal = {
            name: ele.querySelector('.form-name').value,
            tel: ele.querySelector('.form-tel').value,
            shop: ele.querySelector('.form-shop').value,
            date: ele.querySelector('.form-date').value
        }

        if(!formVal.name || !formVal.tel || !formVal.shop || !formVal.date){
            if(reserveBtn.className.indexOf('disabled') < 0){
                reserveBtn.className = 'btn disabled';
            }
            cdStatus = 0;
        }else{
            // console.log(formVal);
            // console.log('!');
            if(reserveBtn.className.indexOf('disabled') > 0){
                count = 10;
                countdownEl.innerHTML = "("+ count +"s)";
                int = self.setInterval("countdown()",1000);
            }
            
        }
    }





    document.querySelector('.form-name').addEventListener('blur', function(){
        if(cdStatus) return false;
        clearInterval(int);
        int = null;
        check(); 
    })

    document.querySelector('.form-tel').addEventListener('blur', function(){
        if(cdStatus) return false;
        clearInterval(int);
        int = null;
        check();
    })

    document.querySelector('.select-shop').addEventListener('blur', function(){
        if(cdStatus) return false;
        clearInterval(int);
        int = null;
        check();
    })

    document.querySelector('.select-date').addEventListener('blur', function(){
        if(cdStatus) return false;
        clearInterval(int);
        int = null;
        check();
    })








    // 活动规则
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