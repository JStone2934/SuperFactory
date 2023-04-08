<div class="box">
    <div class="box-title c">
        <h1>
            <i class="fa fa-table"></i>任务设立
        </h1>
        <span class="back" style="position: absolute;right:0px;">
            <a class="btn" href="<?php echo $this->createUrl('index') ?>">
                <i class="fa fa-reply"></i>返回
            </a>
        </span>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>

        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="9">稿件内容</td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'competition'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'competition', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'competition', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'grade'); ?></td>
                        <td colspan="2">
                            <?php
                            $SentenceGrade = SentenceGrade::model()->findAll();
                            echo Select2::activeDropDownList($model, 'grade', Chtml::listData($SentenceGrade, 'grade', 'grade'), array('prompt' => '请选择', 'style' => 'width:95%;', 'onchange' => 'selectOnchangapply_title(this)',));
                            ?>
                            <?php echo $form->error($model, 'grade', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'style'); ?></td>
                        <td colspan="2">
                            <?php
                            $SentenceStyle = SentenceStyle::model()->findAll();
                            echo Select2::activeDropDownList($model, 'style', Chtml::listData($SentenceStyle, 'style', 'style'), array('prompt' => '请选择', 'style' => 'width:95%;', 'onchange' => 'selectOnchangapply_title(this)',));
                            ?>
                            <?php echo $form->error($model, 'style', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'task_code'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'task_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'task_code', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'start_time'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'start_time', array('class' => 'input-text click_time')); ?>
                            <?php echo $form->error($model, 'start_time', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'end_time', array('class' => 'input-text click_time')); ?>
                            <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    </tr>
                        <td><?php echo $form->labelEx($model, 'release_time'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'release_time', array('class' => 'input-text click_time')); ?>
                            <?php echo $form->error($model, 'release_time', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'icon'); ?></td>
                        <td colspan="5">
                            <?php
                            set_session('datePath', 'articleNew/');
                            echo $form->hiddenField($model, 'icon', array('class' => 'input-text fl'));
                            ?>
                            
                            <script>
                                we.uploadpic('<?php echo get_class($model); ?>_icon', '', '', '', '', 0);
                            </script>

                            <?php echo $form->error($model, 'icon', $htmlOptions = array()); ?>
                        </td>
                    <tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'introduce'); ?></td>
                        <td colspan="8">
                            <?php echo $form->textArea($model, 'introduce', 
                            array('class' => 'input-text', 'style'=>'width:98%; height:150px; resize:none',' maxlength' => '1000', 'placeholder'=>"请输入比赛简介")); ?>
                            <?php echo $form->error($model, 'introduce', $htmlOptions = array());?>
                        </td>
                    </tr>

                    <tr id="news_content" ><!-- 富文本 -->
                        <td><?php echo $form->labelEx($model, 'content'); ?></td>
                        <td colspan="8">
                            <?php 
                            // set_session('contentPath', '../file/task/');
                            echo $form->hiddenField($model, 'content', array('class' => 'input-text')); ?>
                            <script>
                                we.editor('<?php echo get_class($model);?>_content', '<?php echo get_class($model);?>[content]','800','50%');
                            </script>
                            <?php echo $form->error($model, 'content', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'attachment'); ?></td>
                        <td colspan="8">
                            <?php
                            set_session('datePath', 'articleNew/');
                            echo $form->hiddenField($model, 'attachment', array('class' => 'input-text fl'));
                            ?>
                            
                            <script>
                                we.uploadpic('<?php echo get_class($model); ?>_attachment', '', '', '', '', 0);
                            </script>

                            <?php echo $form->error($model, 'attachment', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                </table>

            </div>
            <!--box-detail-tab-item end   style="display:block;"-->

        </div>
        <!--box-detail-bd end-->

        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <!--box-detail end-->
</div>
<!--box end-->
<script>
    $(function() {
        var start_time = $('#<?php echo get_class($model);?>_start_time');
        var end_time = $('#<?php echo get_class($model);?>_end_time');
        var release_time = $('#<?php echo get_class($model);?>_release_time');
        start_time.on('click', function() {
            WdatePicker({start_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
        end_time.on('click', function() {
            WdatePicker({end_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
        release_time.on('click', function() {
            WdatePicker({release_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
    });
</script>