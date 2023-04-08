<?php
class member extends BaseModel {

    public function tableName() {
        return '{{member}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
      return $this->attributeRule();
    }


    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		 
		);
    }


    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
			'id'=>'ID',
			'member_code'=>'个人编码',
			'name'=>'姓名',
            'contact_phone'=>'联系电话',
			'member_type'=>'身份',
            'address'=>'地址',
            'status'=>'审核状态',
            'account_number'=>'账号',
            'ID_number'=>'身份证号',
            'image'=>'头像',
            'sex'=>'性别',
            'birth'=>'出生日期',
            'remark'=>'备注',
            'introduce'=>'个人介绍',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	

    public function getCode() {
        return $this->findAll('1=1');
    }
    public function picLabels() {
        return 'image';
    }
    public  function pathLabels(){
       return '';
   }
}
