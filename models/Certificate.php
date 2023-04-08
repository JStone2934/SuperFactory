<?php
class Certificate extends BaseModel
{
    public function tableName()
    {
        return '{{certificate}}';
    }

    /**  模型验证规则*/
    public function rules()
    {
        return array(
            array('certificate_code', 'required', 'message' => '{attribute} 不能为空'),
            array($this->safeField(), 'safe'),
        );
    }

    /** 属性标签*/
    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'certificate_code' => '编码',
            'image' => '证书图片',
            'article_number' => '货号',
            'sale_number' => '销售单号',
            'sale_statu' => '销售状态',
            'type' => '证书类别',
            'commit_time' => '提交时间', 
        );
    }
    //certificate_code,image,article_number,sale_statu,type,commit_time

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCode()
    {
        return $this->findAll('1=1'); 
    }

    protected function gData() {  
        return $this->findAll('dataFlag=1 order by id');
    }

   public function downSelect($form,$m,$atts,$onchange='',$noneshow=''){
     return BaseLib::model()->selectByData($form,$m,$atts,$this->gData(),'sale_statu',$onchange,$noneshow);
    }
   
    public function downSearch($title,$filedname){
     return BaseLib::model()->searchBy($title,$filedname,$this->gData(),'sale_statu');
    }
}
