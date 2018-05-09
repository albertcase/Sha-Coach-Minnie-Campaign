var checkinBtn = document.querySelector('.checkinBtn');
checkinBtn.addEventListener("click", function(){
    var checkInCode = document.querySelector('.checkInCode').value;

    if(!checkInCode || checkInCode.length < 3){
      formErrorTips('打卡码有误或不存在！');
    }else{
      submitForm({ code: checkInCode });
    }
    
}, false);


function submitForm(data){
    ajax('POST', '/api/checkin', data, function(result){
        formErrorTips(result.msg);
        window.location.reload();
    });
}
