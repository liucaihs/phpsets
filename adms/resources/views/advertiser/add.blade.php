@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9"  data-nav="collapseOne">
                <div class="row" style="margin-top: 30px; ">
                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-success">
                          <div class="panel-heading">
                            <h3 class="panel-title">接入广告主</h3>
                          </div>
                          <form class="form-horizontal" style="margin-top: 20px;margin-left: 25%;" method="POST" onsubmit="return add();" id="subform">
                              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">广告主名称</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" placeholder="广告主名称" style="width: 285px;" id="advertiser_name" name="name">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">行业分类</label>
                                <div class="col-sm-10">
                                    <select class="form-control" style="width: 285px;" id="classification" name="industry">
                                        <option>游戏</option>
                                        <option>电商</option>
                                        <option>应用</option>
                                        <option>其他</option>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">地址</label>
                                <div class="col-sm-10">
                                 <input type="text" class="form-control" placeholder="输入地址" style="width: 285px;" id="site" name="address">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">联系人</label>
                                <div class="col-sm-10">
                                 <input type="text" class="form-control" placeholder="联系人" style="width: 285px;" id="usename" name="contacts">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">联系方式</label>
                                <div class="col-sm-10">
                                 <input type="number" class="form-control" placeholder="联系方式" style="width: 285px;" id="usenumber" name="phone">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">销售</label>
                                <div class="col-sm-10">
                                 <input type="text" class="form-control" placeholder="销售" style="width: 285px;" id="market" name="sales">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">备注</label>
                                <div class="col-sm-10">
                                 <textarea class="form-control" rows="5" style="width: 285px;" id="remark" name="remark"></textarea>
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
    </div>

<script type="text/javascript">
$("#form_datetime").datetimepicker({
  　minView: "month", //选择日期后，不会再跳转去选择时分秒 
　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
　　language: 'zh-CN', //汉化 
　　autoclose:true //选择日期后自动关闭 
});

function add() {
    var advertiser_name=$('#advertiser_name').val();
    var usename=$('#usename').val();
    var usenumber=$('#usenumber').val();
    if(advertiser_name!=''&&usename!=''){
      if(usenumber!=''){
          if(!(/^1(3|4|5|7|8)\d{9}$/.test(usenumber))){
              alert("手机号格式不正确");
          }else{
            var data = $("#subform").serializeArray();
            $.ajax({
                url:'',
                type:'post',
                data:data,
                dataType: "json",
                success: function(data){
                    // alert(data);
                    location.href="{{ url('/index') }}";
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
      }else{
        var data = $("#subform").serializeArray();
        $.ajax({
            url:'',
            type:'post',
            data:data,
            dataType: "json",
            success: function(data){
                // alert(data);
                location.href="{{ url('/index') }}";
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
      
    }else{
      if(advertiser_name==''){
        alert('广告主名称不可为空');
      }
      if(usename==''){
        alert('联系人不可为空');
      }
    }
    
    return false;
    // var advertiser_name=$('#advertiser_name').val();
    // var classification=$('#classification').val();
    // var site=$('#site').val();
    // var usename=$('#usename').val();
    // var usenumber=$('#usenumber').val();
    // var market=$('#market').val();
    // var creation_time=$('#creation_time').val();
    // var remark=$('#remark').val();

    // $.ajax({
    //     url:'',
    //     type:'post',
    //     data:{name:advertiser_name,industry:classification,address:site,contacts:usename,phone:usenumber,sales:market,create_time:creation_time,remark:remark},
    //     success: function(data){
    //         // alert(data);
    //         location.href="{{ url('/index/add') }}";
    //     },
    //     beforeSend: function(){

    //     },
    //     complete: function(xhr, st){

    //     },
    //     error : function(xhr){
    //         alert('ajax error');
    //     }
    // });
}
</script> 
@include('common.footer')