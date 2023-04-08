<div class="box">      
 <?php  
  $title='添加收款';
  $inputCmd='1:5=sale_number;item_name;order_type:list(SaleStatu);goods_type:list(CertificateType);collection_type:list(CollectionType);pay_type:list(PayType);money;worker_name;commit_time:date;remark';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox( $this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
