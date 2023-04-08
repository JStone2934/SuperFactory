<div class="box">    
 <?php 
  $title='添加工程';
  $inputCmd='1:3=project_code;relative_subjects;driving_question;discription;guiding_question;required_knowledge;success_skill;standard;NGSS;arrangement_file:pic';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
