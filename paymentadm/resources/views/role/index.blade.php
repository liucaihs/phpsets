@extends('layouts.admin')

@section('content')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFixe">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">角色列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label> </label>
                    <div class="form-group">
                        <div class="input-append date form_datetime" id="form_datetime">
                            <a href="{{ url('/role/add') }}" target="_self"><button type="button" class="btn btn-default">添加</button></a>
                        </div>
                    </div>
                    <p></p>

                    <label>角色名</label>
                    <div class="form-group">
                        <input class="form-control" name="name" type="text">
                    </div>

                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>角色名</th>
                            <th>说明</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>


                     @foreach($list  as $u)
                        <tr>
                            <td>{{$u['id']}}</td>
                            <td> {{$u['name']}}</td>
                            <td>{{$u['description']}}</td>
                            <td>{{!empty($u['create_time']) ? date("Y-m-d H:i:s" ,$u['create_time']) : ""}}</td>
                            <td>{{!empty($u['update_time']) ? date("Y-m-d H:i:s" ,$u['update_time']) : ""}}</td>
                            <td>
                                <a href="{{ url('/role/perm') }}/{{$u['id']}}"><button class="btn btn-success btn-xs" id="updbtn" data-id="{{$u['id']}}">权限</button></a>
                                <a href="{{ url('/role/up') }}/{{$u['id']}}"><button class="btn btn-success btn-xs" id="updbtn" data-id="{{$u['id']}}">修改</button></a>
                                <button class="btn btn-danger btn-xs" id="delbtn"  data-id="{{$u['id']}}">删除</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="panel-footer text-center">
                    <nav>

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
                url: "{{ url('/role/del') }}/" + id,
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
@endsection