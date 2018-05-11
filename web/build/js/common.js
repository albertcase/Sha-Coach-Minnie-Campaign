var shareData = {
    "_title": 'Coach X Disney 限时嘉年华', //分享标题
    "_desc": "欢乐时光等你来参与",    // 分享朋友圈的描述
    "_desc_friend": "欢乐时光等你来参与",    // 分享好友的描述
    "_link": window.location.origin + '/apply',    //分享的连接
    "_imgUrl": window.location.origin + "/web/build/img/share.jpg",   //分享的图片
    "_shareAppMessageCallback": function(){
        // _hmt.push(['_trackEvent', 'share', 'button', 'onMenuShareAppMessage']);
    },
    "_shareTimelineCallback": function(){
        //_hmt.push(['_trackEvent', 'share', 'button', 'onMenuShareTimeline']);
    }
    //"_url": encodeURIComponent(window.location.href)//encodeURIComponent(window.location.href.split("#")[0]) //.replace('http%3A%2F%2F','')
}

// wx.config({"debug": true}); 
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
    /* ----------- 禁用分享 结束 ----------- */

    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
    wx.onMenuShareAppMessage({
        title: shareData._title,
        desc: shareData._desc_friend,
        link: shareData._link,
        imgUrl: shareData._imgUrl,
        type: '',
        dataUrl: '',
        success: function () {
            shareData._shareAppMessageCallback();
        },
        cancel: function () {

        }
    });
    wx.onMenuShareTimeline({
        title: shareData._desc,
        link: shareData._link,
        imgUrl: shareData._imgUrl,
        success: function () {
            shareData._shareTimelineCallback(); 
        },
        cancel: function () {

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
        alertEvent && alertEvent.remove();
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
 * 微信默认下拉事件禁用
 * https://github.com/sixwinds/blog/issues/17
 */
 
var wrapper = document.getElementById( 'wrapper' );
var touchstartY;

wrapper.addEventListener( 'touchstart', function (ev) {
    var events = ev.touches[ 0 ] || ev;
    touchstartY = events.clientY;
}, false );

wrapper.addEventListener( 'touchmove', function (ev) {
    var events = ev.touches[ 0 ] || ev;
    var scrollTop = wrapper.scrollTop,
        offsetHeight = wrapper.offsetHeight,
        scrollHeight = wrapper.scrollHeight;
    if ( events.clientY > touchstartY && (wrapper.scrollTop === 0) ) {
    // 下拉时并且页面已经到顶部时
      ev.preventDefault();
    } else if ( events.clientY < touchstartY && (scrollTop + offsetHeight >= scrollHeight) ) {
    // 上拉时并且页面已经到底部时
      ev.preventDefault();
    }
}, false );
