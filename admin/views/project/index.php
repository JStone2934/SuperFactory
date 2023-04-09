<div class="box">    
   <?php 
       $title=array('','工程管理','添加,刷新,删除,批删除');
       $schcmd='关键字=keyword';
       $coumnName='project_code,project_name,project_start_time,project_end_time,project_last_time,teacher_name,teacher_age';
       $hw='0:6%,1:12%,2:15%,3:15%,4:15%,5:13%,6:13%,7:16%,8:10%,10:7%';//0:5%,1:5%,2:5%,3:5%,4:10%,5:30%,6:5%,6:20%,6:5%';//每列的宽度
       $index=0;//是否显示序号 0 不显示  1 显示
       $idName='id';//关键字的属性名称
       $cmd='编辑:update,删除';//操作的命令
       $data=array($index,$idName,$coumnName,$hw,$cmd);
       BaseLib::model()->indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
   ?>
</div><!--box end-->