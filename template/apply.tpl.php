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

             <a href="javascript:void(0);" class="btn" id="reserve-btn">
                 一键预约 <span class="countdown"></span>
             </a>
        </div>


    </div>

</section>

<script type="text/javascript">
    var queryData = <?php echo json_encode($quota);?>;
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


    function CheckForm(){
        var ele = document;
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
            return { "qid":formVal.date, "name":formVal.name, "phone":formVal.tel };
        }
    }

    var reserveBtn = document.getElementById('reserve-btn');
    reserveBtn.addEventListener("click", function(){
        CheckForm();
    }, false);



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
        ajax('POST', '/api/submit', CheckForm);
        
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




    function DataBox(){
        this.getShop = function(){
            var shopHTML = ['<option>店铺 / SHOP</option>'], selectShop = document.querySelector('.select-shop');
            for(var i = 0; i < queryData.length; i++){
                shopHTML.push('<option>'+ queryData[i].shop +'</option>');
            }
            selectShop.innerHTML = shopHTML.join('');
        }

        this.getDate = function(val){

            var dateHTML = ['日期 / DATE'], selectDate = document.querySelector('.select-date');
            for(var b = 0; b < queryData.length; b++){
                var timeArr = queryData[b].date;
                if(queryData[b].shop == val){
                    for(var a = 0; a < timeArr.length; a++){
                        console.log(timeArr);
                        dateHTML.push('<option value="'+ timeArr[a].id +'">'+ timeArr[a].name +'</option>');
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
        if(selectShop.value && selectShop.value != "<option>店铺 / SHOP</option>"){
            document.querySelector('.select-date').removeAttribute('disabled');
            databox.getDate(selectShop.value);
        }
        // console.log(data.value);
    })

    var selectData = document.querySelector('.select-date');
    selectData.addEventListener('change', function(){
        var index = selectData.selectedIndex;
        var selectValue = selectData.options[index].value;
        var selectText = selectData.options[index].text;
        document.querySelector('.form-date').value = selectText;
        // console.log(selectText ,selectValue);
    })



    function ajax(method, url, data) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    console.log('success!');
                    console.log(request.responseText);
                } else {
                    console.log(request.status);
                }
            }
        };
        request.open(method, url);
        request.send(data);
    }

    



</script>


</body>
</html>