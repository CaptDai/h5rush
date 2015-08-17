$(document).ready(function(){
    var ox = 402;
    var oy = 474;
    var sx = 1;
    var sy = 1;
    var xx,yy;
    var dis;
    var sin=0;
    var cos=1;
    var k=cos/sin;
    var canShoot = false;
    var controlBall = $("#control-ball");
    var controlPanel = $("#control-panel");
    var controlBarrel = $("#control-barrel");
    var positionMsg = $("#position-msg");
    var nextBalls = $("#next-balls");

    var colorArr = ["red","green","blue","purple","yellow","gray"];
    var colorNum = colorArr.length;

    var nextSize = 6;
    var nextArr = new Array(nextSize+1);

    var cur=0;
    for(cur=0;cur<nextSize;++cur){
        nextArr[cur] = colorArr[Math.floor(Math.random()*colorNum)];
    }

    cur=0;
    nextBalls.find("li").each(function(){
        $(this).addClass("ball-"+nextArr[cur++]);
    });

    controlBall.addClass("ball-"+nextArr[cur]);

    controlPanel.bind("mousemove",function(e){
        xx = e.offsetX || e.originalEvent.layerX;
        yy = e.offsetY || e.originalEvent.layerY;
        if(yy>430){
            return ;
        }
        var el = e.srcElement || e.target;
        if(el.id=="control-ball") return ;
        dis = Math.sqrt(Math.pow((xx-ox),2)+Math.pow((yy-oy),2));
        var tsin = (xx-ox)/dis;
        var tcos = (oy-yy)/dis;
        sin = tsin;
        cos = tcos;
        k = (oy-yy)/(xx-ox);
        positionMsg.html("x: "+xx+"<br/>y: "+yy+"<br/>dis: "+dis+"<br/>sin: "+sin+"<br/>cos: "+cos+"<br/>target id: "+el.id);
        controlBarrel.css("transform","matrix("+ (sx*cos)+","+sin+","+(sy*(-sin))+","+cos+",0,0)");
    });

    controlBall.bind("mousedown", mouseDown);
    controlBall.bind("mouseup mouseleave", mouseUp);
    controlBall.bind("mouseleave",mouseLeave);
    controlBall.bind("mouseup", shoot);


    $(document).bind("keydown",function(e){
        //alert(e.keyCode);
        if(e.keyCode == 32 ){
            mouseDown();
        }

        if(e.keyCode == 65 ){
            sin = sin - 0.1;
            if(sin<-1){ sin+=0.1;return ;}
            cos = Math.sqrt(1 - Math.pow(sin,2));
            k = cos/sin;
            positionMsg.html("x: "+xx+"<br/>y: "+yy+"<br/>dis: "+dis+"<br/>sin: "+sin+"<br/>cos: "+cos+"<br/>target id: ");
            controlBarrel.css("transform","matrix("+ (sx*cos)+","+sin+","+(sy*(-sin))+","+cos+",0,0)");
        }

        if(e.keyCode == 68 ){
            sin = sin + 0.1;
            if(sin>1){ sin-=0.1;return ;}
            cos = Math.sqrt(1 - Math.pow(sin,2));
            k = cos/sin;
            positionMsg.html("x: "+xx+"<br/>y: "+yy+"<br/>dis: "+dis+"<br/>sin: "+sin+"<br/>cos: "+cos+"<br/>target id: ");
            controlBarrel.css("transform","matrix("+ (sx*cos)+","+sin+","+(sy*(-sin))+","+cos+",0,0)");
        }

    });

    $(document).bind("keyup",function(e){

        if(e.keyCode == 32 ){
            shoot();
            mouseUp();
        }

    });

    controlPanel.bind("mousedown", mouseDown);
    controlPanel.bind("mouseup mouseleave", mouseUp);
    controlPanel.bind("mouseleave",mouseLeave);
    controlPanel.bind("mouseup", shoot);

    function mouseDown(){
        sx = 1.1;
        sy = 0.8;
        canShoot = true;
        controlBall.addClass("ball-hover");
        controlBarrel.css("transition","all .2s linear");
        controlBarrel.css("transform","matrix("+ (sx*cos)+","+sin+","+(sy*(-sin))+","+cos+",0,0)");
    }

    function mouseUp(){
        sx = 1;
        sy = 1;
        controlBall.removeClass("ball-hover");
        controlBarrel.css("transition","none");
        controlBarrel.css("transform","matrix("+ (sx*cos)+","+sin+","+(sy*(-sin))+","+cos+",0,0)");
    }

    function mouseLeave(){
        canShoot = false;
        return ;
    }

    function shoot(){
        if(!canShoot) return ;
        var bullet = $("<div></div>");
        bullet.addClass("ball ball-bullet ball-"+nextArr[cur]);
        var ty = 32;
        var tx = ox+(oy-ty)/k;
        if(tx>772){
            tx = 772;
            ty = oy-(tx-ox)*k;
        }
        else if(tx<32){
            tx = 32;
            ty = oy-(tx-ox)*k;
        }
        //bullet.css("margin-bottom",-ty);
        bullet.css("top",ty-32);
        bullet.css("left",tx-32);
        controlPanel.append(bullet);
        setTimeout(function(){bullet.remove()},3000);
        canShoot = false;
        nextBalls.addClass("push-bullet");
        setTimeout(function(){
            controlBall.removeClass("ball-"+nextArr[cur]);
            nextArr[cur] = colorArr[Math.floor(Math.random()*colorNum)];
            cur = (cur+1)%nextSize;
            controlBall.addClass("ball-"+nextArr[cur]);
            var tmp = cur;
            nextBalls.find("li").each(function(){
                $(this).removeClass("ball-"+nextArr[tmp]);
                tmp = (tmp+1)%nextSize;
                $(this).addClass("ball ball-"+nextArr[tmp]);
            });
            setTimeout(function(){nextBalls.removeClass("push-bullet");},500);
        },500);

    }
});
