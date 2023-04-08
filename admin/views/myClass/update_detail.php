<div class="box">    
 <?php 
  $title='添加课程';
  $inputCmd='1:3=project_name;class_type:list(myClass_type);class_name;teacher_name;information;image:pic;file:pic';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
