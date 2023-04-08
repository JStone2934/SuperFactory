 <?php

class IndexController extends BaseController
{

  public $layout = false;


       public function actionIndex($mcode='A') {
        if (Yii::app()->session['admin_id'] == null)
        $this->login_form();
        else{
        $s1='index';
        Yii::app()->session['admin_id']=$mcode;
          $data = array('mcode'=>$mcode);
          set_session('mcode',$mcode);
          $this->render('index',$data);
    }
  }



    public function actionLogin(){
       $this->login_form();
    }


  public function actionLogout()
  {
    
    Yii::app()->session['admin_id'] = null;
    $this->redirect('index.php');
  }

    function login_form(){
        Yii::app()->session['admin_id']=null;
        $model = new Admin('create');
        $data = array();
        $data['model'] = $model;
        $s1='login';
        $this->render($s1,$data);  
    }

  public function actionCheckuser()
  {
    if (isset($_REQUEST['ACCOUNT'])) {
      $account = $_REQUEST['ACCOUNT'];
    }
    $data = array();
    $model = Admin::model()->find("account=?", [$account]);
    $data['account'] = 0;
    if ($model == null) {
      $data['msg'] = "账号不存在";
    } else if ($model->password == $_REQUEST['PASSWORD']) {
      $data['account'] = $model->account;
      Yii::app()->session['name'] = $model->name;
      Yii::app()->session['admin_id'] = $model->id;
      $data['msg'] = "登录成功";
    } else {
      $data['msg'] = "密码错误";
    }

    echo CJSON::encode($data);
  }

    public function actionTest() {
        $a=<<<EF
}
}
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
<style>
*{
    margin:0;
    padding:0;
    -webkit-tap-highlight-color:rgba(0,0,0,0);}
img{
  max-width:100%;}
body{
  line-height:1.8;
  font-size:20px;
  color:#000;
  -webkit-text-size-adjust:none;
  -o-text-size-adjust:none;
  text-size-adjust:none;
  background:#fff;}
.qmdd-wrapper{}
</style>
<script type="text/javascript">
    window.onload = function() {
        var h  = document.body.scrollHeight;
        parent.postMessage(h, "http://gf41.cn:8090/");
    }
</script>
</head>
<body>
<div class="qmdd-wrapper">
<!--详情开始--->
EF;
        echo $a;
    }
}
