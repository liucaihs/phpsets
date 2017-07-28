@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
      <div class="row" style="margin-top: 30px; ">
          <div class="col-md-6 col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">接入广告</h3>
                </div>
                <form class="form-horizontal" style="margin-top: 20px;margin-left: 18%;" method="POST" onsubmit="return add();" id="subform">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">广告主</label>
                      <div class="col-sm-9">
                          <select class="form-control" style="width: 285px;" id="advertiser_id0" name="advertiser_id">
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">广告名称</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="广告名称" style="width: 285px;" id="ad_name0" name="ad_name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">结算方式</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="pay_type" name="pay_type" style="display: none;" value="1">
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio1" name="inlineRadi" value="1" checked> 曝光
                        </label>
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio2" name="inlineRadi" value="2"> 点击
                        </label>
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio3" name="inlineRadi" value="3"> 激活
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">接入单价（元）</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" placeholder="接入单价" style="width: 285px;" id="into_price" name="into_price">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">投放平台</label>
                      <div class="col-sm-9">
                        <label class="radio-inline">
                        <input type="radio" checked name="puton_platform" value="1"> ios
                      </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">下载链接/包</label>
                      <div class="col-sm-9">
                       <input type="text" class="form-control" placeholder="下载链接/包" style="width: 285px;" id="puton_url" name="puton_url">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">回调URLENCODE</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="urlencode" name="urlencode" style="display: none;" value="1">
                        <label class="radio-inline">
                          <input type="radio" id="inlin_urlencode1" name="urlencodei" value="1" checked>是
                        </label>
                        <label class="radio-inline">
                          <input type="radio" id="inlin_urlencode2" name="urlencodei" value="0">否
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">广告主接口地址</label>
                      <div class="col-sm-9">
                       <input type="text" class="form-control" placeholder="广告主接口地址" style="width: 285px;" id="owner_apiurl" name="owner_apiurl">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">投放时间</label>
                      <div class="col-sm-9">
                      <div class="input-append date form_datetime" id="form_datetime0">
                          开始时间：
                          <input size="16" type="text"  readonly style="width: 200px;" name="start_time" id="start_time">
                          <span class="add-on"><i class="icon-th"></i></span>
                      </div>
                      <br/>
                      <div class="input-append date form_datetime" id="form_datetime1">
                        结束时间：
                          <input size="16" type="text"  readonly style="width: 200px;" name="end_time" id="end_time">
                          <span class="add-on"><i class="icon-th"></i></span>
                      </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">要求说明</label>
                      <div class="col-sm-9">
                       <textarea class="form-control" rows="5" style="width: 285px;" id="remark" name="remark"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-10">
                        <button type="submit" class="btn btn-default">添加</button>
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
$("#form_datetime0").datetimepicker({
  　minView: "month", //选择日期后，不会再跳转去选择时分秒 
　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
　　language: 'zh-CN', //汉化 
　　autoclose:true //选择日期后自动关闭 
});
$("#form_datetime1").datetimepicker({
  　minView: "month", //选择日期后，不会再跳转去选择时分秒 
　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
　　language: 'zh-CN', //汉化 
　　autoclose:true //选择日期后自动关闭 
});
$('#inlineRadio1').on("click",function () {
  var inline01=$(this).val();
  $('#pay_type').val(inline01);
});
$('#inlineRadio2').on("click",function () {
  var inline02=$(this).val();
  $('#pay_type').val(inline02);
});
$('#inlineRadio3').on("click",function () {
  var inline03=$(this).val();
  $('#pay_type').val(inline03);
});
$('#inlin_urlencode1').on("click",function () {
  var urlencode01=$(this).val();
  $('#urlencode').val(urlencode01);
});
$('#inlin_urlencode2').on("click",function () {
  var urlencode02=$(this).val();
  $('#urlencode').val(urlencode02);
});
function add() {
    var ad_name =$("#ad_name0").val();
    var into_price =$("#into_price").val();
    var puton_url =$("#puton_url").val();
    var owner_apiurl =$("#owner_apiurl").val();
    var start_time =$("#start_time").val();
    var end_time =$("#end_time").val();
    if(ad_name!=''&&into_price!=''&&puton_url!=''&&owner_apiurl!=''&&start_time!=''&&end_time!=''){
        var data = $("#subform").serializeArray();
        $.ajax({
            url:'',
            type:'post',
            data:data,
            dataType: "json",
            success: function(data){
                // console.log(data.msg);
                if(data.msg==0){
                  alert('任务名称不能为空');
                }else if(data.msg==1){
                  alert('任务名称已存在' );
                }else if(data.msg==2){
                  alert('任务名称长度超出范围');
                }else if(data.msg==3){
                  alert('下载链接/包地址格式错误');
                }else if(data.msg==4){
                  alert('广告主接口地址格式错误');
                }else{
                  location.href="{{ url('/advertising') }}";
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
        alert('除要求说明都不可为空！');
    }
    return false;
}
function getall_zxcq(){
    $.ajax({
        url:"{{url('advertising/pulldown')}}",
        type:'get',
        dataType: "json",
        success: function(data){
            var querySelect = document.getElementById("advertiser_id0");
            // var oOp = querySelect.children;//获取select列表的所有子元素。
            if(data){
                for(var i in data){
                    querySelect.options.add(new Option(data[i].name, data[i].id));
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