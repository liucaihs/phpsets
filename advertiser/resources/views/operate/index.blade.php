@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseOne">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">运营统计列表</h3>
                    </div>
                    <form class="form-inline" role="form" style="margin: 10px;" method="get">
                        <label>广告</label>
                        <div class="form-group">
                            <select class="form-control" id="advertiser_id0" name="ad_idsel">
                            <option value=""> =请选择= </option>
                            </select>
                        </div>&nbsp;&nbsp;
                        <label>投放时间</label>
                        <div class="form-group">
                            <input class="form-control" type="text" size="10" id="start_time" name="start_time">
                        </div>
                        ~
                        <div class="form-group">
                            <input type="text" class="form-control" size="10" id="end_time" name="end_time">
                        </div>&nbsp;&nbsp;
                        <button type="submit" class="btn btn-default">筛选</button>
                    </form>

                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr>
                                <th>时间</th>
                                <th>广告名称</th>
                                <th>曝光</th>
                                <th>点击</th>
                                <th>激活</th>
                                <th>点击率</th>
                                <th>激活率</th>
                                <th>单价</th>
                                <th>花费</th>
                            </tr>
                            @foreach($list  as $u)
                            <tr>
                                <td>{{$u->days}}</td>
                                <td>{{$u->ad_name}}</td>
                                <td>{{$u->show_nums}}</td>
                                <td>{{$u->click_nums}}</td>
                                <td>{{$u->active_nums}}</td>
                                <td>{{ $u->click_nums > 0 ? round($u->active_nums/$u->click_nums *100,2): 0}}%</td>
                                <td></td>
                                <td>{{$u->price/100}}</td>
                                <td>{{$u->costprice/100}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>合计</td>
                                <td></td>
                                <td></td>
                                <td>{{$total['click_nums']}}</td>
                                <td>{{$total['active_nums']}}</td>
                                <td>{{$total['active_percent']}}</td>
                                <td></td>
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
    });
    $("#start_time").datetimepicker({
        pickerPosition:'bottom-left',
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
            url:"{{url('index/pulldown')}}",
            type:'get',
            dataType: "json",
            success: function(data){
                var querySelect = document.getElementById("advertiser_id0");
                if(data){
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].ad_name, data[i].id));
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