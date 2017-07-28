@extends('layouts.admin')

@section('content')

        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9"  data-nav="collapseFixe">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">业务委派</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label> </label>

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

                            <th>业务</th>
                            <th>操作</th>
                        </tr>


                        @foreach($list  as $u)
                            <tr>
                                <td>{{$u->id}}</td>
                                <td>{{$u->admin_name}}</td>
                                <td>{{$u->admin_account}}</td>
                                <td>{{str_replace(PHP_EOL , ', ' , $u->appids)}}</td>

                                <td>
                                    <button class="btn btn-success btn-xs" onclick="exit({{$u}})">
                                        查看/修改
                                    </button>
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


            </div>
        </div>
    </div>
</div>


<!--隐藏修改框-->
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
                    <label for="inputEmail3" class="col-sm-2 control-label">账号</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="账号" style="width: 285px;"
                               id="admin_account" name="admin_account" readonly="readonly" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">名称</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="名称" style="width: 285px;"
                               id="admin_name" name="admin_name" readonly="readonly" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">业务</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="8" style="width: 285px;" id="desc"
                                  name="desc"></textarea>
                        填写appid 使用空格 换行 或 豆号分隔
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

    function closes() {
        $('#advertiser_movie').css('display', 'none');
    }

    function exit(data) {
        if(!data) {
            $('#sub_tit').text('添加');
            data = {id : "" , admin_account : "" , admin_name : "", appids : "" , };
        } else {
            $('#sub_tit').text('查看/修改');
        }
        $('#id').val(data.id);
        $('#admin_account').val(data.admin_account);
        $('#admin_name').val(data.admin_name);
        $('#desc').val(data.appids);
        $('#advertiser_movie').show();
    }

    function update() {

        var value=$('#desc').val();
        if(value!=''){
            var data = $("#subform").serializeArray();
            $.ajax({
                url:"{{url('appids/save')}}",
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
                alert('业务不可为空');
            }
        }
        return false;
    }
</script>
    @endsection
