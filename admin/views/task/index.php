<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>征集列表</h1>
    </div>
    <!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create'); ?>">
                <i class="fa fa-plus"></i>添加栏目
            </a>
            <a class="btn" href="javascript:;" onclick="we.reload();">
                <i class="fa fa-refresh"></i>刷新
            </a>

        </div>
        <!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">

                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">

                <?php
                echo BaseLib::model()->inputSearch('关键字', 'keyword');
                echo BaseLib::model()->searchByData('年级','grade',SentenceGrade::model()->findAll(),'grade','grade');
                echo BaseLib::model()->searchByData('文体','style',SentenceStyle::model()->findAll(),'style','style');
                ?>

                <label style="margin-right:10px;">
                    <span>发布时间：</span>
                    <input name="release_start_time" style="width:120px;" id="release_start_time" class="input-text" type="text" placeholder="开始时间" value="<?php echo Yii::app()->request->getParam('release_start_time');?>">
                    <span>-</span>      
                    <input name="release_end_time" style="width:120px;" id="release_end_time" class="input-text" type="text" placeholder="结束时间" value="<?php echo Yii::app()->request->getParam('release_end_time');?>">
                </label>

                <label style="margin-right:10px;">
                    <span>提交时间：</span>
                    <input name="start_time" style="width:120px;" id="start_time" class="input-text" type="text" placeholder="开始时间" value="<?php echo Yii::app()->request->getParam('start_time');?>">
                    <span>-</span>      
                    <input name="end_time" style="width:120px;" id="end_time" class="input-text" type="text" placeholder="结束时间" value="<?php echo Yii::app()->request->getParam('end_time');?>">
                </label>
                
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('task_code'); ?>
                        </th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('icon'); ?>
                        </th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('competition'); ?>
                        </th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('introduce'); ?>
                        </th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('grade'); ?>
                        </th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('style'); ?>
                        </th>

                        <th style='text-align: center;width: 90px'>详情</th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('release_time'); ?>
                        </th>

                        <th style='text-align: center;'>
                            <?php echo $model->getAttributeLabel('commit_time'); ?>
                        </th>

                        <th style='text-align: center;width: 90px'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(124);?>
                    <?php $index = 1;

                    foreach ($arclist as $v) { ?>
                        <tr>
                            <td style='text-align:center;'>
                                <span class="num num-1"><?php echo $index ?></span>
                            </td>
                            <td style='text-align:center;'><?php echo $v->task_code; ?></td>
                            <td style='text-align:center;'>
                                <div style="text-align: center;">
                                    <img src="<?php echo Yii::app()->request->hostInfo . "/rb_hsyii/uploads/file/" . $v->icon; ?>" style="width: 40px;height: 40px;">
                                </div>    
                            </td>
                            <td style='text-align:center;'><?php echo $v->competition; ?></td>
                            <td style='text-align:center;'><?php echo $v->introduce==''?"见详情":$v->introduce; ?></td>
                            <td style='text-align:center;'><?php echo $v->grade; ?></td>
                            <td style='text-align:center;'><?php echo $v->style; ?></td>
                            <td style='text-align: center;'>
                                <a href="javascript:;" onclick="preview('<?php echo $v->id; ?>')">
                                    预览
                                </a>

                                <a href="<?php echo Yii::app()->request->hostInfo . "/rb_hsyii/uploads/file/" . Task::model()->find('id=' . $v->id)->attachment; ?>" target="_blank" onclick="return <?php echo empty(Task::model()->find('id=' . $v->id)->attachment)?'false':'true';?>">
                                    下载
                                </a>
                            </td>
                            <td style='text-align:center;'><?php echo $v->release_time; ?></td>
                            <td style='text-align:center;'><?php echo $v->commit_time; ?></td>
                            <td style='text-align: center;'>
                                <a class="btn" href="<?php echo $this->createUrl('update', array('id' => $v->id));?>" title="编辑"><i class="fa fa-edit"></i>
                                </a>

                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $index++;
                    } ?>
                </tbody>
            </table>
        </div>
        <!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div>
    <!--box-content end-->
</div>
<!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    $(function() {
        var release_start_time = $('#release_start_time');
        var release_end_time = $('#release_end_time');
        var start_time = $('#start_time');
        var end_time = $('#end_time');
        release_start_time.on('click', function() {
            WdatePicker({release_start_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
        release_end_time.on('click', function() {
            WdatePicker({release_end_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
        start_time.on('click', function() {
            WdatePicker({start_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
        end_time.on('click', function() {
            WdatePicker({end_time: '%y-%M-%D 00:00:00', dateFmt: 'yyyy-MM-dd HH:mm:ss'});
        });
    });

    function preview(id) {
        $.dialog.open('<?php echo $this->createUrl("Task/preview"); ?>&id=' + id, {
            id: 'article',
            lock: true,
            opacity: 0.3,
            title: '预览',
            width: '62%',
            height: '100%',
            close: function() {we.reload();}
        });
    }
</script>