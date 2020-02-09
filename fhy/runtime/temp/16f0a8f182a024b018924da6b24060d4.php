<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"D:\wamp64\www\fhytp5\public/../application/index\view\contact\change.html";i:1577104345;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577157989;}*/ ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>OMS</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
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
                
                
<a href="<?php echo url('index/contact/index'); ?>" class="list-group-item list-group-item-action active waves-effect">
    <i class="fas fa-map mr-3"></i>联系人管理</a>

                
                <a href="<?php echo url('index/custom/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-map mr-3"></i>客户管理</a>
                
                
                <a href="<?php echo url('index/usermanage/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-user mr-3"></i>用户管理</a>
                
                
                <a href="<?php echo url('index/order/index'); ?>" class="list-group-item list-group-item-action waves-effect">
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
    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">联系人详情</h2></div>
    <div class="col-md-12">
        <div id="cargo" class="collapse show">
            <div class="card">
                <form class="form-horizontal" id="form" action="updateData" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">
                            <h6 class="panel-title">联系人详情</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="padding-left: 26px">
                                <input value="<?php echo $contact['contact_id']; ?>" type="hidden" name="contact_id"
                                       class="form-control" placeholder="">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人姓名</label>
                                        <input type="text" name="name" class="form-control" placeholder=""
                                               value="<?php echo $contact['name']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人称谓</label>
                                        <input type="text" name="title" class="form-control"
                                               placeholder="" value="<?php echo $contact['title']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人手机</label>
                                        <input type="text" name="phone" class="form-control"
                                               placeholder="" value="<?php echo $contact['phone']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人电话</label>
                                        <input type="text" name="telephone" class="form-control" placeholder=""
                                               value="<?php echo $contact['telephone']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人传真</label>
                                        <input type="text" name="fax" class="form-control" placeholder=""
                                               value="<?php echo $contact['fax']; ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人电子邮箱</label>
                                        <input type="text" name="email" class="form-control" placeholder=""
                                               value="<?php echo $contact['email']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 25px">
                        <button class="btn btn-primary" type="submit">确认修改</button>
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

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/static/js/popper.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/static/js/mdb.min.js"></script>


    </body>
    
</html>
