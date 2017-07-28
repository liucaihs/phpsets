@include('common.header')
@include('common.menu')
        <!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9"  data-nav="collapseFixe">
    <div class="row" style="margin-top: 30px; ">
        <div class="col-md-6 col-sm-12">
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title">添加</h3>
                </div>
                <form id="subform" class="form-horizontal" style="margin-top: 20px;margin-left: 25%;" method="POST"
                      onsubmit="return chksubm();">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">键</label>

                        <div class="col-sm-10">
                            <input type="text" name="key" class="form-control" placeholder="键"
                                   style="width: 285px;">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">值</label>

                        <div class="col-sm-10">
                            <input type="text" name="value" class="form-control" placeholder="值"
                                   style="width: 285px;">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">添加</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    function chksubm() {
        var a = $("form input");
        var res = true;
        $.each(
                a,
                function (name, object) {
                    var name = $(object).attr("name");
                    var val = $(object).val();
                    if (name != '_token') {
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

        $.ajax({
            type: 'post',
            url: "{{ url('/cmdb/add') }}",
            data: data,
            dataType: "json",//预期服务器返回的数据类型
            success: function (msg) {
                if (!msg.code) {
                    alert(msg.msg)
                } else {
                    $(location).attr('href', "{{ url('/cmdb') }}");
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