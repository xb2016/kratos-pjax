<?php
if(!kratos_option('comment_ua')) return;
function user_agent_show(){
    global $comment;
    $useragent = $comment->comment_agent;
    $title = $version = $code = null;
    if(preg_match('/iPad/i',$useragent)){
        $title = 'iPad';
        if(preg_match('/CPU\ OS\ ([._0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = 'iOS '.str_replace('_','.',$regmatch[1]);
        $code = 'ipad';
    }elseif(preg_match('/iPod/i',$useragent)){
        $title = 'iPod';
        if(preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = 'iOS '.str_replace('_','.',$regmatch[1]);
        $code = 'iphone';
    }elseif(preg_match('/iPhone/i',$useragent)&&!preg_match('/Windows Phone/i',$useragent)){
        $title = 'iPhone';
        if(preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = 'iOS '.str_replace('_', '.', $regmatch[1]);
        $code = 'iphone';
    }elseif(preg_match('/Windows Phone OS 7/i',$useragent)||preg_match('/ZuneWP7/i',$useragent)||preg_match('/WP7/i',$useragent)){
        $title = 'Windows Phone';
        $version = '7';
        $code = 'wp7';
    }elseif(preg_match('/Windows Phone OS 8\.1/i',$useragent)||preg_match('/Windows Phone 8\.1/i',$useragent)||preg_match('/WP8\.1/i',$useragent)){
        $title = 'Windows Phone';
        $version = '8.1';
        $code = 'wp7';
    }elseif(preg_match('/Windows Phone OS 8/i',$useragent)||preg_match('/Windows Phone 8/i',$useragent)||preg_match('/WP8/i',$useragent)){
        $title = 'Windows Phone';
        $version = '8';
        $code = 'wp7';
    }elseif(preg_match('/Windows Phone 10/i',$useragent)||preg_match('/WP10/i',$useragent)){
        $title = 'Windows Phone';
        $version = '10';
        $code = 'wp10';
    }elseif(preg_match('/wp-windowsphone/i',$useragent)){
        $title = 'Windows Phone';
        $code = 'windowsphone';
    }elseif(preg_match('/Android/i',$useragent)){
        $title = 'Android';
        if(preg_match('/Android[\ |\/]?([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'android';
    }elseif(preg_match('/[^A-Za-z]Arch/i',$useragent)){
        $title = 'Arch Linux';
        $code = 'archlinux';
    }elseif(preg_match('/CentOS/i',$useragent)){
        $title = 'CentOS';
        if(preg_match('/.el([.0-9a-zA-Z]+).centos/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'centos';
    }elseif(preg_match('/Debian/i',$useragent)){
        $title = 'Debian GNU/Linux';
        $code = 'debian';
    }elseif(preg_match('/Edubuntu/i',$useragent)){
        $title = 'Edubuntu';
        if(preg_match('/Edubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if($regmatch[1] < 10){
            $code = 'edubuntu-1';
        }else{
            $code = 'edubuntu-2';
        }
    }elseif(preg_match('/FreeBSD/i',$useragent)){
        $title = 'FreeBSD';
        $code = 'freebsd';
    }elseif(preg_match('/Kubuntu/i',$useragent)){
        $title = 'Kubuntu';
        if(preg_match('/Kubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if($regmatch[1] < 10){
            $code = 'kubuntu-1';
        }else{
            $code = 'kubuntu-2';
        }
    }elseif(preg_match('/Linux\ Mint/i',$useragent)){
        $title = 'Linux Mint';
        if(preg_match('/Linux\ Mint\/([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'linuxmint';
    }elseif(preg_match('/Lubuntu/i',$useragent)){
        $title = 'Lubuntu';
        if (preg_match('/Lubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if ($regmatch[1] < 10){
            $code = 'lubuntu-1';
        }else{
            $code = 'lubuntu-2';
        }
    }elseif(preg_match('/Mac/i',$useragent)||preg_match('/Darwin/i',$useragent)){
        $title = 'Mac';
        if(preg_match('/Mac OS X/i',$useragent)||preg_match('/Mac OSX/i',$useragent)){
            if(preg_match('/Mac OS X/i',$useragent)){
                $version = substr($useragent,strpos(strtolower($useragent),strtolower('OS X'))+4);
                $code = 'mac-3';
            }else{
                $version = substr($useragent,strpos(strtolower($useragent),strtolower('OSX'))+3);
                $code = 'mac-2';
            }
            $version = substr($version,0,strpos($version,')'));
            if(strpos($version,';') > -1) $version = substr($version,0,strpos($version,';'));
            $version = str_replace('_','.',$version);
            if($wpua_show_version==='simple'&&preg_match('/([0-9]+\.[0-9]+)/i',$version,$regmatch)) $version = $regmatch[1];
            $version = (empty($version))?'OS X':"OS X $version";
        }elseif(preg_match('/Darwin/i',$useragent)){
            $version = 'OS Darwin';
            $code = 'mac-1';
        }else{
            $title = 'Macintosh';
            $code = 'mac-1';
        }
    }elseif(preg_match('/NetBSD/i',$useragent)){
        $title = 'NetBSD';
        $code = 'netbsd';
    }elseif(preg_match('/Nova/i',$useragent)){
        $title = 'Nova';
        if(preg_match('/Nova[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'nova';
    }elseif(preg_match('/OpenBSD/i',$useragent)){
        $title = 'OpenBSD';
        $code = 'openbsd';
    }elseif(preg_match('/Red\ Hat/i',$useragent)||preg_match('/RedHat/i',$useragent)){
        $title = 'Red Hat';
        if(preg_match('/.el([._0-9a-zA-Z]+)/i',$useragent,$regmatch)){
            $title .= ' Enterprise Linux';
            $version = str_replace('_','.',$regmatch[1]);
        }
        $code = 'red-hat';
    }elseif(preg_match('/Xubuntu/i',$useragent)){
        $title = 'Xubuntu';
        if(preg_match('/Xubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if ($regmatch[1] < 10){
            $code = 'xubuntu-1';
        }else{
            $code = 'xubuntu-2';
        }
    }elseif(preg_match('/Ubuntu/i',$useragent)){
        $title = 'Ubuntu';
        if(preg_match('/Ubuntu[\/|\ ]([.0-9]+[.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if($regmatch[1] < 10){
            $code = 'ubuntu-1';
        }else{
            $code = 'ubuntu-2';
        }
    }elseif(preg_match('/Unix/i',$useragent)){
        $title = 'Unix';
        $code = 'unix';
    }elseif(preg_match('/Windows/i',$useragent)||preg_match('/WinNT/i',$useragent)||preg_match('/Win32/i',$useragent)){
        $title = 'Windows';
        if(preg_match('/Windows NT 10.0/i',$useragent)||preg_match('/Windows NT 6.4/i',$useragent)){
            $version = '10';
            $code = 'win-6';
        }elseif(preg_match('/Windows NT 6.3/i',$useragent)){
            $version = '8.1';
            $code = 'win-5';
        }elseif(preg_match('/Windows NT 6.2/i',$useragent)){
            $version = '8';
            $code = 'win-5';
        }elseif(preg_match('/Windows NT 6.1/i',$useragent)){
            $version = '7';
            $code = 'win-4';
        }elseif(preg_match('/Windows NT 6.0/i',$useragent)){
            $version = 'Vista';
            $code = 'win-3';
        }elseif(preg_match('/Windows NT 5.2 x64/i',$useragent)){
            $version = 'XP';
            $code = 'win-2';
        }elseif(preg_match('/Windows NT 5.2/i',$useragent)){
            $version = 'Server 2003';
            $code = 'win-2';
        }elseif(preg_match('/Windows NT 5.1/i',$useragent)||preg_match('/Windows XP/i',$useragent)){
            $version = 'XP';
            $code = 'win-2';
        }elseif(preg_match('/Windows NT 5.01/i',$useragent)){
            $version = '2000, Service Pack 1 (SP1)';
            $code = 'win-1';
        }elseif(preg_match('/Windows NT 5.0/i',$useragent)||preg_match('/Windows NT5/i',$useragent)||preg_match('/Windows 2000/i',$useragent)){
            $version = '2000';
            $code = 'win-1';
        }elseif(preg_match('/Windows NT 4.0/i',$useragent)||preg_match('/WinNT4.0/i',$useragent)){
            $version = 'NT 4.0';
            $code = 'win-1';
        }elseif (preg_match('/Windows NT 3.51/i',$useragent)||preg_match('/WinNT3.51/i',$useragent)){
            $version = 'NT 3.11';
            $code = 'win-1';
        }elseif(preg_match('/Windows NT/i',$useragent)||preg_match('/WinNT/i',$useragent)){
            $version = 'NT';
            $code = 'win-1';
        }elseif(preg_match('/Windows 3.11/i',$useragent)||preg_match('/Win3.11/i',$useragent)||preg_match('/Win16/i',$useragent)){
            $version = '3.11';
            $code = 'win-1';
        }elseif(preg_match('/Windows 3.1/i',$useragent)){
            $version = '3.1';
            $code = 'win-1';
        }elseif(preg_match('/Windows 98; Win 9x 4.90/i',$useragent)||preg_match('/Win 9x 4.90/i',$useragent)||preg_match('/Windows ME/i',$useragent)){
            $version = 'Millennium Edition (Windows Me)';
            $code = 'win-1';
        }elseif(preg_match('/Win98/i',$useragent)){
            $version = '98 SE';
            $code = 'win-1';
        }elseif(preg_match('/Windows 98/i',$useragent)||preg_match('/Windows\ 4.10/i',$useragent)){
            $version = '98';
            $code = 'win-1';
        }elseif(preg_match('/Windows 95/i',$useragent)||preg_match('/Win95/i',$useragent)){
            $version = '95';
            $code = 'win-1';
        }elseif(preg_match('/Windows CE/i',$useragent)){
            $version = 'CE';
            $code = 'win-2';
        }elseif(preg_match('/WM5/i',$useragent)){
            $version = 'Mobile 5';
            $code = 'win-phone';
        }elseif(preg_match('/WindowsMobile/i',$useragent)){
            $version = 'Mobile';
            $code = 'win-phone';
        }else{
            $code = 'win-2';
        }
    }
    $btitle = $bversion = $bcode = null;
    if(preg_match('/BonEcho/i',$useragent)){
        $btitle = 'BonEcho';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/chromeframe/i',$useragent)){
        $btitle = 'Google Chrome Frame';
        $bcode = 'google';
    }elseif(preg_match('/ChromePlus/i',$useragent)){
        $btitle = 'ChromePlus';
        $bcode = 'chromeplus';
    }elseif(preg_match('/Chromium/i',$useragent)){
        $btitle = 'Chromium';
        $bcode = 'chromium';
    }elseif(preg_match('/CrMo/i',$useragent)){
        $btitle = 'Chrome Mobile';
        $bcode = 'chrome';
    }elseif(preg_match('/CriOS/i',$useragent)){
        $btitle = 'Chrome';
        $bcode = 'chrome';
    }elseif(preg_match('/Galaxy/i',$useragent)&&!preg_match('/Chrome/i',$useragent)){
        $btitle = 'Galaxy';
        $bcode = 'galaxy';
    }elseif(preg_match('/GoBrowser/i',$useragent)){
        $btitle = 'GO Browser';
        $bcode = 'gobrowser';
    }elseif(preg_match('/Google\ Wireless\ Transcoder/i',$useragent)){
        $btitle = 'Google Wireless Transcoder';
        $bcode = 'google';
    }elseif(preg_match('/GreenBrowser/i',$useragent)){
        $btitle = 'GreenBrowser';
        $bcode = 'greenbrowser';
    }elseif(preg_match('/GSA/i',$useragent)&&preg_match('/Mobile/i',$useragent)){
        $btitle = 'Google Search App';
        $bcode = 'google';
    }elseif(preg_match('/Lorentz/i',$useragent)){
        $btitle = 'Lorentz';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/MiniBrowser/i',$useragent)){
        $btitle = 'MiniBrowser';
        $bcode = 'minibrowser';
    }elseif(preg_match('/Minimo/i',$useragent)){
        $btitle = 'Minimo';
        $bcode = 'minimo';
    }elseif(preg_match('/MiuiBrowser/i',$useragent)){
        $btitle = 'MIUI Browser';
        $bcode = 'miuibrowser';
    }elseif(preg_match('/Mosaic/i',$useragent)){
        $btitle = 'Mosaic';
        $bcode = 'mosaic';
    }elseif(preg_match('/MozillaDeveloperPreview/i',$useragent)){
        $btitle = 'Mozilla Developer Preview';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/MQQBrowser/i',$useragent)||preg_match('/QQBrowser/i',$useragent)){
        $btitle = 'QQbrowser';
        $bcode = 'qqbrowser';
    }elseif(preg_match('/MultiZilla/i',$useragent)){
        $btitle = 'MultiZilla';
        $bcode = 'mozilla';
    }elseif(preg_match('/NokiaBrowser/i',$useragent)){
        $btitle = 'Nokia Browser';
        $bcode = 'nokia';
    }elseif(preg_match('/OneBrowser/i',$useragent)){
        $btitle = 'OneBrowser';
        $bcode = 'onebrowser';
    }elseif(preg_match('/Opera Mini/i',$useragent)){
        $btitle = 'Opera Mini';
        $bcode = 'opera-2';
    }elseif(preg_match('/Opera Mobi/i',$useragent)){
        $btitle = 'Opera Mobile';
        $bcode = 'opera-2';
    }elseif(preg_match('#Opera.([a-zA-Z0-9.]+)#i',$useragent,$matches)||preg_match('/OPR/i',$useragent)){
        $btitle = 'Opera';
        $bversion = $matches[1];
        $bcode = 'opera-1';
        if(preg_match('/Version/i',$useragent)){
            $bcode = 'opera-2';
        }elseif(preg_match('/OPR/i',$useragent)){
            $bcode = 'opera-2';
        }
        if(preg_match('/Opera Labs/i',$useragent)||preg_match('/Edition Labs/i',$useragent)){
            $bcode = 'opera-2-next';
        }elseif(preg_match('/Opera Next/i',$useragent)||preg_match('/Edition Next/i',$useragent)){
            $bcode = 'opera-2-next';
        }elseif(preg_match('/Opera Developer/i',$useragent)||preg_match('/Edition Developer/i',$useragent)){
            $bcode = 'opera-2-developer';
        }
        if(preg_match('/Edition ([\ ._0-9a-zA-Z]+)/i',$useragent,$regmatch)){
            $btitle .= ' '.$regmatch[1];
        }elseif(preg_match('/Opera ([\ ._0-9a-zA-Z]+)/i',$useragent,$regmatch)){
            $btitle .= ' '.$regmatch[1];
        }
        if(isset($bversion)&&intval($bversion) > 13) $bcode = 'opera-3';
    }elseif(preg_match('/SeaMonkey/i',$useragent)){
        $btitle = 'SeaMonkey';
        $bcode = 'seamonkey';
    }elseif(preg_match('/Series60/i',$useragent)&&!preg_match('/Symbian/i',$useragent)){
        $btitle = 'Nokia Series60';
        $bcode = 's60';
    }elseif(preg_match('/S60/i',$useragent)&&!preg_match('/Symbian/i',$useragent)){
        $btitle = 'Nokia S60';
        $bcode = 's60';
    }elseif(preg_match('#SE 2([a-zA-Z0-9.]+)#i',$useragent,$matches)&&preg_match('/MetaSr/i',$useragent)){
        $btitle = 'Sogou Explorer';
        $bcode = 'sogou';
    }elseif(preg_match('/Shiretoko/i',$useragent)){
        $btitle = 'Shiretoko';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/SlimBrowser/i',$useragent)){
        $btitle = 'SlimBrowser';
        $bcode = 'slimbrowser';
    }elseif(preg_match('#SAMSUNG-(S.H-[a-zA-Z0-9_/.]+)#i',$useragent)){
        $btitle = "Samsung";
        $bcode = "samsung";
    }elseif(preg_match('/Songbird/i',$useragent)){
        $btitle = 'Songbird';
        $bcode = 'songbird';
    }elseif(preg_match('/TheWorld/i',$useragent)){
        $btitle = 'TheWorld Browser';
        $bcode = 'theworld';
    }elseif(preg_match('/Thunderbird/i',$useragent)){
        $btitle = 'Thunderbird';
        $bcode = 'thunderbird';
    }elseif(preg_match('#TencentTraveler ([a-zA-Z0-9.]+)#i',$useragent)){
        $btitle = 'TT Explorer';
        $bcode = 'tt-explorer';
    }elseif(preg_match('/uBrowser/i',$useragent)&&!preg_match('/Chrome/i',$useragent)){
        $btitle = 'uBrowser';
        $bcode = 'ubrowser';
    }elseif((preg_match('/Ubuntu\;\ Mobile/i',$useragent)||preg_match('/Ubuntu\;\ Tablet/i',$useragent)&&preg_match('/WebKit/i',$useragent))){
        $btitle = 'Ubuntu Web Browser';
        $bcode = 'ubuntuwebbrowser';
    }elseif(preg_match('#UBrowser([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bcode = 'ucbrowser';
    }elseif(preg_match('#UCBrowser([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bcode = 'ucbrowser';
    }elseif(preg_match('#UC\ Browser([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bcode = 'ucbrowser';
    }elseif(preg_match('#UCWEB([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bcode = 'ucweb';
    }elseif(preg_match('/UltraBrowser/i',$useragent)){
        $btitle = 'UltraBrowser';
        $bcode = 'ultrabrowser';
    }elseif(preg_match('/UP.Browser/i',$useragent)){
        $btitle = 'Openwave Mobile Browser';
        $bcode = 'openwave';
    }elseif(preg_match('/UP.Link/i',$useragent)){
        $btitle = 'Openwave Mobile Browser';
        $bcode = 'openwave';
    }elseif(preg_match('/AppleWebkit/i',$useragent,$matches)&&preg_match('/Android/i',$useragent)&&!preg_match('/Chrome/i',$useragent)){
        $btitle = 'Android Webkit';
        $bcode = 'android-webkit';
    }elseif(preg_match('/WebExplorer/i',$useragent)){
        $btitle = 'Web Explorer';
        $bcode = 'webexplorer';
    }elseif(preg_match('/Chrome/i',$useragent)&&preg_match('/Mobile/i',$useragent)&&(preg_match('/Version/i',$useragent)||preg_match('/wv/i',$useragent,$matches))){
        $btitle = 'WebView';
        $bcode = 'android-webkit';
    }elseif(preg_match('/wp-android/i',$useragent)){
        $btitle = 'Wordpress App';
        $bcode = 'wordpress';
    }elseif(preg_match('/wp-blackberry/i',$useragent)){
        $btitle = 'wp-blackberry';
        $bcode = 'wordpress';
    }elseif(preg_match('/wp-iphone/i',$useragent)){
        $btitle = 'Wordpress App';
        $bcode = 'wordpress';
    }elseif(preg_match('/wp-nokia/i',$useragent)){
        $btitle = 'wp-nokia';
        $bcode = 'wordpress';
    }elseif(preg_match('/wp-webos/i',$useragent)){
        $btitle = 'wp-webos';
        $bcode = 'wordpress';
    }elseif(preg_match('/wp-windowsphone/i',$useragent)){
        $btitle = 'wp-windowsphone';
        $bcode = 'wordpress';
    }elseif(preg_match('/YaBrowser/i',$useragent)){
        $btitle = 'Yandex Browser';
        $bcode = 'yandex';
    }elseif(preg_match('#Edge/([a-zA-Z0-9.]+)#i',$useragent,$matches)&&preg_match('/Chrome/i',$useragent)&&preg_match('/Safari/i',$useragent)){
        $btitle = 'Microsoft Edge';
        $bcode = 'msedge12';
    }elseif(preg_match('#Chrome/([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'Google Chrome';
        $bcode = 'chrome';
    }elseif(preg_match('/Safari/i',$useragent)&&!preg_match('/Nokia/i',$useragent)){
        $btitle = 'Safari';
        $bcode = 'safari';
    }elseif(preg_match('/Nokia/i',$useragent)){
        $btitle = 'Nokia Web Browser';
        $bcode = 'maemo';
    }elseif(preg_match('#(Firefox|Phoenix|Firebird|BonEcho|GranParadiso|Minefield|Iceweasel)/([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'Firefox';
        $bcode = 'firefox';
    }elseif(preg_match('#360([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = '360Safe Explorer';
        $bcode = '360se';
    }elseif(preg_match('/baidubrowser/i',$useragent)){
        $btitle = 'Baidu Browser';
        $bcode = 'baidubrowser';
    }elseif(preg_match('/\ Spark/i',$useragent)){
        $btitle = 'Baidu Spark';
        $bcode = 'baiduspark';
    }elseif(preg_match('/MSIE/i',$useragent)||preg_match('/Trident/i',$useragent)){
        $btitle = 'Internet Explorer';
        $bcode = 'msie';
    }
    if($title&&$btitle){
        if(kratos_option('owo_out')) $uapic = 'https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@'.KRATOS_VERSION; else $uapic = get_bloginfo('template_directory');
        return '<div class="useragent"><img src="'.$uapic.'/static/images/ua/'.$bcode.'.png" style="margin-top:-3px;width:16px;height:16px"> '.$btitle.' <img src="'.$uapic.'/static/images/ua/'.$code.'.png" style="margin-left:5px;margin-top:-3px;width:16px;height:16px"> '.$title.' '.$version.'</div>';
    }else return null;
}
function user_agent_display_comment(){
    global $comment;
    remove_filter('comment_text','user_agent');
    apply_filters('get_comment_text',$comment->comment_content);
    if(empty($_POST['comment_post_ID'])||is_admin()) echo convert_smilies(apply_filters('get_comment_text',$comment->comment_content));
}
function user_agent(){
    echo user_agent_show();
    user_agent_display_comment();
    add_filter('comment_text','user_agent');
}
add_filter('comment_text','user_agent');