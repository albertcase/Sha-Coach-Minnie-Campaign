


/* 
 * 获取api数据
 */
var dataPackage;
function queryQuotaData(){
    ajax('GET', '/api/quota', {}, function(result){
        // for (x in result){
        //     console.log(result[x], x);
        // }
        dataPackage = new DataPackage(result)
        dataPackage.getShop();
    });
}



/* 
 * 店铺和日期选项数据获取,输出
 */

function DataPackage(data){
    this.getShop = function(){
        var shopHTML = ['<option>店铺 / SHOP</option>'], selectShop = document.querySelector('.select-shop');
        for (x in data){
            shopHTML.push('<option>'+ x +'</option>');
        }
        selectShop.innerHTML = shopHTML.join('');
    }

    this.getDate = function(val){
        var dateHTML = ['<option>日期 / DATE</option>'], selectDate = document.querySelector('.select-date');
        // console.log(data);
        for (x in data){
            if(x === val){
                var curAllData = data[x];
                // console.log(data[x]);
                for(var a = 0; a < curAllData.length; a++){
                    //if(curAllData[a].has_quota){
                        dateHTML.push('<option '+ (curAllData[a].has_quota ? '' : 'disabled') +' value="'+ curAllData[a].id +'">'+ (curAllData[a].date + ' ' + curAllData[a].time)  +'</option>');
                    //}  
                }
                selectDate.innerHTML = dateHTML.join('');
            }
        }

        // for(var b = 0; b < queryData.length; b++){
        //     var timeArr = queryData[b].date;
        //     if(queryData[b].shop == val){
        //         for(var a = 0; a < timeArr.length; a++){
        //             if(timeArr[a].has_quota){
        //                 dateHTML.push('<option value="'+ timeArr[a].id +'">'+ timeArr[a].name +'</option>');
        //             }  
        //         }
        //         selectDate.innerHTML = dateHTML.join('');
        //     };
        // }     
    }
}







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



// 结果返回显示模版
function submitSuccess(name, date, shop){
    document.getElementById('form').className += ' hide';
    document.getElementById('result').className = 'section reserve-success';

    var successText = '亲爱的'+ name +' <br />'+ date +'<br />'+ shop +'店铺期待您的莅临！';
    document.querySelector('.success-text').innerHTML = successText;
}












