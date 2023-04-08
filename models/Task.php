<?php
class Task extends BaseModel
{
    public function tableName()
    {
        return '{{task}}'; //数据表名称
    }

    /**  模型验证规则*/
    public function rules()
    {
        return array(
            array('task_code,grade,style,competition,commit_time,release_time,start_time,end_time', 'required', 'message' => '{attribute} 不能为空'),
            array($this->safeField(), 'safe'),
        );
    }

    /** 属性标签*/
    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'task_code' => '编码',
            'grade' => '年级',
            'style' => '文体',
            'competition' => '比赛名称',
            'content' => '详细说明',
            'introduce' => '比赛简介',
            'commit_time' => '提交时间',
            'release_time' => '发布时间',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'file' => '文档',
            'attachment' => '附件',
            'icon' => '图标',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCode()
    {
        return $this->findAll('1=1'); 
    }
}
