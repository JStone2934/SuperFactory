<div class="box">    
   <?php 
       $title=array('','工程详情','');
       $schcmd='关键字=keyword';
       $coumnName='project_code,relative_subjects,driving_question,discription,guiding_question,required_knowledge,success_skill,standard,NGSS';
       $hw='';//0:5%,1:5%,2:5%,3:5%,4:10%,5:30%,6:5%,6:20%,6:5%';//每列的宽度
       $index=0;//是否显示序号 0 不显示  1 显示
       $idName='id';//关键字的属性名称
       $cmd='编辑:update_detail,删除';//操作的命令
       $data=array($index,$idName,$coumnName,$hw,$cmd);
       BaseLib::model()->indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
   ?>
</div><!--box end-->