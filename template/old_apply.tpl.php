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

    <?php if($isAllowApply) {?> 
        <?php if($isAplly == 1) { ?>
            <div class="applyStatus">您已成功预约!</div>
        <?php }?>
    <?php }else { ?>
        <div class="applyStatus">活动已经结束!</div>
    <?php }?>

    <div class="logo"></div>

    <div class="form-reserve clearfix">
        <div class="logo-brand"></div>   

        <div class="form-table">
            <ul>
                 <li class="selectArr">
                    <span></span>
                    <select name="shop" class="select-shop">
                         <!-- <option>店铺 / SHOP</option>
                         <option>上海</option>
                         <option>北京</option>
                         <option>深圳</option> -->
                    </select>
                    <input type="text" name="shop" class="form-shop" placeholder="店铺 / SHOP">
                 </li>
                 <li class="selectArr">
                    <span></span>
                    <select name="date" class="select-date" disabled>
                         <option>日期 / DATE</option>
                         <!-- <option>2017</option>
                         <option>2016</option>
                         <option>2015</option> -->
                     </select>
                     <input type="text" name="date" class="form-date" placeholder="日期 / DATE">
                 </li>
             </ul> 
    

            <?php if($isAplly == 1) { ?>
                 <a href="javascript:void(0);" class="btn disabled" id="reserve-btn">
                     一键预约
                 </a>
             <?php } else {?>
                <a href="javascript:void(0);" class="btn" id="reserve-btn">
                     一键预约
                 </a>
             <?php }?>
             
        </div>
        
    </div>

</section>

<script type="text/javascript">

    var queryData = <?php echo json_encode($quota);?>;
    var isAplly = <?php echo json_encode($isAplly);?>;

    if(isAplly){
        formErrorTips('您已成功预约!');
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
            date: ele.querySelector('.select-date').value
        }

        if(!formVal.shop || formVal.shop == '店铺 / SHOP'){
            formErrorTips('请选择您需要预约的店铺！');
        }else if(!formVal.date || formVal.date == '日期 / DATE'){
            formErrorTips('请选择您需要预约的日期！');
        }else{
            // console.log(formVal);
            submitForm({ qid: formVal.date });
        }
    }

    var reserveBtn = document.getElementById('reserve-btn');
    reserveBtn.addEventListener("click", function(){
        if(this.className.indexOf('disabled') < 0){
            CheckForm();
        }
    }, false);



    var selectShop = document.querySelector('.select-shop');
    selectShop.addEventListener('change', function(){
        document.querySelector('.form-shop').value = selectShop.value;
        if(selectShop.value && selectShop.value != "店铺 / SHOP"){
            document.querySelector('.select-date').removeAttribute('disabled');
            document.querySelector('.form-date').value = "";
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



    function submitForm(data){
        ajax('POST', '/api/submit', data);
    }





    wx.ready(function(){
        /* ----------- 禁用分享 开始 ----------- */
        wx.hideMenuItems({
          menuList: [
            //'menuItem:share:appMessage', // 分享到朋友
            //'menuItem:share:timeline', // 分享到朋友圈
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