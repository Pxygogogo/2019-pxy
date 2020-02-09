<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\wamp64\www\fhytp5\public/../application/index\view\cargo\index.html";i:1577168407;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577193163;}*/ ?>
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
                
                
<a href="<?php echo url('index/cargo/index'); ?>" class="active list-group-item list-group-item-action waves-effect">
    <i class="fas fa-table mr-3"></i>货物管理</a>

                
                <a href="<?php echo url('index/contact/index'); ?>" class="list-group-item list-group-item-action waves-effect">
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
    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">货物搜索</h2></div>
    <div class="col-md-12">
        <div class="collapse show" id="searchForm">
            <div class="card">
                <form class="form-horizontal" action="searchResult" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">
                            <h6 class="panel-title">货物搜索</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">关键词</label>
                                <div class="col-sm-9">
                                    <input type="text" name="keywords" class="form-control"
                                           placeholder="请输入任意货物信息进行搜索...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 25px">
                        <button class="btn btn-primary" type="submit">搜索</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="text-align: center;margin-left:40%;margin-top: 20px;"><h2 class="page-title">新增货物</h2></div>
    <div class="col-md-12">
        <div id="cargo" class="collapse show">
            <div class="card">
                <form class="form-horizontal" id="form" action="addCargo" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">

                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="padding-left: 26px">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">货物名字</label>
                                        <input type="text" name="name" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">货物类型</label>
                                        <input type="text" name="kind" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">打包方式</label>
                                        <input type="text" name="pack" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">计量单位</label>
                                        <input type="text" name="unit" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">单位长度（米）</label>
                                        <input type="text" name="length" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">单位宽度（米）</label>
                                        <input type="text" name="width" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">单位高度（米）</label>
                                        <input type="text" name="height" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">单位重量（千克）</label>
                                        <input type="text" name="weight" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">保鲜温度（摄氏度）</label>
                                        <input type="text" name="temp" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">保质期（天）</label>
                                        <input type="text" name="deadline" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 25px">
                        <button class="btn btn-primary" type="submit">确定新增</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="text-align: center;margin-left:38%;margin-top: 20px;"><h2 class="page-title">现有货物管理</h2></div>

    <!--Grid column-->
    <div class="col-md-12">

        <!--        <div>-->
        <!--            <button type="button" class="btn btn-primary">增加货物</button>-->
        <!--        </div>-->

        <!--Card-->
        <div class="card">

            <!--Card content-->
            <div class="card-body">

                <!-- Table  -->
                <table class="table table-hover">
                    <!-- Table head -->
                    <thead class="blue-grey lighten-4">
                    <tr>
                        <th>货物编号</th>
                        <th>货物名称</th>
                        <th>货物类型</th>
                        <th>计量单位</th>
                        <th>保鲜温度（摄氏度）</th>
                        <th>保质期（天）</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <!-- Table head -->

                    <!-- Table body -->
                    <tbody>
                    <?php if(is_array($cargo) || $cargo instanceof \think\Collection || $cargo instanceof \think\Paginator): if( count($cargo)==0 ) : echo "" ;else: foreach($cargo as $key=>$vo): ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td><?php echo $vo['cargo_id']; ?></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['kind']; ?></td>
                        <td><?php echo $vo['unit']; ?></td>
                        <td><?php echo $vo['temp']; ?></td>
                        <td><?php echo $vo['deadline']; ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="del(<?php echo $vo['cargo_id']; ?>)">删除</button>
                            <button class="btn btn-primary btn-sm" onclick="change(<?php echo $vo['cargo_id']; ?>)">修改</button>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <!-- Table body -->
                </table>
                <!-- Table  -->

            </div>

        </div>
        <!--/.Card-->

    </div>
    <!--Grid column-->


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
    
<script>
    function del(cargo_id) {
        if (confirm('确定要删除吗？')) {
            location.href = "<?php echo url('del'); ?>" + '?cargo_id=' + cargo_id;
        } else {

        }
    }

    function change(cargo_id) {
        location.href = "<?php echo url('change'); ?>" + '?cargo_id=' + cargo_id;
    }
</script>

</html>
