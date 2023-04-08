<?php
//date:2019/09/26   
//author: lrw
//加入统一身份认证
//使用例子，自行修改其中的参数
require("OAuth.php");
if(!isset($_SESSION)){ session_start();}
       
if(isset($_SESSION["admin"]))
{
    header("location:index.php?r=index/index");	 
}
else{
    $client_id="c8ff0e59c9adc639b3311e08b2dc4fbd";//xxxxxxxxxx623d5fcxxxxxxxxxxxxx"; //申请取得的client_id
    $client_secret="9cSJfkdCYKASE2aZsBpJ669aYJKq54Gsbvmab5Ab47J1C0VuI79GvjaC9KcMop6G";
       //申请取得的client_secret
    $url_callback="https://zcps.scnu.edu.cn/scnursps/index.php?r=index/mycallback";   //
//https://zcps.scnu.edu.cn/scnursps/useoauth.php
    //自己的域名及处理登录的程序，根据自己程序修改
    $auth=new ScnuAuth($client_id,$client_secret,$url_callback);
    
    header("location:". $auth->getRedirectUrl());
    //$redirect_code=$auth->getRedirectUrl();
    #todo:  如果返回的url不对，则不跳转
    //if($redirect_code){
    //    header("location:".str_replace("http://","https://",$redirect_code));
    //}
    
}    
?>