<div class="box">    
   <?php 
       $title=array('','会员添加','添加,删除,批删除');
       $schcmd='身份=type:list(Member_type),关键字=keyword';
       $coumnName='member_code,name,account_number,sex,contact_phone,member_type,status,image:pic';
       $hw='';//0:5%,1:5%,2:5%,3:5%,4:10%,5:30%,6:5%,6:20%,6:5%';//每列的宽度
       $index=0;//是否显示序号 0 不显示  1 显示
       $idName='id';//关键字的属性名称
       $cmd='编辑:update_edit,删除';//操作的命令
       $data=array($index,$idName,$coumnName,$hw,$cmd);
       BaseLib::model()->indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
   ?>
</div><!--box end-->
