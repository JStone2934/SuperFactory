<div class="box">    
 <?php 
  $title='会员信息编辑';
  $inputCmd='1:3=member_code;name;sex;contact_phone;member_type:list(Member_type);address;birth:date;ID_number;remark;introduce';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  BaseLib::model()->updateBox($this,$model,$inputCmd,$title,$comstr);
 ?>
</div><!--box end-->
