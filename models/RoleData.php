<?php
class RoleData extends BaseModel {

    public function tableName() {
        return '{{role_data}}';//'角色权限明细'
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   /**   * 模型关联规则     */
    public function relations() {
        return array( );
    }

    /** * 模型验证规则*/
    public function rules() {
       return $this->attributeRule();
    }  
    /*** 属性标签*/
    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
        'f_id'  => '内部ID',
        'f_tcode'  => '一级菜单码',
        'f_mcode'  => '菜单码',
        'f_group'  => '分组',
        'f_mname'  => '菜单名称',
        'f_no'  => '变换',
        'f_show'  => '显示标识',
        'f_url'  => '网页连接地址',
        'f_mid'  => '菜单ID',
        'f_rid'  => '角色ID',
        'f_time'  => '保存时间',
        'f_pid'  => '父角色ID',
        'f_tmpmark'  => '临时使用标识',//f_tmpmark=0 正常使用  1 是删除标识
        );
    } 


   public function getLevel($lang_type='0',$club_id=-1) {
      $s1=' club_id='.$club_id.' and not isnull(f_rcode) ';
      $s2="substr(f_rcode,3,1)>' ' and club_id=0 and substr(f_rcode,4,1)=' '";
      $ws=($lang_type=='1') ? $s1 : $s2;
      return $this->findAll($ws.' order by f_rcode');
    }

  public function getChild($pcode,$pnew=0) {
      $w1=($pnew==0) ? " and (1=2) " : "";
      return $this->findAll("left(f_tcode,".strlen($pcode).")='".$pcode."' and f_tcode<>'".$pcode."'".$w1);
    }

   protected function beforeSave() {
      parent::beforeSave();
       return true;
    }

   protected function afterFind() {
      parent::afterFind();
       return true;
    }

 public function getmId($rId,$tcode='A') {
    return $this->find("f_rid=".$rId);
  }



 public  function saveRole($tmp) {
    $rId=$tmp->id; $data=$tmp->f_opter;
    $w1='f_rid='.$rId;
    RoleData::model()->updateAll(array('f_tmpmark'=>'1'),$w1);
    $data=str_replace('[','', $data);
    $data=str_replace(']','', $data);
    $data=str_replace('"','', $data);
    $list=explode(',',$data);
    foreach ($list as $v){
      if(!empty($v)){
        $this-> saveRec($rId,$v);
      }
    }

}

 public  function saveData($rId,$data,$tcode) {
    $w1='f_rid='.$rId." ";
    RoleData::model()->updateAll(array('f_tmpmark'=>'1'),$w1);
    if (is_array($data)){
          $data=json_encode($data);
    }
    $data=str_replace('[','', $data);
    $data=str_replace(']','', $data);
    $data=str_replace('"','', $data);
    $list=explode(',',$data);
    foreach ($list as $v){
      if(!empty($v)){
        $this-> saveRec($rId,$v);
      }
    }

}

  function save_datas(){
    $tmp=Role::model()->find('f_tmpmark<>1');
    if (!empty($tmp)){
        $rid=$tmp->f_id;
        $r=0;
        //$tcode=substr($tmp->f_code,0,1); 
        $ds=explode(',',$tmp->f_opter);
        foreach ( $ds as $v ) {
          $r=$r+1;
          if(($r<10)&&(!empty($v))){
            $this->saveRec($rid,'',$v);
          }
        }
        $tmp->f_temporary=1;
        $tmp->save();
    } 
  }
 
 public  function saveRec($rId,$mid) {
  if(empty($mid)) return;
    $tmp=$this->find("f_rid=".$rId." and f_mid=".$mid);
    $tmp0=Menu::model()->find('id='.$mid);
    if(empty($tmp)){
       $tmp=new RoleData;
       $tmp->isNewRecord = true;
       $tmp->f_rid=$rId;
       $tmp->f_mid=$mid;
    }
    $tmp->getFrom($tmp0,'f_tcode:f_mcode,f_mname:f_name,f_mcode:f_code,f_group,f_tmpmark::0');
    $tmp->f_tmpmark=0;
    put_msg($tmp->attributes);
    $tmp->save();
  }

public function getIds($mcode,$rid=0) {
   $tmp=$this->find('f_rid='.$rid);
   $pid=0;
   if(!empty( $tmp)) $pid=$tmp->f_pid;
   $ids1=$this-> getRoleIds($mcode,$pid);//父亲ID
   $ids2=$this-> getRoleIds($mcode,$rid);
   return array($ids1,$ids2);
  }

  //根据上级取本级菜单
public function getRoleIds($rid,$mcode,$group) {
    $w1="f_tmpmark=0 and f_tcode='".$mcode."' and f_group='".$group."' and f_rid=".$rid;
    return $this->idToarray($w1);
  }


  //根据上级取本级菜单
public function bgetRoleIds($rid,$mcode) {
    $w1="f_tcode='".substr($mcode,0,1)."' and substr(f_mcode,1,5)='".substr($mcode,0,5)."'";
    $w1.=' and f_rid='.$rid;
    return $this->idToarray($w1);
  }

  //活动角色所授权权限
function idToarray($w1){
    $tmp=$this->findAll($w1.' order by f_mcode');
    return $this->recToarray($tmp);
  }

  //活动角色所授权权限
function strAdd($s1,$s0){
      if(indexof($s1,$s0)<0){
        $s1.=",".$s0;
      }
      return $s1;
  }

  //活动角色所授权权限/18818399096
function recToarray($tmp){
    $s1="'0'";
    $s2="'0'"; 
    $r=array(0);
    if(is_array($tmp))
    foreach ( $tmp as $v ) {
      $r[] =$v->f_mid;
      $s1=$this->strAdd($s1,"'".substr($v->f_mcode,0,3)."'");
      $s2=$this->strAdd($s1,"'".substr($v->f_mcode,0,5)."'");
    }
    return array($r,$s1,$s2);
  }

function Toarray($tmp){
    return $this->recToarray($tmp);
  }
  //活动角色所授权权限
  //
  //
  
   public  function copyToData($p_rid,$r_id) {
     $tmp=$this->findAll("f_rid=".$p_rid);
     RoleData::model()->updateAll(array('f_tmpmark'=>'1'),"f_rid=".$r_id);
     foreach ( $tmp as $v ) {
       $tmp1=$this->find("f_rid=".$r_id.' and f_mid='.$v->f_mid);
       if(empty($tmp1)){
         $tmp1=new RoleData;
         $tmp1->isNewRecord = true;
       }
       $tmp1->attributes=$v->attributes;
       unset($tmp1->f_id);
       $tmp1->f_rid=$r_id;
       $tmp1->f_pid=$p_rid;
       $tmp1->f_tmpmark=0;
       $tmp1->save();
      }
   }

   function saveRoleData($f_id,$mcode,$rdata){
        $w1="f_rid=".$f_id."";
        RoleData::model()->updateAll(array('f_tmpmark'=>'1'),$w1);
        foreach ($rdata as $v1)
        {
            foreach ($v1 as $v2)
            if(is_array($v2)){
                foreach ($v2 as $v3)
                if(!empty($v3))
                {
                  $this-> saveRec($f_id,$mcode,$v3);
                }
              }
              else{
                  $this-> saveRec($f_id,$mcode,$v2);
              }
      }
      $w1="f_rid=".$f_id." and f_tcode='".$mcode."' and f_tmpmark='1'";
      RoleData::model()->deleteAll($w1);
   }

  public function getRoleId(){
     $tmp=QmddAdministrators::model()->getInfo($cid=0);
     $w1="f_rid=".$f_id." and f_tcode='".$mcode."'";
   }
}
