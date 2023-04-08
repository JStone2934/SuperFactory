<?php
class RoleManagement extends BaseModel {
    public function tableName() {
        return '{{role_management}}';
    }
    /*** Returns the static model of the specified AR class.*/
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**   * 模型关联规则  */
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
        'id' =>'ID', 
        'roleName' =>'角色名称', 
        'roleCode' => '角色编码',
        'roleExplain' => '角色权限说明',
        'dataFlag' => '使用'//1为使用
        );
      }

    public  function pathLabels(){
        return 'roleManagement';
    }
   protected function afterFind() {
       parent::afterFind();
       return true;
    }
    protected function beforeSave() {
        parent::beforeSave();   
        return true;
    }

    protected function gData() {  
        return $this->findAll('dataFlag=1 order by id');
    }

   public function downSelect($form,$m,$atts,$onchange='',$noneshow=''){
     return BaseLib::model()->selectByData($form,$m,$atts,$this->gData(),'roleName',$onchange,$noneshow);
    }
   
    public function downSearch($title,$filedname){
     return BaseLib::model()->searchBy($title,$filedname,$this->gData(),'roleName');
    }



}
