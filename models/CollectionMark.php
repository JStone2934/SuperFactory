<?php 
class CollectionMark extends BaseModel {
    public function tableName() {
        return '{{collection_mark}}';
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
            'id' => 'id',
            'item_name' => '货物名',
            'order_type' => '订单类型',
            'goods_type' => '货品类型',
            'sale_number' => '销售单号',
            'collection_type' => '收款类型',
            'customer_name' => '客户姓名',
            'customer_telephone_number' => '客户电话',
            'pay_type' => '支付方式',
            'money' => '支付金额',            
            'worker_name' => '收款人姓名',
            'commit_time' => '提交时间',
            'remark' => '备注',
        );
      }
//sale_number,item_name,order_type,goods_type,collection_type,pay_type,money,worker_name,commit_time,remark
    public  function pathLabels(){
        return 'collectionMark';
    }
   protected function afterFind() {
       parent::afterFind();
       return true;
    }
    protected function beforeSave() {
        parent::beforeSave();   
        $this->commit_time=date('Y-m-d H:i:s');
        return true;
    }


}
