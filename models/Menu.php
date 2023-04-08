<?php 

class Menu extends BaseModel {

    public function tableName() {
        return '{{menu}}';
    }

  /**
     * 模型关联规则
     */
    public function relations() {
        return array(   );
    }

  /*** 模型验证规则*/
    public function rules() {
       return $this->attributeRule();
    }
    /** * 属性标签*/
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
            'id' =>'id',
            'f_mcode'=>'编码',
            'f_show'=>'显示',
            'f_group' => '一级菜单',
            'f_code'  => '二级菜单编码',
            'f_name'  => '二级菜单名称',
            'f_url'  => '网页连接地址',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

    public function getMenu($ptc="") {
        $tmp=$this->getRec($ptc);
        $m1='=';$st1="";
        $menu=array();
        foreach($tmp as $v1){
            if(($v1->f_group!==$m1)){
                $m1=trim($v1->f_group);
                $m2=array();
                foreach($tmp as $v2){
                    if($v2->f_group==$m1){
                        $url=trim($v2->f_url);
                        if(empty($url)) $url='public/noopen';
                        if($this->check_time($v2->f_group)) $url='public/noopen';
                        $m2[trim($v2->f_code)]=array(trim($v2->f_name),$url,$v2->id);
                    }
                }
                $st1.=','.$m1.',';
                $menu[]=array(trim($v1->f_group),$m2);
            }
        }
        return $menu;
    }

    public function getMcodeSet() {
        $tmp=$this->getRec();
        $st1="";$bt='';
        foreach($tmp as $v1){
         $st1.=$bt.'"'.trim($v1->f_mcode).'"';
         $bt=',';
        }
        return $st1;
    }

    public function getRec($ptc=""){
        $w1=" f_show=1 and f_no<>' '".(($ptc=="") ? " " :" and f_mcode='".$ptc."'");
        $ptypename='';//Role::model()->getUserDefault();
        if(!empty($ptypename)){
            $role=Role::model()->find("f_rname='".$ptypename."'");
            $rop="1";         
            if(!empty($role->f_opter)) $rop=$role->f_opter;
            $w1.=' and id in ('.$rop.") ";
        }
        return $this->findAll($w1.' order by f_mcode,f_no');
    }
   
   public function getMcode() {
        return get_session('mcode');
    }
    
    protected function check_time($group){
        $s1=0;
        return $s1;
   }


    public function mainMenu() {
        $w1="f_mcode,f_group";
        $criteria = new CDbCriteria;
        $criteria->condition='f_show=1';//get_where
        $criteria->select=$w1;
        $criteria->order=$w1;//areaCode,areaName
        $criteria->group=$w1;//areaCode,areaName
        return $this->findAll($criteria);
    }

    public function getTitle(){
        $ctname=Yii::app()->controller->id;
        $tmp=$this->find("left(f_url,".mb_strlen($ctname).")='".$ctname."'");
        return ($tmp)  ? trim($tmp->f_group).'>>'.trim($tmp->f_name) :'';
    }
   
}
 