@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
      <div class="row" style="margin-top: 30px; ">
          <div class="col-md-6 col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">投放广告复制</h3>
                </div>
                <form class="form-horizontal" style="margin-top: 20px;margin-left: 18%;" method="POST" onsubmit="return add();" id="subform">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="is_copy" value="1">
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">广告</label>
                      <div class="col-sm-9">
                          <select class="form-control" style="width: 285px;" id="ad_id" name="ad_id" readonly="true">
                              <option value=""> =请选择= </option>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">渠道</label>
                        <div class="col-sm-9">
                            <select class="form-control" style="width: 285px;" id="media_id" name="media_id" readonly="true">
                                <option value=""> =请选择= </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">任务名称</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="任务名称" style="width: 285px;" id="ad_name0" name="adput_name"  value="{{$row->adput_name}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">结算方式</label>
                      <div class="col-sm-9">
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio1" name="pay_type" value="1" checked> 曝光
                        </label>
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio2" name="pay_type" value="2"> 点击
                        </label>
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio3" name="pay_type" value="3"> 激活
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">单价（元）</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="单价" style="width: 285px;" id="price" name="price"   value="{{$row->price/100}}">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">日均限量</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" placeholder="日均限量" style="width: 285px;" id="limited" name="limited"   value="{{$row->limited}}">
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">扣量比率</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" placeholder="扣量比率%" style="width: 285px;" id="reduction" name="reduction" value="{{$row->reduction*100}}">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">投放时间</label>
                        <div class="col-sm-9">
                            <div class="input-append date form_datetime" id="form_datetime0">
                                开始时间：
                                <input size="16" type="text" placeholder="开始时间"  readonly style="width: 200px;" id="start_time" name="start_time"   value="{{date("Y-m-d",$row->start_time)}}">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div><br/>
                            <div class="input-append date form_datetime" id="form_datetime1">
                                结束时间：
                                <input size="16" type="text"  placeholder="结束时间"    readonly style="width: 200px;" id="end_time" name="end_time"   value="{{date("Y-m-d",$row->end_time)}}">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">投放平台</label>
                      <div class="col-sm-9">
                        <label class="radio-inline">
                        <input type="radio" checked name="puton_platform" value="1" /> ios </label>
                          <label class="radio-inline">
                              <input type="radio"   name="puton_platform" value="2" /> android
                      </label>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">投放链接/包</label>
                      <div class="col-sm-9">
                       <input type="text" class="form-control" placeholder="投放链接/包" style="width: 285px;" id="puton_url" name="puton_url"   value="{{$row->puton_url}}">
                      </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">是否使用接口</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" checked name="use_api" value="1" /> 是  </label>
                            <label class="radio-inline">
                                <input type="radio"   name="use_api" value="0" /> 否
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="useapishow">
                      <label for="inputPassword3" class="col-sm-3 control-label">回调链接</label>
                      <div class="col-sm-9">
                       <input type="text" class="form-control" placeholder="回调链接" style="width: 285px;" id="channel_url" name="channel_url"   value="{{$row->channel_url}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">要求说明</label>
                      <div class="col-sm-9">
                       <textarea class="form-control" rows="5" style="width: 285px;" id="remark" name="remark">  {{$row->remark}} </textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-10">
                        <button type="submit" class="btn btn-default">保存</button>
                      </div>
                    </div>
                  </form>
              </div>
          </div>
      </div>
</div>


<script type="text/javascript">
$(document).ready(function(){

    getall_zxcq("{{url('advertising/select')}}", "ad_id");
    getall_zxcq("{{url('channel/select')}}", "media_id");
    $("#ad_id").val({{$row->ad_id}});
    $("#media_id").val({{$row->media_id}});
    setRadioValue("pay_type" , "{{$row->pay_type}}");
    setRadioValue("puton_platform" , "{{$row->puton_platform}}");
    setRadioValue("use_api" , "{{$row->use_api}}");
    $("input[name='use_api']").click(function(){
        var value = $("input[name='use_api']:checked").val();
        if (value == 0) {
            $("#useapishow").hide();
        } else {
            $("#useapishow").show();
        }
    });
    if (useapi == 0) {
        $("#useapishow").hide();
    }
});

function setRadioValue(name, value) {
    $("input[name='" + name + "']").each(function() {
        if ($(this).val() == value) {
            $(this).prop("checked", "checked");
        }
    });
}

$("#start_time").datetimepicker({
  　minView: "month", //选择日期后，不会再跳转去选择时分秒 
　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
　　language: 'zh-CN', //汉化 
　　autoclose:true //选择日期后自动关闭 
});
$("#end_time").datetimepicker({
  　minView: "month", //选择日期后，不会再跳转去选择时分秒 
　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
　　language: 'zh-CN', //汉化 
　　autoclose:true //选择日期后自动关闭 
});

function add() {

    var a = $("form input");
    var res = true;
    $.each(
            a,
            function (name, object) {
                var name =  $(object).attr("name");
                var val =  $(object).val();
                if (name != 'limited'&& name!= 'reduction'  && name != '_token' && name != "channel_url" && name != "remark" && $(object).attr("placeholder") != undefined) {
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
    if (!$("#ad_id").val()) {
        alert( "请选择广告！");
        return false;
    }
    if (!$("#media_id").val()) {
        alert( "请选择渠道！");
        return false;
    }
    var data = $("#subform").serializeArray();
    $.ajax({
        url: "{{url('/adputon/add')}}",
        type:'post',
        data:data,
        dataType: "json",
        success: function(data){
            if (!data.code) {
                alert(data.msg)
            } else {

                $(location).attr('href', "{{ url('/adputon') }}");
            }
        },
        async: true,
        error: function (d) {
            alert("请求失败！")
        }
    });
   
    return false;
}
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
        async: false,
        error: function (d) {
            alert("请求失败！")
        }
    });
}
</script> 
@include('common.footer')