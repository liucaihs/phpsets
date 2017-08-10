@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseOne">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">广告主列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label>选择广告</label>
                    <div class="form-group">
                        <select class="form-control" id="ad_name" name="ad_name" onchange="onclis()">
                        </select>
                    </div>
                    <label>结算方式</label>
                    <div class="form-group">
                        <select class="form-control" name="pay_type" onchange="onclis()">
                            <option value="">  ==请选择==  </option>
                            <option value="1">曝光</option>
                            <option value="2">点击</option>
                            <option value="3">激活</option>
                        </select>
                    </div>
                    <label>广告平台</label>
                    <div class="form-group">
                        <select class="form-control" name="puton_platform" onchange="onclis()">
                            <option value="">  ==请选择平台==  </option>
                            <option value="1">ios</option>
                            <option value="2">Android</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default" id="submit_atun" style="display: none;">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>序号</th>
                            <th>广告名称</th>
                            <th>结算方式</th>
                            <th>接入单价（元）</th>
                            <th>投放平台</th>
                            <th>开始投放时间</th>
                            <th>结束投放时间</th>
                        </tr>

                        @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->ad_name}}</td>
                            <td>@if ($u->pay_type==1)
                                    曝光
                                @elseif ($u->pay_type==2)
                                    点击
                                @else
                                    激活
                                @endif
                            </td>
                            <td>{{$u->into_price/100}}</td>
                            <td>@if ($u->puton_platform==1)
                                    ios
                                @elseif ($u->puton_platform==2)
                                    Android
                                @else
                                    
                                @endif
                            </td>
                            <td>{{date("Y-m-d" ,$u->start_time)}}</td>
                            <td>{{date("Y-m-d" ,$u->end_time)}}</td>
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

<script type="text/javascript">
$(document).ready(function(){
    getall_corporation();
});
function getall_corporation(){
    $.ajax({
        url:"{{url('/index/pulldown')}}",
        type:'get',
        dataType: "json",
        success: function(data){
            // console.log(data);
            var querySelect = document.getElementById("ad_name");
            // var oOp = querySelect.children;//获取select列表的所有子元素。
            if(data){
                querySelect.options.add(new Option(" ==选择广告== ",""));
                for(var i in data){
                    querySelect.options.add(new Option(data[i].ad_name, data[i].ad_name));
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
function onclis(){
    $('#submit_atun').click();
}
</script>
@include('common.footer')