<?php

class RoleController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    public function actionDelete($id) {
        parent::_clear($id,'','roleId');
    }
  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 

   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  
  public function viewUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update', $data);
        } else {
           $this-> saveData($model,$_POST[$modelName]);
        }
    }/*曾老师保留部份，---结束*/
  
    function saveData($model,$post) {
        $model->attributes =$post;
        $pmsg=$post['tmp_opter2'];
        if (is_array($pmsg)){
          $pmsg=json_encode($pmsg,JSON_UNESCAPED_UNICODE);
        }
        $pmsg=str_replace('[', '', $pmsg);
        $pmsg=str_replace(']', '', $pmsg);//,""
        $pmsg=str_replace(',,', ',', $pmsg);
        $pmsg=str_replace(',""', '', $pmsg);
        $model->f_opter = $pmsg;
        $model->save();
        RoleData::model()->saveData( $model->roleId, $pmsg,'A');
        show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
  
    ///列表搜索
    public function actionIndex( $keywords = '',$type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_like('f_show=1','roleName,roleCode',$keywords,'');
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

}
