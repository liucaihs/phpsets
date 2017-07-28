<div class="col-md-2 col-sm-3 col-xs-3 text-left" style="">
    <!-- 手风琴效果 -->
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">广告主</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <li role="presentation"><a href="{{ url('/index/add') }}">接入广告主</a></li>
                        <li role="presentation"><a href="{{ url('/index') }}">广告主列表</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        广告
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <li role="presentation"><a href="{{ url('/advertising/add') }}">接入广告</a></li>
                        <li role="presentation"><a href="{{ url('/advertising') }}">广告列表</a></li>
                        <li role="presentation"><a href="{{ url('/adputon/add') }}">投放广告</a></li>
                        <li role="presentation"><a href="{{ url('/adputon') }}">投放广告列表</a></li>
                        <li role="presentation"><a href="{{ url('/advertisers_test') }}">广告主测试</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThere">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#channel" aria-expanded="false" aria-controls="channel">
                        渠道
                    </a>
                </h4>
            </div>
            <div id="channel" data-nav="channel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThere">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <li role="presentation" class="" ><a href="{{ url('/channel/add') }}">维护渠道</a></li>
                        <li role="presentation"><a href="{{ url('/channel') }}">渠道列表</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        数据统计
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked" role="tablist">
                        <li role="presentation"><a href="{{url('idfa')}}">ifa查询</a></li>
                        <li role="presentation"><a href="{{url('recvidfa')}}">ifa激活列表</a></li>
                        <li role="presentation"><a href="#">广告主</a></li>
                        <li role="presentation"><a href="{{url('operate')}}">运营</a></li>
                        <li role="presentation"><a href="#">渠道</a></li>
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
                        <li role="presentation" class="" ><a href="{{ url('/cmdb') }}">配置管理</a></li>
                        <li role="presentation" class="" ><a href="{{ url('/role') }}">角色管理</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   
</script>