@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">投放广告列表 </h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label>投放时间</label>
                    <div class="form-group">
                        <input class="form-control" type="text" size="10" id="start_time" name="start_time">
                    </div>
                    ~
                    <div class="form-group">
                        <input type="text" class="form-control" size="10" id="end_time" name="end_time">
                    </div>
                    <label>任务ID</label>
                    <div class="form-group">
                        <input class="form-control" type="text" id="id" name="id">
                    </div>
                    <label>任务名称</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="adname2" name="name">
                    </div>
                    <label>渠道ID</label>
                    <div class="form-group">
                        <input class="form-control" type="text" id="client_id2" name="media_id">
                    </div>
                    <label>渠道名称</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="adname2" name="media_name">
                    </div>

                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>任务ID</th>
                            <th>任务名称</th>
                            <th>广告名称</th>
                            <th>渠道ID</th>
                            <th>渠道名称</th>
                            <th>结算方式</th>
                            <th>单价</th>
                            <th>扣量比率</th>
                            <th>投放平台</th>
                            <th>开始投放时间</th>
                            <th>结束时间</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->adput_name}}</td>
                            <td>{{$u->ad_name}}</td>
                            <td>{{$u->media_id}}</td>
                            <td>{{$u->media_name}}</td>
                            <td>@if ($u->pay_type==1)
                                    曝光
                                @elseif ($u->pay_type==2)
                                    点击
                                @elseif ($u->pay_type==3)
                                    激活
                                @endif
                            </td>
                            <td>{{$u->price/100}}</td>
                            <td>{{$u->reduction*100}}%</td>
                            <td>@if ($u->puton_platform==1)
                                    ios
                                @elseif ($u->puton_platform==2)
                                    Android
                                @endif
                            </td>
                            <td>{{date("Y-m-d " ,$u->start_time)}}</td>
                            <td>{{date("Y-m-d " ,$u->end_time)}}</td>
                            <td>{{date("Y-m-d H:i:s" ,$u->create_time)}}</td>
                            <td>{{!empty($u->update_time) ? date("Y-m-d H:i:s" ,$u->update_time) : ""}}</td>
                            <td>{{$u->status}}</td>
                            <td>
                                <a href="{{ url('/adputon/up') }}/{{$u->id}}"> <button class="btn btn-success btn-xs"  >修改</button> </a>
                                <a href="{{ url('/adputon/copy') }}/{{$u->id}}"> <button class="btn btn-success btn-xs" >复制</button> </a>
                                        @if ($u->status!='暂停')
                                            <button class="btn btn-danger btn-xs" id="stophad" data-id="{{$u->id}}">暂停</button>
                                        @else
                                            <button class="btn btn-success btn-xs" id="starthad" data-id="{{$u->id}}">开启</button>
                                        @endif


                                <button class="btn btn-danger btn-xs" id="delete" data-id="{{$u->id}}">删除</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="panel-footer text-center">
                    <nav>
                        {{$page}}
                    </nav>
                </div>      
            </div>
        </div>
    </div>

    <!--隐藏修改框-->

</div>

<script type="text/javascript">
    $("#start_time").datetimepicker({
        minView: "month", //选择日期后，不会再跳转去选择时分秒
        format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
        language: 'zh-CN', //汉化
        autoclose:true //选择日期后自动关闭
    });
    $("#end_time").datetimepicker({
        minView: "month", //选择日期后，不会再跳转去选择时分秒
        format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
        language: 'zh-CN', //汉化
        autoclose:true //选择日期后自动关闭
    });

    function stoporstart(type ,id)
    {
        // var alertstr = type == 1 ? "暂停" : "开启" ;
        // if(confirm("确定要" + alertstr + "吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/adputon/stop') }}/" + id,
                dataType: "json",//预期服务器返回的数据类型
                success: function (msg) {
                    if (!msg.code) {
                        alert(msg.msg);
                    } else {
                        location.reload();
                    }
                },
                async: true,
                error: function (d) {
                    alert("请求失败！");
                }
            });
        // }
    }
    $("table #stophad").on("click", function() {
        var id = $(this).attr("data-id");
        stoporstart(1 , id);
    } );
    $("table #starthad").on("click",function() {
        var id = $(this).attr("data-id");
        stoporstart(2 , id);
    });

    $("table #delete").on("click",function () {
        var id = $(this).attr("data-id");
        if(confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/adputon/del') }}/" + id,
                data: "",
                dataType: "json",//预期服务器返回的数据类型
                success: function (msg) {
                    if (!msg.code) {
                        alert(msg.msg);
                    } else {
                        location.reload();
                    }
                },
                async: true,
                error: function (d) {
                    alert("请求失败！")
                }
            });
        }
    });


</script>
@include('common.footer')