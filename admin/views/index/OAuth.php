<?php
///author: lrw
// date: 2019/09/26
//date:2019/10/17 changed，更改原来的错误重定向，第一步是由浏览器发出的
// 功能： 华南师范大学统一身份认证对接
//todo: 没有容错机制

define("code_url","https://sso.scnu.edu.cn/AccountService/openapi/auth.html");
define("url_access_token","https://sso.scnu.edu.cn/AccountService/openapi/token.html");
define("url_userinfo","https://sso.scnu.edu.cn/AccountService/openapi/userinfo.html");

class ScnuAuth{
    private $code;
    private $token;

    private $client_id;
    private $client_secret;
    private $url_callback;
    public function __construct($client_id,$client_secret,$url_callback){
        $this->client_id=$client_id;
        $this->client_secret=$client_secret;
        $this->url_callback=$url_callback;
    }
    
    public function getRedirectUrl(){
        $redirect_url="";
        $data=array(
            "client_id"=>$this->client_id,
            "response_type"=>"code",
            "redirect_url"=>$this->url_callback
        );
        $redirect_url=code_url."?".http_build_query($data);
        return $redirect_url;
    }

    public function getRedirectUrl1(){
        $redirect_url="";
        $data=array(
            "client_id"=>$this->client_id,
            "response_type"=>"code",
            "redirect_url"=>$this->url_callback
        );
        //$ret=$this->curlpost(code_url,$data);        
        $ret=$this->curlData(code_url,$data,"GET");
        $headers=$ret[1];
        //var_dump($headers);
        if($headers["http_code"]==302){ 
            //echo($headers["redirect_url"])          ;
            $redirect_url=$headers["redirect_url"];    
        }           
        return $redirect_url;
    }
    public function getAccessToken($code){
        $access_token="";
        $data=array(
            "code"=>$code,
            "client_id"=>$this->client_id,
            "client_secret"=>$this->client_secret,
            "grant_type"=>"authorization_code"

        );
        //echo("<br />==============<br />");
        //var_dump($data);
        $ret=$this->curlpost(url_access_token,$data);
        //echo("<br />==============<br />");
        //var_dump($ret);
        //echo("<br />==============<br />");
        //echo("code:".$ret[1]["http_code"]);
        if($ret[1]["http_code"]==200){
            $retdata=$ret[0];
            $retobject=json_decode($retdata,True);
            $access_token=$retobject["access_token"];
        };

        return $access_token;
    }

    #根据token取得用户信息
    public function getUserinfo($access_token){
        $userobj=array();
        $data=array(
            "access_token"=>$access_token
        );
        $ret=$this->curlpost(url_userinfo,$data);
        if($ret[1]["http_code"]==200){
            $retdata=$ret[0];
            $userobj=json_decode($retdata,TRUE);            
        };
        return $userobj;
    }

    //简化步骤，在对象里传入code，直接返回用户信息对象
    // obj["account"] 工号
    public function getUserObject($code){
        //echo("aaaaaaaaaaaaaaaa\n");
        $access_token=$this->getAccessToken($code);
        $userobj=$this->getUserinfo($access_token);
        return $userobj;
    }
    function curlpost($url, $data) {

        //初使化init方法
        $ch = curl_init();     
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);     
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);     
        //发送什么数据呢
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //忽略证书
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
        //忽略header头信息
        //curl_setopt($ch, CURLOPT_HEADER, 0);
     
        //设置超时时间
        //curl_setopt($ch, CURLOPT_TIMEOUT, 10);
     
   
        //发送请求
        $output  = curl_exec($ch);     
        $headers =  curl_getinfo($ch);
        //关闭curl
        curl_close($ch);
        
        //返回数据
        return array($output,$headers);
    }

    /**
 * @param $url
 * @param $data
 * @param string $method
 * @param string $type
 * @return bool|string
 */
function curlData($url,$data,$method = 'GET',$type='json')
{
    //初始化
    $ch = curl_init();
    $headers = [
        'form-data' => ['Content-Type: multipart/form-data'],
        'json'      => ['Content-Type: application/json'],
    ];
    if($method == 'GET'){
        if($data){
            $querystring = http_build_query($data);
            $url = $url.'?'.$querystring;
        }
    }
    // 请求头，可以传数组
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers[$type]);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         // 执行后不直接打印出来
    if($method == 'POST'){
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');     // 请求方式
        curl_setopt($ch, CURLOPT_POST, true);               // post提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);              // post的变量
    }
    if($method == 'PUT'){
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    }
    if($method == 'DELETE'){
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
    $output = curl_exec($ch); //执行并获取HTML文档内容
    $headers =  curl_getinfo($ch);
    //关闭curl
    curl_close($ch);
    
    //返回数据
    return array($output,$headers);
    
   }
}
