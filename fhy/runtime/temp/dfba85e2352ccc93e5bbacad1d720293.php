<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\wamp64\www\fhytp5\public/../application/index\view\custom\index.html";i:1577169271;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577193163;}*/ ?>
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
    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">客户搜索</h2></div>
    <div class="col-md-12">
        <div class="collapse show" id="searchForm">
            <div class="card">
                <form class="form-horizontal" action="searchResult" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">
                            <h6 class="panel-title">客户搜索</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">关键词</label>
                                <div class="col-sm-9">
                                    <input type="text" name="keywords" class="form-control"
                                           placeholder="请输入任意客户信息进行搜索...">
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
    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">新增客户</h2></div>
    <div class="col-md-12">
        <div id="cargo" class="collapse show">
            <div class="card">
                <form class="form-horizontal" id="form" action="addClient" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">

                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="padding-left: 26px">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">客户中文名</label>
                                        <input type="text" name="cname" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">客户英文名</label>
                                        <input type="text" name="ename" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">客户简称</label>
                                        <input type="text" name="sname" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">客户所在省市区</label>
                                        <input type="text" name="area" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">负责人</label>
                                        <input type="text" name="principle" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">负责人联系电话</label>
                                        <input type="text" name="prin_phone" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">客户地址</label>
                                        <input type="text" name="location" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">电子邮箱</label>
                                        <input type="email" name="email" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">邮政编码</label>
                                        <input type="text" name="postcode" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">开户银行</label>
                                        <input type="text" name="bank" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">银行账户</label>
                                        <input type="text" name="bank_account" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人一</label>
                                        <div class="input-group">
                                            <input type="text" name="contact1" id="contact1"
                                                   class="form-control contact"
                                                   placeholder="请输入联系人名称进行查找...">
                                            <span class="input-group-btn"><button
                                                    class="btn btn-primary search_contact" id="search_contact1"
                                                    type="button">查询</button></span>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-sm-6 -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div id="">

                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="contact_result1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人二</label>
                                        <div class="input-group">
                                            <input type="text" name="contact2" id="contact2"
                                                   class="form-control contact"
                                                   placeholder="请输入联系人名称进行查找...">
                                            <span class="input-group-btn"><button
                                                    class="btn btn-primary search_contact" id="search_contact2"
                                                    type="button">查询</button></span>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-sm-6 -->
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">联系人三</label>
                                        <div class="input-group">
                                            <input type="text" name="contact3" id="contact3"
                                                   class="form-control contact"
                                                   placeholder="请输入联系人名称进行查找...">
                                            <span class="input-group-btn"><button
                                                    class="btn btn-primary search_contact" id="search_contact3"
                                                    type="button">查询</button></span>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-sm-6 -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="contact_result2">

                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="contact_result3">
                                        </div>
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

    <div style="text-align: center;margin-left:38%;margin-top: 20px;"><h2 class="page-title">现有客户管理</h2></div>
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
    <script type="text/javascript" src="/static/js/bootstrap-toggle.min.js"></script>

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