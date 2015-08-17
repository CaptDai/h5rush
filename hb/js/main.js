$(document).ready(function(){
    var height = $("#bg").height(),
        pho = $("#pho");

    $("#content").css("top",height*0.63);
    $("#pho").css("height",height*0.07);
    $("#btn-submit").css("height",height*0.07);
    $("#btn-submit").css("margin-top",height*0.03);
    $(".rules").css("margin-top",height*0.19);
    var phoRegexp = /^[1-9][0-9]{10}$/,
        submitBtn = $("#btn-submit");

    pho.bind("input propertychange",function(){
        if(!phoRegexp.test(pho.val())){
            !submitBtn.hasClass("btn-disabled")?submitBtn.addClass("btn-disabled"):0;
            submitBtn.attr("disabled",true);
        }
        else{
            submitBtn.removeClass("btn-disabled");
            submitBtn.attr("disabled",false);
        }
    });
});
