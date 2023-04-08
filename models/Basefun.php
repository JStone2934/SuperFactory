<?php
class Basefun extends BaseModel {
  // public $app_appid ='wx775e4d708b9cbe29';//深海
  // public $app_secret='c05e533273ef7bc864fc89bc51e663b8';
    public function tableName() {
        return '{{ws_areas}}';
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }   

    public  function return_ok($pcode=0){  
         return $this->test_error($pcode);
    }


    public  function test_error($err){  
         return $this->check_error($err>-1,"0","操作成功","2","操作失败");
        }

    public function check_error($ex,$err0,$msg0,$err1="0",$msg1="",$aname="",$value=""){
         $data= ($ex) ? $this->get_error($err0,$msg0) : $this->get_error($err1,$msg1) ;
        if (!empty($aname))  $data[$aname]=$value;
        return $data;
    }

    function get_error($error,$msg){
        return array('error' =>$error,'msg'=>$msg);
    }
    function set_error(&$data,$error,$msg,$exit=0){//不能直接使用get_error($error,$msg)方法，否则$
        if($data==null){
            $data=array();
        }        
        $data['error'] =$error;
        $data['msg'] =  $msg;
        if($exit==1) $this->exit_json($data);
      }

    function exit_error($error,$msg,$data=null){//不能直接使用get_error($error,$msg)方法，否则$
        $this->set_error($data,$error,$msg,1);
      }
    
    function exit_data($data){//不能直接使用get_error($error,$msg)方法，否则$
        $this->exit_json($data);
      }

    function resultAuto($ret) {
      return empty($ret) ? $this->result(1,'数据异常') : $this->result(0,$ret);
    }
    /**
     * 组装返回array('error','res')
     */
    function result($err, $ret) {
        return array ('error' => $err,'res' => $ret );
    }
    /**
     * 检查数据是否在有效范围内
     */
    function checkNum($num, $min, $max) {
        $n = intval( $num );
        return $min <= $n && $n <= $max;
    }

    /**
     * 参数过滤匹配
     */
    function fliterParam($array, $def) {
        $ret = array ();
        foreach ( $def as $k => $v )
            if (!isset($array[$k]) || $this->isEmpty( $array[$k] ))
                $ret[$k] = $def[$k];
            else
                $ret[$k] = $array[$k];
        return $ret;
    }
    /**
     * 返回数据交集
     */
    function params($arr, $keys) {
        return parama( $arr, explode( ',', $keys ) );
    }
    /**
     * 返回数据交集
     */
    function parama($arr, $keys) {
        $keycheck;
        foreach ( $keys as $k => $v ) {
            $keycheck[trim( $v )] = $k;
        }
        return array_intersect_key( $arr, $keycheck );
    }
    /**
     * 值是否为空
     */
    function isEmpty($p) {
        if (isset( $p ))
            return trim( $p ) == '';
        return true;
    }

 //将 xml数据转换为数组格式。
    function xml_to_array($xml){
      $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
      if(preg_match_all($reg, $xml, $matches)){
        $count = count($matches[0]);
        for($i = 0; $i < $count; $i++){
        $subxml= $matches[2][$i];
        $key = $matches[1][$i];
          if(preg_match( $reg, $subxml )){
            $arr[$key] = $this->xml_to_array( $subxml );
          }else{
            $arr[$key] = $subxml;
          }
        }
      }
      return $arr;
    }

//app_appid: 'wx775e4d708b9cbe29',//深海
//app_secret : 'c05e533273ef7bc864fc89bc51e663b8',
 
public static function get_appid() {
    return 'wx566c15824fd2564b';
  }
public static function get_secret() {
    return 'c32b9f18e8be0e5293c388521b9341ec';//$this->app_secret;
  }
     
public static function Get3rdsession($len){
    $s1 ='0123456789abcdefghijklmnopqrstuvwxyz';
    $s1.='!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $s2='';
    for($i=0;$i<100;$i++){
      $i1=rand(0,70);
      $s2.=substr($s1,$i1,1);
    }
    $result = base64_encode($s2);
    $result = strtr($result, '+/', '-_');
    return substr($result, 0, $len);
 }


  function exit_json($data){
   //    exit(json_encode($data,JSON_UNESCAPED_SLASHES));
   $s1=JSON_UNESCAPED_SLASHES;
    $data['stime']=time();
    ob_clean();
    exit(json_encode($data,$s1));
  }

     /**输出模块**/
    //输出JSON数据   第一个数组用于附加res.data 第二个数组附加res.data.data
public function echoEncode($rs,$code='200',$msg='获取成功',$ecode='400',$emsg='获取失败'){
    $rs['code']=$code;
    $rs['msg']=$msg;
    $rs['time'] = time();
    echo CJSON::encode($rs);
  }

public function echoAjxCode($data,$dateItem=''){
     if (!empty($dateItem)) $data=array($dateItem=>$data,'total'=>count($data));
     $r=array('data'=>$data);
     $this->echoEncode($r);
  }


public  function noNameArray($cooperation,$afieldstr)
 {
    $arr = array();$r=0;
    $afields=explode(',',$afieldstr);
    $cn=count($afields);
    if($cn>1){
        $arr=$this->moreArray($cooperation, $afields);
    } else{
      $v1=$afields[0];
      foreach ($cooperation as $v) {
         $arr[] =$v[$v1];
      }  
    }
    return $arr;
  }

 public  function moreArray($cooperation, $afields)
 {
    $arr = array();$r=0;
    foreach ($cooperation as $v) {
      $arr0 = array();
         foreach($afields as $v1){
             $vs=$v[$v1];
             if(empty($vs)){
                $vs="";
             }
             $arr0[] = $vs;
        }
        $arr[]= $arr0;
    }
    return $arr;
  }

//检查数组存在的条件
//$W1 原来条件
//$PARA 数组，$rname下标，$fname字段名
public function arrayCondition($w1,$para,$rname,$fname){
    if(isset($para[$rname])) 
      if($para[$rname]) $w1=$fname."='".$para[$rname]."'"; 
     return $w1;
  }
//检查数组存在的条件
//$W1 原来条件
//$PARA 数组，$rname下标，$fname字段名
public function emptyArray($astr){
    $d=array();
    $afields=explode(',',$astr);
    foreach($afields as $v1){
       $v=explode(':',$v1);
       $d[$v[0]]='';
       if(isset($v[1])) $d[$v[0]]=$v[1];
    }
    return $v;
}


function clear_html($content) {
    $content = preg_replace("/<a[^>]*>/i", "", $content);
    $content = preg_replace("/<\/a>/i", "", $content);
    $content = preg_replace("/<div[^>]*>/i", "", $content);
    $content = preg_replace("/<\/div>/i", "", $content);
    $content = preg_replace("/<!--[^>]*-->/i", "", $content); //注释内容
    $content = preg_replace("/style=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/class=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/id=.+?['|\"]/i", '', $content); //去除样式   
    $content = preg_replace("/lang=.+?['|\"]/i", '', $content); //去除样式    
    $content = preg_replace("/width=.+?['|\"]/i", '', $content); //去除样式 
    $content = preg_replace("/height=.+?['|\"]/i", '', $content); //去除样式 
    $content = preg_replace("/border=.+?['|\"]/i", '', $content); //去除样式 
    $content = preg_replace("/face=.+?['|\"]/i", '', $content); //去除样式 
    $content = preg_replace("/face=.+?['|\"]/", '', $content); //去除样式 只允许小写 正则匹配没有带 i 参数

    return trim($content);
}

}
