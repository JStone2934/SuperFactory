<?php
class Basepath extends BaseModel {
    var $db_data="2";//文件上传使用的是统一的服务器，需要设置访问数据源，1-新服务器，2-内测，3-公测，4-公网

    public function tableName() {
        return '{{ws_basepath}}';//base_path
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
        'id'=>'id',
        'F_CODE' => '编码',
        'F_SCODE' => '分类代码，相关表名称',
        'F_NAME' => '名称',
        'F_PATH' => '路径',
        'F_WWWPATH' => '',
        'F_PATH_CODE' => '标识代码',
        'F_PX_WIDE' => '图片宽度要求像素，单位像素（PX）',
        'F_PX_HIGH' => '图片高度要求像素，单位像素（PX）',
      );
    }
    public static function getPath() {
        return   $this->getParentPath();
    }

    public function getWwwPath() {
        return  $this->getParentPath();//."uploads/temp/";
    }

    public function getParentPath() {
        return  "http://127.0.0.1/rm_hsyii/uploads/file/";
    }

    public function getImagePath() {
        return  "http://127.0.0.1/rm_hsyii/uploads/image/";
    }

  public function modelPath(){
     $s1=get_session('modelPath');
     return ($s1) ? $s1.'/' : '';
  }

  public function subsPath(){
     $s1= 'upload/'.$this->modelPath().$this->datePath();
     $s2=str_replace('/wshop','',$this->rootBasePath().'/'.$s1);
     if (!is_dir($s2)) {
           mk_dir($s2);
        }
     return $s1;
  }

  public function rootBasePath(){

     return  str_replace('/wshop','',ROOT_PATH);
  }

  public function siteBasePath(){
     return  str_replace('/wshop','',SITE_PATH);
  }

  public function datePath(){
     return date('Y') . '-' . date('m') ;//. '/' . date('d') . '/';
  }

function get_short_path(){
  $dir_name=$this->getPath();
  $ymd = date("Ymd");
  $yy=  substr($ymd,0,4);
  $this->check_path($dir_name.$yy);
  $yy.='/'.substr($ymd,4,2);;
  $this->check_path($dir_name.$yy);
  $yy.='/'.substr($ymd,6,2);
  $this->check_path($dir_name.$yy);
  return $yy.'/';
}

function check_save_path($file_path){
  $dir_name=$this->getPath();
  $path0=explode('/',$file_path);
  $bs="";
  for($i=0; $i<count($path0)-1; $i++){
      $dir_name.=$bs.$path0[$i];
      $this->check_path($dir_name);
      $bs='/';
    }
 }

public function toNewPage($paction) {
        return  $this->getParentPath().'index?r='.$paction;
  }
   
public function reMovePath($str1){
       return  str_replace($this->getWwwPath(),"",$str1);
}

public function local_pic($str1){
       return  $this->rootBasePath();
  }

  public function addPath($str1){
    if($str1)
     if(!substr_count($str1,'http'))
      $str1=$this->getWwwPath().$str1;      
      return  $str1;
  }
     
   public function remove_path($str) {
      return $this->reMovePath($str);
  }

  public function fileIcon($flie) {
     $s1=substr($flie,-3,3);
     $s2='uploads/temp/image/'.$s1.'_icon.jpg';
     $s2=$this->addPath($s2);
     $rs=$flie;
     if (substr($flie,-3,3)=='pdf') $rs=$s2;
      return $rs;
  }
      
}
