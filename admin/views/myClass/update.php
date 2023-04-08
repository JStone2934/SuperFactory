<div class="box">    
 <?php 
  $title='添加课程';
  $inputCmd='1:3=project_name;class_name;class_type:list(myClass_type);start_time:date;end_time:date;last_time;information;class_session;class_address;class_time;teacher_name;image:pic;file:pic;class_code';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
