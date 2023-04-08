  
<div class="box">
   <?php 
       $title=array('角色权限设置','角色管理','添加,刷新,删除,批删除');
       $schcmd='关键字=keywords';
       $coumnName='roleCode,roleName,roleDesc,privileges,dataFlag:YN';
       $hw='0:4%,1:7%,2:8%,3:65%,4:4%';//0:10%,1:5%,2:15%,3:50%,4:10%,5:5%,6:5%';//每列的宽度
       $index=0;//是否显示序号 0 不显示  1 显示
       $idName='roleId';//关键字的属性名称
       $cmd='编辑:update,删除';//操作的命令
       $data=array($index,$idName,$coumnName,$hw,$cmd);
       BaseLib::model()->indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
   ?>
</div><!--box end-->
