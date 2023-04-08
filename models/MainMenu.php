<?php 

class MainMenu extends BaseModel {

    public function tableName() {
        return '{{menu_main}}';
    }

  /**
     * 模型关联规则
     */
    public function relations() {
        return array( );
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
            'f_code'  => '编码',
            'f_name'  => '名称',
            'f_image'  => '图标',
            'f_url'  => '连接地址',
            'f_show'  => '显示',
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

   public function getMenu() {
       // $s2=TeacherBase::model()->getRoleCode();
      //  $s1=Menu::model()->getMcodeSet();
        $w1=(empty($s2)) ? "" : " '".$s2."' like concat('%',trim(f_name),'%') and ";
        return  $this->findAll(" f_show=1  order by f_code");
    }
  
    public function checkList()
    {
      return checkListArray($this->findAll(' f_show=1 order by f_code'),'f_name');
    }
}
 