<?php 
    $apply_title_=BaseCode::model()->findAll(" LEFT(f_type,11)='APPLY_TITLE'");
    $apply_title_=toIoArray($apply_title_,'f_name,f_type,f_type_CN');
 ?>
  
<script>
    var apply_title_var= <?php echo json_encode($apply_title_)?>;
</script>

<div class="box">
    <div class="box-title c">
        <h2>
            <i class="fa fa-table"></i>
            当前界面：基本情况》<span style="color:DodgerBlue">个人信息</span>
            <span class="back">
            </span>
        </h2>
    </div><!--box-title end-->
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail">
            <div style="display:block;" class="box-detail-tab-item">

                <div class="mt15">
                    <table style='margin-top:5px;'>
                        <tr class="table-title"><td colspan="6">申报情况<span class="msgstr" style="color:#CCCCCC">申报类型中的转评指转系列申报评审(如高级实验师转评副教授等)</span></td></tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'apply_series'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'apply_series', Chtml::listData(BaseCode::model()->getByType('apply_series'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'apply_series', Chtml::listData(BaseCode::model()->getByType('apply_series'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:90%;','onchange' =>'selectOnchangapply_series(this)',)); ?>
                                <?php echo $form->error($model, 'apply_series', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'apply_title'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'apply_title', Chtml::listData(BaseCode::model()->getByType('ASSESS_TECHNIC'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php
                               //$csd=BaseCode::model()->findAll(); 
                                 $cds=BaseCode::model()->getByType2($model->apply_series);
                                echo Select2::activeDropDownList($model, 'apply_title', Chtml::listData($cds, 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;','onchange' =>'selectOnchangapply_title(this)',)); ?>
                                <?php echo $form->error($model, 'apply_title', $htmlOptions = array());?>
                            </td>


                            <td>
                                <span id="apply_nature_label" style="display: none"><?php echo $form->labelEx($model, 'apply_nature').' '; ?><span class="required">*</span></span>
                            </td>
                            <td>
                                 <span id="apply_nature_content" style="display: none">
<!--                                --><?php //echo $form->dropDownList($model, 'apply_nature', Chtml::listData(BaseCode::model()->getByType('apply_nature'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                 <?php echo Select2::activeDropDownList($model, 'apply_nature', Chtml::listData(BaseCode::model()->getByType('apply_nature'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                     <?php echo $form->error($model, 'apply_nature', $htmlOptions = array());?>
                                 </span>
                            </td>




                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'apply_type'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'apply_type', Chtml::listData(BaseCode::model()->getByType('apply_type'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'apply_type', Chtml::listData(BaseCode::model()->getByType('apply_type'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;','onchange' =>'selectOnchangapply_type(this)')); ?>
                                <?php echo $form->error($model, 'apply_type', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'apply_subject_type'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'apply_subject_type', Chtml::listData(BaseCode::model()->getByType('apply_subject_type'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'apply_subject_type', Chtml::listData(BaseCode::model()->getByType('apply_subject_type'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'apply_subject_type', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'apply_subject'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'apply_subject', Chtml::listData(BaseCode::model()->getByType('subject_group'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'apply_subject', Chtml::listData(BaseCode::model()->getByType('APPLY_SUBJECT'), 'f_name', 'f_name','f_group'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'apply_subject', $htmlOptions = array());?>
                            </td>
                        </tr>

                        <tr  id="poge" style="display:none;">

                            <td colspan="1">
                                <?php echo $form->labelEx($model, 'poge_condition').'(限填50字)'; ?><span class="required">*</span>
                            </td>
                            <td colspan="2">
                                <?php echo $form->textArea($model, 'poge_condition', array('class' => 'input-text', 'style'=>'width:97%;height:35px;resize:none','maxlength' => '50')); ?>
                                <?php echo $form->error($model, 'poge_condition', $htmlOptions = array()); ?>
                            </td>
                            <td colspan="1"><?php echo $form->labelEx($model, 'poge_fujian'); ?><span class="required">*</span></td>
                            <td colspan="2">
                                <?php echo $form->hiddenField($model, 'poge_fujian', array('class' => 'input-text fl')); ?>
                                <?php echo show_pic($model->poge_fujian,get_class($model).'_poge_fujian')?>
                                <div> <script>we.uploadpic('<?php echo get_class($model);?>_poge_fujian', 'jpg');</script></div>
                                <?php echo $form->error($model, 'poge_fujian', $htmlOptions = array()); ?>
                            </td>

                        </tr>


                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'subject_group'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'subject_group', Chtml::listData(BaseCode::model()->getByType('apply_subject_type'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'subject_group', Chtml::listData(BaseCode::model()->getByType('subject_group'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'subject_group', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'apply_qualify'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'apply_qualify', Chtml::listData(BaseCode::model()->getByType('apply_qualify'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'apply_qualify', Chtml::listData(BaseCode::model()->getByType('apply_qualify'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'apply_qualify', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'research_direction').'(限填30字)'; ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model, 'research_direction', array('class' => 'input-text','maxlength'=>'30')); ?>
                                <?php echo $form->error($model, 'research_direction', $htmlOptions = array()); ?>
                            </td>
                        </tr>

                        <tr id="tr_qualify_fujian" style="display: none">
                            <td colspan="2">
                            </td>
                            <td colspan="2"><?php echo $form->labelEx($model, 'apply_qualify_fujian');echo'<span class="required">*</span>';echo '<br>';
                                echo "<span style='color: red'>请上传我国驻外使（领）馆出具的业绩成果材料真实性证明，或由国内三位同行专家出具的专业鉴定。</span>" ?></td>
                            <td colspan="2">
                                <?php echo $form->hiddenField($model, 'apply_qualify_fujian', array('class' => 'input-text fl')); ?>
                                <?php echo show_pic($model->apply_qualify_fujian,get_class($model).'_apply_qualify_fujian')?>
                                <div> <script>we.uploadpic('<?php echo get_class($model);?>_apply_qualify_fujian', 'jpg');</script></div>
                                <?php echo $form->error($model, 'apply_qualify_fujian', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'other_title'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'other_title', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'other_title', $htmlOptions = array()); ?>
                            </td>
                            <td></td>  <td></td>  <td></td>  <td></td>
                        </tr>

                    </table>
                    <table style='margin-top:-1px;'>
                        <tr class="table-title"><td colspan="6">基本情况</td></tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'teacher_code'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'teacher_code', array('class' => 'input-text','readonly'=>'readonly')); ?>
                                <?php echo $form->error($model, 'teacher_code', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'teacher_name'); ?>
                            </td>
                            <td><!-- <?php echo get_session('TNAME');?> -->
                                <?php echo $form->textField($model, 'teacher_name', array('class' => 'input-text','readonly'=>'readonly')); ?>
                                <?php echo $form->error($model, 'teacher_name', $htmlOptions = array()); ?>
                            </td>
                            <td colspan="2" rowspan="4">
                                <?php echo $form->hiddenField($model, 'head_portrait', array('class' => 'input-text fl')); ?>
                                <?php if($model->head_portrait!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_head_portrait"><a href="<?php echo $model->head_portrait;?>" target="_blank"><img src="<?php echo $model->head_portrait;?>"  width="100"></a></div><?php }?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model);?>_head_portrait', 'jpg');
                                </script>
                                <?php echo $form->error($model, 'head_portrait', $htmlOptions = array()); ?>
                                <span class="msgstr" style="color:#CCCCCC">1、照片背景颜色应为红底或蓝底;<br>2、照片为jpg格式，大小在600k以内，像素不小于128×180”；<br>3、评审通过后，相片用于电子职称证书制作，请务必按要求上传照片。</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'work_unit'); ?>
                            </td>
                            <td>
                                <?php echo Select2::activeDropDownList($model, 'work_unit', Chtml::listData(BaseCode::model()->getByType('work_unit'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'work_unit', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'gender'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'gender', Chtml::listData(BaseCode::model()->getByType('gender'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'gender', Chtml::listData(BaseCode::model()->getByType('gender'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'gender', $htmlOptions = array());?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'birth_date'); ?>
                            </td>
                            <td>
                                <!-- <?php echo $form->textField($model, 'birth_date', array('class' => 'Wdate','readonly'=>'readonly')); ?>
                                <?php echo $form->error($model, 'birth_date', $htmlOptions = array()); ?> -->
                                <?php echo $form->textField($model, 'birth_date', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'birth_date', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'native_place'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'native_place', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'native_place', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'id_card_no'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'id_card_no', array('class' => 'input-text','maxlength' => '18','minlength' => '8')); ?>
                                <?php echo $form->error($model, 'id_card_no', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'nation'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'nation', Chtml::listData(BaseCode::model()->getByType('nation'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'nation', Chtml::listData(BaseCode::model()->getByType('nation'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'nation', $htmlOptions = array());?>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'politic_countenance'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'politic_countenance', Chtml::listData(BaseCode::model()->getByType('politic_countenance'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'politic_countenance', Chtml::listData(BaseCode::model()->getByType('politic_countenance'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'politic_countenance', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'employment_date'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'employment_date', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'employment_date', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'admission_date'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'admission_date', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'admission_date', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'teacher_id'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'teacher_id', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'teacher_id', $htmlOptions = array()); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'teacher_certificate'); ?><span class="required" style="display: none" id="span_teacher_certificate">*</span></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'teacher_certificate', array('class' => 'input-text fl')); ?>

                                <?php echo show_pic($model->teacher_certificate,get_class($model).'_teacher_certificate')?>


                                <div> <script>we.uploadpic('<?php echo get_class($model);?>_teacher_certificate', 'jpg');</script></div>
                                <?php echo $form->error($model, 'teacher_certificate', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'current_title'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'current_title', Chtml::listData(BaseCode::model()->getByType('current_title'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'current_title', Chtml::listData(BaseCode::model()->getByType('current_title'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'current_title', $htmlOptions = array());?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'title_certificate'); ?><span class="required" id="span_title_certificate">*</span></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'title_certificate', array('class' => 'input-text fl')); ?>
                                <?php echo show_pic($model->title_certificate,get_class($model).'_title_certificate')?>
                                <div> <script>we.uploadpic('<?php echo get_class($model);?>_title_certificate', 'jpg');</script></div>
                                <?php echo $form->error($model, 'title_certificate', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'title_get_time'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'title_get_time', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'title_get_time', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'job_category'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'job_category', Chtml::listData(BaseCode::model()->getByType('job_category'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'job_category', Chtml::listData(BaseCode::model()->getByType('job_category'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'job_category', $htmlOptions = array());?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'person_type'); ?>
                            </td>
                            <td>
<!--                                --><?php //echo $form->dropDownList($model, 'person_type', Chtml::listData(BaseCode::model()->getByType('person_type'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                <?php echo Select2::activeDropDownList($model, 'person_type', Chtml::listData(BaseCode::model()->getByType('person_type'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:95%;')); ?>
                                <?php echo $form->error($model, 'person_type', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'phone_num'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'phone_num', array('class' => 'input-text','maxlength' => '11')); ?>
                                <?php echo $form->error($model, 'phone_num', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'office_phone'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'office_phone', array('class' => 'input-text','maxlength' => '10')); ?>
                                <?php echo $form->error($model, 'office_phone', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'assess_desc'); ?>
                            </td>
                            <td colspan="5">
                                <?php echo $form->textArea($model, 'assess_desc', array('class' => 'input-text','placeholder'=>"范例: 2012.12, 华南师范大学教师专业技术资格评审委员会评定高等教育学副教授资格")); ?>
                                <?php echo $form->error($model, 'assess_desc', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'post_desc'); ?>
                            </td>
                            <td colspan="5">
                                <?php echo $form->textArea($model, 'post_desc', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'post_desc', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'current_job'); ?>
                            </td>
                            <td colspan="2">
                                <?php echo $form->textField($model, 'current_job', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'current_job', $htmlOptions = array()); ?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'tenure'); ?>
                            </td>
                            <td colspan="2">
                                <?php echo $form->textField($model, 'tenure', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'tenure', $htmlOptions = array()); ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $form->label($model, 'reduction_year'); ?>
                            </td>
                            <td colspan="2">
                                <?php echo $form->textField($model, 'reduction_year', array('class' => 'input-text')); //,'readonly'=>'readonly')
                                    ?>
                                <?php echo $form->error($model, 'reduction_year', $htmlOptions = array());?>
                            </td>

                            <td>
                                <span style="display: none" id="span_supporting_materials_label">
                                    <?php echo $form->label($model, 'supporting_materials'); ?><span class="required"> </span>
                                </span>
                            </td>
                            <td colspan="2">
                                <div style="display: none" id="div_supporting_materials">
                                    <?php echo $form->hiddenField($model, 'supporting_materials', array('class' => 'input-text fl')); ?>
                                    <?php echo show_pic($model->supporting_materials,get_class($model).'_'.'supporting_materials')?>
 <div> <script>we.uploadpic('<?php echo get_class($model);?>_supporting_materials', 'jpg');</script></div>
                                    <?php echo $form->error($model, 'supporting_materials', $htmlOptions = array()); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'computer_skill'); ?>
                            </td>
                            <td colspan="2">
                                <?php echo $form->textField($model, 'computer_skill', array('class' => 'input-text','readonly'=>'readonly','value'=>'不作要求','style'=>'color:#C0C0C0')); ?>
                                <?php echo $form->error($model, 'computer_skill', $htmlOptions = array());?>
                            </td>
                            <td>
                                <?php echo $form->labelEx($model, 'title_foreign_language'); ?>
                            </td>
                            <td colspan="2">
                                <?php echo $form->textField($model, 'title_foreign_language', array('class' => 'input-text','readonly'=>'readonly','value'=>'不作要求','style'=>'color:#C0C0C0')); ?>
                                <?php echo $form->error($model, 'title_foreign_language', $htmlOptions = array());?>
                            </td>
                        </tr>
                        <tr>
                            <td ><?php echo $form->labelEx($model, 'current_work'); ?></td>
                            <td colspan="2">
                                <?php echo $form->textField($model, 'current_work', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'current_work', $htmlOptions = array()); ?>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'last_year_result'); ?>
                            </td>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td>
                                            <?php
                                            echo $form->textField($model, 'last_year_time', array('class' => 'input-text','style'=>'width:40px;','value'=>get_year()-1));
                                            ?>
                                            <?php echo $form->error($model, 'last_year_time', $htmlOptions = array()); ?>
                                        </td>
                                        <td>
<!--                                            --><?php //echo "考核结果："; echo $form->dropDownList($model, 'last_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                            <?php echo Select2::activeDropDownList($model, 'last_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:120px;')); ?>
                                            <?php echo $form->error($model, 'last_year_result', $htmlOptions = array());?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $form->textField($model, 'last_two_year_time', array('class' => 'input-text','style'=>'width:40px;','value'=>get_year()-2));
                                            ?>
                                            <?php echo $form->error($model, 'last_two_year_time', $htmlOptions = array()); ?>
                                        </td>
                                        <td>
<!--                                            --><?php //echo "考核结果："; echo $form->dropDownList($model, 'last_two_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                            <?php echo Select2::activeDropDownList($model, 'last_two_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:120px;')); ?>
                                            <?php echo $form->error($model, 'last_two_year_result', $htmlOptions = array());?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $form->textField($model, 'last_three_year_time', array('class' => 'input-text','style'=>'width:40px;','value'=>get_year()-3));
                                            ?>
                                            <?php echo $form->error($model, 'last_three_year_time', $htmlOptions = array()); ?>
                                        </td>
                                        <td>
<!--                                            --><?php //echo "考核结果："; echo $form->dropDownList($model, 'last_three_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                            <?php echo Select2::activeDropDownList($model, 'last_three_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:120px;')); ?>
                                            <?php echo $form->error($model, 'last_three_year_result', $htmlOptions = array());?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            echo $form->textField($model, 'last_four_year_time', array('class' => 'input-text','style'=>'width:40px;','value'=>get_year()-4));
                                            ?>
                                            <?php echo $form->error($model, 'last_four_year_time', $htmlOptions = array()); ?>
                                        </td>
                                        <td>
<!--                                            --><?php //echo "考核结果："; echo $form->dropDownList($model, 'last_four_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                            <?php echo Select2::activeDropDownList($model, 'last_four_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:120px;')); ?>
                                            <?php echo $form->error($model, 'last_four_year_result', $htmlOptions = array());?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $form->textField($model, 'last_five_year_time', array('class' => 'input-text','style'=>'width:40px;','value'=>get_year()-5));
                                            ?>
                                            <?php echo $form->error($model, 'last_five_year_time', $htmlOptions = array()); ?>
                                        </td>
                                        <td>
<!--                                            --><?php //echo "考核结果："; echo $form->dropDownList($model, 'last_five_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择')); ?>
                                            <?php echo Select2::activeDropDownList($model, 'last_five_year_result', Chtml::listData(BaseCode::model()->getByType('assess_result'), 'f_name', 'f_name'), array('prompt'=>'请选择','style'=>'width:120px;')); ?>
                                            <?php echo $form->error($model, 'last_five_year_result', $htmlOptions = array());?>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </table>
                            </td>
<!--                    <tr>-->
<!--                        <td>--><?php //echo $form->labelEx($model, 'teacher_name'); ?><!--</td>-->
<!--                        <td>--><?php //echo $form->textField($model, 'teacher_name', array('class' => 'input-text')); ?><!--</td>-->
<!--                        <td>--><?php //echo $form->labelEx($model, 'teacher_code'); ?><!--</td>-->
<!--                        <td>--><?php //echo $form->textField($model, 'teacher_code', array('class' => 'input-text')); ?><!--</td>-->
<!--                    </tr>-->

                    </table>
                    </table>


                </div>

            </div><!--box-detail-tab-item end   style="display:block;"-->

        </div><!--box-detail-bd end-->

        <div class="box-detail-submit">
        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                           
<!--            <a class="btn" href="--><?php //echo $this->createUrl('datasubmit');?><!--"><i class="fa fa-check-square-o"></i>完成</a>-->
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

    //加载初始化
    $(document).ready(function () {
        if ($("#BaseInfo_apply_qualify").val()==='海外高层次留学回国人员' ) {
            $('#tr_qualify_fujian').show();
        }
        if($('#BaseInfo_apply_title').val()==='教授'||$('#BaseInfo_apply_title').val()==='副教授')
        {
            $('#apply_nature_label').show();
            $('#apply_nature_content').show();
        }

        if($('#BaseInfo_apply_type').val()=='破格申报'){
            $('#poge').show();
        }
        if ($("#BaseInfo_reduction_year").val()==='' || $("#BaseInfo_reduction_year").val()==='无') {
            $("#div_supporting_materials").hide();
        }
        else{
            $("#div_supporting_materials").show();
            $("#span_supporting_materials_label").show();
        }
        if( $('#BaseInfo_teacher_id').val()!=''){
            $('#span_teacher_certificate').show();
        }


        if ($('#BaseInfo_current_title').val()!='无') {
            $('#span_title_certificate').show();
        }
    })



    $('#BaseInfo_birth_date').on('click', function(){
        WdatePicker({startDate:'%y-%M',dateFmt:'yyyy-MM'});
    });
    $('#BaseInfo_employment_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $('#BaseInfo_admission_date').on('click', function(){
        WdatePicker({startDate:'%y-%M',dateFmt:'yyyy-MM'});
    });
    $('#BaseInfo_tenure').on('click', function(){
        WdatePicker({startDate:'%y-%M',dateFmt:'yyyy-MM'});
    });
    $('#BaseInfo_title_get_time').on('click', function(){
        WdatePicker({startDate:'%y-%M',dateFmt:'yyyy-MM'});
    });
    $('#BaseInfo_last_year_time').on('click', function(){
        WdatePicker({startDate:'%y',dateFmt:'yyyy'});
    });
    $('#BaseInfo_last_two_year_time').on('click', function(){
        WdatePicker({startDate:'%y',dateFmt:'yyyy'});
    });
    $('#BaseInfo_last_three_year_time').on('click', function(){
        WdatePicker({startDate:'%y',dateFmt:'yyyy'});
    });
    $('#BaseInfo_last_four_year_time').on('click', function(){
        WdatePicker({startDate:'%y',dateFmt:'yyyy'});
    });
    $('#BaseInfo_last_five_year_time').on('click', function(){
        WdatePicker({startDate:'%y',dateFmt:'yyyy'});
    });

    //教师资格证书扫描件
    $('#BaseInfo_teacher_id').on('input propertychange',
        function () {
            if( $('#BaseInfo_teacher_id').val()!=''){
                $('#span_teacher_certificate').show();
            }
            else{
                $('#span_teacher_certificate').hide();
            }
        }
    )

//教学减免
    $('#BaseInfo_reduction_year').on('input propertychange',
        function () {
            if ($("#BaseInfo_reduction_year").val()==='' || $("#BaseInfo_reduction_year").val()==='无') {
                $("#div_supporting_materials").hide();
                $("#span_supporting_materials_label").hide();
                $('#BaseInfo_supporting_materials').val('');
            }
            else{
                $("#div_supporting_materials").show();
                $("#span_supporting_materials_label").show();

            }
        }
    );


    //职称证书

    $('#BaseInfo_current_title').change(
        function () {
            if ($('#BaseInfo_current_title').val()!='无') {
                $('#span_title_certificate').show();
            }
            else{
                $('#span_title_certificate').hide();
            }
        }
    );

    //资格附件
    $('#BaseInfo_apply_qualify').change(
        function () {
            if ($("#BaseInfo_apply_qualify").val()==='海外高层次留学回国人员' ) {
                $('#tr_qualify_fujian').show();
            }
            else{
                $('#tr_qualify_fujian').hide();
                $('#BaseInfo_apply_qualify_fujian').val('');

            }
        }
    );

    //申报系列-职称，联动显示
    var sname='<?php echo $model->apply_title; ?>';
    var ser='<?php echo $model->apply_series; ?>';
    selectOnchangapply_series('#BaseInfo_apply_series');
    function selectOnchangapply_series(obj){
        var show_id=$(obj).val();
        var code,c1,c2;
        var code1;
        var p_html ='<option value="">请选择</option>';
         if (show_id==undefined){
          show_id=ser;  
         }
        if (!(show_id==undefined)) {
            for (j=0;j<apply_title_var.length;j++) {
                if(apply_title_var[j]['f_type_CN']=='申报职称（'+show_id+'）'){
                 c2=we.trim(apply_title_var[j]['f_name'],' ');
                c1='';
                if (c2==sname){c1='selected';}
                 p_html = p_html +'<option value="'+c2+'"'+c1+'>';
                 p_html = p_html +c2+'</option>';
                }
            }
            $("#BaseInfo_apply_title").html(p_html);
        }     
    }

//申报类别
    selectOnchangapply_title('#BaseInfo_apply_title');
    function selectOnchangapply_title(obj){
        if($(obj).val()==='教授'||$(obj).val()==='副教授'){
            $('#apply_nature_content').show();
            $('#apply_nature_label').show();
            $('#BaseInfo_apply_nature').validate('required');
        }
        else
        {
            $('#apply_nature_content').hide();
            $('#apply_nature_label').hide();
            $('#BaseInfo_apply_nature').val('');
        }
    }


//破格申报
    selectOnchangapply_type('#BaseInfo_apply_type');
    function selectOnchangapply_type(obj){
        if($(obj).val()==='破格申报'){
            $('#poge').show();
        }
        else
        {
            $('#poge').hide();
            $('#BaseInfo_poge_fujian').val('');
            $('#BaseInfo_poge_condition').val('');

        }
    }




</script>