<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>渠道后台</title>
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
            margin-top: 110px;
        }
        .menu3 {background:rgba(0, 0, 0, 0.60) none repeat scroll 0 0 !important; filter:Alpha(opacity=65);}
        .header_top img{
            margin: 10px 0;
            height: 78px;
            width: 300px;
        }
    </style>
</head>
<body>
<!-- 头部 -->
<header>
    <!-- 导航条 -->
    <nav class="navbar navbar-inverse navbar-fixed-top menu3" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="header_top" href="{{url('/index')}}"><img src='{{URL::asset("images/mitulogo.png")}}'/></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                <!-- 登陆表单 -->
                <form class="navbar-form navbar-right visible-md-block  visible-lg-block" action="{{url('/logout')}}" role="search" style="padding: 20px 0;">
                    <div class="form-group">
                      <input type="text" class="form-control" readonly id="gooleraccont">
                    </div>
                    <button type="submit" class="btn btn-default">退出</button>
                </form>

                <form class="navbar-form navbar-right visible-sm-block" action="{{url('/logout')}}" role="search" style="padding: 20px 0;">
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