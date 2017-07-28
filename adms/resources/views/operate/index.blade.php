@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFour">
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">运营统计列表</h3>
                    </div>
                    <form class="form-inline" role="form" style="margin: 10px;" method="get">
                        <label>投放时间</label>
                        <div class="form-group">
                            <input class="form-control" type="text" size="10" id="start_time" name="start_time">
                        </div>
                        ~
                        <div class="form-group">
                            <input type="text" class="form-control" size="10" id="end_time" name="end_time">
                        </div>&nbsp;&nbsp;
                        <label>广告ID</label>
                        <div class="form-group">
                            <input class="form-control" type="text" id="id" name="ad_id" size="10">
                        </div>&nbsp;&nbsp;
                        <label>广告</label>
                        <div class="form-group">
                            <select class="form-control" id="advertiser_id0" name="ad_idsel">
                            <option value=""> =请选择= </option>
                            </select>
                        </div>&nbsp;&nbsp;
                        <label>渠道名称</label>
                        <div class="form-group">
                            <select class="form-control" id="media_id0" name="media_id">
                            <option value=""> =请选择= </option>
                            </select>
                        </div>&nbsp;&nbsp;
                        <label>任务名称</label>
                        <div class="form-group">
                            <select class="form-control" id="adputon_id0" name="puton_id">
                            <option value=""> =请选择= </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">筛选</button>
                    </form>

                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr>
                                <th>时间</th>
                                <th>广告ID</th>
                                <th>广告名称</th>
                                <th>渠道名称</th>
                                <th>任务名称</th>
                                <th>曝光</th>
                                <th>点击</th>
                                <th>激活</th>
                                <th>同步数</th>
                                <th>点击率</th>
                                <th>激活率</th>
                                <th>单价</th>
                                <th>成本</th>
                            </tr>
                            @foreach($list  as $u)
                            <tr>
                                <td>{{$u->days}}</td>
                                <td>{{$u->ad_id}}</td>
                                <td>{{$u->ad_name}}</td>
                                <td>{{$u->media_name}}</td>
                                <td>{{$u->adput_name}}</td>
                                <td>{{$u->show_nums}}</td>
                                <td>{{$u->click_nums}}</td>
                                <td>{{$u->active_nums}}</td>
                                <td>{{$u->notclasp_nums}}</td>
                                <td> </td>
                                <td>{{ $u->click_nums > 0 ? round($u->active_nums/$u->click_nums *100,2): 0}}%</td>
                                <td>{{$u->price/100}}</td>
                                <td>{{$u->costprice/100}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>合计</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$total['click_nums']}}</td>
                                <td>{{$total['active_nums']}}</td>
                                <td></td>
                                <td></td>
                                <td>{{$total['active_percent']}}</td>
                                <td></td>
                                <td>{{$total['costprice']/100}}</td>
                            </tr>
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
</div>

<script type="text/javascript">
    $(document).ready(function(){
        getall_advertising();
        getall_channel();
        getall_adputon();
    });
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

    function getall_advertising(){
        $.ajax({
            url:"{{url('advertising/select')}}",
            type:'get',
            dataType: "json",
            success: function(data){
                var querySelect = document.getElementById("advertiser_id0");
                if(data){
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].name, data[i].id));
                    }
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
    }
    function getall_channel(){
        $.ajax({
            url:"{{url('channel/select')}}",
            type:'get',
            dataType: "json",
            success: function(data){
                var querySelect = document.getElementById("media_id0");
                if(data){
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].name, data[i].id));
                    }
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
    }
    function getall_adputon(){
        $.ajax({
            url:"{{url('adputon/select')}}",
            type:'get',
            dataType: "json",
            success: function(data){
                var querySelect = document.getElementById("adputon_id0");
                if(data){
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].adput_name, data[i].id));
                    }
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
    }
</script>
@include('common.footer')