<?php
if(!kratos_option('comment_ua')) return;
function user_agent_show(){
    global $comment;
    $useragent = $comment->comment_agent;
    $title = 'Unknown';
    $version = null;
    $code = 'null';
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
	}elseif (preg_match('/[^M]SIE/i',$useragent)){
		$title = 'BenQ-Siemens';
		if(preg_match('/[^M]SIE-([.0-9a-zA-Z]+)\//i',$useragent,$regmatch)) $version = $regmatch[1];
		$code = 'benq-siemens';
	}elseif(preg_match('/BlackBerry/i',$useragent)){
		$title = 'BlackBerry';
		if(preg_match('/blackberry([.0-9a-zA-Z]+)\//i', $useragent, $regmatch)) $version = $regmatch[1];
		$code = 'blackberry';
	}elseif(preg_match('/Dell Mini 5/i',$useragent)){
		$title = 'Dell Mini 5';
		$code = 'dell';
	}elseif(preg_match('/Dell Streak/i',$useragent)){
		$title = 'Dell Streak';
		$code = 'dell';
	}elseif(preg_match('/Dell/i',$useragent)){
		$title = 'Dell';
		$code = 'dell';
	}elseif(preg_match('/Nexus One/i',$useragent)){
		$title = 'Nexus One';
		$code = 'google-nexusone';
	}elseif(preg_match('/Desire/i',$useragent)){
		$title = 'HTC Desire';
		$code = 'htc';
	}elseif(preg_match('/Rhodium/i',$useragent)||preg_match('/HTC[_|\ ]Touch[_|\ ]Pro2/i',$useragent)||preg_match('/WMD-50433/i',$useragent)){
		$title = 'HTC Touch Pro2';
		$code = 'htc';
	}elseif(preg_match('/HTC[_|\ ]Touch[_|\ ]Pro/i',$useragent)){
		$title = 'HTC Touch Pro';
		$code = 'htc';
	}elseif(preg_match('/HTC/i',$useragent)){
		$title = 'HTC';
		if(preg_match('/HTC[\ |_|-]8500/i',$useragent)) $title .= ' Startrek';
		elseif(preg_match('/HTC[\ |_|-]Hero/i',$useragent)) $title .= ' Hero';
		elseif(preg_match('/HTC[\ |_|-]Legend/i',$useragent)) $title .= ' Legend';
		elseif(preg_match('/HTC[\ |_|-]Magic/i',$useragent)) $title .= ' Magic';
		elseif(preg_match('/HTC[\ |_|-]P3450/i',$useragent)) $title .= ' Touch';
		elseif(preg_match('/HTC[\ |_|-]P3650/i',$useragent)) $title .= ' Polaris';
		elseif(preg_match('/HTC[\ |_|-]S710/i',$useragent)) $title .= ' S710';
		elseif(preg_match('/HTC[\ |_|-]Tattoo/i',$useragent)) $title .= ' Tattoo';
		elseif(preg_match('/HTC[\ |_|-]?([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $title .= ' '.$regmatch[1];
		elseif(preg_match('/HTC([._0-9a-zA-Z]+)/i',$useragent,$regmatch)) $title .= str_replace('_',' ',$regmatch[1]);
		$code = 'htc';
	}elseif(preg_match('/Kindle/i',$useragent)){
		$title = 'Kindle';
		if(preg_match('/Kindle\/([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
		$code = 'kindle';
	}elseif(preg_match('/LG/i',$useragent)){
		$title = 'LG';
		if(preg_match('/LG[E]?[\ |-|\/]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
		$code = 'lg';
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
	}elseif(preg_match('/Xbox/i',$useragent)){
		$title = 'Xbox';
		$code = 'xbox';
		if(preg_match('/Xbox360/i',$useragent,$regmatch)||preg_match('/Xbox 360/i',$useragent,$regmatch)){
			$title .= ' 360';
			$code = 'xbox';
		}elseif(preg_match('/XboxOne/i',$useragent,$regmatch)||preg_match('/XboxOne/i',$useragent,$regmatch)){
			$title .= ' One';
			$code = 'xboxone';
		}
	}elseif(preg_match('/\ Droid/i',$useragent)){
		$title = 'Motorola Droid';
		$code = 'motorola';
	}elseif(preg_match('/XT720/i',$useragent)){
		$title = 'Motorola Motoroi (XT720)';
		$code = 'motorola';
	}elseif(preg_match('/MOT-/i',$useragent)||preg_match('/MIB/i',$useragent)){
		$title = 'Motorola';
		if(preg_match('/MOTO([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
		if(preg_match('/MOT-([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
		$code = 'motorola';
	}elseif(preg_match('/XOOM/i',$useragent)){
		$title = 'Motorola Xoom';
		$code = 'motorola';
	}elseif(preg_match('/Nintendo/i',$useragent)){
		$title = 'Nintendo';
		if(preg_match('/Nintendo 3DS/i',$useragent)){
			$title .= ' 3DS';
			$code = 'nintendods';
		}elseif (preg_match('/Nintendo DSi/i',$useragent)){
			$title .= ' DSi';
			$code = 'nintendodsi';
		}elseif (preg_match('/Nintendo DS/i',$useragent)){
			$title .= ' DS';
			$code = 'nintendods';
		}elseif (preg_match('/Nintendo WiiU/i',$useragent)){
			$title .= ' Wii U';
			$code = 'nintendowiiu';
		}elseif (preg_match('/Nintendo Wii/i',$useragent)){
			$title .= ' Wii';
			$code = 'nintendowii';
		}else $code = 'nintendo';
	}elseif(preg_match('/Nokia/i',$useragent)&&!preg_match('/S(eries)?60/i',$useragent)){
		$title = 'Nokia';
		if(preg_match('/Nokia(E|N)?([0-9]+)/i',$useragent,$regmatch)) $title .= ' '.$regmatch[1].$regmatch[2];
		$code = 'nokia';
	}elseif(preg_match('/S(eries)?60/i',$useragent)){
		$title = 'Nokia Series60';
		$code = 'nokia';
	}elseif(preg_match('/OLPC/i',$useragent)){
		$title = 'OLPC (XO)';
		$code = 'olpc';
	}elseif(preg_match('/\ Pixi\//i',$useragent)){
		$title = 'Palm Pixi';
		$code = 'palm';
	}elseif(preg_match('/\ Pre\//i',$useragent)){
		$title = 'Palm Pre';
		$code = 'palm';
	}elseif(preg_match('/Palm/i',$useragent)){
		$title = 'Palm';
		$code = 'palm';
	}elseif(preg_match('/wp-webos/i',$useragent)){
		$title = 'Palm';
		$code = 'palm';
	}elseif(preg_match('/PlayStation/i',$useragent)){
		$title = 'PlayStation';
		if(preg_match('/[PS|PlayStation\ ]3/i',$useragent)) $title .= ' 3';
		elseif(preg_match('/[PS|PlayStation\ ]4/i',$useragent)) $title .= ' 4';
		elseif(preg_match('/[PlayStation Portable|PSP]/i',$useragent)) $title .= ' Portable';
		elseif(preg_match('/[PlayStation Vita|PSVita]/i',$useragent)) $title .= ' Vita';
		$code = 'playstation';
	}elseif(preg_match('/Galaxy Nexus/i',$useragent)){
		$title = 'Galaxy Nexus';
		$code = 'samsung';
	}elseif(preg_match('/SmartTV/i',$useragent)){
		$title = 'Samsung Smart TV';
		$code = 'samsung';
	}elseif(preg_match('/Samsung/i',$useragent)){
		$title = 'Samsung';
		if(preg_match('/Samsung-([.\-0-9a-zA-Z]+)/i',$useragent,$regmatch)) $title .= ' '.$regmatch[1];
		$code = 'samsung';
	}elseif(preg_match('/SonyEricsson/i',$useragent)){
		$title = 'Sony Ericsson';
		if(preg_match('/SonyEricsson([.0-9a-zA-Z]+)/i',$useragent,$regmatch)){
			if (strtolower($regmatch[1])===strtolower('U20i')){
				$title .= ' Xperia X10 Mini Pro';
			}else{
				$title .= ' '.$regmatch[1];
			}
		}
		$code = 'sonyericsson';
	}elseif (preg_match('/Ubuntu\;\ Mobile/i',$useragent)){
		$title = 'Ubuntu Phone';
		$code = 'ubuntutouch';
	}elseif (preg_match('/Ubuntu\;\ Tablet/i',$useragent)){
		$title = 'Ubuntu Tablet';
		$code = 'ubuntutouch';
	}elseif(preg_match('/wp-windowsphone/i',$useragent)){
		$title = 'Windows Phone';
		$code = 'windowsphone';
	}elseif(preg_match('/AmigaOS/i',$useragent)){
        $title = 'AmigaOS';
        if(preg_match('/AmigaOS\ ([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'amigaos';
    }elseif(preg_match('/Android/i',$useragent)){
        $title = 'Android';
        if(preg_match('/Android[\ |\/]?([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'android';
    }elseif(preg_match('/[^A-Za-z]Arch/i',$useragent)){
        $title = 'Arch Linux';
        $code = 'archlinux';
    }elseif(preg_match('/BeOS/i',$useragent)){
        $title = 'BeOS';
        $code = 'beos';
    }elseif(preg_match('/CentOS/i',$useragent)){
        $title = 'CentOS';
        if(preg_match('/.el([.0-9a-zA-Z]+).centos/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'centos';
    }elseif(preg_match('/Chakra/i',$useragent)){
        $title = 'Chakra Linux';
        $code = 'chakra';
    }elseif(preg_match('/CrOS/i',$useragent)){
        $title = 'Google Chrome OS';
        $code = 'chromeos';
    }elseif(preg_match('/Crunchbang/i',$useragent)){
        $title = 'Crunchbang';
        $code = 'crunchbang';
    }elseif(preg_match('/Debian/i',$useragent)){
        $title = 'Debian GNU/Linux';
        $code = 'debian';
    }elseif(preg_match('/DragonFly/i',$useragent)){
        $title = 'DragonFly BSD';
        $code = 'dragonflybsd';
    }elseif(preg_match('/Edubuntu/i',$useragent)){
        $title = 'Edubuntu';
        if(preg_match('/Edubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if($regmatch[1] < 10){
            $code = 'edubuntu-1';
        }else{
            $code = 'edubuntu-2';
        }
    }elseif(preg_match('/Fedora/i',$useragent)){
        $title = 'Fedora';
        if(preg_match('/.fc([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'fedora';
    }elseif(preg_match('/Foresight\ Linux/i',$useragent)){
        $title = 'Foresight Linux';
        if (preg_match('/Foresight\ Linux\/([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'foresight';
    }elseif(preg_match('/FreeBSD/i',$useragent)){
        $title = 'FreeBSD';
        $code = 'freebsd';
    }elseif(preg_match('/Gentoo/i',$useragent)){
        $title = 'Gentoo';
        $code = 'gentoo';
    }elseif(preg_match('/Inferno/i',$useragent)){
        $title = 'Inferno';
        $code = 'inferno';
    }elseif(preg_match('/IRIX/i',$useragent)){
        $title = 'IRIX Linux';
        if(preg_match('/IRIX(64)?\ ([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[2];
        $code = 'irix';
    }elseif(preg_match('/Kanotix/i',$useragent)){
        $title = 'Kanotix';
        $code = 'kanotix';
    }elseif(preg_match('/Knoppix/i',$useragent)){
        $title = 'Knoppix';
        $code = 'knoppix';
    }elseif(preg_match('/Kubuntu/i',$useragent)){
        $title = 'Kubuntu';
        if(preg_match('/Kubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if($regmatch[1] < 10){
            $code = 'kubuntu-1';
        }else{
            $code = 'kubuntu-2';
        }
    }elseif(preg_match('/LindowsOS/i',$useragent)){
        $title = 'LindowsOS';
        $code = 'lindowsos';
    }elseif(preg_match('/Linspire/i',$useragent)){
        $title = 'Linspire';
        $code = 'lindowsos';
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
    }elseif(preg_match('/Mageia/i',$useragent)){
        $title = 'Mageia';
        $code = 'mageia';
    }elseif(preg_match('/Mandriva/i',$useragent)){
        $title = 'Mandriva';
        if (preg_match('/mdv([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'mandriva';
    }elseif(preg_match('/moonOS/i',$useragent)){
        $title = 'moonOS';
        if(preg_match('/moonOS\/([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'moonos';
    }elseif(preg_match('/MorphOS/i',$useragent)){
        $title = 'MorphOS';
        $code = 'morphos';
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
    }elseif(preg_match('/Oracle/i',$useragent)){
        $title = 'Oracle';
        if(preg_match('/.el([._0-9a-zA-Z]+)/i',$useragent,$regmatch)){
            $title .= ' Enterprise Linux';
            $version = str_replace('_','.',$regmatch[1]);
        }else{
            $title .= ' Linux';
        }

        $code = 'oracle';
    }elseif(preg_match('/Pardus/i',$useragent)){
        $title = 'Pardus';
        $code = 'pardus';
    }elseif(preg_match('/PCLinuxOS/i',$useragent)){
        $title = 'PCLinuxOS';
        if(preg_match('/PCLinuxOS\/[.\-0-9a-zA-Z]+pclos([.\-0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = str_replace('_', '.', $regmatch[1]);
        $code = 'pclinuxos';
    }elseif(preg_match('/Red\ Hat/i',$useragent)||preg_match('/RedHat/i',$useragent)){
        $title = 'Red Hat';
        if(preg_match('/.el([._0-9a-zA-Z]+)/i',$useragent,$regmatch)){
            $title .= ' Enterprise Linux';
            $version = str_replace('_','.',$regmatch[1]);
        }
        $code = 'red-hat';
    }elseif(preg_match('/Rosa/i',$useragent)){
        $title = 'Rosa Linux';
        $code = 'rosa';
    }elseif(preg_match('/Sabayon/i',$useragent)){
        $title = 'Sabayon Linux';
        $code = 'sabayon';
    }elseif(preg_match('/Slackware/i',$useragent)){
        $title = 'Slackware';
        $code = 'slackware';
    }elseif(preg_match('/Solaris/i',$useragent)){
        $title = 'Solaris';
        $code = 'solaris';
    }elseif(preg_match('/SunOS/i',$useragent)){
        $title = 'Solaris';
        $code = 'solaris';
    }elseif(preg_match('/Suse/i',$useragent)){
        $title = 'openSUSE';
        $code = 'suse';
    }elseif(preg_match('/Symb[ian]?[OS]?/i',$useragent)){
        $title = 'SymbianOS';
        if(preg_match('/Symb[ian]?[OS]?\/([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        $code = 'symbianos';
    }elseif(preg_match('/Xandros/i',$useragent)){
        $title = 'Xandros';
        $code = 'xandros';
    }elseif(preg_match('/Xubuntu/i',$useragent)){
        $title = 'Xubuntu';
        if(preg_match('/Xubuntu[\/|\ ]([.0-9a-zA-Z]+)/i',$useragent,$regmatch)) $version = $regmatch[1];
        if ($regmatch[1] < 10){
            $code = 'xubuntu-1';
        }else{
            $code = 'xubuntu-2';
        }
    }elseif(preg_match('/Zenwalk/i',$useragent)){
        $title = 'Zenwalk GNU Linux';
        $code = 'zenwalk';
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
    }elseif(preg_match('/VectorLinux/i',$useragent)){
        $title = 'VectorLinux';
        $code = 'vectorlinux';
    }elseif(preg_match('/Venenux/i',$useragent)){
        $title = 'Venenux GNU Linux';
        $code = 'venenux';
    }elseif(preg_match('/webOS/i',$useragent)){
        $title = 'Palm webOS';
        $code = 'palm';
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
    $btitle = 'Unknown';
    $bversion = null;
    $bcode = 'null';
    if(preg_match('#360([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = '360Safe Explorer';
        $bversion = $matches[1];
        $bcode = '360se';
    }elseif(preg_match('/Abolimba/i',$useragent)){
        $btitle = 'Abolimba';
        $bcode = 'abolimba';
    }elseif(preg_match('/Acoo\ Browser/i',$useragent)){
        $btitle = 'Acoo Browser';
        $bcode = 'acoobrowser';
    }elseif(preg_match('/Alienforce/i',$useragent)){
        $btitle = 'Alienforce';
        $bcode = 'alienforce';
    }elseif(preg_match('/Amaya/i',$useragent)){
        $btitle = 'Amaya';
        $bcode = 'amaya';
    }elseif(preg_match('/Amiga-AWeb/i',$useragent)){
        $btitle = 'Amiga AWeb';
        $bcode = 'amiga-aweb';
    }elseif(preg_match('/MRCHROME/i',$useragent)){
        $btitle = 'Amigo';
        $bcode = 'amigo';
    }elseif(preg_match('/America\ Online\ Browser/i',$useragent)){
        $btitle = 'America Online Browser';
        $bcode = 'aol';
    }elseif(preg_match('/AmigaVoyager/i',$useragent)){
        $btitle = 'Amiga Voyager';
        $bcode = 'amigavoyager';
    }elseif(preg_match('/ANTFresco/i',$useragent)){
        $btitle = 'ANT Fresco';
        $bcode = 'antfresco';
    }elseif(preg_match('/AOL/i',$useragent)){
        $btitle = 'AOL';
        $bcode = 'aol';
    }elseif(preg_match('/Arora/i',$useragent)){
        $btitle = 'Arora';
        $bcode = 'arora';
    }elseif(preg_match('/AtomicBrowser/i',$useragent)){
        $btitle = 'Atomic Web Browser';
        $bcode = 'atomicwebbrowser';
    }elseif(preg_match('/Avant\ Browser/i',$useragent)){
        $btitle = 'Avant Browser';
        $bcode = 'avantbrowser';
    }elseif(preg_match('/WhiteHat\ Aviator/i',$useragent)){
        $btitle = 'Aviator';
        $bcode = 'aviator';
    }elseif(preg_match('/baidubrowser/i',$useragent)){
        $btitle = 'Baidu Browser';
        $bcode = 'baidubrowser';
    }elseif(preg_match('/\ Spark/i',$useragent)){
        $btitle = 'Baidu Spark';
        $bcode = 'baiduspark';
    }elseif(preg_match('/BarcaPro/i',$useragent)){
        $btitle = 'Barca Pro';
        $bcode = 'barca';
    }elseif(preg_match('/Barca/i',$useragent)){
        $btitle = 'Barca';
        $bcode = 'barca';
    }elseif(preg_match('/Beamrise/i',$useragent)){
        $btitle = 'Beamrise';
        $bcode = 'beamrise';
    }elseif(preg_match('/Beonex/i',$useragent)){
        $btitle = 'Beonex';
        $bcode = 'beonex';
    }elseif(preg_match('/BlackBerry/i',$useragent)){
        $btitle = 'BlackBerry';
        $bcode = 'blackberry';
    }elseif(preg_match('/Blackbird/i',$useragent)){
        $btitle = 'Blackbird';
        $bcode = 'blackbird';
    }elseif(preg_match('/BlackHawk/i',$useragent)){
        $btitle = 'BlackHawk';
        $bcode = 'blackhawk';
    }elseif(preg_match('/Blazer/i',$useragent)){
        $btitle = 'Blazer';
        $bcode = 'blazer';
    }elseif(preg_match('/Bolt/i',$useragent)){
        $btitle = 'Bolt';
        $bcode = 'bolt';
    }elseif(preg_match('/BonEcho/i',$useragent)){
        $btitle = 'BonEcho';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/BrowseX/i',$useragent)){
        $btitle = 'BrowseX';
        $bcode = 'browsex';
    }elseif(preg_match('/Browzar/i',$useragent)){
        $btitle = 'Browzar';
        $bcode = 'browzar';
    }elseif(preg_match('/Bunjalloo/i',$useragent)){
        $btitle = 'Bunjalloo';
        $bcode = 'bunjalloo';
    }elseif(preg_match('#(Camino|Chimera)[ /]([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'Camino';
        $bversion = $matches[2];
        $bcode = 'camino';
    }elseif(preg_match('/Cayman\ Browser/i',$useragent)){
        $btitle = 'Cayman Browser';
        $bcode = 'caymanbrowser';
    }elseif(preg_match('/Charon/i',$useragent)){
        $btitle = 'Charon';
        $bcode = 'null';
    }elseif(preg_match('/Cheshire/i',$useragent)){
        $btitle = 'Cheshire';
        $bcode = 'aol';
    }elseif(preg_match('/Chimera/i',$useragent)){
        $btitle = 'Chimera';
        $bcode = 'null';
    }elseif(preg_match('/chromeframe/i',$useragent)){
        $btitle = 'Google Chrome Frame';
        $bcode = 'google';
    }elseif(preg_match('/ChromePlus/i',$useragent)){
        $btitle = 'ChromePlus';
        $bcode = 'chromeplus';
    }elseif(preg_match('/Iron/i',$useragent)){
        $btitle = 'SRWare Iron';
        $bcode = 'srwareiron';
    }elseif(preg_match('/Chromium/i',$useragent)){
        $btitle = 'Chromium';
        $bcode = 'chromium';
    }elseif(preg_match('/Classilla/i',$useragent)){
        $btitle = 'Classilla';
        $bcode = 'classilla';
    }elseif(preg_match('/Coast/i',$useragent)){
        $btitle = 'Coast';
        $bcode = 'coast';
    }elseif(preg_match('/coc_coc_browser/i',$useragent)){
        $btitle = 'Coc Coc';
        $bcode = 'coccoc';
    }elseif(preg_match('/Columbus/i',$useragent)){
        $btitle = 'Columbus';
        $bcode = 'columbus';
    }elseif(preg_match('/CometBird/i',$useragent)){
        $btitle = 'CometBird';
        $bcode = 'cometbird';
    }elseif(preg_match('/Comodo_Dragon/i',$useragent)){
        $btitle = 'Comodo Dragon';
        $bcode = 'comodo-dragon';
    }elseif(preg_match('/Conkeror/i',$useragent)){
        $btitle = 'Conkeror';
        $bcode = 'conkeror';
    }elseif(preg_match('/CoolNovo/i',$useragent)){
        $btitle = 'CoolNovo';
        $bcode = 'coolnovo';
    }elseif(preg_match('/CoRom/i',$useragent)){
        $btitle = 'CoRom';
        $bcode = 'corom';
    }elseif(preg_match('/Crazy\ Browser/i',$useragent)){
        $btitle = 'Crazy Browser';
        $bcode = 'crazybrowser';
    }elseif(preg_match('/CrMo/i',$useragent)){
        $btitle = 'Chrome Mobile';
        $bcode = 'chrome';
    }elseif(preg_match('/CriOS/i',$useragent)){
        $btitle = 'Chrome';
        $bcode = 'chrome';
    }elseif(preg_match('/Cruz/i',$useragent)){
        $btitle = 'Cruz';
        $bcode = 'cruz';
    }elseif(preg_match('/Cyberdog/i',$useragent)){
        $btitle = 'Cyberdog';
        $bcode = 'cyberdog';
    }elseif(preg_match('/Deepnet\ Explorer/i',$useragent)){
        $btitle = 'Deepnet Explorer';
        $bcode = 'deepnetexplorer';
    }elseif(preg_match('/Demeter/i',$useragent)){
        $btitle = 'Demeter';
        $bcode = 'demeter';
    }elseif(preg_match('/DeskBrowse/i',$useragent)){
        $btitle = 'DeskBrowse';
        $bcode = 'deskbrowse';
    }elseif(preg_match('/Dillo/i',$useragent)){
        $btitle = 'Dillo';
        $bcode = 'dillo';
    }elseif(preg_match('/DoCoMo/i',$useragent)){
        $btitle = 'DoCoMo';
        $bcode = 'null';
    }elseif(preg_match('/DocZilla/i',$useragent)){
        $btitle = 'DocZilla';
        $bcode = 'doczilla';
    }elseif(preg_match('/Dolfin/i',$useragent)){
        $btitle = 'Dolfin';
        $bcode = 'samsung';
    }elseif(preg_match('/Dooble/i',$useragent)){
        $btitle = 'Dooble';
        $bcode = 'dooble';
    }elseif(preg_match('/Doris/i',$useragent)){
        $btitle = 'Doris';
        $bcode = 'doris';
    }elseif(preg_match('/Dorothy/i',$useragent)){
        $btitle = 'Dorothy';
        $bcode = 'dorothybrowser';
    }elseif(preg_match('/DPlus/i',$useragent)){
        $btitle = 'D+';
        $bcode = 'dillo';
    }elseif(preg_match('/Edbrowse/i',$useragent)){
        $btitle = 'Edbrowse';
        $bcode = 'edbrowse';
    }elseif(preg_match('/Element\ Browser/i',$useragent)){
        $btitle = 'Element Browser';
        $bcode = 'elementbrowser';
    }elseif(preg_match('/Elinks/i',$useragent)){
        $btitle = 'Elinks';
        $bcode = 'elinks';
    }elseif(preg_match('/Enigma\ Browser/i',$useragent)){
        $btitle = 'Enigma Browser';
        $bcode = 'enigmabrowser';
    }elseif(preg_match('/EnigmaFox/i',$useragent)){
        $btitle = 'EnigmaFox';
        $bcode = 'null';
    }elseif(preg_match('/Epic/i',$useragent)){
        $btitle = 'Epic';
        $bcode = 'epicbrowser';
    }elseif(preg_match('/Epiphany/i',$useragent)){
        $btitle = 'Epiphany';
        $bcode = 'epiphany';
    }elseif(preg_match('/Escape/i',$useragent)){
        $btitle = 'Espial TV Browser';
        $bcode = 'espialtvbrowser';
    }elseif(preg_match('/Espial/i',$useragent)){
        $btitle = 'Espial TV Browser';
        $bcode = 'espialtvbrowser';
    }elseif(preg_match('/Fennec/i',$useragent)){
        $btitle = 'Fennec';
        $bcode = 'fennec';
    }elseif(preg_match('/Firebird/i',$useragent)){
        $btitle = 'Firebird';
        $bcode = 'firebird';
    }elseif(preg_match('/Fireweb\ Navigator/i',$useragent)){
        $btitle = 'Fireweb Navigator';
        $bcode = 'firewebnavigator';
    }elseif(preg_match('/Flock/i',$useragent)){
        $btitle = 'Flock';
        $bcode = 'flock';
    }elseif(preg_match('/Fluid/i',$useragent)){
        $btitle = 'Fluid';
        $bcode = 'fluid';
    }elseif(preg_match('/Galaxy/i',$useragent)&&!preg_match('/Chrome/i',$useragent)){
        $btitle = 'Galaxy';
        $bcode = 'galaxy';
    }elseif(preg_match('/Galeon/i',$useragent)){
        $btitle = 'Galeon';
        $bcode = 'galeon';
    }elseif(preg_match('/GlobalMojo/i',$useragent)){
        $btitle = 'GlobalMojo';
        $bcode = 'globalmojo';
    }elseif(preg_match('/GoBrowser/i',$useragent)){
        $btitle = 'GO Browser';
        $bcode = 'gobrowser';
    }elseif(preg_match('/Google\ Wireless\ Transcoder/i',$useragent)){
        $btitle = 'Google Wireless Transcoder';
        $bcode = 'google';
    }elseif(preg_match('/GoSurf/i',$useragent)){
        $btitle = 'GoSurf';
        $bcode = 'gosurf';
    }elseif(preg_match('/GranParadiso/i',$useragent)){
        $btitle = 'GranParadiso';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/GreenBrowser/i',$useragent)){
        $btitle = 'GreenBrowser';
        $bcode = 'greenbrowser';
    }elseif(preg_match('/GSA/i',$useragent)&&preg_match('/Mobile/i',$useragent)){
        $btitle = 'Google Search App';
        $bcode = 'google';
    }elseif(preg_match('/Hana/i',$useragent)){
        $btitle = 'Hana';
        $bcode = 'hana';
    }elseif(preg_match('/HotJava/i',$useragent)){
        $btitle = 'HotJava';
        $bcode = 'hotjava';
    }elseif(preg_match('/Hv3/i',$useragent)){
        $btitle = 'Hv3';
        $bcode = 'hv3';
    }elseif(preg_match('/Hydra\ Browser/i',$useragent)){
        $btitle = 'Hydra Browser';
        $bcode = 'hydrabrowser';
    }elseif(preg_match('/Iris/i',$useragent)){
        $btitle = 'Iris';
        $bcode = 'iris';
    }elseif(preg_match('/IBM\ WebExplorer/i',$useragent)){
        $btitle = 'IBM WebExplorer';
        $bcode = 'ibmwebexplorer';
    }elseif(preg_match('/IBrowse/i',$useragent)&&!preg_match('/MiuiBrowser/i',$useragent)){
        $btitle = 'IBrowse';
        $bcode = 'ibrowse';
    }elseif(preg_match('/iCab/i',$useragent)){
        $btitle = 'iCab';
        $bcode = 'icab';
    }elseif(preg_match('/Ice Browser/i',$useragent)){
        $btitle = 'Ice Browser';
        $bcode = 'icebrowser';
    }elseif(preg_match('/Iceape/i',$useragent)){
        $btitle = 'Iceape';
        $bcode = 'iceape';
    }elseif(preg_match('/IceCat/i',$useragent)){
        $btitle = 'GNU IceCat';
        $bcode = 'icecat';
    }elseif(preg_match('/IceDragon/i',$useragent)){
        $btitle = 'IceDragon';
        $bcode = 'icedragon';
    }elseif(preg_match('/IceWeasel/i',$useragent)){
        $btitle = 'IceWeasel';
        $bcode = 'iceweasel';
    }elseif(preg_match('/IEMobile/i',$useragent)){
        $btitle = 'IEMobile';
        $bcode = 'msie-mobile';
    }elseif(preg_match('/iNet\ Browser/i',$useragent)){
        $btitle = 'iNet Browser';
        $bcode = 'null';
    }elseif(preg_match('/iRider/i',$useragent)){
        $btitle = 'iRider';
        $bcode = 'irider';
    }elseif(preg_match('/Iron/i',$useragent)){
        $btitle = 'Iron';
        $bcode = 'iron';
    }elseif(preg_match('/InternetSurfboard/i',$useragent)){
        $btitle = 'InternetSurfboard';
        $bcode = 'internetsurfboard';
    }elseif(preg_match('/Jasmine/i',$useragent)){
        $btitle = 'Jasmine';
        $bcode = 'samsung';
    }elseif(preg_match('/K-Meleon/i',$useragent)){
        $btitle = 'K-Meleon';
        $bcode = 'kmeleon';
    }elseif(preg_match('/K-Ninja/i',$useragent)){
        $btitle = 'K-Ninja';
        $bcode = 'kninja';
    }elseif(preg_match('/Kapiko/i',$useragent)){
        $btitle = 'Kapiko';
        $bcode = 'kapiko';
    }elseif(preg_match('/Kazehakase/i',$useragent)){
        $btitle = 'Kazehakase';
        $bcode = 'kazehakase';
    }elseif(preg_match('/Kinza/i',$useragent)){
        $btitle = 'Kinza';
        $bcode = 'kinza';
    }elseif(preg_match('/Strata/i',$useragent)){
        $btitle = 'Kirix Strata';
        $bcode = 'kirix-strata';
    }elseif(preg_match('/KKman/i',$useragent)){
        $btitle = 'KKman';
        $bcode = 'kkman';
    }elseif(preg_match('/KMail/i',$useragent)){
        $btitle = 'KMail';
        $bcode = 'kmail';
    }elseif(preg_match('/KMLite/i',$useragent)){
        $btitle = 'KMLite';
        $bcode = 'kmeleon';
    }elseif(preg_match('/Konqueror/i',$useragent)){
        $btitle = 'Konqueror';
        $bcode = 'konqueror';
    }elseif(preg_match('/Kylo/i',$useragent)){
        $btitle = 'Kylo';
        $bcode = 'kylo';
    }elseif(preg_match('/LBrowser/i',$useragent)){
        $btitle = 'LBrowser';
        $bcode = 'lbrowser';
    }elseif(preg_match('/LG Browser/i',$useragent)){
        $btitle = 'LG Web Browser';
        $bcode = 'lgbrowser';
    }elseif(preg_match('/LeechCraft/i',$useragent)){
        $btitle = 'LeechCraft';
        $bcode = 'null';
    }elseif(preg_match('/Links/i',$useragent)&&!preg_match('/online\ link\ validator/i',$useragent)){
        $btitle = 'Links';
        $bcode = 'links';
    }elseif(preg_match('/Lobo/i',$useragent)){
        $btitle = 'Lobo';
        $bcode = 'lobo';
    }elseif(preg_match('/lolifox/i',$useragent)){
        $btitle = 'lolifox';
        $bcode = 'lolifox';
    }elseif(preg_match('/Lorentz/i',$useragent)){
        $btitle = 'Lorentz';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/luakit/i',$useragent)){
        $btitle = 'luakit';
        $bcode = 'luakit';
    }elseif(preg_match('/Lunascape/i',$useragent)){
        $btitle = 'Lunascape';
        $bcode = 'lunascape';
    }elseif(preg_match('/Lynx/i',$useragent)){
        $btitle = 'Lynx';
        $bcode = 'lynx';
    }elseif(preg_match('/Madfox/i',$useragent)){
        $btitle = 'Madfox';
        $bcode = 'madfox';
    }elseif(preg_match('/Maemo\ Browser/i',$useragent)){
        $btitle = 'Maemo Browser';
        $bcode = 'maemo';
    }elseif(preg_match('/Maxthon/i',$useragent)){
        $btitle = 'Maxthon';
        $bcode = 'maxthon';
    }elseif(preg_match('/\ MIB\//i',$useragent)){
        $btitle = 'MIB';
        $bcode = 'mib';
    }elseif(preg_match('/Tablet\ browser/i',$useragent)){
        $btitle = 'MicroB';
        $bcode = 'microb';
    }elseif(preg_match('/Midori/i',$useragent)){
        $btitle = 'Midori';
        $bcode = 'midori';
    }elseif(preg_match('/ min\//i',$useragent)){
        $btitle = 'Min Browser';
        $bcode = 'min';
    }elseif(preg_match('/Minefield/i',$useragent)){
        $btitle = 'Minefield';
        $bcode = 'minefield';
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
    }elseif(preg_match('/Multi-Browser/i',$useragent)){
        $btitle = 'Multi-Browser XP';
        $bcode = 'multi-browserxp';
    }elseif(preg_match('/MultiZilla/i',$useragent)){
        $btitle = 'MultiZilla';
        $bcode = 'mozilla';
    }elseif(preg_match('/MxNitro/i',$useragent)){
        $btitle = 'MxNitro';
        $bcode = 'mxnitro';
    }elseif(preg_match('/myibrow/i',$useragent)&&preg_match('/My\ Internet\ Browser/i',$useragent)){
        $btitle = 'myibrow';
        $bcode = 'my-internet-browser';
    }elseif(preg_match('/MyIE2/i',$useragent)){
        $btitle = 'MyIE2';
        $bcode = 'myie2';
    }elseif(preg_match('/Namoroka/i',$useragent)){
        $btitle = 'Namoroka';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/Navigator/i',$useragent)){
        $btitle = 'Netscape Navigator';
        $bcode = 'netscape';
    }elseif(preg_match('/NetBox/i',$useragent)){
        $btitle = 'NetBox';
        $bcode = 'netbox';
    }elseif(preg_match('/NetCaptor/i',$useragent)){
        $btitle = 'NetCaptor';
        $bcode = 'netcaptor';
    }elseif(preg_match('/NetFrontLifeBrowser/i',$useragent)){
        $btitle = 'NetFront Life';
        $bcode = 'netfrontlife';
    }elseif(preg_match('/NetFront/i',$useragent)){
        $btitle = 'NetFront';
        $bcode = 'netfront';
    }elseif(preg_match('/NetNewsWire/i',$useragent)){
        $btitle = 'NetNewsWire';
        $bcode = 'netnewswire';
    }elseif(preg_match('/NetPositive/i',$useragent)){
        $btitle = 'NetPositive';
        $bcode = 'netpositive';
    }elseif(preg_match('/Netscape/i',$useragent)){
        $btitle = 'Netscape';
        $bcode = 'netscape';
    }elseif(preg_match('/NetSurf/i',$useragent)){
        $btitle = 'NetSurf';
        $bcode = 'netsurf';
    }elseif(preg_match('/NF-Browser/i',$useragent)){
        $btitle = 'NetFront';
        $bcode = 'netfront';
    }elseif(preg_match('/Ninesky-android-mobile/i',$useragent)){
        $btitle = 'Ninesky';
        $bcode = 'ninesky';
    }elseif(preg_match('/Nintendo 3DS/i',$useragent)){
        $btitle = 'Nintendo 3DS';
        $bcode = 'nintendo3dsbrowser';
    }elseif(preg_match('/NintendoBrowser/i',$useragent)){
        $btitle = 'Nintendo Browser';
        $bcode = 'nintendobrowser';
    }elseif(preg_match('/NokiaBrowser/i',$useragent)){
        $btitle = 'Nokia Browser';
        $bcode = 'nokia';
    }elseif(preg_match('/Novarra-Vision/i',$useragent)){
        $btitle = 'Novarra Vision';
        $bcode = 'novarra';
    }elseif(preg_match('/Obigo/i',$useragent)){
        $btitle = 'Obigo';
        $bcode = 'obigo';
    }elseif(preg_match('/OffByOne/i',$useragent)){
        $btitle = 'Off By One';
        $bcode = 'offbyone';
    }elseif(preg_match('/OmniWeb/i',$useragent)){
        $btitle = 'OmniWeb';
        $bcode = 'omniweb';
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
    }elseif(preg_match('/Orca/i',$useragent)){
        $btitle = 'Orca';
        $bcode = 'orca';
    }elseif(preg_match('/Oregano/i',$useragent)){
        $btitle = 'Oregano';
        $bcode = 'oregano';
    }elseif(preg_match('/Origyn\ Web\ Browser/i',$useragent)){
        $btitle = 'Oregano Web Browser';
        $bcode = 'owb';
    }elseif(preg_match('/osb-browser/i',$useragent)){
        $btitle = 'Gtk+ WebCore';
        $bcode = 'null';
    }elseif(preg_match('/Otter/i',$useragent)){
        $btitle = 'Otter';
        $bcode = 'otter';
    }elseif(preg_match('/\ Pre\//i',$useragent)){
        $btitle = 'Palm';
        $bcode = 'palmpre';
    }elseif(preg_match('/\ WebPro\//i',$useragent)){
        $btitle = 'Palm WebPro';
        $bcode = 'palmwebpro';
    }elseif(preg_match('/Palemoon/i',$useragent)){
        $btitle = 'Pale Moon';
        $bcode = 'palemoon';
    }elseif(preg_match('/Patriott\:\:Browser/i',$useragent)){
        $btitle = 'Patriott Browser';
        $bcode = 'patriott';
    }elseif(preg_match('/Perk/i',$useragent)){
        $btitle = 'Perk';
        $bcode = 'perk';
    }elseif(preg_match('/Phaseout/i',$useragent)){
        $btitle = 'Phaseout';
        $bcode = 'phaseout';
    }elseif(preg_match('/Phoenix/i',$useragent)){
        $btitle = 'Phoenix';
        $bcode = 'phoenix';
    }elseif(preg_match('/PlayStation\ 4/i',$useragent)){
        $btitle = 'PS4 Web Browser';
        $bcode = 'webkit';
    }elseif(preg_match('/Podkicker/i',$useragent)){
        $btitle = 'Podkicker';
        $bcode = 'podkicker';
    }elseif(preg_match('/Podkicker\ Pro/i',$useragent)){
        $btitle = 'Podkicker Pro';
        $bcode = 'podkicker';
    }elseif(preg_match('/Pogo/i',$useragent)){
        $btitle = 'Pogo';
        $bcode = 'pogo';
    }elseif(preg_match('/Polaris/i',$useragent)){
        $btitle = 'Polaris';
        $bcode = 'polaris';
    }elseif(preg_match('/Polarity/i',$useragent)){
        $btitle = 'Polarity';
        $bcode = 'polarity';
    }elseif(preg_match('/Prism/i',$useragent)){
        $btitle = 'Prism';
        $bcode = 'prism';
    }elseif(preg_match('/Puffin/i',$useragent)){
        $btitle = 'Puffin';
        $bcode = 'puffin';
    }elseif(preg_match('/QtWeb\ Internet\ Browser/i',$useragent)){
        $btitle = 'QtWeb Internet Browser';
        $bcode = 'qtwebinternetbrowser';
    }elseif(preg_match('/QupZilla/i',$useragent)){
        $btitle = 'QupZilla';
        $bcode = 'qupzilla';
    }elseif(preg_match('/Nichrome\/self/i',$useragent)){
        $btitle = 'Rambler browser';
        $bcode = 'ramblerbrowser';
    }elseif(preg_match('/rekonq/i',$useragent)){
        $btitle = 'rekonq';
        $bcode = 'rekonq';
    }elseif(preg_match('/retawq/i',$useragent)){
        $btitle = 'retawq';
        $bcode = 'terminal';
    }elseif(preg_match('/Roccat/i',$useragent)){
        $btitle = 'Roccat';
        $bcode = 'roccatbrowser';
    }elseif(preg_match('/RockMelt/i',$useragent)){
        $btitle = 'RockMelt';
        $bcode = 'rockmelt';
    }elseif(preg_match('/Ryouko/i',$useragent)){
        $btitle = 'Ryouko';
        $bcode = 'ryouko';
    }elseif(preg_match('/SaaYaa/i',$useragent)){
        $btitle = 'SaaYaa Explorer';
        $bcode = 'saayaa';
    }elseif(preg_match('/SeaMonkey/i',$useragent)){
        $btitle = 'SeaMonkey';
        $bcode = 'seamonkey';
    }elseif(preg_match('/SEMC-Browser/i',$useragent)){
        $btitle = 'SEMC Browser';
        $bcode = 'semcbrowser';
    }elseif(preg_match('/SEMC-java/i',$useragent)){
        $btitle = 'SEMC-java';
        $bcode = 'semcbrowser';
    }elseif(preg_match('/Series60/i',$useragent)&&!preg_match('/Symbian/i',$useragent)){
        $btitle = 'Nokia Series60';
        $bcode = 's60';
    }elseif(preg_match('/S60/i',$useragent)&&!preg_match('/Symbian/i',$useragent)){
        $btitle = 'Nokia S60';
        $bcode = 's60';
    }elseif(preg_match('#SE 2([a-zA-Z0-9.]+)#i',$useragent,$matches)&&preg_match('/MetaSr/i',$useragent)){
        $btitle = 'Sogou Explorer';
        $bversion = $matches[1];
        $bcode = 'sogou';
    }elseif(preg_match('/Seznam\.cz/i',$useragent)){
        $btitle = 'Seznam.cz';
        $bcode = 'seznam-cz';
    }elseif(preg_match('/Shiira/i',$useragent)){
        $btitle = 'Shiira';
        $bcode = 'shiira';
    }elseif(preg_match('/Shiretoko/i',$useragent)){
        $btitle = 'Shiretoko';
        $bcode = 'firefoxdevpre';
    }elseif(preg_match('/Silk/i',$useragent)&&!preg_match('/PlayStation/i',$useragent)){
        $btitle = 'Amazon Silk';
        $bcode = 'silk';
    }elseif(preg_match('/SiteKiosk/i',$useragent)){
        $btitle = 'SiteKiosk';
        $bcode = 'sitekiosk';
    }elseif(preg_match('/SkipStone/i',$useragent)){
        $btitle = 'SkipStone';
        $bcode = 'skipstone';
    }elseif(preg_match('/Skyfire/i',$useragent)){
        $btitle = 'Skyfire';
        $bcode = 'skyfire';
    }elseif(preg_match('/Sleipnir/i',$useragent)){;
        $btitle = 'Sleipnir';
        $bcode = 'sleipnir';
    }elseif(preg_match('/SlimBoat/i',$useragent)){
        $btitle = 'SlimBoat';
        $bcode = 'slimboat';
    }elseif(preg_match('/SlimBrowser/i',$useragent)){
        $btitle = 'SlimBrowser';
        $bcode = 'slimbrowser';
    }elseif(preg_match('/SmartTV/i',$useragent)){
        $btitle = 'Maple Browser';
        $bcode = 'maplebrowser';
    }elseif(preg_match('/Songbird/i',$useragent)){
        $btitle = 'Songbird';
        $bcode = 'songbird';
    }elseif(preg_match('/Stainless/i',$useragent)){
        $btitle = 'Stainless';
        $bcode = 'stainless';
    }elseif(preg_match('/SubStream/i',$useragent)){
        $btitle = 'SubStream';
        $bcode = 'substream';
    }elseif(preg_match('/Sulfur/i',$useragent)){
        $btitle = 'Flock Sulfur';
        $bcode = 'flock';
    }elseif(preg_match('/Sundance/i',$useragent)){
        $btitle = 'Sundance';
        $bcode = 'sundance';
    }elseif(preg_match('/Sundial/i',$useragent)){
        $btitle = 'Sundial';
        $bcode = 'sundial';
    }elseif(preg_match('/Sunrise/i',$useragent)){
        $btitle = 'Sunrise';
        $bcode = 'sunrise';
    }elseif(preg_match('/Superbird/i',$useragent)){
        $btitle = 'Superbird';
        $bcode = 'superbird';
    }elseif(preg_match('/Surf/i',$useragent)){
        $btitle = 'Surf';
        $bcode = 'surf';
    }elseif(preg_match('/Swiftfox/i',$useragent)){
        $btitle = 'Swiftfox';
        $bcode = 'swiftfox';
    }elseif(preg_match('/Swiftweasel/i',$useragent)){
        $btitle = 'Swiftweasel';
        $bcode = 'swiftweasel';
    }elseif(preg_match('/Sylera/i',$useragent)){
        $btitle = 'Sylera';
        $bcode = 'null';
    }elseif(preg_match('/tear/i',$useragent)){
        $btitle = 'Tear';
        $bcode = 'tear';
    }elseif(preg_match('/TeaShark/i',$useragent)){
        $btitle = 'TeaShark';
        $bcode = 'teashark';
    }elseif(preg_match('/Teleca/i',$useragent)){
        $btitle = ' Teleca';
        $bcode = 'obigo';
    }elseif(preg_match('/TenFourFox/i',$useragent)){
        $btitle = 'TenFourFox';
        $bcode = 'tenfourfox';
    }elseif(preg_match('/QtCarBrowser/i',$useragent)){
        $btitle = 'Tesla Car Browser';
        $bcode = 'teslacarbrowser';
    }elseif(preg_match('/TheWorld/i',$useragent)){
        $btitle = 'TheWorld Browser';
        $bcode = 'theworld';
    }elseif(preg_match('/Thunderbird/i',$useragent)){
        $btitle = 'Thunderbird';
        $bcode = 'thunderbird';
    }elseif(preg_match('/Tizen/i',$useragent)){
        $btitle = 'Tizen';
        $bcode = 'tizen';
    }elseif(preg_match('/Tjusig/i',$useragent)){
        $btitle = 'Tjusig';
        $bcode = 'tjusig';
    }elseif(preg_match('#TencentTraveler ([a-zA-Z0-9.]+)#i',$useragent)){
        $btitle = 'TT Explorer';
        $bversion = $matches[1];
        $bcode = 'tt-explorer';
    }elseif(preg_match('/uBrowser/i',$useragent)&&!preg_match('/Chrome/i',$useragent)){
        $btitle = 'uBrowser';
        $bcode = 'ubrowser';
    }elseif((preg_match('/Ubuntu\;\ Mobile/i',$useragent)||preg_match('/Ubuntu\;\ Tablet/i',$useragent)&&preg_match('/WebKit/i',$useragent))){
        $btitle = 'Ubuntu Web Browser';
        $bcode = 'ubuntuwebbrowser';
    }elseif(preg_match('#UBrowser([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bversion = $matches[1];
        $bcode = 'ucbrowser';
    }elseif(preg_match('#UCBrowser([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bversion = $matches[1];
        $bcode = 'ucbrowser';
    }elseif(preg_match('#UC\ Browser([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bversion = $matches[1];
        $bcode = 'ucbrowser';
    }elseif(preg_match('#UCWEB([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'UC Browser';
        $bversion = $matches[1];
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
    }elseif(preg_match('/Usejump/i',$useragent)){
        $btitle = 'Usejump';
        $bcode = 'usejump';
    }elseif(preg_match('/uZardWeb/i',$useragent)){
        $btitle = 'uZardWeb';
        $bcode = 'uzardweb';
    }elseif(preg_match('/uZard/i',$useragent)){
        $btitle = 'uZard';
        $bcode = 'uzardweb';
    }elseif(preg_match('/uzbl/i',$useragent)){
        $btitle = 'uzbl';
        $bcode = 'uzbl';
    }elseif(preg_match('/Vivaldi/i',$useragent)){
        $btitle = 'Vivaldi';
        $bcode = 'vivaldi';
    }elseif(preg_match('/Vimprobable/i',$useragent)){
        $btitle = 'Vimprobable';
        $bcode = 'null';
    }elseif(preg_match('/Vonkeror/i',$useragent)){
        $btitle = 'Vonkeror';
        $bcode = 'null';
    }elseif(preg_match('/w3m/i',$useragent)){
        $btitle = 'W3M';
        $bcode = 'w3m';
    }elseif(preg_match('/AppleWebkit/i',$useragent)&&preg_match('/WebPositive/i',$useragent)){
        $btitle = 'WebPositive';
        $bcode = 'webpositive';
    }elseif(preg_match('/AppleWebkit/i',$useragent,$matches)&&preg_match('/Android/i',$useragent)&&!preg_match('/Chrome/i',$useragent)){
        $btitle = 'Android Webkit';
        $bcode = 'android-webkit';
    }elseif(preg_match('/Waterfox/i',$useragent)){
        $btitle = 'Waterfox';
        $bcode = 'waterfox';
    }elseif(preg_match('/WebExplorer/i',$useragent)){
        $btitle = 'Web Explorer';
        $bcode = 'webexplorer';
    }elseif(preg_match('/WebianShell/i',$useragent)){
        $btitle = 'Webian Shell';
        $bcode = 'webianshell';
    }elseif(preg_match('/Webrender/i',$useragent)){
        $btitle = 'Webrender';
        $bcode = 'webrender';
    }elseif(preg_match('/Chrome/i',$useragent)&&preg_match('/Mobile/i',$useragent)&&(preg_match('/Version/i',$useragent)||preg_match('/wv/i',$useragent,$matches))){
        $btitle = 'WebView';
        $bcode = 'android-webkit';
    }elseif(preg_match('/WeltweitimnetzBrowser/i',$useragent)){
        $btitle = 'Weltweitimnetz Browser';
        $bcode = 'weltweitimnetzbrowser';
    }elseif(preg_match('/wKiosk/i',$useragent)){
        $btitle = 'wKiosk';
        $bcode = 'wkiosk';
    }elseif(preg_match('/WorldWideWeb/i',$useragent)){
        $btitle = 'WorldWideWeb';
        $bcode = 'worldwideweb';
    }elseif(preg_match('/wOSBrowser/i',$useragent)||preg_match('/webOSBrowser/i',$useragent)){
        $btitle = 'wOSBrowser';
        $bcode = 'webos';
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
    }elseif(preg_match('/Wyzo/i',$useragent)){
        $btitle = 'Wyzo';
        $bcode = 'Wyzo';
    }elseif(preg_match('/X-Smiles/i',$useragent)){
        $btitle = 'X-Smiles';
        $bcode = 'x-smiles';
    }elseif(preg_match('/Xiino/i',$useragent)){
        $btitle = 'Xiino';
        $bcode = 'null';
    }elseif(preg_match('/YaBrowser/i',$useragent)){
        $btitle = 'Yandex Browser';
        $bcode = 'yandex';
    }elseif(preg_match('/YRCWeblink/i',$useragent)){
        $btitle = 'YRC Weblink';
        $bcode = 'yrcweblink';
    }elseif(preg_match('/zBrowser/i',$useragent)){
        $btitle = 'zBrowser';
        $bcode = 'zbrowser';
    }elseif(preg_match('/ZipZap/i',$useragent)){
        $btitle = 'ZipZap';
        $bcode = 'zipzap';
    }elseif(preg_match('/ABrowse/i',$useragent)){
        $btitle = 'ABrowse';
        $bcode = 'abrowse';
    }elseif(preg_match('#Edge/([a-zA-Z0-9.]+)#i',$useragent,$matches)&&preg_match('/Chrome/i',$useragent)&&preg_match('/Safari/i',$useragent)){
        $btitle = 'Microsoft Edge';
        $bversion = $matches[1];
        $bcode = 'msedge12';
    }elseif(preg_match('#Chrome/([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'Google Chrome';
        $bversion = $matches[1];
        $bcode = 'chrome';
    }elseif(preg_match('/Safari/i',$useragent)&&!preg_match('/Nokia/i',$useragent)){
        $btitle = 'Safari';
        $bcode = 'safari';
    }elseif(preg_match('/Nokia/i',$useragent)){
        $btitle = 'Nokia Web Browser';
        $bcode = 'maemo';
    }elseif(preg_match('#(Firefox|Phoenix|Firebird|BonEcho|GranParadiso|Minefield|Iceweasel)/([a-zA-Z0-9.]+)#i',$useragent,$matches)){
        $btitle = 'Firefox';
        $bversion = $matches[2];
        $bcode = 'firefox';
    }elseif(preg_match('/MSIE/i',$useragent)||preg_match('/Trident/i',$useragent)){
        $btitle = 'Internet Explorer';
        $bcode = 'msie';
    }
    return '<div class="useragent"><img src="'.get_stylesheet_directory_uri().'/images/net/'.$bcode.'.png" style="margin-top:-5px;border:0px;vertical-align:middle;width:16px;height:16px"> '.$btitle.' <span class="bversion">'.$bversion.' </span><img src="'.get_stylesheet_directory_uri().'/images/os/'.$code.'.png" style="margin-top:-5px;border:0px;vertical-align:middle;width:16px;height:16px"> '.$title.' '.$version.'</div>';
}
function user_agent_display_comment(){
    global $comment;
    remove_filter('comment_text','user_agent');
    apply_filters('get_comment_text',$comment->comment_content);
    if(empty($_POST['comment_post_ID'])||is_admin()) echo apply_filters('comment_text', $comment->comment_content);
}
function user_agent(){
    echo user_agent_show();
    user_agent_display_comment();
    add_filter('comment_text','user_agent');
}
add_filter('comment_text','user_agent');