@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseFixe">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">配置管理列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label></label>
                    <div class="form-group">
                        <div class="input-append date form_datetime" id="form_datetime">
                            <a href="{{ url('/cmdb/add') }}" target="_self"><button type="button" class="btn btn-default">添加</button></a>
                        </div>
                    </div>
                    <p></p>

                    <label>键</label>
                    <div class="form-group">
                        <input class="form-control" name="key" type="text">
                    </div>

                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>键</th>
                            <th>值</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>


                     @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->key}}</td>
                            <td>{{$u->value}}</td>
                            <td>{{!empty($u->create_time) ? date("Y-m-d H:i:s" ,$u->create_time) : ""}}</td>
                            <td>{{!empty($u->update_time) ? date("Y-m-d H:i:s" ,$u->update_time) : ""}}</td>
                            <td>
                                <button class="btn btn-success btn-xs" onclick="exit({{$u}})">修改</button>
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

    <!--隐藏修改框-->
    <div class="row" style="margin-top: 100px; display:none;margin-left: 130px; position: absolute;  top: 0; left: 100px; bottom: 0; right: 0;" id="cmdb_movie">
          <div class="col-md-8 col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">接入广告</h3>
                </div>
                <form class="form-horizontal" style="margin-top: 20px;margin-left: 18%;" method="POST" onsubmit="return update();" id="subform">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="text" name="id" class="form-control" id="cmdb_id"style="display:none;">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">键</label>

                        <div class="col-sm-10">
                            <input type="text" name="key" class="form-control" id="cmdb_key" placeholder="键"
                                   style="width: 285px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">值</label>

                        <div class="col-sm-10">
                            <input type="text" name="value" class="form-control" id="cmdb_value" placeholder="值"
                                   style="width: 285px;">
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-default">修改</button>&nbsp;&nbsp;
                        <a class="btn btn-danger" onclick="closes()">关闭</a>
                      </div>
                    </div>
                  </form>
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
                url: "{{ url('/cmdb/del') }}/" + id,
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
        $('#cmdb_movie').css('display','none');
    }
    function exit(datac){
        $('#cmdb_key').val(datac.key);
        $('#cmdb_id').val(datac.id);
        $('#cmdb_value').val(datac.value);
        $('#cmdb_movie').show();
    }

    function update() {
        var data = $("#subform").serializeArray();
        $.ajax({
            url:"{{url('/cmdb/update')}}",
            type:'post',
            data:data,
            dataType: "json",
            success: function(msg){
                // console.log(msg);
                if(data.msg==0){
                  alert('键不能为空');
                }else if(data.msg==1){
                  alert('键已存在' );
                }else if(data.msg==2){
                  alert('键超出范围' );
                }else if(data.msg==3){
                  alert('值不能为空' );
                }else{
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

        return false;
    }
</script>
@include('common.footer')