<div class="box">    
 <?php 
  $title='RoboMaster资源管理';
  $inputCmd='1:3=function;source_code;source_url;source_type:list(source_type);source_img:pic';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
