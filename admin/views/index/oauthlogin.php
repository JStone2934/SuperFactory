<?php
//登录处理代码例子
require("OAuth.php");
require("_conn_.php");
require("function.php");
session_start();
$loginResult=FALSE;
if(isset($_GET["code"])){
    $client_id="c8ff0e59c9adc639b3311e08b2dc4fbd";
    $client_secret="9cSJfkdCYKASE2aZsBpJ669aYJKq54Gsbvmab5Ab47J1C0VuI79GvjaC9KcMop6G";
    $url_callback="https://zcps.scnu.edu.cn/scnursps/index.php?r=index/mycallback";
    $curtime=getcurtime();
    $ip=getIP();
    $code=$_GET["code"];    
    $auth=new ScnuAuth($client_id,$client_secret,$url_callback);            
    $userobj=$auth->getUserObject($code);
    if(count($userobj)){
          //登录成功，取得了用户信息
            header("location:index.php?r=index/mycallback");
        }
        else{
            $loginResult=FALSE;
        }
    }
}
else{
    $loginResult=FALSE;
        
}

if(!$loginResult){
    $log="[$curtime] $ip  登录失败";
    echo("登录失败");
    writelog($log);
}
    

?>