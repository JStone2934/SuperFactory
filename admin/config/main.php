    <?php

    $config = require(ROOT_PATH . "/include/config.php");
    $params = array_merge($config['params'], array('administrator' => array('admin'),));
    $st = "";

    $params['roleItem'] = array(
        array(
            '证书管理',
            array(
                'award_index301' => array('宝石设置', 'gem/index'),
                'award_index303' => array('证书类型', 'certificateType/index'),
                'award_index304' => array('证书总览', 'certificate/index'),
            ),
        ),
        array(
            '货品管理',
            array(
                'award_index301' => array('货品来源', 'goodsSource/index'),
                'award_index302' => array('货品总览', 'goods/index'),
            ),
        ),
        array(
            '订单管理',
            array(
                'award_index301' => array('下单登记', 'order/index'),
                'award_index302' => array('生产确认', 'order/indexProduce'),
                'award_index303' => array('出货登记', 'order/indexShip'),
                'award_index304' => array('失效订单', 'order/indexInvalid'),
            ),
        ),
        array(
            '顾客信息',
            array(
                'award_index301' => array('顾客总览', 'customer/index'),
            )
        ),
        array(
            '系统设置',
            array(
                'award_index301' => array('人员管理', 'personnel/index'),
                'award_index302' => array('工单设置', 'workOrder/index'),
            )
        ),
        array(
            '工单审核',
            array(
                'award_index301' => array('工单审批', 'order/indexJudge'),
                // 'award_index302' => array('工单配备', 'order/indexEquip'),
                'award_index302' => array('工单流程设置', 'orderEquip/index'),
                'award_index303' => array('工单流程登记', 'orderEquip/register'),
                'award_index305' => array('完成工单登记', 'orderEquip/registerFinish'),
                'award_index304' => array('在做流程查询', 'orderEquip/indexDoing'),
                'award_index306' => array('完成工单查询', 'order/indexFinish'),
                'award_index307' => array('通过工单查询', 'order/indexPass'),
                'award_index308' => array('否决工单查询', 'order/indexPass&statu=out'),
            )
        ),
        array(
            '财务管理',
            array(
                'award_index301' => array('收款类型', 'collectionType/index'),
                'award_index302' => array('支付类型', 'payType/index'),
                'award_index303' => array('收款登记', 'orderAccount/index'),
                'award_index304' => array('流水管理', 'receipt/index'),
                'award_index305' => array('材料维护', 'activity/index'),
            )
        ),
    );




    $main = array(
        'basePath' => ROOT_PATH . '/admin',
        'runtimePath' => ROOT_PATH . '/runtime/admin',
        'name' => '',
        'defaultController' => 'index',
        'components' => array(
            'db' => $config['components']['db'],
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'info,error, warning'
                    ),
                    array(
                        'class' => 'CWebLogRoute',
                        'levels' => 'trace'
                    ),
                ),
            ),
        ),
        'params' => $params,
    );

    return array_merge($config, $main);
    ?>

    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-gears"></i> <span>權限控制</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="/admin">管理員</a>
                    <ul class="treeview-menu">
                        <li><a href="/user"><i class="fa fa-circle-o"></i> 後臺用戶</a></li>
                        <li class="treeview">
                            <a href="/admin/role"> <i class="fa fa-circle-o"></i> 權限 <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/admin/route"><i class="fa fa-circle-o"></i> 路由</a></li>
                                <li><a href="/admin/permission"><i class="fa fa-circle-o"></i> 權限</a></li>
                                <li><a href="/admin/role"><i class="fa fa-circle-o"></i> 角色</a></li>
                                <li><a href="/admin/assignment"><i class="fa fa-circle-o"></i> 分配</a></li>
                                <li><a href="/admin/menu"><i class="fa fa-circle-o"></i> 菜單</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>