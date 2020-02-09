<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\wamp64\www\fhytp5\public/../application/index\view\order\index.html";i:1577192159;s:53:"D:\wamp64\www\fhytp5\application\index\view\base.html";i:1577193163;}*/ ?>
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
    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">订单搜索</h2></div>
    <div class="col-md-12">
        <div class="collapse show" id="searchForm">
            <div class="card">
                <form class="form-horizontal" action="searchResult" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">
                            <h6 class="panel-title">订单搜索</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">关键词</label>
                                <div class="col-sm-9">
                                    <input type="text" name="keywords" class="form-control"
                                           placeholder="请输入任意订单信息进行搜索...">
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
    <div style="text-align: center;margin-left:40%;"><h2 class="page-title">新增订单</h2></div>

    <div class="col-md-12">
        <div id="cargo" class="collapse show">
            <div class="card">
                <form class="form-horizontal" id="form" action="addOrder" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 20px">
                            <h6 class="panel-title">新增订单</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="padding-left: 26px">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="hidden" id="custom_id" name="custom_id" value="">
                                        <label for="" class="col-sm-5 control-label">客户名称</label>
                                        <div class="input-group">
                                            <input type="text" id="client_name" name="client_name"
                                                   class="form-control"
                                                   placeholder="请输入客户名称">
                                            <span class="input-group-btn"><button class="btn btn-primary"
                                                                                  id="search_client"
                                                                                  type="button">查询</button></span>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                    <div class="col-lg-5">
                                        <input type="hidden" id="cargo_id" value="">
                                        <label for="" class="col-sm-5 control-label">货物</label>
                                        <div class="input-group">
                                            <input type="hidden" name="cargoArr" id="cargoArr">
                                            <button class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#addGoods"
                                                    type="button">添加
                                            </button>
                                            <!-- Button trigger modal -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="addGoods" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel"
                                                 style="width: 900px;margin:0 auto;">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="">选择货物</h4>
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for=""
                                                                   class="col-sm-5 control-label">货物名称</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="cargo_name"
                                                                       placeholder="请输入货物名称">
                                                                <span class="input-group-btn"><button
                                                                        class="btn btn-primary"
                                                                        id="search_cargo"
                                                                        type="button">查询</button></span>
                                                            </div><!-- /input-group -->
                                                            <table class="table table-striped"
                                                                   style="text-align: center;">
                                                                <thead>
                                                                <tr>
                                                                    <th>货物名称</th>
                                                                    <th>货物数量</th>
                                                                    <th>计量单位</th>
                                                                    <th>删除</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody">

                                                                </tbody>
                                                            </table>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div id="cargo_result" class=""
                                                                         style="width:100%;display: flex;flex-wrap: wrap;justify-content: flex-start;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">关闭
                                                            </button>
                                                            <button type="button" class="btn btn-primary"
                                                                    id="confirmCargo"
                                                                    data-dismiss="modal">确认
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div id="client_result">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货人</label>
                                        <input type="text" name="sender" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货人联系电话</label>
                                        <input type="text" name="sender_phone" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货地省市区</label>
                                        <input type="text" name="sender_area" class="form-control"
                                               placeholder="">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货详细地址</label>
                                        <input type="text" name="sender_location" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">发货人电子邮箱</label>
                                        <input type="email" name="sender_email" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人</label>
                                        <input type="text" name="receiver" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人联系电话</label>
                                        <input type="text" name="receiver_phone" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货地省市区</label>
                                        <input type="text" name="receiver_area" class="form-control"
                                               placeholder="">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人详细地址</label>
                                        <input type="text" name="receiver_location" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">收货人电子邮箱</label>
                                        <input type="email" name="receiver_email" class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="" class="col-sm-5 control-label">下单日期</label>
                                        <input type="text" name="date" class="form-control"
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

    <div style="text-align: center;margin-left:38%;margin-top: 20px;"><h2 class="page-title">现有订单管理</h2></div>
    <!--Grid column-->
    <div class="col-md-12">

        <div class="card">

            <!--Card content-->
            <div class="card-body">

                <!-- Table  -->
                <table class="table table-hover">
                    <!-- Table head -->
                    <thead class="blue-grey lighten-4">
                    <tr style="text-align: center">
                        <th>编号</th>
                        <th>客户名称</th>
                        <th>下单日期</th>
                        <th>发货人</th>
                        <th>收货人</th>
                        <th>审核进度</th>
                        <th>审核评语</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <!-- Table head -->

                    <!-- Table body -->
                    <tbody>
                    <?php if(is_array($order) || $order instanceof \think\Collection || $order instanceof \think\Paginator): if( count($order)==0 ) : echo "" ;else: foreach($order as $key=>$vo): ?>
                    <tr style="border-bottom: 1px solid #dee2e6; text-align: center;">
                        <td><?php echo $vo['order_id']; ?></td>
                        <td><?php echo $vo['custom_name']; ?></td>
                        <td><?php echo $vo['date']; ?></td>
                        <td><?php echo $vo['sender']; ?></td>
                        <td><?php echo $vo['receiver']; ?></td>
                        <td><?php echo $vo['check_status']; ?></td>
                        <td><?php echo $vo['check_result']; ?></td>
                        <td>
                            <button class="btn btn-default btn-sm commit">提交</button>
                            <button class="btn btn-info btn-sm " onclick="audit(<?php echo $vo['order_id']; ?>)">审核</button>
                            <button class="btn btn-primary btn-sm detail">详情</button>
                            <button class="btn btn-danger btn-sm del">删除</button>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <!-- Table body -->
                </table>
                <!-- Table  -->

                <!-- Modal -->
                <div class="modal fade" id="auditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     style="width: 500px;margin: 0 auto;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">订单审核</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="audit" method="post">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="" class="col-sm-5 control-label">是否通过</label>
                                            <select class="js-example-basic-single form-control" name="isCheck">
                                                <option value="pass">审核通过</option>
                                                <option value="reject">驳回审核</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="" class="col-sm-5 control-label">审核意见（不超过20字）</label>
                                            <input type="text" name="check_result" class="form-control"
                                                   placeholder="请输入审核意见...">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" id="audit">提交</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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
    function audit(order_id) {
        location.href = "<?php echo url('audit'); ?>" + '?order_id=' + order_id;
    }

    $(function () {
        let client_result = [];
        let cargo_result = [];
        let client_result_length = 0;
        let cargo_result_length = 0;
        let cargoArr = [];
        //提交
        $('.commit').on('click', function (data, status) {
            let btn = this;
            let order_id = $(this).parent().siblings(0).html();
            if (confirm('确定要提交吗？')) {
                $(($(this).parent().siblings())[5]).html('审核中');
                $.get(`commit?order_id=${order_id}`, function (data) {
                    alert(data['msg']);
                })
            }
        });
        //修改
        $('.detail').on('click', function () {
            let order_id = $(this).parent().siblings(0).html();
            // console.log(order_id);
            location.href = "<?php echo url('detail'); ?>" + '?order_id=' + order_id;
        });

        $('#auditModal').on('show.bs.modal', function (e) {
            $('.modal-body').append(`<input type="hidden" name="order_id" value="${$(e.relatedTarget).data('orderid')}">`);
            // console.log($(e.relatedTarget).data('orderid'));
        });
        //删除
        $('.del').on('click', function (data, status) {
            let btn = this;
            let order_id = $(this).parent().siblings(0).html();
            if (confirm('确定要删除吗？')) {
                location.href = "<?php echo url('del'); ?>" + '?order_id=' + order_id;
            }
        });
        //查找客户
        $("#search_client").on('click', function () {
            $('#client_result').html('');
            const client_name = $('#client_name').val();
            $.post('/index/order/searchClient', {"client_name": client_name}, function (data) {
                if (data.msg === '查询失败！') {
                    $('#client_result').append('不存在此客户,请重新查询');
                } else {
                    client_result = data.data;
                    client_result_length = data.data.length;
                    for (let i = 0; i < client_result_length; i++) {
                        $('#client_result').append(`<div class="cl_res col-sm-4" id="${i}" style="background: #f1f2f3;line-height: 40px;text-align: center;padding: 2px;font-size: 20px;margin-bottom: 5px;cursor: pointer;border-radius: 20px;">${data.data[i].cname}</div>`)
                    }
                }
            });
        });
        $('#client_result').on('click', ".cl_res", function () {
            $('#client_name').val(client_result[this.id].cname);
            $('#client_id').val(client_result[this.id].custom_id);
            $('#client_result').html('');
        });
        //查找货物
        $("#search_cargo").on('click', function () {
            $('#cargo_result').html('');
            const cargo_name = $('#cargo_name').val();
            $.post('/index/order/searchCargo', {"cargo_name": cargo_name}, function (data) {
                if (data.msg === '查询失败！') {
                    $('#cargo_result').append('不存在此货物,请重新查询');
                } else {
                    cargo_result = data.data;
                    cargo_result_length = data.data.length;
                    for (let i = 0; i < cargo_result_length; i++) {
                        $('#cargo_result').append(`<div class="cargo_res col-sm-4" id="${i}" style="flex: 1;background: #f1f2f3;line-height: 40px;text-align: center;padding: 2px;font-size: 20px;margin-bottom: 5px;margin-left:5px;cursor: pointer;border-radius: 20px;">${data.data[i].name}</div>`)
                    }
                }
            });
        });

        $('#cargo_result').on('click', ".cargo_res", function () {
            $('#tbody').append(`<tr><input class="cargo_id" type="hidden" value="${cargo_result[this.id].cargo_id}"><td class="cargoName">${cargo_result[this.id].name}</td><td ><input type="text" class="cargo_count" value="10"></td><td class="measure_unit">${cargo_result[this.id].unit}</td><td><button type="button" class="delCargo btn btn-danger" >删除
             </button></td></tr>`);
            $('#cargo_result').html('');

        });
        $('#tbody').on('click', ".delCargo", function () {
            let cargo_id = $(this).parent().parent().children("input.cargo_id").val();
            $(this).parent().parent().remove();
        });
        $('#confirmCargo').on('click', function () {
            let trLength = $(this).parent().prev().find('tbody').children('tr').length;
            for (let i = 0; i < trLength; i++) {
                let tr = $($(this).parent().prev().find('tbody').children('tr')[i]);
                cargoArr.push({
                    'cargo_id': tr.children("input.cargo_id").val(),
                    'cargo_name': tr.children("td.cargoName").html(),
                    'cargo_count': tr.children("td").children("input[class='cargo_count']").val(),
                    'measure_unit': tr.children("td.measure_unit").html()
                });
            }
            $('#cargoArr').val(JSON.stringify(cargoArr));
        })


    })
</script>
</html>
