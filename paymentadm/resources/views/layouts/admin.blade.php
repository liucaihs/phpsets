<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>支付后台</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="{{URL::asset("css/bootstrap.min.css")}}">
    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <link href="{{URL::asset("css/bootstrap-datetimepicker.css")}}" rel="stylesheet"/>
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="{{URL::asset("js/jquery-3.1.0.min.js")}}"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="{{URL::asset("js/bootstrap.min.js")}}"></script>
    <script src="{{URL::asset("js/bootstrap-datetimepicker.js")}}"></script>
    <script src="{{URL::asset("js/bootstrap-datetimepicker.zh-CN.js")}}"></script>

    <!-- 独立样式 -->
    <style type="text/css">
        .content {
            margin-top: 60px;
        }
    </style>
</head>
<body>
<!-- 头部 -->
<header>
    <!-- 导航条 -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-sm" href="">支付后台管理系统</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <!-- 登陆表单 -->
                <form class="navbar-form navbar-right visible-md-block  visible-lg-block" action="{{url('/logout')}}" role="search">
                    <button type="submit" class="btn btn-default">退出</button>
                </form>

                <form class="navbar-form navbar-right visible-sm-block" action="{{url('/logout')}}" role="search">
                    <button type="submit" class="btn btn-default input-sm">退出</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<!-- 内容 -->
<div class="content container-fluid">
    <div class="row">
        <!--左边导航-->
        <div class="col-md-2 col-sm-3 col-xs-3 text-left" style="">
            <!-- 手风琴效果 -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">配置管理</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation"><a href="{{ url('/setting') }}">配置列表</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                通道管理
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation"><a href="{{ url('/passage') }}">通道列表</a></li>
                                <li role="presentation"><a href="{{ url('/billing') }}">通道计费类型</a></li>
                                <li role="presentation"><a href="{{ url('/passtoall') }}">通道统计</a></li>
                                <li role="presentation"><a href="{{ url('/passto') }}">单通道统计</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThere">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#channel" aria-expanded="false" aria-controls="channel">
                                cp管理
                            </a>
                        </h4>
                    </div>
                    <div id="channel" data-nav="channel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThere">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation"><a href="{{ url('/channel') }}">渠道列表</a></li>
                                <li role="presentation"><a href="{{url('/orders')}}">订单查看</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                同步管理
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation"><a href="{{url('chanto')}}">同步统计</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFixe">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFixe" aria-expanded="false" aria-controls="collapseFixe">
                                账户管理
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFixe" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFixe">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation" class="" ><a href="{{ url('/account') }}">账户管理</a></li>
                                <li role="presentation" class="" ><a href="{{ url('/permission') }}">权限管理</a></li>
                                <li role="presentation" class="" ><a href="{{ url('/role') }}">角色管理</a></li>
                                <li role="presentation" class="" ><a href="{{ url('/appids') }}">业务委派</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var navType=$(".col-md-10").attr("data-nav");
        if (navType != "" && navType != undefined) {
            $("#"+ navType ).addClass("in");
        }
    });
</script>

</body>
</html>