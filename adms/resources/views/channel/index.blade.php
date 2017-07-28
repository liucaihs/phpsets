@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="channel">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">渠道列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">

                    <p></p>
                    <label>媒体ID&nbsp;&nbsp;&nbsp;</label>
                    <div class="form-group">
                        <input type="text" name="id" class="form-control">
                    </div>
                    <label>媒体名称</label>
                    <div class="form-group">
                        <input class="form-control" name="name" type="text">
                    </div>
                    <p></p>
                    <label>所属平台</label>
                    <div class="form-group">
                        <select class="form-control"  name="belong"  style="width: 285px;" placeholder="所属平台">
                            <option value=""> =请选择= </option>
                            @foreach($plat  as $u)
                                <option value="{{$u->id}}"   >{{$u->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>媒体ID</th>
                            <th>媒体名称</th>
                            <th>所属平台</th>
                            <th>渠道类别</th>
                            <th>联系人</th>
                            <th>联系方式</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                    @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->name}}</td>
                            <td>{{$u->platform}}</td>
                            <td>{{$u->channel_type}}</td>
                            <td>{{$u->contacts}}</td>
                            <td>{{$u->phone}}</td>
                            <td>{{!empty($u->create_time) ? date("Y-m-d H:i:s" ,$u->create_time) :""}}</td>
                            <td>{{!empty($u->update_time) ? date("Y-m-d H:i:s" ,$u->update_time) :""}}</td>
                            <td>
                                <a href="{{ url('/channel/up') }}/{{$u->id}}"><button class="btn btn-success btn-xs" id="updbtn" data-id="{{$u->id}}">修改</button></a>
                              <button class="btn btn-danger btn-xs" id="delbtn"  data-id="{{$u->id}}">删除</button>
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
</div>
</div>

<script type="text/javascript">
    $("#form_datetime").datetimepicker({
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
    $("table #delbtn").on("click",function () {
        var id = $(this).attr("data-id");
        if(confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/channel/del') }}/" + id,
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
    $("table #updbtn").on("click",function () {
        var id = $(this).attr("data-id");

    });
</script>
@include('common.footer')