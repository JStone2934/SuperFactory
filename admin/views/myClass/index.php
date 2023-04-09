<div class="box">    
   <?php 
       $title=array('','课程管理','添加,刷新,删除,批删除');
       $schcmd='课程类型=type:list(myClass_type),关键字=keyword';
       $coumnName='project_name,class_type,class_name,teacher_name,information';
       $hw='';//0:5%,1:5%,2:5%,3:5%,4:10%,5:30%,6:5%,6:20%,6:5%';//每列的宽度
       $index=0;//是否显示序号 0 不显示  1 显示
       $idName='id';//关键字的属性名称
       $cmd='编辑:update,删除';//操作的命令
       $data=array($index,$idName,$coumnName,$hw,$cmd);
       BaseLib::model()->indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
   ?>
</div><!--box end-->
