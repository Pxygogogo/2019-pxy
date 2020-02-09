<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\wamp64\www\fhytp5\public/../application/index\view\order\detail.html";i:1577193111;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577193163;}*/ ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>OMS</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/static/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="/static/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="/static/css/mdb.min.css" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="/static/css/style.min.css" rel="stylesheet">

        <style>

            .map-container {
                overflow: hidden;
                padding-bottom: 56.25%;
                position: relative;
                height: 0;
            }

            .map-container iframe {
                left: 0;
                top: 0;
                height: 100%;
                width: 100%;
                position: absolute;
            }
        </style>
    </head>

    <body class="grey lighten-3">

    <!--Main Navigation-->
    <header>


        <!-- Sidebar -->
        <div class="sidebar-fixed position-fixed">

            <a class="logo-wrapper waves-effect">
                <img src="/static/img/mdb.png" class="img-fluid" alt="">
            </a>

            <div class="list-group list-group-flush">
                
                <a href="<?php echo url('index/entry/index'); ?>" class="list-group-item  list-group-item-action waves-effect">
                    <i class="fas fa-chart-pie mr-3"></i>首页
                </a>
                
                
                <a href="<?php echo url('index/cargo/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-table mr-3"></i>货物管理</a>
                
                
                <a href="<?php echo url('index/contact/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-map mr-3"></i>联系人管理</a>
                
                
                <a href="<?php echo url('index/custom/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-map mr-3"></i>客户管理</a>
                
                
                <a href="<?php echo url('index/usermanage/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-user mr-3"></i>用户管理</a>
                
                
<a href="<?php echo url('index/order/index'); ?>" class="active list-group-item list-group-item-action waves-effect">
    <i class="fas fa-money-bill-alt mr-3"></i>订单管理</a>

                
                <a href="<?php echo url('index/entry/logout'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-minus-circle mr-3"></i>退出登录</a>
                
            </div>

        </div>
        <!-- Sidebar -->

    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            

<!--Grid row-->
<div class="row wow fadeIn">

    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">订单详情</h2></div>
    <div class="col-md-12">
        <div id="cargo" class="collapse show">
            <div class="card">
                <form class="form-horizontal" id="form" action="addOrder" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">
                            <h6 class="panel-title">订单详情</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="padding-left: 26px">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input disabled type="hidden" id="order_id" name="order_id"
                                               value="<?php echo $order['order_id']; ?>">
                                        <label for="" class="col-sm-5 control-label">客户名称</label>
                                        <div class="input-group">
                                            <input disabled type="text" id="client_name" name="client_name"
                                                   class="form-control"
                                                   placeholder="请输入客户名称" value="<?php echo $order['custom_name']; ?>">
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                    <div class="col-lg-5">
                                        <label for="" class="col-sm-5 control-label">货物名称</label>
                                        <div class="input-group">
                                            <div class="input-group">
                                                <?php if(is_array($cargoArr) || $cargoArr instanceof \think\Collection || $cargoArr instanceof \think\Paginator): if( count($cargoArr)==0 ) : echo "" ;else: foreach($cargoArr as $key=>$vo): ?>
                                                <div style="position: relative;height: 80px;margin-left: 20px;text-align: center;">
                                                    <button type="button" class="btn btn-primary cargo_id"
                                                            id="$<?php echo $vo['cargo_id']; ?>">
                                                        <?php echo $vo['cargo_name']; ?>
                                                    </button>
                                                    <div style="width:100%;position:absolute;bottom: 0;">
                                                        <?php echo $vo['cargo_count']; ?><?php echo $vo['measure_unit']; ?>
                                                    </div>
                                                </div>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </div><!-- /input-group -->
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div id="client_result">

                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div id="cargo_result">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货人</label>
                                        <input disabled type="text" name="sender" class="form-control"
                                               placeholder="" value="<?php echo $order['sender']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货人联系电话</label>
                                        <input disabled type="text" name="sender_phone" class="form-control"
                                               placeholder="" value="<?php echo $order['sender_phone']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货地省市区</label>
                                        <input disabled type="text" name="sender_area" class="form-control"
                                               placeholder="" value="<?php echo $order['sender_area']; ?>">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货详细地址</label>
                                        <input disabled type="text" name="sender_location" class="form-control"
                                               placeholder="" value="<?php echo $order['sender_location']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货人电子邮箱</label>
                                        <input disabled type="email" name="sender_email" class="form-control"
                                               placeholder="" value="<?php echo $order['sender_email']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人</label>
                                        <input disabled type="text" name="receiver" class="form-control"
                                               placeholder="" value="<?php echo $order['receiver']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人联系电话</label>
                                        <input disabled type="text" name="receiver_phone" class="form-control"
                                               placeholder="" value="<?php echo $order['receiver_phone']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货地省市区</label>
                                        <input disabled type="text" name="receiver_area" class="form-control"
                                               placeholder="" value="<?php echo $order['receiver_area']; ?>">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人详细地址</label>
                                        <input disabled type="text" name="receiver_location" class="form-control"
                                               placeholder="" value="<?php echo $order['receiver_location']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人电子邮箱</label>
                                        <input disabled type="email" name="receiver_email" class="form-control"
                                               placeholder="" value="<?php echo $order['receiver_email']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">下单日期</label>
                                        <input disabled type="text" name="date" class="form-control"
                                               placeholder="" value="<?php echo $order['date']; ?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!--Grid row-->


        </div>
    </main>

    <!--Main layout-->


    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="/static/js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/js/bootstrap-toggle.min.js"></script>

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/static/js/popper.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/static/js/mdb.min.js"></script>


    </body>
    


</html>
