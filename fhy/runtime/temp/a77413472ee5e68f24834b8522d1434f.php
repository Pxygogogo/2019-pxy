<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"D:\wamp64\www\fhytp5\public/../application/index\view\custom\search_result.html";i:1577169388;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577157989;}*/ ?>
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
                
                
                <a href="<?php echo url('index/contact/index'); ?>" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-map mr-3"></i>联系人管理</a>
                
                
<a href="<?php echo url('index/custom/index'); ?>" class="active list-group-item list-group-item-action waves-effect">
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
                        <th>中文名</th>
                        <th>英文名</th>
                        <th>所在省市区</th>
                        <th>负责人</th>
                        <th>负责人联系方式</th>
                        <th>邮箱</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <!-- Table head -->

                    <!-- Table body -->
                    <tbody>
                    <?php if(is_array($custom) || $custom instanceof \think\Collection || $custom instanceof \think\Paginator): if( count($custom)==0 ) : echo "" ;else: foreach($custom as $key=>$vo): ?>
                    <tr style="border-bottom: 1px solid #dee2e6; text-align: center;">
                        <td><?php echo $vo['custom_id']; ?></td>
                        <td><?php echo $vo['cname']; ?></td>
                        <td><?php echo $vo['ename']; ?></td>
                        <td><?php echo $vo['area']; ?></td>
                        <td><?php echo $vo['principle']; ?></td>
                        <td><?php echo $vo['prin_phone']; ?></td>
                        <td><?php echo $vo['email']; ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="del(<?php echo $vo['custom_id']; ?>)">删除</button>
                            <button class="btn btn-primary btn-sm" onclick="change(<?php echo $vo['custom_id']; ?>)">修改</button>
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
    function del(custom_id) {
        if (confirm('确定要删除吗？')) {
            location.href = "<?php echo url('del'); ?>" + '?custom_id=' + custom_id;
        } else {

        }
    }

    function change(custom_id) {
        location.href = "<?php echo url('change'); ?>" + '?custom_id=' + custom_id;
    }
</script>

<script>
    $(function () {
        let contact_result = [];
        let contact_result_length = [];
        $('#search_contact1').on('click', function () {
            $('.contact_result1').html('');
            const contact_name = $('#contact1').val();
            $.post('/index/custom/searchContact', {"contact_name": contact_name}, function (data) {
                if (data.msg === '查询失败！') {
                    $('.contact_result1').append('不存在此联系人,请重新查询');
                } else {
                    contact_result = data.data;
                    contact_result_length = data.data.length;
                    for (let i = 0; i < contact_result_length; i++) {
                        $('.contact_result1').append(`<div class="contact_res col-sm-4" id="${i}" style="background: #f1f2f3;line-height: 40px;text-align: center;padding: 2px;font-size: 20px;margin-bottom: 5px;cursor: pointer;border-radius: 20px;">${data.data[i].name}</div>`)
                    }
                }
            });
        });
        $('.contact_result1').on('click', ".contact_res", function () {
            $('#contact1').val(contact_result[this.id].name);
            $('.contact_result1').html('');
        });
        //联系人2
        $('#search_contact2').on('click', function () {
            $('.contact_result2').html('');
            const contact_name = $('#contact2').val();
            $.post('/index/custom/searchContact', {"contact_name": contact_name}, function (data) {
                if (data.msg === '查询失败！') {
                    $('.contact_result2').append('不存在此联系人,请重新查询');
                } else {
                    contact_result = data.data;
                    contact_result_length = data.data.length;
                    for (let i = 0; i < contact_result_length; i++) {
                        $('.contact_result2').append(`<div class="contact_res col-sm-4" id="${i}" style="background: #f2f2f3;line-height: 40px;text-align: center;padding: 2px;font-size: 20px;margin-bottom: 5px;cursor: pointer;border-radius: 20px;">${data.data[i].name}</div>`)
                    }
                }
            });
        });
        $('.contact_result2').on('click', ".contact_res", function () {
            $('#contact2').val(contact_result[this.id].name);
            $('.contact_result2').html('');
        });
        //联系人2
        $('#search_contact3').on('click', function () {
            $('.contact_result3').html('');
            const contact_name = $('#contact3').val();
            $.post('/index/custom/searchContact', {"contact_name": contact_name}, function (data) {
                if (data.msg === '查询失败！') {
                    $('.contact_result3').append('不存在此联系人,请重新查询');
                } else {
                    contact_result = data.data;
                    contact_result_length = data.data.length;
                    for (let i = 0; i < contact_result_length; i++) {
                        $('.contact_result3').append(`<div class="contact_res col-sm-4" id="${i}" style="background: #f2f2f3;line-height: 40px;text-align: center;padding: 2px;font-size: 20px;margin-bottom: 5px;cursor: pointer;border-radius: 20px;">${data.data[i].name}</div>`)
                    }
                }
            });
        });
        $('.contact_result3').on('click', ".contact_res", function () {
            $('#contact3').val(contact_result[this.id].name);
            $('.contact_result3').html('');
        });


    })
</script>

</html>
