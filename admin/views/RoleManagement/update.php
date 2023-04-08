<div class="box">
 <?php 
  $title='角色管理';
  $inputCmd='1:3=roleName;roleExplain;roleCode';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox( $this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
