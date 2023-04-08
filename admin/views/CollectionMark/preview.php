<div class="box"> 
    <div class="box-title c">
        <h1>
            <i class="fa fa-table"></i>工单预览
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
                        <td colspan="9">工单信息</td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'sale_number'); ?></td>
                        <td colspan="7">
                            <?php echo $model->sale_number; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'item_name'); ?></td>
                        <td colspan="7">
                            <?php echo $model->item_name; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                        <td colspan="7">
                            <?php echo $model->order_type; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'goods_type'); ?></td>
                        <td colspan="7">
                            <?php echo $model->goods_type; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'customer_name'); ?></td>
                        <td colspan="7">
                            <?php echo $model->customer_name;?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'collection_type'); ?></td>
                        <td colspan="7">
                            <?php echo $model->collection_type; ?>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'pay_type'); ?></td>
                        <td colspan="7">
                            <?php echo $model->pay_type; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'money'); ?></td>
                        <td colspan="2">
                            <?php echo $model->money; ?>    
                        </td>

                        <td colspan="2"><?php echo $form->labelEx($model, 'worker_name'); ?></td>
                        <td colspan="3">
                            <?php echo $model->worker_name; ?>    
                        </td>
                    </tr>



                    <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'commit_time'); ?></td>
                        <td colspan="7">
                            <?php echo $model->commit_time; ?>
                        </td>
                    </tr>



                     <tr>
                        <td colspan="2"><?php echo $form->labelEx($model, 'remark'); ?></td>
                        <td colspan="7">
                            <?php echo $model->remark; ?>
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