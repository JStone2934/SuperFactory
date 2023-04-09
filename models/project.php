<?php
class project extends BaseModel {

    public function tableName() {
        return '{{project}}';
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
            'project_name'=>'工程名称',
            'project_start_time'=>'工程开始时间',
            'project_end_time'=>'工程结束时间',
            'project_last_time'=>'工程持续时间',
            'relative_subjects'=>'相关学科',
            'teacher_name'=>'教师',
            'teacher_age'=>'年级/年龄',
            'driving_question'=>'驱动性问题',
            'discription'=>'项目描述',
            'guiding_question'=>'引导性问题',
            'required_knowledge'=>'关键知识和理解',
            'success_skill'=>'成功技巧',
            'standard'=>'中小学科学课标',
            'NGSS'=>'下代标准',
            'project_code'=>'工程编码',
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
    
    public  function pathLabels(){
        return '';
    }
}

