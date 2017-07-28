@extends('layouts.admin')

@section('content')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFour">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">同步统计列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get" onsubmit="return checkOneMon();">
                    <p></p>
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
                            <th colspan="9">   <h4>   时间:{{$data['start']}} 至 {{$data['end']}} </h4> </th>
                        </tr>
                        <tr>
                            <th>渠道名称</th>
                            <th>appid</th>
                            <th>数量</th>
                            <th>总额(元)</th>
                            <th>设置同步率</th>
                            <th>同步数量</th>
                            <th>同步总额(元)</th>
                            <th>同步率</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list  as $u)
                            <tr>
                                <td>{{$u['cpname']}}</td>
                                <td>{{$u['appid']}}</td>
                                <td>{{$u['nums']}}</td>
                                <td>{{$u['money']> 0 ? $u['money']/100 : 0}}</td>
                                <td>{{$u['money']> 0 ? $u['notify_rate']*100 : 0}}%</td>
                                <td>{{$u['tb_num']}}</td>
                                <td>{{$u['money']> 0 ? $u['tb_money']/100 : 0}}</td>
                                <td>
                                    {{$u['money'] > 0 ? round($u['tb_money']/$u['money'] *100,2): 0}}%
                                </td>
                                <td> <button class="btn btn-success btn-xs" onclick="exit({{$u}})">
                                        调整
                                    </button></td>
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

    <div class="row"
         style="margin-top: 60px; width: 900px; display:none;margin-left: auto; margin-right: auto; position: absolute;  top: 0; left: 0; bottom: 0; right: 0;"
         id="advertiser_movie">
        <div class="col-md-10 col-sm-12">
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title"><span id="sub_tit" >查看/修改</span></h3>
                </div>
                <form class="form-horizontal" style="margin-top: 20px;margin-left: 25%;" method="POST"
                      onsubmit="return update();" id="subform">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                    <input type="hidden" name="id" id="id" value="0"/>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">渠道标示</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="渠道标示" style="width: 285px;"
                                   id="appid" name="appid" readonly="readonly" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">同步率</label>

                        <div class="col-sm-10">
                            <div><input type="text" class="form-control" placeholder="同步率" style="width: 285px;display: inline;"
                                   id="notify_rate" name="notify_rate"   />  % </div>
                            <div>整数 0~100, 表示xx%</div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">保存</button>
                            &nbsp;&nbsp;
                            <a class="btn btn-danger" onclick="closes()">关闭</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--隐藏修改框-->


<script type="text/javascript">
    $(document).ready(function () {


        $("#start_time").datetimepicker({
            minView: "month", //选择日期后，不会再跳转去选择时分秒
            format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
            language: 'zh-CN', //汉化
            autoclose: true //选择日期后自动关闭
        });
        $("#end_time").datetimepicker({
            minView: "month", //选择日期后，不会再跳转去选择时分秒
            format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
            language: 'zh-CN', //汉化
            autoclose: true //选择日期后自动关闭
        });
    });


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

    function closes() {
        $('#advertiser_movie').css('display', 'none');
    }

    function exit(data) {
        if(!data) {
            $('#sub_tit').text('添加');
            data = {  appid : "" ,   notify_rate : "", notify_rate_m2 : "" , };
        } else {
            $('#sub_tit').text('查看/修改');
        }

        $('#appid').val(data.appid);
        var rateval = data.notify_rate ;
        if(rateval) {
            rateval = rateval * 100;
        }
        $('#notify_rate').val(rateval);

        $('#advertiser_movie').show();
    }

    function update() {

        var key=$('#appid').val();
        var value=$('#notify_rate').val();
        if(key!=''&&value!=''){
            var data = $("#subform").serializeArray();
            $.ajax({
                url:"{{url('channel/rate')}}",
                type:'post',
                data:data,
                dataType: "json",
                success: function(data){
                    // alert(data);
                    if (!data.code) {
                        alert(data.msg);
                    } else {
                        location.reload();
                    }
                },
                beforeSend: function(){

                },
                complete: function(xhr, st){

                },
                error : function(xhr){
                    alert('ajax error');
                }
            });
        }else{
            if(value==''){
                alert('同步率不可为空');
            }
            if(key==''){
                alert('appid不可为空');
            }

        }
        return false;
    }
</script>
@endsection