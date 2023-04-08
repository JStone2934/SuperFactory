<div class="box">    
 <?php 
  $title='添加会员';
  $inputCmd='1:3=member_code;name;sex;contact_phone;member_type:list(Member_type);address;birth:date;ID_number;image:pic;remark;introduce';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
