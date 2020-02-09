<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"D:\wamp64\www\fhytp5\public/../application/index\view\contact\search_result.html";i:1577169020;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577157989;}*/ ?>
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
                
                
<a href="<?php echo url('index/contact/index'); ?>" class="active list-group-item list-group-item-action waves-effect">
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


    <div style="text-align: center;margin-left:38%;margin-top: 20px;"><h2 class="page-title">搜索结果</h2></div>

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
                    <tr style="text-align: center">
                        <th>编号</th>
                        <th>姓名</th>
                        <th>称谓</th>
                        <th>手机</th>
                        <th>电话</th>
                        <th>传真</th>
                        <th>邮箱</th>
                        <th>客户</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <!-- Table head -->

                    <!-- Table body -->
                    <tbody>
                    <?php if(is_array($contact) || $contact instanceof \think\Collection || $contact instanceof \think\Paginator): if( count($contact)==0 ) : echo "" ;else: foreach($contact as $key=>$vo): ?>
                    <tr style="border-bottom: 1px solid #dee2e6; text-align: center;">
                        <td><?php echo $vo['contact_id']; ?></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['title']; ?></td>
                        <td><?php echo $vo['phone']; ?></td>
                        <td><?php echo $vo['telephone']; ?></td>
                        <td><?php echo $vo['fax']; ?></td>
                        <td><?php echo $vo['email']; ?></td>
                        <td><?php echo $vo['custom_name']; ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="del(<?php echo $vo['contact_id']; ?>)">删除</button>
                            <button class="btn btn-primary btn-sm" onclick="change(<?php echo $vo['contact_id']; ?>)">修改</button>
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

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="/static/js/popper.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="/static/js/mdb.min.js"></script>


    </body>
    
<script>
    function del(contact_id) {
        if (confirm('确定要删除吗？')) {
            location.href = "<?php echo url('del'); ?>" + '?contact_id=' + contact_id;
        } else {

        }
    }

    function change(contact_id) {
        location.href = "<?php echo url('change'); ?>" + '?contact_id=' + contact_id;
    }
</script>

</html>
