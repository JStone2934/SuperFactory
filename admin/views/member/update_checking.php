<div class="box">    
 <?php 
  $title='审核界面';
  $inputCmd='1:3=member_code;name;sex;contact_phone;member_type:list(Member_type);address;birth:date;account_number;ID_number;image:pic;remark;introduce;status:list(status)';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
