var int, count = 10, countdownEl = document.querySelector('.countdown');


queryQuotaData();


// 倒计时
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

                count = 10;
                countdownEl.innerHTML = "("+ count +"s)";
                int = self.setInterval("countdown()",1000);

                // reserveBtn.className = 'btn';
            }
        }
        
    })
}



var reg = /^1\d{10}$/;
reserveBtn.addEventListener("touchstart", function(){

    if(reserveBtn.className.indexOf('disabled') == -1){
        var checkFuc = check();
        if(!reg.test(checkFuc[1])){
            formErrorTips('手机号码输入有误！');
        }else{
            reserveBtn.className = 'btn disabled isloading';
            var subdate = { id: checkFuc[3], name: checkFuc[0], phone: checkFuc[1] };
            // console.log(subdate);
            submitForm(subdate);
        }
    }
    
}, false);


function submitForm(data){
    ajax('POST', '/api/submit', data, function(result){
        formErrorTips(result.msg);
        window.location.reload();
    });
}







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






