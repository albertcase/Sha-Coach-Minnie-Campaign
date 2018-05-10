
queryQuotaData();



// 表单输入框失去焦点事件监测
var ftli = document.querySelectorAll('.form-blur');
for (var i = 0; i < ftli.length; i++){
    ftli[i].addEventListener('blur', function(evt){
        var checkFuc = check(),
            ci = checkFuc.indexOf('');

        if(ci > -1){
            var errorText = formAllEl[ci].getAttribute('data-error');
            console.log(errorText);

            if(reserveBtn.className.indexOf('disabled') == -1){
                reserveBtn.className = 'btn disabled';
            }
        }else{
            if(reserveBtn.className.indexOf('disabled') > -1){
                reserveBtn.className = 'btn';
            }
        }
        
    })
}



reserveBtn.addEventListener("touchstart", function(){

    if(reserveBtn.className.indexOf('disabled') == -1){
        var checkFuc = check();
        // console.log(checkFuc);
        reserveBtn.className = 'btn disabled isloading';
        submitForm({ id: checkFuc[1] });
    }
    
}, false);


function submitForm(data){
    ajax('POST', '/api/submit', data, function(result){
        formErrorTips(result.msg);
        window.location.reload()
    });
}






