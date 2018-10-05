<?php
if($_GET['p']==='22') $p = 2; else if($_GET['p']==='33') $p = 3; else $p = mt_rand(2,3);
if($p==2){$person = 22;$idle3 = 100;$tap1 = 150;$tap2 = 100;$ra = mt_rand(1,15);}else{$person = 33;$idle3 = 1000;$tap1 = 500;$tap2 = 200;$ra = mt_rand(1,15);}
header("Content-type: application/json");
if($_GET['model']==='rand') echo '{
    "model":"'.$person.'/'.$person.'.v2.moc",
    "textures":[
        "'.$person.'/textures/texture_00.png",
        "'.$person.'/textures/texture_01/'.$ra.'.png",
        "'.$person.'/textures/texture_02/'.$ra.'.png",
        "'.$person.'/textures/texture_03/'.$ra.'.png"
'; else echo '{
    "model":"./'.$person.'/'.$person.'.v2.moc",
    "textures":[
        "'.$person.'/textures/texture_00.png",
        "'.$person.'/textures/texture_01/1.png",
        "'.$person.'/textures/texture_02/1.png",
        "'.$person.'/textures/texture_03/12.png"
'; echo '    ],
    "hit_areas_custom":{
        "head_x":[-0.35, 0.6],
        "head_y":[0.19, -0.2],
        "body_x":[-0.3, -0.25],
        "body_y":[0.3, -0.9]
    },
    "layout":{
        "center_x":-0.05,
        "center_y":0.25,
        "height":2.7
    },
    "motions":{
        "idle":[
            {
                "file":"'.$person.'/'.$person.'.v2.idle-01.mtn",
                "fade_in":2000,
                "fade_out":2000
            },
            {
                "file":"'.$person.'/'.$person.'.v2.idle-02.mtn",
                "fade_in":2000,
                "fade_out":2000
            },
            {
                "file":"'.$person.'/'.$person.'.v2.idle-03.mtn",
                "fade_in":'.$idle3.',
                "fade_out":'.$idle3.'
            }
        ],
        "tap_body":[
            {
                "file":"'.$person.'/'.$person.'.v2.touch.mtn",
                "fade_in":'.$tap1.',
                "fade_out":'.$tap2.'
            }
        ],
        "thanking":[
            {
                "file":"'.$person.'/'.$person.'.v2.thanking.mtn",
                "fade_in":2000,
                "fade_out":2000
            }
        ]
    }
}
';