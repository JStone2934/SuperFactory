
<div class="box">
    <div class="box-title c">
        <h2>
            <i class="fa fa-table"></i>
            当前界面：基本数据维护》单位角色授权管理》<span style="color:DodgerBlue">详情</span>
            <span class="back">
            <a2 class="btn" href="javascript:;" onclick="we.back();">
                <class="fa fa-reply"></i>
                返回
            </a2>
            </span>
        </h2>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div style="display:block;" class="box-detail-tab-item">
            <div class="mt15">
                <table>
                <tr class="table-title"><td colspan="4">单位角色授权管理</td></tr>
                   <?php
                     echo  BaseLib::model()->tableInput($form,$model,'roleCode,dataFlag:YN;roleName:1:3;roleDesc:1:3;');
                    ?>
                    <tr>
                    <td colspan="1">功能授权</td>
                    <td colspan="3">
                     <span style="font-size: larger;">填报模块</span>
                            <button id="SelectAll_jstb" class="btn" type="button" >全选</button>
                            <button id="SelectAll_jstb_qx" class="btn" type="button" style="margin-right: 60px">取消</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="subnav" colspan="4">
                            <input id="ytRole_f_opter" type="hidden" value="" name="Role[f_opter]">
                            <span id="Role_f_opter">
                            <?php 
                            $r=-1; 
                            $pmenu=Menu::model()->mainMenu();
                            $model->tmp_opter2=array();
                            foreach( $pmenu as $v){
                                $r+=1;
                                ?>
                                <div class="subnav-hd"><a href="javascript:;"><i class="fa fa-angle-down"></i><?php echo $v->f_group;?></a></div>
                                <ul class="subnav-bd">
                    <?php
                       $w1="f_show=1 and f_mcode='".$v->f_mcode."' and f_group='".$v->f_group."'";
                       $tmp=Menu::model()->findAll($w1.' order by f_code ');
                       put_msg($w1);
                       $tmenu=Chtml::listData($tmp,'id', 'f_name');
                       $id=-1;
                       if($model) $id=$model->roleId;
                       if(empty($id)) $id=-1;
                       $ra=RoleData::model()->getRoleIds($id,$v->f_mcode,$v->f_group); 
                       put_msg($ra);
                       $model->tmp_opter2[$r]=$ra[0];
                       put_msg( $model->tmp_opter2);
                       echo $form->checkBoxList($model,'tmp_opter2['.$r.']',$tmenu, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
                    ?>
                                </ul>
                            <?php }?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div><!--box-detail-tab-item end   style="display:block;"-->

    </div><!--box-detail-bd end-->

    <div class="box-detail-submit">
        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
        <button class="btn" type="button" onclick="we.back();">取消</button>
    </div>

    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->

<script>
    $('#SelectAll_jstb').click( function () {setRole(true);})
    $('#SelectAll_jstb_qx').click( function () { setRole(false);})
    function setRole(ccheck,msg){
        for( var i =0;i<32;i++){
           for( var i1 =0;i1<12;i1++)
             $('#Role_tmp_opter2_'+i+"_"+i1).prop("checked",ccheck);
        }
    }
</script>
<?php $cs = Yii::app()->clientScript;$ul=Yii::app()->request->baseUrl.'/static/admin/';?>
<?php $cs->registerCssFile($ul.'css/public.css');?>
<?php $cs->registerCssFile($ul.'css/font.css');?>
<?php $cs->registerCssFile($ul.'css/index.css');?>
<?php $cs->registerScriptFile($ul.'js/jquery.nicescroll.js', CClientScript::POS_END);?>
<?php $cs->registerScriptFile($ul.'js/index.js', CClientScript::POS_END);?>

