<?php 
//角色管理 
class Role extends BaseModel {
    public $tmp_opter2='';
    public function tableName() {
        return '{{ws_roles}}';//角色管理
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**  * 模型关联规则  */
    public function relations() {
        return array();
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
      'roleId'=>'id',
      'roleCode' =>'编码',
      'roleName' => '名称',
      'roleDesc' =>'备注',
      'privileges'=> '功能',
      'dataFlag'=> '使用',//删除 0 是  1 否',
      //'createTime' => '建立时间 '
     );
   }
//   sortNo,brandCode,brandName,brandDesc,brandImg,
 /* 
  public function picLabels() {
        return 'brandImg';
    }
   
   public  function pathLabels(){
       return 'Brands';x
   }
   */
    protected function afterFind() {
       parent::afterFind();
       return true;
    }
    protected function beforeSave() {
        parent::beforeSave();   
        return true;
    }

    protected function gData() {  
        return $this->findAll('dataFlag=1 order by roleId');
    }
    public function downSelect($form,$m,$atts,$onchange='',$noneshow=''){
     return BaseLib::model()->selectByData($form,$m,$atts,$this->gData(),'roleName',$onchange,$noneshow);
    }
    public function downSearch($title,$filedname){
     return BaseLib::model()->searchBy($title,$filedname,$this->gData(),'roleName');
    }

  //Role::model()->getPowen($role);
    //http://127.0.0.1/shop/wxshop/index.php?r=user/index
    function getPowen($role)
    {
      $tmp=Role::model()->find("f_rname='".$role."'");
      $tid='0';
      if(!empty($tmp)) { $tid=$tmp->f_opter;}
      if(empty($tid)) $tid='0';
      $tmp=Menu::model()->findAll("id in (".$tid.") AND f_url<>' ' order by f_no ");
      $power=array();
      $power['index']['logout']='1';
      $power['index']['login']='1';
      $b=trim(' / ');
      foreach($tmp as $v){
        $string = trim($v->f_url);
        $d1 = explode($b, $string);
        $power[$d1[0]][$d1[1]]='1';
      }
      Yii::app()->session['power']=$power;
    }

   public function getUserDefault()
    {
      return Yii::app()->session['F_ROLENAME'];
    }

    public function checkUser()
    {
      $r=0;
      $tmp=$this->find("f_rname='".$this->getUserDefault()."'");
      if($tmp) $r=$tmp->f_optname;
      return ($r==1);
    }

    public function checkList()
    {
      return checkListArray($this->findAll(),'f_rname');
    }




/**
 * check_power
 * @param string ,$mname,$oname 模块名，操作名
 */
function check($mname,$oname) {
    $mname=strtolower($mname);
    $oname=strtolower($oname);
    $oname1=$oname;
    $s1=$oname;
    $iop=substr($mname,0,3);
    if($iop=='io_'){ return true;} 
    if(($mname=='select')||($mname=='index')&&(($s1=='login')||($s1=='logout')||($s1=='checkuser'))){
        return true;
    }
    if(($mname=='sendsms')||($mname=='gameupdate')){
        return true;
    } 
    if(($oname=='roleset')){
        return true;
    } 
  //   return true;
    if(empty($_SESSION['gfaccount'])){
       // session_destroy();
        unset($_SESSION);
        echo '<script>window.location.href="index.php?r=index/login"</script>';
    }
    checkSession();
    $role_tmp=Menu::model()->get_role_power(get_session('level'),$mname);
    if(strpos($oname,'index')!==false){
        header("Cache-Control: no-cache, must-revalidate");
    }
    if(($mname=='select')||(get_session('sys_user')==2)||($mname=='index')&&(($oname=='index')||($oname=='logout'))){
        return true;
    }
    if ($oname=='message_content'){
       return true;
    }
    if (isset($_POST['submitType']))
        { $oname=$_POST['submitType'];}
    if ($oname=='update') { $oname1='ch';}
  
    if((isset($role_tmp[$mname][$oname]))||(isset($role_tmp[$mname][$oname1]))) {
        return true;
    }
    return false;
  }

    protected function checkColumnAccess($column) {
        if (!$this->checkColumn($column)) {
            if (Yii::app()->request->isAjaxRequest) {
                ajax_status(0, '对不起，没有操作权限');
            } else {
                $this->layout = false;
                $this->render('//public/error', array('message' => '对不起，没有操作权限'));
                exit;
            }
        }
    }

    protected function checkColumn($column) {
        if (Yii::app()->session['admin_system']) {
            return true;
        }
        if (in_array($column, Yii::app()->session['role_column'])) {
            return true;
        }
        return false;
    }

}