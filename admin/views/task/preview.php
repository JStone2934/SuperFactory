<div class="box">
    <div class="box-title c">
        <h1>
            <i class="fa fa-table"></i>征文预览
        </h1>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <!--box-detail-tab end-->

        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">

                <table>
                    <tr class="table-title">
                        <td colspan="9">征文信息</td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'competition'); ?></td>
                        <td colspan="7">
                            <?php echo $model->competition; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'introduce'); ?></td>
                        <td colspan="7">
                            <?php echo $model->introduce; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'grade'); ?></td>
                        <td colspan="7">
                            <?php echo $model->grade; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'style'); ?></td>
                        <td colspan="7">
                            <?php echo $model->style; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">征集时间</td>
                        <td colspan="7">
                            <?php echo $model->start_time.' ---- '.$model->end_time;?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="9" style="text-align: center;">
                            <span style="font-weight: bold;"><?php echo $form->labelEx($model, 'content');?></span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="9">
                            <?php echo $model->content; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'release_time'); ?></td>
                        <td colspan="3">
                            <?php echo $model->release_time; ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'commit_time'); ?></td>
                        <td colspan="3">
                            <?php echo $model->commit_time; ?>
                        </td>
                    </tr>

                </table>

            </div>
            <!--box-detail-tab-item end   style="display:block;"-->

        </div>
        <!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div>
    <!--box-detail end-->
</div>
<!--box end-->