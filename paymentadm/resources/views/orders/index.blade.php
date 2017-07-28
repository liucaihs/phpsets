@extends('layouts.admin')

@section('content')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">订单列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get" onsubmit="return checkOneMon()">
                    <p></p>
                    <label >渠道</label>
                    <div class="form-group">
                            <select class="form-control" style="width: 185px;" id="chan_id" name="cpname">
                            </select>
                    </div>

                    <label >appid</label>
                    <div class="form-group">
                        <select class="form-control" style="width: 185px;" id="app_id" name="appid">
                        </select>
                    </div>

                    <label>时间</label>
                    <div class="form-group">
                        <input class="form-control" type="text" size="10" id="start_time" name="start_time">
                    </div>
                    ~
                    <div class="form-group">
                        <input type="text" class="form-control" size="10" id="end_time" name="end_time">
                    </div>
                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th colspan="12">   <h4>   时间:{{$data['start']}} 至 {{$data['end']}} </h4> </th>
                        </tr>

                        <tr>
                            <th>渠道名</th>
                            <th>appid</th>
                            <th>订单号</th>
                            <th>总额（元）</th>
                            <th>imsi</th>
                            <th>省份</th>
                            <th>电话</th>
                            <th>自定义数据</th>
                            <th>日期</th>
                            <th>状态</th>
                            <th>同步</th>
                            <th>其它</th>
                        </tr>
                        @foreach($list  as $u)
                            <tr>
                                <td>{{$u['cpname']}}</td>
                                <td>{{$u['appid']}}</td>
                                <td>{{$u['sn']}}</td>
                                <td>{{$u['price']/100}}</td>
                                <td>{{$u['imsi']}}</td>
                                <td>{{$u['province']}}</td>
                                <td>{{$u['mobile']}}</td>
                                <td>{{$u['cpparam']}}</td>
                                <td>{{$u['created_at']}}</td>
                                <td>@if ($u['state']==0)
                                        成功
                                    @elseif ($u['state']==3)
                                        退订
                                    @endif
                                </td>
                                <td>@if ($u['notify_state']==0)
                                        无需同步
                                    @elseif ($u['notify_state']==1)
                                        已同步
                                    @elseif ($u['notify_state']==2)
                                        失败
                                    @endif
                                </td>
                                <td>
                                    {{$u['ext']}}
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
</div>

<!--隐藏修改框-->


<script type="text/javascript">
    $(document).ready(function(){
        getall_zxcq("{{url('channel/chansel')}}", "chan_id");
        getall_zxcq("{{url('channel/appsel/')}}", "app_id");
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
        });

    function checkOneMon(){
        var start = $('#start_time').val();
        var end = $('#end_time').val();
//        if ( start != '' && end == '' ) {
//            alert("请选择结束时间");
//            return false;
//        }
//        if ( start == '' && end != '' ) {
//            alert("请选择开始时间");
//            return false;
//        }
        if (start != '' && end != '') {
            if ( start  > end   ) {
                alert("开始时间不能大于结束时间");
                return false;
            }
//            var smon = start.substring(0,7);
//            var emon = end.substring(0,7);
//
//            if ( smon != emon   ) {
//                alert("开始时间和结束时间不能夸月");
//                return false;
//            }
        }
        return true;
    }
    function getall_zxcq( url , idsel ){
        $.ajax({
            url: url ,
            type:'get',
            dataType: "json",
            success: function(data){
                console.log(data);
                $("#" + idsel).empty();
                var querySelect = document.getElementById(idsel);
                // var oOp = querySelect.children;//获取select列表的所有子元素。
                querySelect.options.add(new Option(" =请选择= ",""));
                if(data){
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].name, data[i].name));
                    }
                }
            },
            async: true,
            error: function (d) {
                alert("请求失败！")
            }
        });
    }
    $("table #delbtn").on("click", function () {
        var id = $(this).attr("data-id");
        if (confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/billing/del') }}/" + id,
                data: "",
                dataType: "json",//预期服务器返回的数据类型
                success: function (msg) {
                    if (!msg.code) {
                        alert(msg.msg)
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


    $("#chan_id").change(function(){
        var cpname = $("#chan_id").val();
        if (cpname) {
            getall_zxcq("{{url('channel/appsel/')}}" + "/" + cpname, "app_id");
        }
    });

</script>
@endsection