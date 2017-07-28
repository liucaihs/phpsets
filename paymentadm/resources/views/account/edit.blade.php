@extends('layouts.admin')

@section('content')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9"  data-nav="collapseFixe">
    <!-- <div class="row">
        <div class="col-md-12">
            <h2>用户管理</h2>
        </div>
        <div class="col-md-12">
            <button class="btn btn-default">用户详细信息</button>
            <button class="btn btn-success">添加用户</button>
            <button class="btn btn-info">用户使用情况</button>
            <button class="btn btn-warning">用户流失情况</button>
        </div>
    </div> -->

    <div class="row" style="margin-top: 30px; ">
        <div class="col-md-6 col-sm-12">
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title">编辑账号</h3>
                </div>
                <form id="subform" class="form-horizontal" style="margin-top: 20px;margin-left: 25%;" method="POST"
                      onsubmit="return chksubm();">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>

                        <div class="col-sm-10">
                            <input type="text" name="admin_name" class="form-control" placeholder="姓名"
                                   style="width: 285px;" value="{{$row->admin_name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">账号</label>

                        <div class="col-sm-10">
                            <input type="text" name="admin_account" class="form-control" placeholder="账号"
                                   style="width: 285px;"  value="{{$row->admin_account}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>

                        <div class="col-sm-10">
                            <input type="text" name="admin_password" class="form-control" placeholder="密码"
                                   style="width: 285px;"  value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色</label>

                        <div class="col-sm-10">
                            <select class="form-control"  name="role"  style="width: 285px;" placeholder="角色">
                                <option value=""> =请选择= </option>
                                @foreach($role  as $u)
                                    <option value="{{$u->id}}" @if($u->id == $row->role)
                                    selected="selected"
                                    @endif >{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">保存</button>
                        </div>
                    </div>
                </form>
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
        autoclose: true //选择日期后自动关闭
    });
    function chksubm() {

        var a = $("form input");
        var res = true;
        $.each(
                a,
                function (name, object) {
                    var name =  $(object).attr("name");
                    var val =  $(object).val();
                    if (name != 'admin_password' && name != '_token') {
                        if (val == "" || val == " ") {
                            alert($(object).attr("placeholder") + "不能为空！");
                            res = false;
                        }
                    }

                }
        );
        if (!res) {
            return false;
        }
        var data = $("#subform").serializeArray();
        console.log(data);
        $.ajax({
            type:'post',
            url:'',
            data:data,
            dataType: "json",//预期服务器返回的数据类型
            success:function(msg){
                if (!msg.code) {
                    alert(msg.msg)
                } else {
                    $(location).attr('href', "{{ url('/account') }}");
                }
            },
            async: true,
            error: function (d) {
                alert("请求失败！")
            }
        });
        return false;

    }
</script>
@endsection