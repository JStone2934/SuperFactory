<?php

class TaskController extends BaseController
{

    protected $model = '';

    public function init()
    {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionDelete($id)
    {
        parent::_clear($id);
    }


    public function actionCreate()
    {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();

        if (!Yii::app()->request->isPostRequest) { // 进入添加栏目界面
            $data['model'] = $model;
            $this->render('update', $data);
        } else { // 进入添加栏目界面并提交保存
            $temp = $_POST[$modelName];
            $this->saveData($model, $temp);
        }

    }

    public function actionUpdate($id)
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $temp = $_POST[$modelName];
            $this->saveData($model, $temp);
        }
    }


    function saveData($model, $post)
    {
        $model->attributes = $post;
        // 保存稿件的提交时间
        $model->commit_time = date('Y-m-d H:i:s', time());

        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    public function actionIndex($keyword = '', $grade = '', $style = '', $release_start_time = '', $release_end_time = '', $start_time = '', $end_time = '')
    {
        // put_msg('actionIndex keyword='.$keyword.','.' grade='.$grade.' style='.$style);
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;

        // 模糊查询，中间的表示可以从哪里得来，后面$**表示哪个变量
        // index显示所有的稿件，不论是否是一审，二审通过
        $criteria->condition = get_where('1=1', ($start_time != ""), 'commit_time>=', $start_time, '"');
        $criteria->condition = get_where($criteria->condition, ($end_time != ""), 'commit_time<=', $end_time, '"');
        $criteria->condition = get_where($criteria->condition, ($release_start_time != ""), 'release_time>=', $release_start_time, '"');
        $criteria->condition = get_where($criteria->condition, ($release_end_time != ""), 'release_time<=', $release_end_time, '"');
        $criteria->condition = get_like($criteria->condition, 'task_code,competition,introduce', $keyword);
        $criteria->condition = get_like($criteria->condition, 'grade', $grade);
        $criteria->condition = get_like($criteria->condition, 'style', $style);

        $criteria->order = 'task_code';

        // 提交时间晚的在前面出现
        $data = array();
        $data['grade'] = SentenceGrade::model()->findAll();
        $data['style'] = SentenceStyle::model()->findAll();
        parent::_list($model, $criteria, 'index', $data);
    }


    // 预览动作,传入要显示article的id
    public function actionPreview($id = '')
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $data = array();
        $data['model'] = $model;
        $this->render('preview', $data);
    }

}
