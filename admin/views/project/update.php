<div class="box">    
 <?php 
  $title='添加工程';
  $inputCmd='1:3=project_name;project_start_time:date;project_end_time:date;project_last_time:date;relative_subjects;teacher_name;teacher_age;guiding_question;discription;driving_question;required_knowledge;success_skill;standard;NGSS;image:pic;arrangement_file:pic;project_code';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->

