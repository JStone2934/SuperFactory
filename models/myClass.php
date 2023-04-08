<?php
class myClass extends BaseModel {

    public function tableName() {
        return '{{myClass}}';
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
			'project_name'=>'所属工程名称',
			'class_name'=>'课程名称',
            'class_type'=>'课程类型',
			'start_time'=>'课程开始时间',
            'end_time'=>'课程结束时间',
            'last_time'=>'课程持续时间(天)',
            'information'=>'课程信息',
            'class_session'=>'上课时间',
            'class_address'=>'上课地点',
            'class_time'=>'课次',
            'teacher_name'=>'教师姓名',
            'image'=>'课程图片',
            'file'=>'文件',
            'class_code'=>'课程编码',
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
        return 'image,file';
    }
    public  function pathLabels(){
       return '';
   }
}
