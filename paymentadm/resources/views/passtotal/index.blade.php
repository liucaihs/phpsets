@extends('layouts.admin')

@section('content')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">单通道统计列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get" onsubmit="return checkOneMon()">
                    <p></p>
                    <label >通道</label>
                    <div class="form-group">
                            <select class="form-control" style="width: 185px;" id="pass_id" name="spname">
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
                            <td colspan="6">   <h4>   时间:{{$data['start']}} 至 {{$data['end']}} </h4> </td>
                        </tr>
                        <tr>
                            <td colspan="6">  <h4>{{$data['ps_name']}}  <b>{{$total['pay_num']}}</b>  支付总额: <b>{{$total['pay_mon']/100}}</b> (元)   退订条数:  <b>{{$total['cancel_num']}}</b>  退订总额:<b>{{$total['cancel_mon']/100}}</b> (元)</h4></td>
                        </tr>
                        <tr>

                            <th>appid</th>
                            <th>cp</th>
                            <th>数量</th>
                            <th>支付(元)</th>
                            <th>退订数量</th>
                            <th>退订金额(元)</th>
                        </tr>
                        @foreach($list  as $u)
                            <tr>

                                <td>{{$u['appid']}}</td>
                                <td>{{$u['cpname']}}</td>
                                <td>{{$u['pay_num']}}</td>
                                <td>{{$u['pay_mon'] > 0 ? $u['pay_mon']/100 : 0}}</td>
                                <td>{{$u['cancel_num']}}</td>
                                <td>
                                    {{$u['cancel_mon'] > 0 ? $u['cancel_mon']/100 : 0}}
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
        getall_zxcq("{{url('passage/passsel')}}", "pass_id");

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
                var querySelect = document.getElementById(idsel);
                // var oOp = querySelect.children;//获取select列表的所有子元素。
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

</script>
@endsection