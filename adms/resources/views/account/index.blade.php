@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9"  data-nav="collapseFixe">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">账号列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label> </label>
                    <div class="form-group">
                        <div class="input-append date form_datetime" id="form_datetime">
                            <a href="{{ url('/account/add') }}" target="_self"><button type="button" class="btn btn-default">添加</button></a>
                        </div>
                    </div>
                    <p></p>

                    <label>账号</label>
                    <div class="form-group">
                        <input class="form-control" name="account" type="text">
                    </div>

                    <button type="submit" class="btn btn-default">筛选</button>
                </form>


                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>账号</th>
                            <th>角色</th>
                            <th>最后登录时间</th>
                            <th>操作</th>
                        </tr>


                     @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->admin_name}}</td>
                            <td>{{$u->admin_account}}</td>
                            <td>{{$u->name}}</td>
                            <td>{{!empty($u->last_login) ? date("Y-m-d H:i:s" ,$u->last_login) : ""}}</td>
                            <td>
                                <a href="{{ url('/account/up') }}/{{$u->id}}"><button class="btn btn-success btn-xs" id="updbtn" data-id="{{$u->id}}">修改</button></a>
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
    $("table #delbtn").on("click",function () {
        var id = $(this).attr("data-id");
        if(confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/account/del') }}/" + id,
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