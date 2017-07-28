@include('common.header')
@include('common.menu')
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
                        <label class="col-sm-2 control-label">所属模块</label>

                        <div class="col-sm-10">
                            <select class="form-control"  name="fid"  style="width: 285px;">
                                <option value="0"> =顶级模块= </option>
                                @foreach($role  as $u)
                                    <option value="{{$u->id}}" @if($u->id == $row->fid)
                                    selected="selected"
                                            @endif >{{$u->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">权限路由</label>

                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" placeholder="权限路由"
                                   style="width: 285px;"  value="{{$row->name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">显示名称</label>

                        <div class="col-sm-10">
                            <input type="text" name="display_name" class="form-control" placeholder="显示名称"
                                   style="width: 285px;"  value="{{$row->display_name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">说明</label>

                        <div class="col-sm-10">
                            <input type="text" name="description" class="form-control" placeholder="说明"
                                   style="width: 285px;"  value="{{$row->description}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">是否菜单</label>

                        <div class="col-sm-10">
                            <select class="form-control"  name="is_menu"  style="width: 285px;">
                                <option value="0" @if(!$row->is_menu)  selected="selected"  @endif >否</option>
                                <option value="1" @if($row->is_menu)  selected="selected"  @endif>是</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序</label>

                        <div class="col-sm-10">
                            <input type="text" name="sort" class="form-control" placeholder="排序"
                                   style="width: 285px;" value="{{$row->sort}}">
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
                    $(location).attr('href', "{{ url('/permission') }}");
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
@include('common.footer')