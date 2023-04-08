<?php

class EpRobot {
    const EP_PORT = 40923;//    这个是进入命令控制的端口号，需要TCP方式连接

    protected $socket;
    protected $ep_ip;

    public $club_list_pic = '';

    public function tableName() {
        return '{{ep_robot}}';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**  * 模型关联规则  */
    public function relations() {
        return array();
    }

    /*** 模型验证规则*/
    public function rules() {
        return $this->attributeRule();
    }

    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
            'id' => 'ID',
            'robot_code' => '编码:k',
            'sn' => 'SN号',
            'wife_ssid' => '机器wife名称',
            'wife_passwd' => '机器wife密码',
            'image' => '图片',
        );
    }

    /**
     * @param $str
     * @return string 返回UTF8编码的字符串
     */
    function doEncoding($str) {
        $encode = strtoupper(mb_detect_encoding($str, ["ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5']));
        if ($encode != 'UTF-8') {
            $str = mb_convert_encoding($str, 'UTF-8', $encode);
        }
        return $str;
    }

    /**
     * @return string 获取ep在局域网连接的ip
     */
    public function getIp() {
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        //绑定广播端口40926
        socket_bind($this->socket, '0.0.0.0', 40926);
        try {
            $ip_str = socket_read($this->socket, 1024);
            return explode(" ", $ip_str)[2];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 设置机器人ip
     * @param $ip
     */
    protected function setIp($ip) {
        $this->ep_ip = $ip;
    }

    /**
     * 机器执行msg的结果
     * @param $msg
     * @return string 机器执行msg的结果
     */
    public function sendCommand($msg) {
        $msg .= ';';
        socket_write($this->socket, $this->doEncoding($msg), strlen($msg));
        try {
            return socket_read($this->socket, 1024);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 调用python代码生成二维码连接机器
     */
    public function connectRobot() {
        //调用本地指定python环境运行py文件
        exec('D:\anaconda\envs\rm\python.exe conn_helper.py');
    }

    /**
     * @return string 机器进入SDK状态是否成功
     */
    public function toSDK() {
        $this->setIp($this->getIp());//先获取并赋值机器ip
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket < 0) {
            echo "socket_create() failed: reason: " . socket_strerror($this->socket) . "\n";
        } else {
            echo "socket created!\n";
        }
        echo "Connecting " . $this->ep_ip . " port " . self::EP_PORT . "...\n";
        $result = socket_connect($this->socket, $this->ep_ip, self::EP_PORT);
        if ($result == false) {   //简单的对连接结果进行响应/为了Debug方便
            echo "Connect Fail!\n";
        } else {
            echo "Connected!\n";
            echo "Trying enter...\n";
            return $this->sendCommand("command");
        }
    }



    /**
     * @return string 获取当前机器的电量百分比
     */
    public function getBattery() {
        return $this->sendCommand("robot battery ?");
    }

    /**
     * 移动
     * @param $x 向前后移动的距离,单位m
     * @param $y 向左右移动的距离,单位m
     * @param $z 顺时针旋转的角度,单位°
     * @param $vxy 前后左右的移动速度,单位m/s
     * @param $vz 旋转速度,单位°/s
     */
    public function move($x = 0, $y = 0, $z = 0, $vxy = 2, $vz = 45) {
        $msg = "chassis move x " . $x . " y " . $y . " z " . $z . " xy_speed " . $vxy . " z_speed " . $vz;
        $tmp = $this->sendCommand($msg);
        $this->wait_completed(10);
        return $tmp;
    }

    /**
     * @param $t 等待任务完成的时间
     */
    public function wait_completed($t = 1) {
        sleep($t);
        $this->setChassisSpeed();
    }

    /**
     * 底盘速度获取
     * @return string <x> <y> <z> <w1> <w2> <w3> <w4>
     * x 轴向运动速度(m/s)，y 轴向运动速度(m/s)，z 轴向旋转速度(°/s)，w1 右前麦轮速度(rpm)，
     * w2 左前麦轮速速(rpm)，w3 右后麦轮速度(rpm)，w4 左后麦轮速度(rpm)
     */
    public function getSpeed() {
        return $this->sendCommand("chassis speed ?");
    }

    /**
     * 设置底盘运动速度
     * @param float $x speed_x (float:[-3.5,3.5]): x 轴向运动速度，单位 m/s
     * @param float $y speed_y (float:[-3.5,3.5]): y 轴向运动速度，单位 m/s
     * @param float $z speed_z (float:[-600,600]): z 轴向旋转速度，单位 °/s
     * @return string
     */
    public function setChassisSpeed($x = 0, $y = 0, $z = 0) {
        $msg = "chassis speed x " . $x . " y " . $y . " z " . $z;
        return $this->sendCommand($msg);
    }

    /** 底盘轮子速度控制
     * @param int $w1 speed_w1 (int:[-1000, 1000]): 右前麦轮速度，单位 rpm
     * @param int $w2 speed_w2 (int:[-1000, 1000]): 左前麦轮速度，单位 rpm
     * @param int $w3 speed_w3 (int:[-1000, 1000]): 右后麦轮速度，单位 rpm
     * @param int $w4 speed_w4 (int:[-1000, 1000]): 左后麦轮速度，单位 rpm
     * @return string
     */
    public function setWheelSpeed($w1 = 100, $w2 = 100, $w3 = 100, $w4 = 100) {
        $msg = "chassis wheel x " . $w1 . " w2 " . $w2 . " w3 " . $w3 . " w4 " . $w4;
        echo $msg;
        $res = $this->sendCommand($msg);
        $this->wait_completed(1);
        return $res;
    }

    /**
     * 底盘状态获取
     * @return string
     * static：是否静止
     * uphill：是否上坡
     * downhill：是否下坡
     * on_slope：是否溜坡
     * pick_up：是否被拿起
     * slip：是否滑行
     * impact_x：x 轴是否感应到撞击
     * impact_y：y 轴是否感应到撞击
     * impact_z：z 轴是否感应到撞击
     * roll_over：是否翻车
     * hill_static：是否在坡上静止
     */
    public function getChassisStatus() {
        return $this->sendCommand("chassis status ?");
    }

    /**
     * 设置机器人运动模式
     * @param string $mode (mode_enum): 机器人运动模式
     * chassis_lead : 云台跟随底盘模式
     * gimbal_lead : 底盘跟随云台模式
     * free : 自由模式
     */
    public function setRobotMode($mode="chassis_lead"){
        return $this->sendCommand("robot mode " . $mode);
    }

    /**
     * 获取机器人运动模式
     * @return string
     * free：自由模式
     * gimbal_lead：底盘跟随云台
     * chassis_lead：云台跟随底盘
     */
    public function getRobotMode(){
        return $this->sendCommand("robot mode ?");
    }

    /**
     * 底盘姿态获取
     * @return string
     * <pitch> <roll> <yaw> ：pitch 轴角度(°)，roll 轴角度(°)，yaw 轴角度(°)
     */
    public function getChassisAttitude(){
        return $this->sendCommand("chassis attitude ?");
    }

//    /**
//     * 底盘信息推送控制
//     * @param string $switch_enum  on表示打开对应属性的推送；off表示关闭对应属性的推送
//     * @param int $freq (int:(1,5,10,20,30,50)) ：对应的属性推送的推送频率(Hz)
//     * @param int $freq_all (int:(1,5,10,20,30,50)) : 整个底盘所有相关推送信息的推送频率
//     */
//    public function changeChassisPushStatus($switch_enum="off" , $freq=10 , $freq_all=10){
//        if($switch_enum!="off") {
//            $tmp = "chassis push freq " .$freq;
//            $this->sendCommand($tmp);
//        }
//    }
//
//    /**
//     * 底盘推送信息数据
//     * @param string $attr position:<x> <y>,attitude:<pitch> <roll> <yaw>,status:<static> <uphill> <downhill> <on_slope> <pick_up> <slip> <impact_x> <impact_y> <impact_z> <roll_over> <hill_static>
//     */
//    public function getChassisPush($attr="position"){
//        return $this->sendCommand("chassis push " .$attr);
//    }


    /**
     * 获取当前位置
     * @return string <x> <y> <z> ：x 轴位置(m)，y 轴位置(m)，偏航角度(°)
     * 示例:
     * IN: chassis position ?; ：获取底盘的位置信息
     * OUT: 1 1.5 20; ：底盘当前的位置距离上电时刻位置，沿 x 轴运动了 1 m，沿 y 轴运动了 1.5 m，旋转了 20°
     */
    public function getPosition(){
        return $this->sendCommand("chassis position ?");
    }

    /**
     * 返回两点之间的距离
     * @param $x0
     * @param $y0
     * @param $x1
     * @param $y1
     * @return float
     */
    public function getDistance($x0, $y0, $x1, $y1) {
        return sqrt(($x0 - $x1) * ($x0 - $x1) + ($y0 - $y1) * ($y0 - $y1));
    }

    /**
     * 给点A(x1,y1),B(x2,y2),求向量AB的与x轴的方向角
     * 计算向量(x2-x1,y2-x2)的角度 返回(-PI,PI],单位是°
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @return float|int
     */
    public function getAngle($x1, $y1, $x2, $y2) {
//        弧度制与角度的转换,acos(-1)等于PI
        return 180 * atan2($y2 - $y1, $x2 - $x1) / acos(-1);
    }

    /**
     * 使机器人从现在位置,用t秒移动到目标位置(x1,y1)
     * @param int $x1 目标x坐标
     * @param int $y1 目标y左边
     * @param int $t 总时长，单位秒s
     */
    public function moveTo($x1 = 0, $y1 = 0, $t = 2) {
        $pos = explode(' ', $this->getPosition());
        $x0 = $pos[0];
        $y0 = $pos[1];
        $z0 = $pos[2];
//        echo $x0 . "," . $y0 . "," . $z0 . "\n";
//        echo $x1 . "," . $y1 . "," . $z1 . "\n";
//        echo "------------------\n";
        $theta1 = $z0;
        $theta2 = $this->getAngle($x0, $y0, $x1, $y1);
        $this->rotate($theta2 - acos(-1) / 2 + $theta1);//先让机器人看向目的地
        $this->moveForward($this->getDistance($x0, $x1, $y0, $y1), $t = $t);//再移动直线距离
    }

    /**
     * 向前看（使角度恢复成原始0度）,默认完成时间1s
     */
    public function lookForward() {
        $pos = explode(' ', $this->getPosition());
        $this->rotate($z = -$pos[2]);
    }

    /**
     * @param int $t 转动的时间 （$t>=0.15） ,单位秒s
     */
    public function turnRight($t = 1) {
        $base = 0.95;
        $res = $this->setChassisSpeed($x = 0, $y = 0, $z = 90 * $base / $t);
        $this->wait_completed($t);
        return $res;
    }

    /**
     * @param int $t 转动的时间 （$t>=0.15） ,单位秒s
     */
    public function turnLeft($t = 1) {
        $base = 0.95;
        $res = $this->setChassisSpeed($x = 0, $y = 0, $z = -90 * $base / $t);
        $this->wait_completed($t);
        return $res;
    }

    /**
     * @param int $t 转动的时间 $t>=0.15 ,单位秒s
     */
    public function turnBack($t = 1, $right = true) {
        if ($t < 0.15) return false;
//        true为1，false为0，用于控制左转还是右转
        $base = 0.95;
        $res = $this->setChassisSpeed($x = 0, $y = 0, $z = pow(-1, $right) * 180 * $base / $t);
        $this->wait_completed($t);
        return $res;
    }

    /**
     * 转动底盘 |$z| <= 600*t
     * @param $z 转动角度
     * @param int $t 转动时间,单位秒s
     * @return false|string
     */
    public function rotate($z, $t = 1) {
        if (abs($z) > 600 * $t) return false;
        $res = $this->setChassisSpeed($z / $t);
        $this->wait_completed($t);
        return $res;
    }

    /**
     * $x <= 3.5 * $t
     * @param $x 移动的距离
     * @param int $t 移动总时间,单位秒s
     */
    public function moveForward($x, $t = 1) {
        if (abs($x) > 3.5 * $t) return false;
        $res = $this->setChassisSpeed($x = $x / $t);
        $this->wait_completed($t);
        return $res;
    }

    /**
     * |$x| <= 3.5 * $t
     * @param $x 移动的距离
     * @param int $t 移动总时间,单位秒s
     * @param false $turnBack 是否向后转
     * @return false|string
     */
    public function moveBack($x = 0, $t = 1, $turnBack = false) {
        if (abs($x) > 3.5 * $t) return false;
        $res = false;
        if ($turnBack) {
            $this->turnBack();
            $res = $this->setChassisSpeed($x = $x / $t);
        } else {
            $res = $this->setChassisSpeed($x = -$x / $t);
        }
        $this->wait_completed($t);
        return $res;
    }

    /**
     * @param $y 移动的距离
     * @param int $t 移动的总时间,单位秒s
     * @param false $rotate 是否转动，如果是，则先左转，再移动（转动会额外消耗1s）
     * @return false|string
     */
    public function moveLeft($y = 0, $t = 1, $rotate = false) {
        if (abs($y) > 3.5 * $t) return false;
        $res = false;
        if ($rotate) {//如果旋转，则先左转再移动
            $this->turnLeft();
            $res = $this->setChassisSpeed($x = $y / $t, 0, 0);
        } else {//直接平移
            $res = $this->setChassisSpeed(0, $y = -$y / $t, 0);
        }
        $this->wait_completed($t);
        return $res;
    }

    /**
     * @param $y 移动的距离
     * @param int $t 移动的总时间,单位秒s
     * @param false $rotate 是否转动，如果是，则先右转，再移动（转动会额外消耗1s）
     * @return false|string
     */
    public function moveRight($y = 0, $t = 1, $rotate = false) {
        if (abs($y) > 3.5 * $t) return false;
        $res = false;
        if ($rotate) {//如果旋转，则先左转再移动
            $this->turnRight();
            $res = $this->setChassisSpeed($x = $y / $t, 0, 0);
        } else {//直接平移
            $res = $this->setChassisSpeed(0, $y = $y / $t, 0);
        }
        $this->wait_completed($t);
        return $res;
    }

    /**
     * 云台运动速度控制
     * @param int $p (float:[-450, 450]) ：pitch 轴速度，单位 °/s
     * @param int $y (float:[-450, 450]) ：yaw 轴速度，单位 °/s
     */
    public function setGimbalSpeed($p , $y){
        return $this->sendCommand("gimbal speed p " .$p ." y " .$y);
    }

    /**
     * 云台相对位置控制
     * @param int $p (float:[-55, 55]) ：pitch 轴角度， 单位 °
     * @param int $y (float:[-55, 55]) ：yaw 轴角度，单位 °
     * @param int $vp (float:[0, 540]) ：pitch 轴运动速速，单位 °/s
     * @param int $vy (float:[0, 540]) ：yaw 轴运动速度，单位 °/s
     */
    public function gimbalMove($p = 0 , $y = 0 , $vp = 0 , $vy = 0){
        return $this->sendCommand("gimbal move" ." p " .$p ." y " .$y ." vp " .$vp ." vy " .$vy);
    }

    /**
     * 云台绝对位置控制
     * @param int $p (float:[-55, 55]) ：pitch 轴角度， 单位 °
     * @param int $y (float:[-55, 55]) ：yaw 轴角度，单位 °
     * @param int $vp (float:[0, 540]) ：pitch 轴运动速速，单位 °/s
     * @param int $vy (float:[0, 540]) ：yaw 轴运动速度，单位 °/s
     */
    public function gimbalMoveTo($p = 0 , $y = 0 , $vp = 0 , $vy = 0){
        return $this->sendCommand("gimbal moveto" ." p " .$p ." y " .$y ." vp " .$vp ." vy " .$vy);
    }

    /**
     * 云台休眠控制
     */
    public function gimbalSuspend(){
        return $this->sendCommand("gimbal suspend");
    }

    /**
     * 云台恢复控制
     */
    public function gimbalResume(){
        return $this->sendCommand("gimbal resume");
    }

    /**
     * 云台回中控制
     */
    public function gimbalRecenter(){
        return $this->sendCommand("gimbal recenter");
    }

    /**
     * 云台姿态获取
     * @return string <pitch> <yaw> ：pitch 轴角度(°)，yaw 轴角度(°)
     */
    public function getGimbalAttitude(){
        return $this->sendCommand("gimbal attitude ?");
    }

//    /**
//     * 云台信息推送控制
//     * @param string $attr 订阅的属性名称
//     * @param string $switch on表示打开对应属性的推送；off表示关闭对应属性的推送
//     * @param string $freq_all 云台所有相关推送信息的推送频率
//     */
//    public function changeGimbalPushStatus(){
//
//    }
//
//    /**
//     * 云台信息推送控制
//     * @param string $attr 订阅的属性名称
//     * @param string $data 订阅的属性数据 当 attr 为 attitude 时，data 内容为 <pitch> <yaw>
//     */
//    public function getGimbalPush(){
//
//    }

    /**
     * 发射器单次发射量控制
     * @param int $num (int:[1,5]) ：发射量
     */
    public function setBlasterBeadNum($num = 1){
        return $this->sendCommand("blaster bead " .$num);
    }

    /**
     * 发射器发射控制 控制水弹枪发射一次
     */
    public function blasterFire() {
        return $this->sendCommand("blaster fire");
    }

    /**
     * 发射器单次发射量获取
     * @return string <num> ：水弹枪单次发射的水弹数
     */
    public function getBlasterBeadNum(){
        return $this->sendCommand("blaster bead ?");
    }

    /**
     * 装甲板灵敏度控制
     * @param int $value (int:[1,10]) ：装甲板灵敏度，数值越大，越容易检测到打击。默认灵敏度值为 5
     */
    public function setArmorSensitivity($value = 5){
        return $this->sendCommand("armor sensitivity " .$value);
    }

    /**
     * 装甲板灵敏度获取
     * @return string <value> ：装甲板灵敏度
     */
    public function getArmorSensitivity($value = 5){
        return $this->sendCommand("armor sensitivity ?");
    }

//    /**
//     * 装甲板事件上报控制
//     * @return string <value> ：装甲板灵敏度
//     */
//    public function setArmorEvent($value = 5){
//        return $this->sendCommand("armor sensitivity ?");
//    }

    /**
     * PWM 输出占空比控制
     * @param hex $port_mask (hex:0-0xffff) ：PWM 拓展口掩码组合, 编号为 X 的输出口对应掩码为 1 << (X-1)
     * @param float $value  (float:0-100) ：PWM 输出占空比，默认输出为 12.5
     */
    public function setPwmValue($port_mask , $value = 12.5){
        return $this->sendCommand("pwm value " .$port_mask ." " .$value);
    }

    /**
     * PWM 输出频率控制
     * @param hex $port_mask (hex:0-0xffff) ：PWM 拓展口掩码组合, 编号为 X 的输出口对应掩码为 1 << (X-1)
     * @param int $value (int:XXX) ：PWM 输出频率值
     */
    public function setPwmFreq($port_mask , $value){
        return $this->sendCommand("pwm freq " .$port_mask ." " .$value);
    }

    /**
     * LED 灯效控制
     * @param string $comp_str (led_comp_enum) ：LED 编号
     * all : 所有 LED 灯
     * top_all : 云台所有 LED 灯
     * top_right : 云台右侧 LED 灯
     * top_left : 云台左侧 LED 灯
     * bottom_all : 底盘所有 LED 灯
     * bottom_front : 底盘前侧 LED 灯
     * bottom_back : 所有后侧 LED 灯
     * bottom_left : 所有左侧 LED 灯
     * bottom_right : 所有右侧 LED 灯
     * @param int $r_value (int:[0, 255]) ：RGB 红色分量值
     * @param int $g_value (int:[0, 255]) ：RGB 绿色分量值
     * @param int $b_value (int:[0, 255]) ：RGB 蓝色分量值
     * @param string $effect_str (led_effect_enum) ：LED 灯效类型
     * solid : 常亮效果
     * off : 熄灭效果
     * pulse : 呼吸效果
     * blink : 闪烁效果
     * scrolling : 跑马灯
     */
    public function ledControlComp($comp_str = "all" ,$r_value = 0 ,$g_value = 0 ,$b_value = 0 ,$effect_str = "solid"){
        return $this->sendCommand("led control comp " .$comp_str ." r " .$r_value ." g " .$g_value ." b " .$b_value ." effect " .$effect_str);
    }

    /**
     * 红外深度传感器开关控制
     * @param string $switch (switch_enum)：红外传感器的开关
     * on : 打开
     * off : 关闭
     */
    public function setIrDistanceSensorMeasure($switch  = "off"){
        return $this->sendCommand("ir_distance_sensor measure " .$switch );
    }

    /**
     * 红外深度传感器距离获取
     * @param int $id (int:[1, 4])：红外传感器的 ID
     * @return distance_value：指定 ID 的红外传感器测得的距离值，单位 mm
     */
    public function getIrDistanceSensorDistance($id){
        return $this->sendCommand("ir_distance_sensor distance " .$id ." ?" );
    }

//    舵机系统

//    /**
//     * 舵机角度控制
//     * @param int $servo_id (int:[1, 3])：舵机的 ID
//     * @param float $angle_value (float:[-180, 180])：指定的角度，单位 °
//     */
//    public function setServoAngle(){
//        return $this->sendCommand("blaster bead ?");
//    }

    /**
     * 相机曝光设置
     * @param string $ev_level (camera_ev_enum): 相机曝光值档位枚举
     * default : 默认值
     * small : 小
     * medium : 中
     * large : 大
     */
    public function setCameraExposure($ev_level = "default"){
        return $this->sendCommand("camera exposure " .$ev_level);
    }

    /**
     * 视频流开启控制
     */
    public function streamOn(){
        return $this->sendCommand("stream on");
    }

    /**
     * 视频流关闭控制
     */
    public function streamOff(){
        return $this->sendCommand("stream off");
    }

    /**
     * 音频流开启控制
     */
    public function audioOn(){
        return $this->sendCommand("audio on");
    }

    /**
     * 音频流关闭控制
     */
    public function audioOff(){
        return $this->sendCommand("audio off");
    }

}

$ep_robot = new EpRobot();
//$ep_robot->connectRobot();//只需要执行一次
echo $ep_robot->toSDK() . "\n";

echo $ep_robot->getPosition() . "\n";

//echo $ep_robot->moveForward(3,3);
echo $ep_robot->turnRight();
//echo $ep_robot->moveForward(1,3);
//echo $ep_robot->turnLeft();
//echo $ep_robot->moveForward(5,5);
echo $ep_robot->moveBack(1.5,1);
echo $ep_robot->turnRight();
echo $ep_robot->moveForward(1,3);

echo "Chassis Status :";
echo $ep_robot->getChassisStatus()."\n";
echo $ep_robot->getPosition() . "\n";


//测试sdk命令，按q退出
//while (1) {
//    echo ">>> please input SDK cmd: ";
//    $msg = trim(fgets(STDIN));
//    if (strcasecmp($msg, 'q') == 0) break;
//    echo $ep_robot->sendCommand($msg) . "\n";
//}








