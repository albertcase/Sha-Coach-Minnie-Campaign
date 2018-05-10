var checkinBtn = document.querySelector('.checkinBtn');
checkinBtn.addEventListener("touchstart", function(){
    var checkInCode = document.querySelector('.checkInCode').value;

    if(!checkInCode || checkInCode.length < 3){
      formErrorTips('打卡码有误或不存在！');
    }else{
      submitForm({ code: checkInCode });
    }
    
}, false);


function submitForm(data){
    ajax('POST', '/api/checkin', data, function(result){
        if(result.status == 200){
            formErrorTips('打卡成功！');
            document.querySelector('.codeConfirm').style.visibility = 'hidden';
        }
        // window.location.reload();
    });
}
