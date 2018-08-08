function showMessage(a,b){
    if(b==null) b = 10000;
    jQuery("#message").hide().stop();
    jQuery("#message").html(a);
    jQuery("#message").fadeTo("10",1);
    jQuery("#message").fadeOut(b);
};
function showHitokoto(){
    $.post("https://www.fczbl.vip/api/hitokoto/",function(result){
        showMessage(result);
    });
}
$(document).on('copy',function(){
    showMessage('你都复制了些什么呀，转载要记得加上出处哦',8000);
});
jQuery(document).ready(function($){
    $("#message").hover(function(){
       $("#message").fadeTo("100",1);
    });
});
jQuery(document).ready(function($){
    var text;
    var SiteIndexUrl = window.location.protocol+'//'+window.location.hostname+'/';
    if(window.location.href == SiteIndexUrl){
        var now = (new Date()).getHours();
        if(now>23||now<=5){
            text = '你是夜猫子呀？这么晚还不睡觉，明天起的来嘛';
        }else if(now>5&&now<=7){
            text = '早上好！一日之计在于晨，美好的一天就要开始了';
        }else if(now>7&&now<=11){
            text = '上午好！工作顺利嘛，不要久坐，多起来走动走动哦！';
        }else if(now>11&&now<=14){
            text = '中午了，工作了一个上午，现在是午餐时间！';
        }else if(now>14&&now<=17){
            text = '午后很容易犯困呢，今天的运动目标完成了吗？';
        }else if(now>17&&now<=19){
            text = '傍晚了！窗外夕阳的景色很美丽呢，最美不过夕阳红~';
        }else if(now>19&&now<=21){
            text = '晚上好，今天过得怎么样？';
        }else if(now>21&&now<=23){
            text = '已经这么晚了呀，早点休息吧，晚安~';
        }else{
            text = '嗨~ 快来逗我玩吧！';
        }
    }else{
        if(document.referrer!==''){
            var referrer = document.createElement('a');
            referrer.href = document.referrer;
            var domain = referrer.hostname.split('.')[1];
            if(window.location.hostname==referrer.hostname){
                text = '欢迎阅读<span style="color:#0099cc;">『'+document.title.split(' - ')[0]+'』</span>';
            }else if(domain=='baidu') {
                text = 'Hello! 来自 百度搜索 的朋友<br>你是搜索 <span style="color:#0099cc;">'+referrer.search.split('&wd=')[1].split('&')[0]+'</span> 找到的我吗？';
            }else if(domain=='so') {
                text = 'Hello! 来自 360搜索 的朋友<br>你是搜索 <span style="color:#0099cc;">'+referrer.search.split('&q=')[1].split('&')[0]+'</span> 找到的我吗？';
            }else if(domain=='google') {
                text = 'Hello! 来自 谷歌搜索 的朋友<br>欢迎阅读<span style="color:#0099cc;">『'+document.title.split(' - ')[0]+'』</span>';
            }else{
                text = 'Hello! 来自 <span style="color:#0099cc;">'+referrer.hostname+'</span> 的朋友';
            }
        }else{
            text = '欢迎阅读<span style="color:#0099cc;">『'+document.title.split(' - ')[0]+'』</span>';
        }
    }
    $(".spig").animate({
        top:$(".spig").offset().top+300,
        left:60
    },
    {
        queue:false,
        duration:1000
    });
    var f = $(".spig").offset().top;
    $(window).scroll(function(){
        $(".spig").animate({
            top:$(window).scrollTop()+f+300
        },
        {
            queue:false,
            duration:1000
        });
    });
    showMessage(text,8000);
});
jQuery(document).ready(function($){
    $("#spig").mousedown(function(e){
        if(e.which==3){showMessage("秘密通道:<br />    <a href=\"https://www.fczbl.vip\" title=\"首页\">首页</a>    <a href=\"http://pay.fczbl.vip/\" title=\"打赏\">打赏</a>    <a href=\"/wp-admin/\" title=\"后台\">后台</a> ",10000);}
    });
    $("#spig").bind("contextmenu",function(e){return false;});
    $('.search-box').mouseover(function(){
        showMessage('找不到想要的？试试搜索吧！');
    });
    $('#search').focus(function(){
        showMessage('输入你想搜索的关键词再按Enter键就可以搜索啦!');
    });
    $('.desc a h2,.desc a span,.color-logo a,.back-index,.waifu-tool .fa-home,#kratos-primary-menu .fa-home').mouseover(function(){
        showMessage('点它就可以回到首页啦！');
    });
    $('#footer p a i.fa-weibo').mouseover(function(){
        showMessage('微博？求关注喵！');
    });
    $('#footer p a i.fa-envelope').mouseover(function(){
        showMessage('邮件我会及时回复的！');
    });
    $('#footer p a i.fa-twitter').mouseover(function(){
        showMessage('Twitter?好像是不存在的东西?');
    });
    $('#footer p a i.fa-facebook-official').mouseover(function(){
        showMessage('emmm...FB已经好久没上了...');
    });
    $('#footer p a i.fa-github').mouseover(function(){
        showMessage('GayHub！我是新手！');
    });
    $('#wechat-img').mouseover(function(){
        showMessage('这是我的微信二维码~');
    });
    $('.gotop-box').mouseover(function(){
        showMessage('要回到开始的地方么？');
    });
    $(document).on("click","h2 a",function(){
        showMessage('加载<span style="color:#0099cc;">'+$(this).text()+'</span>中...请稍候',600);
    });
    $(document).on("mouseover","h2 a",function(){
        showMessage('要看看<span style="color:#0099cc;">'+$(this).text()+'</span>么？');
    });
    $(document).on("mouseover",".prev",function(){
        showMessage('要翻到上一页吗?');
    });
    $(document).on("mouseover",".next",function(){
        showMessage('要翻到下一页吗?');
    });
    $(document).on("mouseover",".kratos-post-content a",function(){
        showMessage('去 <span style="color:#0099cc;">'+$(this).text()+'</span> 逛逛吧');
    });
    $(document).on("mouseover","#submit",function(){
        showMessage('呐 首次评论需要审核，请耐心等待哦~');
    });
    $(document).on("mouseover",".OwO-logo",function(){
        showMessage('要来一发表情吗？');
    });
    $(document).on("mouseover",".nav-previous",function(){
        showMessage('点它可以后退哦！');
    });
    $(document).on("mouseover",".nav-next",function(){
        showMessage('点它可以前进哦！');
    });
    $(document).on("mouseover",".comment-reply-link",function(){
        showMessage('要说点什么吗');
    });
    $(document).on("mouseover",".Donate",function(){
        showMessage('要打赏我嘛？好期待啊~');
    });
    $(document).on("mouseover",".Love",function(){
        showMessage('我是不是棒棒哒~快给我点赞吧！');
    });
    $(document).on("mouseover",".must-log-in",function(){
        showMessage('登录才可以继续哦~');
    });
    $(document).on("mouseover",".Share",function(){
        showMessage('好东西要让更多人知道才行哦');
    });
    $(document).on("click","#author",function(){
        showMessage("留下你的尊姓大名！");
        $(".spig").animate({
            top:$("#author").offset().top-70,
            left:$("#author").offset().left-170
        },
        {
            queue:false,
            duration:1000
        });
    });
    $(document).on("click","#email",function(){
        showMessage("留下你的邮箱，不然就是无头像人士了！");
        $(".spig").animate({
            top:$("#email").offset().top-70,
            left:$("#email").offset().left-170
        },
        {
            queue:false,
            duration:1000
        });
    });
    $(document).on("click","#url",function(){
        showMessage("快快告诉我你的家在哪里，好让我去参观参观！");
        $(".spig").animate({
            top:$("#url").offset().top-70,
            left:$("#url").offset().left-170
        },
        {
            queue:false,
            duration:1000
        });
    });
    $(document).on("click","#comment",function(){
        showMessage("一定要认真填写喵~");
        $(".spig").animate({
            top:$("#comment").offset().top-70,
            left:$("#comment").offset().left-170
        },
        {
            queue:false,
            duration:1000
        });
    });
});
jQuery(document).ready(function($){
    $(".mumu").mouseover(function(){
       $(".mumu").fadeTo("300",0.3);
       msgs = ["我隐身了，你看不到我","我会隐身哦！嘿嘿！","别动手动脚的，把手拿开！","喵喵喵？","把手拿开我才出来！"];
       var i = Math.floor(Math.random()*msgs.length);
        showMessage(msgs[i]);
    });
    $(".mumu").mouseout(function(){
        $(".mumu").fadeTo("300",1)
    });
    window.setInterval(function(){
        var temp = Math.random();
        if(temp>0.35){
            showMessage(showHitokoto());
        }else{
            msgs = ["乾坤大挪移！","我飘过来了！~","我飘过去了","我得意地飘！~飘！~"];
            var i = Math.floor(Math.random()*msgs.length);
            s = [0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.75,-0.1,-0.2,-0.3,-0.4,-0.5,-0.6,-0.7,-0.75];
            var i1 = Math.floor(Math.random()*s.length);
            var i2 = Math.floor(Math.random()*s.length);
                $(".spig").animate({
                    left:document.body.offsetWidth/2*(1+s[i1]),
                    top:(window.innerHeight+$(window).scrollTop()-170)-(window.innerHeight-170)/2*(1+s[i2])
                },
                {
                    duration:2000,
                    complete:showMessage(msgs[i])
                });
        }
    },40000);
    var stat_click = 0;
    $(".mumu").click(function(){
        if(!ismove){
            stat_click++;
            if (stat_click>6) {
                msgs = ["你有完没完呀？","你已经摸我"+stat_click+"次了","非礼呀！救命！","OH，My ladygaga","110吗，这里有个变态一直在摸我(ó﹏ò｡)"];
                var i = Math.floor(Math.random()*msgs.length);
            } else {
                msgs = ["是…是不小心碰到了吧","我跑呀跑呀跑！~~","再摸的话我可要报警了！⌇●﹏●⌇","别摸我，有什么好摸的！","惹不起你，我还躲不起你么？","不要摸我了，我会告诉老婆来打你的！","干嘛动我呀！小心我咬你！"];
                var i = Math.floor(Math.random()*msgs.length);
            }
        s = [0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.75,-0.1,-0.2,-0.3,-0.4,-0.5,-0.6,-0.7,-0.75];
        var i1 = Math.floor(Math.random()*s.length);
        var i2 = Math.floor(Math.random()*s.length);
            $(".spig").animate({
            left:document.body.offsetWidth/2*(1+s[i1]),
            top:(window.innerHeight+$(window).scrollTop()-300)-(window.innerHeight-270)/2*(1-s[i2])
            },
            {
                duration:500,
                complete:showMessage(msgs[i])
            });
        }else{
            ismove = false;
        }
    });
});
var _move = false;
var ismove = false;
var _x, _y;
jQuery(document).ready(function($){
    $("#spig").mousedown(function(e){
        _move = true;
        _x = e.pageX-parseInt($("#spig").css("left"));
        _y = e.pageY-parseInt($("#spig").css("top"));
     });
    $(document).mousemove(function(e){
        if(_move){
            var x = e.pageX-_x; 
            var y = e.pageY-_y;
            var wx = $(window).width()-$('#spig').width();
            var dy = $(document).height()-$('#spig').height();
            if(x>=0&&x<=wx&&y>0&&y<=dy){
                $("#spig").css({
                    top:y,
                    left:x
                });
            ismove = true;
            }
        }
    }).mouseup(function(){
        _move = false;
    });
});