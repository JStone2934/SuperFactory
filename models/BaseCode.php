<?php

class BaseCode extends BaseModel {
   var $d_path;
    public function tableName() {
        return '{{base_code}}';
    }
    /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /** * 模型关联规则 */
    public function relations() {
        return array( );
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
            'f_id' => '内部自增id',
            'F_TCODE' => '类型编码',
            'F_TYPECODE'=>'二级编码',
            'F_CODE'  =>  '编号:k',
            'F_NAME'  =>  '类型名称:k',
            'f_value'  =>  '取值使用',
            'F_SHORTNAME'  =>'短名称',
            'fater_id'  =>  '父级ID',
            'if_oper' => '是否开放'
        );
    }



    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    // 获取单条数据，主表名转换为模型返回
    public function getOne($id, $ismodel = true) {
        $rs = $this->find('f_id=' . $id);
        if ($ismodel) {
          if ($rs != null && $rs->user_table != '') {
              $modelName = explode(',',$rs->user_table);
              $arr = explode('_', $modelName[0]);
              $modelName[0] = '';
              foreach ($arr as $v) {
                  $modelName[0].=ucfirst($v);
              }
              $rs->user_table = implode(',', $modelName);
          }
        }
        return $rs;
   }

  public function getName($id) {
        $rs = $this->find('f_id=' . $id);
        return  str_replace(' ','',is_null($rs->F_NAME) ? "" : $rs->F_NAME);
    }
 
    public function expToArray($w1) {
        $cooperation=$this->findAll($w1);
        $s1='f_id,F_NAME,F_TYPECODE,fater_id';
        return BaseLib::model()->toArray($cooperation,$s1);
    }
  



function mk_dir($path){
/*
 写出一个能创建多级目录的PHP函数
 */
 $this->createdirlist($path,0777);
}
/*
 写出一个能创建多级目录的PHP函数
 */
 function createdirlist($path,$mode){
   if (is_dir($path)){
   //判断目录存在否，存在不创建
  //   echo "目录'" . $path . "'已经存在";
  //已经存在则输入路径
   }else{ //不存在则创建目录
      $re=mkdir($path,$mode,true);
  //第三个参数为true即可以创建多极目录
     if ($re){
   //    echo "目录创建成功";//目录创建成功
     }else{
     //  echo "目录创建失败";
      }
     }
  }
//$path="/a/x/cc/cd"; //要创建的目录
//$mode=0755; //创建目录的模式，即权限.
//createdirlist($path,$mode);//测试

  function delete_file($path_filename)
    { 
        return unlink($path_filename);
      }
  //删除网上的文件，包括路径，新文件纸，旧文件值
   function delete_file_set($path,$new_filenames,$old_filenames)
    {
        $old_file = explode(",",$old_filenames);
        for ($i = 0; $i < count($old_file); $i = $i + 1) {
           if (strpos($new_filenames,$old_file[$i]) == false)//不存在，要删除
           {
            $this->delete_file($path.$old_file[$i]);//，要删除
           }        
        }
    }

function getTime(){
 $time = explode ( " ", microtime () );  
 $time = "".($time [0] * 1000);  
 $time2 = explode ( ".", $time );  
 $time = $time2 [0]; 
 $s1=str_replace('-','',date('y-m-d h:i:s',time()));
 $s1=str_replace(':','',$s1);
 $s1=str_replace(' ','',$s1);
 return $this->get_date_ymd(2).$s1.$time;
//2010-08-29 11:25:26
}


  function get_filename($fillename_type){
   return $this->getTime().$fillename_type;
  }

 function get_relatively_filename($fillename_type){
   $fname=$this->get_filename($fillename_type);//read_max_value_key($where=" 1=1 ",$fields,$order)
   return  substr($fname,0,4).'/'.substr($fname,4,2).'/'.substr($fname,6,2).'/'.$fname;
   // relatively
  }

 
 function str_to_file_old($str_content,$filename) //内容保存文件/早期版本
    {  
       BasePath::model()->check_save_path($filename);//检查路径是否存在，不存在创建
       $filename=BasePath::model()->getPath().$filename;
       $fp = fopen($filename, 'w');
       if ($this->indexof(strtolower($filename),'.htm')>=0){
          $str_content=str_replace('\\"','"',$str_content);
       }
      $w=fwrite($fp,$str_content);
      $w=fclose($fp);
    }

 function str_to_file($str_content,$filename,$param) //内容保存文件
    {  
      if ($this->indexof(strtolower($filename),'.htm')>=0){
          $str_content=str_replace('\\"','"',$str_content);
       }
       $param['fileType']=".html";
       $param['oldfilename']=$filename;
       $data=$this->saveFileTo73($str_content,$param);
       return $data['code']==0?$data['filename']:"";
    }

    function str_to_html($str,$filename,$param) //内容保存文件
    { 
     
      $str=str_replace(BasePath::model()->getPath(),'<gf></gf>',$str);
      $str=str_replace(BasePath::model()->getPath(),'<gw></gw>',$str);
      return $this->str_to_file($str,$filename,$param);
    }
    
   function str_to_html_ke4($str,$filename,$param) //内容保存文件
    {   
      $s0=BasePath::model()->getPath();
      $sw=BasePath::model()->getPath();

      $sh1='<!doctype html><html><head><meta charset="utf-8">';
      $sh1.='<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
      $sh1.='<script type="text/javascript" src="'.$sw.'view/layout/info/rule/diyUpload/css/wap.js"></script>';
      $sh1.='<link rel="stylesheet" type="text/css" href="'.$sw.'view/layout/info/rule/diyUpload/css/wap.css" />';
      $sh1.='<style>';
      $sh1.='body{padding:5px;margin:0 auto; position:absolute;}';
      $sh1.='img{width:100%;height:auto;float:left;}';
      $sh1.='p,h1,h2,h3,h4,h5,h6,strong{margin:0px;}';
      $sh1.='</style>';
      $sh1.='<script type="text/javascript">';
      $sh1.='window.onload = function() { var h =document.body.scrollHeight;parent.postMessage(h,"'.$s0.'");}';
      $sh1.='</script><title></title></head>';
      $sh1.='<body align="absmiddle">';
     
      $st1='</body></html>';
      if($this->indexof($str,$st1)<0) { $str=$sh1.$str.$st1;}
      return $this->str_to_html($str,$filename,$param);
    }
    
    function file_to_str($filename)
     {
      $content="";
      if($this->indexof($filename,'.')>0){
             $filename= BasePath::model()->getPath().$filename;
      try{
           $handle = @fopen($filename,"rb");
           if ($handle>0){
           $i=0;
          do {
                $data = fread($handle, 8192);
                if (strlen($data) == 0) {
                   break; 
                }
               $content .= $data; 
            } while(true);
          @fclose ($handle);
         }
          $content=str_replace('\\"','"',$content);
        } 
        catch (Exception $e) {
         $content=""; 
       }
      }
        return  $content;
     }

    /**
     * html的不解码
     */
    function to_base64($htmlstr){
       return  (strpos($htmlstr,".html")=== false) ? parent::base64_decodeing($htmlstr) : $htmlstr; 
    }

    public  function down_list_bycode($pcode){
       $datalist=$this->getCode($pcode);
       return BaseLib::optionList($datalist,'f_id','F_NAME','0');
    }
}
