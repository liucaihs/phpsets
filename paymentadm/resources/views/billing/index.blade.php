@extends('layouts.admin')

@section('content')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">通道计费类型列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label> </label>

                    <div class="form-group">
                        <div class="input-append date form_datetime" id="form_datetime">

                                <button type="button" class="btn btn-default" onclick="exit(null)">添加</button>

                        </div>
                    </div>
                    <p></p>

                    <label>编号</label>

                    <div class="form-group">
                        <input class="form-control" name="name" type="text">
                    </div>
                    <label >通道</label>
                    <div class="form-group">
                            <select class="form-control" style="width: 185px;" id="pass_id" name="spid">
                                <option value=""> =请选择= </option>
                            </select>
                    </div>

                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>编号</th>
                            <th>通道</th>
                            <th>脚本位置</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list  as $u)
                            <tr>
                                <td>{{$u['id']}}</td>
                                <td>{{$u['codetype']}}</td>
                                <td>{{$u['name']}}</td>
                                <td>{{$u['script']}}</td>
                                <td>{{$u['created_at']}}</td>
                                <td>{{ !empty($u['updated_at']) ?  strtotime($u['updated_at']) ?  $u['updated_at']  : "" : ""}}</td>
                                <td>
                                    <button class="btn btn-success btn-xs" onclick="exit({{$u}})">
                                        查看/修改
                                    </button>

                                    <button class="btn btn-danger btn-xs" id="delbtn" data-id="{{$u['id']}}">删除</button>
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
                    <label for="inputEmail3" class="col-sm-2 control-label">编号</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="编号" style="width: 285px;"
                               id="codetype" name="codetype"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">通道</label>

                    <div class="col-sm-10">
                        <select class="form-control" style="width: 185px;" id="spid-sub" name="spid">
                            <option value=""> =请选择= </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">脚本位置</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="脚本位置" style="width: 285px;"
                               id="script" name="script"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">备注</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="6" style="width: 285px;" id="desc"
                                  name="desc"></textarea>
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
    $(document).ready(function(){
        getall_zxcq("{{url('passage/passsel')}}", "pass_id");
        getall_zxcq("{{url('passage/passsel')}}", "spid-sub");
        });


    function getall_zxcq( url , idsel ){
        $.ajax({
            url: url ,
            type:'get',
            dataType: "json",
            success: function(data){
                console.log(data);
                var querySelect = document.getElementById(idsel);
                // var oOp = querySelect.children;//获取select列表的所有子元素。
                if(data){
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].name, data[i].id));
                    }
                }
            },
            async: true,
            error: function (d) {
                alert("请求失败！")
            }
        });
    }
    $("table #delbtn").on("click", function () {
        var id = $(this).attr("data-id");
        if (confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/billing/del') }}/" + id,
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


    function closes() {
        $('#advertiser_movie').css('display', 'none');
    }

    function exit(data) {
        if(!data) {
            $('#sub_tit').text('添加');
            data = {id : ""   , codetype : "",   spid : "",   desc : "", script: "", };
        } else {
            $('#sub_tit').text('查看/修改');
        }
        $('#id').val(data.id);
        $('#codetype').val(data.codetype);
        $('#spid-sub').val(data.spid);
        $('#desc').val(data.desc);
        $('#script').val(data.script);

        $('#advertiser_movie').show();
    }

    function update() {

        var value=$('#codetype').val();
        if(value!=''){
            var data = $("#subform").serializeArray();
            $.ajax({
                url:"{{url('billing/save')}}",
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
                alert('编号不可为空');
            }
        }
        return false;
    }
</script>
@endsection