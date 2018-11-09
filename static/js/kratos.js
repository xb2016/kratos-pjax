//functions
(function(){
    'use strict';
    var shareMenu = function(){
        $(document).on("click",".Share",function(){
            $(".share-wrap").fadeToggle("slow");
        });
    }
    var sidebaraffix = function(){
        if($("#sidebar").height()&&xb.site_sh){
            if($("#main").height()>$("#sidebar").height()){
                var footerHeight = 0;
                if($('#page-footer').length>0){
                    footerHeight = $('#page-footer').outerHeight(true);
                }
                $('#sidebar').affix({
                    offset:{
                        top:$('#sidebar').offset().top-xb.site_sh,
                        bottom:$('#footer').outerHeight(true)+footerHeight+6
                    }
                });
            }
        }
    }
    var toSearch = function(){
        $('.search-box').on("click",function(e){
            $("#searchform").animate({width:"200px"},200),
            $("#searchform input").css('display','block');
            $(document).one("click", function(){
                $("#searchform").animate({width:"0"},100),
                $("#searchform input").hide();
            });
            e.stopPropagation();
        });
        $('#searchform').on("click",function(e){e.stopPropagation();})
    }
    var showlove = function(){
        $.fn.postLike = function(){
            if($(this).hasClass('done')){
                layer.msg('您已经支持过了',function(){});
                return false;
            }else{
                $(this).addClass('done');
                layer.msg('感谢您的支持');
                var id = $(this).data("id"),
                    action = $(this).data('action'),
                    rateHolder = $(this).children('.count');
                var ajax_data = {
                    action:"love",
                    um_id:id,
                    um_action:action
                };
                $.post(xb.ajax_url,ajax_data,function(data){
                    $(rateHolder).html(data);
                });
                return false;
            }
        };
        $(document).on("click",".Love",function(){$(this).postLike();});
    }
    var gotop = function(){
        $('.gotop-box').on('click',function(event){
            event.preventDefault();
            $('html, body').animate({
                scrollTop:$('html').offset().top
            },500);
            return false;
        });
        $(window).scroll(function(){
            var $win = $(window);
            if ($win.scrollTop()>200){
                $('.gotop-box').addClass('active');
            }else{
                $('.gotop-box').removeClass('active');
            }
        });
    }
    var wechatpic = function(){
        $("#wechat-img").mouseout(function(){
            $("#wechat-pic")[0].style.display = 'none';
        })
        $("#wechat-img").mouseover(function(){
            $("#wechat-pic")[0].style.display = 'block';
        })
    }
    var showPhotos = function(){
        layer.photos({
          photos:'.kratos-post-content p,.kratos-status-post p',
          anim: 0
        });
    }
    var offcanvas = function(){
        var $clone = $('#kratos-menu-wrap').clone();
        $clone.attr({
            'id':'offcanvas-menu'
        });
        $clone.find('> ul').attr({
            'class':'ul-me',
            'id':''
        });
        $('#kratos-page').prepend($clone);
        $('.js-kratos-nav-toggle').on('click',function(){
            if($('.nav-toggle').hasClass('toon')){
                $('.nav-toggle').removeClass('toon');
                $('#offcanvas-menu').css('right','-240px');
            }else{
                $('.nav-toggle').addClass('toon');
                $('#offcanvas-menu').css('right','0px');
            }
        });
        $('#offcanvas-menu a').on('click',function(){
            $('.nav-toggle').removeClass('toon');
            $('#offcanvas-menu').css('right','-240px');
        });
        $('#offcanvas-menu').css('height',$(window).height());
        $('#offcanvas-menu').css('right','-240px');
        $(window).resize(function(){
            var w = $(window);
            $('#offcanvas-menu').css('height',w.height());
            if(w.width()>769){
                if($('.nav-toggle').hasClass('toon')){
                    $('.nav-toggle').removeClass('toon');
                    $('#offcanvas-menu').css('right','-240px');
                }
            }
        });
    }
    var menu = function(){
        $(document).click(function(e){
            var container = $("#offcanvas-menu,.js-kratos-nav-toggle");
            if(!container.is(e.target)&&container.has(e.target).length===0){
                if($('.nav-toggle').hasClass('toon')){
                    $('.nav-toggle').removeClass('toon');
                    $('#offcanvas-menu').css('right','-240px');
                }
            }
        });
        $('#kratos-header-section:not(.color-banner) ul>li').hover(function(){
            $(this).children('ul').slideDown(150)
        },function(){$(this).children('ul').stop(true,false).slideUp(200)});
    }
    var xControl = function(){
        $(document).on("click",".xHeading",function(event){
            var $this = $(this);
            $this.closest('.xControl').find('.xContent').slideToggle(300);
            if ($this.closest('.xControl').hasClass('active')){
                $this.closest('.xControl').removeClass('active');
            }else{
                $this.closest('.xControl').addClass('active');
            }
            event.preventDefault();
        });
    }
    var donateConfig = function(){
        $(document).on("click",".Donate",function(){
            layer.open({
                type:1,
                area:['300px', '370px'],
                title:'打赏作者',
                resize:false,
                scrollbar:false,
                content:'<div class="donate-box"><div class="meta-pay text-center"><strong>扫一扫支付</strong></div><div class="qr-pay text-center"><img class="pay-img" id="alipay_qr" src="'+xb.alipay+'"><img class="pay-img d-none" id="wechat_qr" src="'+xb.wechat+'"></div><div class="choose-pay text-center mt-2"><input id="alipay" type="radio" name="pay-method" checked><label for="alipay" class="pay-button"><img src="'+xb.thome+'/static/images/alipay.png"></label><input id="wechatpay" type="radio" name="pay-method"><label for="wechatpay" class="pay-button"><img src="'+xb.thome+'/static/images/wechat.png"></label></div></div>'
            });
            $(".choose-pay input[type='radio']").click(function(){
                var id= $(this).attr("id");
                if(id=='alipay'){$(".qr-pay #alipay_qr").removeClass('d-none');$(".qr-pay #wechat_qr").addClass('d-none')};
                if(id=='wechatpay'){$(".qr-pay #alipay_qr").addClass('d-none');$(".qr-pay #wechat_qr").removeClass('d-none')};
            });
        });
    }
    var OwOcfg = function(){
        if($("#commentform").height()){
            var OwO_demo = new OwO({
                logo:'OωO表情',
                container:document.getElementsByClassName('OwO')[0],
                target:document.getElementsByClassName('OwO')[0],
                api:xb.thome+'/inc/OwO.json',
                position:'down',
                width:'90%',
                maxHeight:'250px'
            });
        }
    }
    //pjax reload
    $.fn.kratos_pjax_reload = function(){
        sidebaraffix();
        showPhotos();
        OwOcfg();
			Prism.highlightAll();
    }
    $(function(){
        gotop();
        sidebaraffix();
        offcanvas();
        menu();
        toSearch();
        xControl();
        showPhotos();
        donateConfig();
        showlove();
        shareMenu();
        OwOcfg();
        wechatpic();
    });
}());
//comment ajax
jQuery(document).ready(function(jQuery) {
    var __cancel = jQuery('#cancel-comment-reply-link'),
    __cancel_text = __cancel.text(),
    __list = 'comment-list';
    jQuery(document).on("submit","#commentform",function(){
        jQuery.ajax({
            url:xb.ajax_url,
            data:jQuery(this).serialize()+"&action=ajax_comment",
            type:jQuery(this).attr('method'),
            beforeSend:addComment.createButterbar("正在提交"),
            error:function(request){
                var t = addComment;
                t.createButterbar(request.responseText)
            },
            success:function(data){
                jQuery('textarea').each(function(){this.value = ''});
                var t = addComment,cancel = t.I('cancel-comment-reply-link'),temp = t.I('wp-temp-form-div'),respond = t.I(t.respondId),post = t.I('comment_post_ID').value,parent = t.I('comment_parent').value;
                if(parent!='0'){
                    jQuery('#respond').before('<ol class="children">'+data+'</ol>')
                }else if(!jQuery('.'+__list).length){
                    jQuery('#comments-nav').before('<ol class="'+__list+'">'+data+'</ol>')
                }else{
                    if(xb.order=='asc'){
                        jQuery('.'+__list).append(data)
                    }else{
                        jQuery('.'+__list).prepend(data)
                    }
                }
                t.createButterbar("提交成功");
                cancel.style.display = 'none';
                cancel.onclick = null;
                t.I('comment_parent').value = '0';
                if(temp&&respond){
                    temp.parentNode.insertBefore(respond,temp);
                    temp.parentNode.removeChild(temp)
                }
            }
        });
        return false
    });
    addComment = {
        moveForm:function(commId,parentId,respondId){
            var t = this,div,comm = t.I(commId),respond = t.I(respondId),cancel = t.I('cancel-comment-reply-link'),parent = t.I('comment_parent'),post = t.I('comment_post_ID');
            __cancel.text(__cancel_text);
            t.respondId = respondId;
            if(!t.I('wp-temp-form-div')){
                div = document.createElement('div');
                div.id = 'wp-temp-form-div';
                div.style.display = 'none';
                respond.parentNode.insertBefore(div,respond)
            }!comm?(temp = t.I('wp-temp-form-div'),t.I('comment_parent').value = '0',temp.parentNode.insertBefore(respond,temp),temp.parentNode.removeChild(temp)):comm.parentNode.insertBefore(respond,comm.nextSibling);
            jQuery("body").animate({
                scrollTop:jQuery('#respond').offset().top-180
            },400);
            parent.value = parentId;
            cancel.style.display = '';
            cancel.onclick = function(){
                var t = addComment,temp = t.I('wp-temp-form-div'),respond = t.I(t.respondId);
                t.I('comment_parent').value = '0';
                if(temp&&respond){
                    temp.parentNode.insertBefore(respond,temp);
                    temp.parentNode.removeChild(temp)
                }
                this.style.display = 'none';
                this.onclick = null;
                return false
            };
            try{t.I('comment').focus()}catch(e){}
            return false
        },
        I:function(e){
            return document.getElementById(e)
        },
        createButterbar:function(message){
            var t = this;
            layer.msg(message)
        }
    }
});
//time
var now = new Date();
function createtime(){
    var grt = new Date(xb.ctime);
    now.setTime(now.getTime()+250);
    days = (now-grt)/1000/60/60/24;dnum = Math.floor(days);
    hours = (now-grt)/1000/60/60-(24*dnum);hnum = Math.floor(hours);
    if(String(hnum).length==1){hnum = "0"+hnum;}
    minutes = (now-grt)/1000/60-(24*60*dnum)-(60*hnum);mnum = Math.floor(minutes);
    if(String(mnum).length==1){mnum = "0"+mnum;}
    seconds = (now-grt)/1000-(24*60*60*dnum)-(60*60*hnum)-(60*mnum);snum = Math.round(seconds);
    if(String(snum).length==1){snum = "0"+snum;}
    document.getElementById("span_dt_dt").innerHTML = dnum+"天"+hnum+"小时"+mnum+"分"+snum+"秒";
}
setInterval("createtime()",250);
//copy
if(xb.copy) document.body.oncopy=function(){alert('已复制所选内容。请务必遵守本站条约！');}
//console
window.onload = function(){
    var now = new Date().getTime();
    var page_load_time = now-performance.timing.navigationStart;
    console.clear();
    //console.log('项目托管:https://github.com/xb2016/kratos-pjax');
    //console.log('%cwww.fczbl.vip','font-size:2em');
    console.log('%c页面加载完毕消耗了'+Math.round(performance.now()*100)/100+'ms','background:#fff;color:#333;text-shadow:0 0 2px #eee,0 0 3px #eee,0 0 3px #eee,0 0 2px #eee,0 0 3px #eee;');
};