<?php    

class CollectionType extends BaseModel
{

    public function tableName()
    {
        return '{{collection_type}}';
    }

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
            'id' =>  'id',
            'collection_type_code' => '编码',
            'type' =>  '收款类型',
            'dataFlag' =>  '使用',
            'remark' =>  '备注',
        );
    }
    //collection_type_code,type,dataFlag,remark

    /**
     * Returns the static model of the specified AR class.
     */
    public function getCode()
    {
        return $this->findAll('1=1');
    }

    protected function gData() {  
        return $this->findAll('dataFlag=1 order by id');
    }

   public function downSelect($form,$m,$atts,$onchange='',$noneshow=''){
     return BaseLib::model()->selectByData($form,$m,$atts,$this->gData(),'type',$onchange,$noneshow);
    }
   
    public function downSearch($title,$filedname){
     return BaseLib::model()->searchBy($title,$filedname,$this->gData(),'type');
    }

}
