<?php
class source extends BaseModel
{

    public function tableName()
    {
        return '{{source}}';
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
            'source_type' =>'类型',
            'source_code' =>'资源code',
            'source_url' =>'资源地址',
            'source_img' =>'资源图片',
            'function' =>'功能介绍',
        );
    }
//gem_code,gem_type,gem_image,gem_CertificateName,gem_CertificateCode,gem_shuliang
    /**
     * Returns the static model of the specified AR class.
     */

    public function getCode()
    {
        return $this->findAll('1=1');
    }

      public function picLabels() {
        return 'source_img';
    }
   
   public  function pathLabels(){
       return '';
   }
}
?>
