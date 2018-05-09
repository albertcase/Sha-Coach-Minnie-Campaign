
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

