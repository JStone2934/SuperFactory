<div class="box">
    <div class="box_title c" style="padding: 10px 0 7px 15px ;border-bottom: 1px;" >
    <a style="color:#368EE0;font-size: large;">会员列表管理</a>
    <span style="float:right;margin-right: 5%;">

   
    </span>
    </div><!--box_title c end -->
    <div class="box-content" style="padding: 0;">
        <!-- <div class="box-header"> -->
        <!-- </div>box-header end -->
        <div class="box-search" style="padding-top: 0px;margin-top:0px" >
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="list_type" value="<?php echo Yii::app()->request->getParam('list_type');?>">
                <label style="margin-right:10px;">
                <span>身份：</span>
                <select style="margin-top: 1%;" name="member_type" id='member_type'>
                    <option value="">请选择</option>
                    <?php if(isset($member_type)) foreach ($member_type as $v) {?>
                        <option value="<?php echo $v->member_type; ?>" <?php if (Yii::app()->request->getParam('member_type') == $v->id) { ?> selected<?php } ?>><?php echo $v->member_type; ?></option>
                    <?php } ?>
                </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
            </div><!--box-search end-->

        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('member_code');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('account_number');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sex');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('member_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('status');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('image');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo $index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->member_code; ?></td>
                        <td style='text-align: center;'><?php echo $v->name; ?></td>
                        <td style='text-align: center;'><?php echo $v->account_number; ?></td>
                        <td style='text-align: center;'><?php echo $v->sex; ?></td>
                        <td style='text-align: center;'><?php echo $v->contact_phone; ?></td>
                        <td style='text-align: center;'><?php echo $v->member_type; ?></td>
                        <td style='text-align: center;'><?php echo $v->status; ?></td>
                        <!-- 缩略图要改下面这一行 -->
                        <td style='text-align: center;'><?php echo BaseLib::model()->show_pic(0,$v->image,NULL);?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update_edit', array('id'=>$v->id));?>" title="查看"><i class="fa fa-edit"></i></a>

                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>