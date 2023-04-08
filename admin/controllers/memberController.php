<?php

class memberController extends BaseController
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

    public function actionUpdate_checking($id)
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update_checking', $data);
        } else {
           // put_msg($modelName);
            $this->saveData($model, $_POST[$modelName]);
        }
    }
    
    public function actionUpdate_edit($id)
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update_edit', $data);
        } else {
           // put_msg($modelName);
            $this->saveData($model, $_POST[$modelName]);
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
            //put_msg($modelName);
            $this->saveData($model, $_POST[$modelName]);
        }
    }
    function saveData($model, $post)
    {
        $model->attributes = $post;
        //put_msg($model->attributes);
       // put_msg($post);
        show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    public function actionIndex($type = '',$keyword = '')
    {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like('1', 'member_type', $type);
        $criteria->condition = get_like($criteria->condition, 'name,sex,member_code,contact_phone,ID_number,account_number', $keyword);//关键字查询
        $criteria->order = 'id';//根据'(里面的东西）'进行顺序排序
        $data = array();
        parent::_list($model, $criteria, 'index', $data); 
    }

    public function actionRegister($type='',$keyword='')
    {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like('1', 'member_type', $type);
        $criteria->condition = get_like($criteria->condition, 'name,sex,member_code,contact_phone,ID_number,account_number', $keyword);//关键字查询
        $criteria->order = 'id';//根据'(里面的东西）'进行顺序排序
        $data = array();
        parent::_list($model, $criteria, 'register', $data); 
    }

    public function actionChecking($member_type='',$keyword='')
    {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where('1=1',$member_type,'member_type',$member_type,'"');
        $criteria->condition=get_where($criteria->condition,"待审核",'status',"待审核",'"');
        $criteria->condition = get_like($criteria->condition, 'name,sex,member_code,contact_phone,ID_number,account_number', $keyword);//关键字查询
        $criteria->order = 'id';//根据'(里面的东西）'进行顺序排序
        $data = array();
        $a = member_type::model()->findAll();
        $data['member_type']=$a;
        parent::_list($model, $criteria, 'checking', $data); 
    }

    public function actionAccept($member_type='',$keyword='')
    {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where('1=1',$member_type,'member_type',$member_type,'"');
        $criteria->condition=get_where($criteria->condition,"审核通过",'status',"审核通过",'"');
        $criteria->condition = get_like($criteria->condition, 'name,sex,member_code,contact_phone,ID_number,account_number', $keyword);//关键字查询
        $criteria->order = 'id';//根据'(里面的东西）'进行顺序排序
        $data = array();
        $a = member_type::model()->findAll();
        $data['member_type']=$a;
        parent::_list($model, $criteria, 'accept', $data); 
    }

    public function actionRefuse($member_type='',$keyword='')
    {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where('1=1',$member_type,'member_type',$member_type,'"');
        $criteria->condition=get_where($criteria->condition,"审核不通过",'status',"审核不通过",'"');
        $criteria->condition = get_like($criteria->condition, 'name,sex,member_code,contact_phone,ID_number,account_number', $keyword);//关键字查询
        $criteria->order = 'id';//根据'(里面的东西）'进行顺序排序
        $data = array();
        $a = member_type::model()->findAll();
        $data['member_type']=$a;
        parent::_list($model, $criteria, 'refuse', $data); 
    }
}
