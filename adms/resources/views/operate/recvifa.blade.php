@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFour">
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">ifa激活列表</h3>
                    </div>
                    <form class="form-inline" role="form" style="margin: 10px;" method="get">

                        <label>ifa </label>
                        <div class="form-group">
                            <input class="form-control" type="text" id="id" name="ifa" size="50">
                        </div>&nbsp;&nbsp;
                        <label>时间</label>
                        <div class="form-group">
                            <input class="form-control" type="text" size="10" id="start_time" name="time">
                        </div>
                        <button type="submit" class="btn btn-default">筛选</button>
                    </form>
                    <h3> 总记录条数：{{$totalNum}} {{$dayNum}}</h3>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr>
                                <th>ifa</th>
                                <th>timestamp</th>
                            </tr>
                            @foreach($list  as $u)
                            <tr>
                                <td>{{$u->ifa}}</td>
                                <td>{{!empty($u->timestamp) ? date("Y-m-d H:i:s" ,$u->timestamp) :""}} </td>
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
</div>

<script type="text/javascript">
    $(document).ready(function(){

    });
    $("#start_time").datetimepicker({
        minView: "month", //选择日期后，不会再跳转去选择时分秒
        format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
        language: 'zh-CN', //汉化
        autoclose:true //选择日期后自动关闭
    });
</script>
@include('common.footer')