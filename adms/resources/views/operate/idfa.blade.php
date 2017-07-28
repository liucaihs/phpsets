@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFour">
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">ifa数据查询</h3>
                    </div>
                    <form class="form-inline" role="form" style="margin: 10px;" method="get">

                        <label>ifa </label>
                        <div class="form-group">
                            <input class="form-control" type="text" id="id" name="ifa" size="60">
                        </div>&nbsp;&nbsp;

                        <button type="submit" class="btn btn-default">筛选</button>
                    </form>

                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr>
                                <th>时间</th>
                                <th>广告投放标示</th>
                                <th>mac</th>
                                <th>ifa</th>
                                <th>ip</th>
                                <th>原始数据</th>

                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: center;"> <h5>点击数据</h5> </td>
                            </tr>
                            @foreach($clickData  as $u)
                            <tr>
                                <td>{{!empty($u->create_time) ? date("Y-m-d H:i:s" ,$u->create_time) :""}} </td>
                                <td>{{$u->adput_sn}}</td>
                                <td>{{$u->mac}}</td>
                                <td>{{$u->ifa}}</td>
                                <td>{{$u->ip}}</td>
                                <td>{{$u->raw_data}}</td>

                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6"  style="text-align: center;"> <h5>激活数据</h5> </td>

                            </tr>
                            @foreach($activeData  as $u)
                                <tr>
                                    <td>{{!empty($u->create_time) ? date("Y-m-d H:i:s" ,$u->create_time) :""}} </td>
                                    <td>{{$u->adput_sn}}</td>
                                    <td>{{$u->mac}}</td>
                                    <td>{{$u->ifa}}</td>
                                    <td>{{$u->ip}}</td>
                                    <td>{{$u->raw_data}}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer text-center">
                        <nav>

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

</script>
@include('common.footer')