@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
      <div class="row" style="margin-top: 30px; ">
          <div class="col-md-6 col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">广告主测试</h3>
                </div>
                <form class="form-horizontal" style="margin-top: 20px;margin-left: 18%;" method="POST" onsubmit="return add();" id="subform">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">广告主接口地址</label>
                                <div class="col-sm-9">
                                    <select class="form-control" style="width: 285px;" id="adput_id0" name="id">
                                        <option value=""> =请选择= </option>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">mac</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="mac" style="width: 285px;" id="mac" name="mac">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">idfa</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="idfa" style="width: 285px;" id="idfa" name="idfa">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">IP</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="ip" style="width: 285px;" id="ip" name="ip">
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-10">
                                  <button type="submit" class="btn btn-default">生成</button>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">测试链接</label>
                                <div class="col-sm-9">

                                    <textarea class="form-control" rows="5" style="width: 285px;" id="remark" name="cs_site"></textarea>
                                </div>
                              </div>
                  </form>
              </div>
          </div>
      </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    getall_zxcq();
});

function add() {
    var data = $("#subform").serializeArray();
    $.ajax({
        url:"{{url('/testurl')}}",
        type:'post',
        data:data,
        dataType: "json",
        success: function(data){
            // console.log(data.msg);
            if (!data.code) {
                alert(data.msg);
            } else {
                $("#remark").val(data.msg)
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
function getall_zxcq(){
    $.ajax({
        url:"{{url('adputon/select')}}",
        type:'get',
        dataType: "json",
        success: function(data){
            var querySelect = document.getElementById("adput_id0");
            if(data){
                for(var i in data){
                    querySelect.options.add(new Option(data[i].adput_name, data[i].id));
                }
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
}
</script> 
@include('common.footer')