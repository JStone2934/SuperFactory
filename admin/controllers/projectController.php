<?php

class projectController extends BaseController
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
            $this->saveData($model, $_POST[$modelName]);
        }
    }
    public function actionUpdate_detail($id)
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update_detail', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }
    function saveData($model, $post)
    {
        $model->attributes = $post;
        put_msg($model->attributes);
        put_msg($post);
        show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    public function actionIndex($type = '',$keyword = '')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like('1', 'project_name', $type);
        $criteria->condition = get_like($criteria->condition, 'project_name,teacher_name,teacher_age,discription', $keyword);//关键字查询

        $criteria->order = 'project_code';//根据'(里面的东西）'进行顺序排序
        $data = array();
        parent::_list($model, $criteria, 'index', $data); 
    }
    public function actionDetail($type = '',$keyword = '')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like('1', 'project_code', $type);
        $criteria->condition = get_like($criteria->condition, 'project_code,relative_subjects,discription', $keyword);//关键字查询
        $criteria->order = 'project_code';//根据'(里面的东西）'进行顺序排序
        $data = array();
        parent::_list($model, $criteria, 'detail', $data); 
    }
}
