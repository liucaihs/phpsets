@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseOne">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">广告主列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <!-- <label>开始时间</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="form-group">
                        <div class="input-append date form_starttime" id="form_starttime">
                            <input size="16" type="text" value="" readonly style="width: 176px;" name="start_time">
                            <span class="add-on"><i class="icon-th glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                    <label>结束时间</label>
                    <div class="form-group">
                        <div class="input-append date form_endtime" id="form_endtime">
                            <input size="16" type="text" value="" readonly style="width: 176px;" name="end_time">
                            <span class="add-on"><i class="icon-th glyphicon glyphicon-th"></i></span>
                        </div>
                    </div> -->
                    <label>广告主ID</label>
                    <div class="form-group">
                        <input class="form-control" type="text" id="Client_ID2" name="client_ID">
                    </div>
                    <label>广告主名称</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="advertiser2" name="advertiser">
                    </div>
                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>广告主ID</th>
                            <th>广告主名称</th>
                            <th>行业分类</th>
                            <th>联系人</th>
                            <th>联系方式</th>
                            <th>销售</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->name}}</td>
                            <td>{{$u->industry}}</td>
                            <td>{{$u->contacts}}</td>
                            <td>{{$u->phone}}</td>
                            <td>{{$u->sales}}</td>
                            <td>{{date("Y-m-d H:i:s" ,$u->create_time)}}</td>
                            <td>{{!empty($u->update_time) ? date("Y-m-d H:i:s" ,$u->update_time) : ""}}</td>
                            <td>
                                <button class="btn btn-success btn-xs" onclick="exit({{$u}})">修改</button>
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
                <!-- <div class="panel-footer text-center">
                      <nav>
                      <ul class="pagination pagination-sm" style="margin: 0;">
                        <li><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                      </ul>
                    </nav>
                </div> -->
                
            </div>
        </div>
    </div>

    <!--隐藏修改框-->
    <div class="row" style="margin-top: 30px; display:none;margin-left: 100px; position: absolute;  top: 0; left: 0; bottom: 0; right: 0;" id="advertiser_movie">
    <div class="col-md-10 col-sm-12">
        <div class="panel panel-success ">
          <div class="panel-heading">
            <h3 class="panel-title">广告主修改框</h3>
          </div>
          <form class="form-horizontal" style="margin-top: 20px;margin-left: 25%;" method="POST" onsubmit="return update();" id="subform">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">广告主名称</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="广告主名称" style="width: 285px;" id="advertiser_name" name="name">
                  <input type="text" class="form-control"style="width: 285px;display:none;" id="advertiser_id" name="id">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">行业分类</label>
                <div class="col-sm-10">
                    <select class="form-control" style="width: 285px;" id="classification" name="industry">
                        <option>游戏</option>
                        <option>电商</option>
                        <option>应用</option>
                        <option>其他</option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">地址</label>
                <div class="col-sm-10">
                 <input type="text" class="form-control" placeholder="输入地址" style="width: 285px;" id="site" name="address">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">联系人</label>
                <div class="col-sm-10">
                 <input type="text" class="form-control" placeholder="联系人" style="width: 285px;" id="usename" name="contacts">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">联系方式</label>
                <div class="col-sm-10">
                 <input type="number" class="form-control" placeholder="联系方式" style="width: 285px;" id="usenumber" name="phone">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">销售</label>
                <div class="col-sm-10">
                 <input type="text" class="form-control" placeholder="销售" style="width: 285px;" id="market" name="sales">
                </div>
              </div>
              <!-- <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">创建时间</label>
                <div class="col-sm-10">
                    <div class="input-append date form_datetime" id="form_datetime">
                        <input size="16" type="text" value="" readonly style="width: 285px;" id="creation_time" name="create_time">
                        <span class="add-on"><i class="icon-th glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
              </div> -->
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">备注</label>
                <div class="col-sm-10">
                 <textarea class="form-control" rows="5" style="width: 285px;" id="remark" name="remark"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">修改</button>&nbsp;&nbsp;
                  <a class="btn btn-danger" onclick="closes()">关闭</a>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $("#form_datetime").datetimepicker({
        minView: "month", //选择日期后，不会再跳转去选择时分秒
        format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
        language: 'zh-CN', //汉化
        autoclose:true //选择日期后自动关闭
    });
    $("#form_starttime").datetimepicker({
        minView: "month", //选择日期后，不会再跳转去选择时分秒
        format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
        language: 'zh-CN', //汉化
        autoclose:true //选择日期后自动关闭
    });
    $("#form_endtime").datetimepicker({
        minView: "month", //选择日期后，不会再跳转去选择时分秒
        format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式
        language: 'zh-CN', //汉化
        autoclose:true //选择日期后自动关闭
    });
    function add0(m){return m<10?'0'+m:m };//时间方法
    $("table #delete").on("click",function () {
        var id = $(this).attr("data-id");
        if(confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/index/delete') }}/" + id,
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
    function closes(){
        $('#advertiser_movie').css('display','none');
    }
    function exit(data){
        $('#advertiser_id').val(data.id);
        $('#advertiser_name').val(data.name);
        $('#classification').val(data.industry);
        $('#site').val(data.address);
        $('#usename').val(data.contacts);
        $('#usenumber').val(data.phone);
        $('#market').val(data.sales);
        // var time = new Date(data.create_time*1000);
        // var y = time.getFullYear(); 
        // var m = time.getMonth()+1; 
        // var d = time.getDate(); 
        // var heaven=y+'-'+add0(m)+'-'+add0(d);
        // $('#creation_time').val(heaven);
        $('#remark').val(data.remark);
        $('#advertiser_movie').show();
    }

    function update() {
        var advertiser_name=$('#advertiser_name').val();
        var usename=$('#usename').val();
        if(advertiser_name!=''&&usename!=''){
            var data = $("#subform").serializeArray();
            $.ajax({
                url:"{{url('index/update')}}",
                type:'post',
                data:data,
                dataType: "json",
                success: function(data){
                    // alert(data);
                    location.href="{{ url('/index') }}";
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
            if(advertiser_name==''){
                alert('广告主名称不可为空');
            }
            if(usename==''){
                alert('联系人不可为空');
            }
        }
        return false;
    }
</script>
@include('common.footer')