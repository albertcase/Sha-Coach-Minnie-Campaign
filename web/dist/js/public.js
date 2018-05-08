
/* 
 * 微信分享禁用 
 */
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




/* 
 * 状态提示
 */
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



/* 
 * ajax
 */
function ajax(method, url, data, callback) {
    var request = new XMLHttpRequest();
    var data = JSON.stringify(data);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                var result = JSON.parse(request.responseText);
                callback(result);
            } else {
                formErrorTips(request.status);
            }
        }
    };
    request.open(method, url);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    request.send(data);
}




/* 
 * 获取api数据
 */

function queryQuotaData(){
    ajax('GET', '/api/quota', {}, function(result){
        console.log(result);
    });
}

queryQuotaData();



var queryData = {};



/* 
 * 店铺和日期选项数据获取,输出
 */

function DataPackage(){
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


var dataPackage = new DataPackage()
dataPackage.getShop();




var selectShop = document.querySelector('.select-shop');
selectShop.addEventListener('change', function(){
    document.querySelector('.form-shop').value = selectShop.value;
    if(selectShop.value && selectShop.value != "店铺 / SHOP"){
        document.querySelector('.select-date').removeAttribute('disabled');
        dataPackage.getDate(selectShop.value);
    }else{
        document.querySelector('.select-date').innerHTML = "";
        document.querySelector('.form-shop').value = "";
    }

    document.querySelector('.form-date').value = "";
    document.querySelector('.select-date-value').value = "";
})




var selectData = document.querySelector('.select-date');
selectData.addEventListener('change', function(){
    var index = selectData.selectedIndex;
    var selectValue = selectData.options[index].value;
    var selectText = selectData.options[index].text;
    
    if(selectText == "日期 / DATE"){
        document.querySelector('.select-date-value').value = "";
        document.querySelector('.form-date').value = "";
    }else{
        document.querySelector('.select-date-value').value = selectValue;
        document.querySelector('.form-date').value = selectText;
    }
    // console.log(selectText ,selectValue);
})





// 失去焦点时检测
var formVal, formAllEl = document.querySelectorAll('.form-check'), reserveBtn = document.getElementById('reserve-btn');;
function check(){
    var fromData = [];
    for(var i = 0; i < formAllEl.length; i++){
        fromData.push(formAllEl[i].value);
    }
    return fromData;
}






















