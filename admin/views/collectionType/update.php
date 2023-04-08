<div class="box">      
 <?php  
  $title='收款类型设置';
  $inputCmd='1:3=collection_type_code;type;dataFlag:YN;remark';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox( $this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
