@include('common.header')
@include('common.menu')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFixe">
    <div class="col-sm-9 col-lg-10">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-btns">

                </div>
                <h4 class="panel-title">编辑[{{$data->name}}]权限</h4>
            </div>

            <form action="" method="post" id="subform" id="role-permissions-form" onsubmit="return chksubm();" >
                <div class="panel-body panel-body-nopadding">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    @foreach($permList  as $u)
                        <div class="top-permission col-md-12">
                            <a href="javascript:;" class="display-sub-permission-toggle">
                                <span class="glyphicon glyphicon-minus"></span>
                            </a>
                            <input type="checkbox" name="permissions[]" value="{{$u['id']}}"  @if($u['is_chk']) checked="checked" @endif class="top-permission-checkbox"  >
                            <label><h5>&nbsp;&nbsp;{{$u['display_name']}}</h5></label>
                        </div>
                        <div class="sub-permissions col-md-11 col-md-offset-1" style="display: block;">
                        @foreach($u['sub_perm']  as $su)
                                <div class="col-sm-3">
                                    <label><input type="checkbox" name="permissions[]"  @if($su['is_chk']) checked="checked" @endif value="{{$su['id']}}" class="sub-permission-checkbox"  >&nbsp;&nbsp;<span class="fa fa-bars"></span>{{$su['display_name']}}
                                    </label>
                                </div>
                        @endforeach
                        </div>
                    @endforeach

                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button class="btn btn-primary" id="save-role-permissions">保存</button>
                        </div>
                    </div>
                </div><!-- panel-footer -->

            </form>

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
                    $(location).attr('href', "{{ url('/role') }}");
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