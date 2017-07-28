@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9" data-nav="collapseTwo">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">广告列表</h3>
                </div>
                <form class="form-inline" role="form" style="margin: 10px;" method="get">
                    <label>广告ID</label>
                    <div class="form-group">
                        <input class="form-control" type="text" id="client_id2" name="client_id">
                    </div>
                    <label>广告名称</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="adname2" name="adname">
                    </div>
                    <label>投放平台</label>
                    <div class="form-group">
                        <select class="form-control" id="puton_platform01" name="puton_platform01">
                            <option value="1">ios</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">筛选</button>
                </form>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th>广告ID</th>
                            <th>广告名称</th>
                            <th>结算方式</th>
                            <th>接入单价(元)</th>
                            <th>投放平台</th>
                            <th>开始投放时间</th>
                            <th>结束时间</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list  as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->ad_name}}</td>
                            <td>@if ($u->pay_type==1)
                                    曝光
                                @elseif ($u->pay_type==2)
                                    点击
                                @else
                                    激活
                                @endif
                            </td>
                            <td>{{$u->into_price/100}}</td>
                            <td>@if ($u->puton_platform==1)
                                    ios
                                @elseif ($u->puton_platform==2)
                                    Android
                                @else
                                    
                                @endif
                            </td>
                            <td>{{date("Y-m-d" ,$u->start_time)}}</td>
                            <td>{{date("Y-m-d" ,$u->end_time)}}</td>
                            <td>{{date("Y-m-d H:i:s" ,$u->create_time)}}</td>
                            <td>{{!empty($u->update_time) ? date("Y-m-d H:i:s" ,$u->update_time) : ""}}</td>
                            <td>
                                <button class="btn btn-success btn-xs" onclick="exit({{$u}})">修改</button>
                                <button class="btn btn-danger btn-xs" id="delete" data-id="{{$u->id}}">删除</button>
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
    <div class="row" style="margin-top: 30px; display:none;margin-left: 100px; position: absolute;  top: 0; left: 100px; bottom: 0; right: 0;" id="advertiser_movie">
          <div class="col-md-8 col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">接入广告</h3>
                </div>
                <form class="form-horizontal" style="margin-top: 20px;margin-left: 18%;" method="POST" onsubmit="return update();" id="subform">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">广告ID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" style="width: 285px;" id="ad_id" name="id" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">广告名称</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" style="width: 285px;" id="ad_name" name="ad_name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">广告主</label>
                      <div class="col-sm-9">
                          <select class="form-control" style="width: 285px;" id="advertiser_id" name="advertiser_id">
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">结算方式</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="pay_type" name="pay_type" style="display: none;">
                        <label class="radio-inline">
                          <input type="radio" id="inlineRadio1" name="inlineRadi" value="1"> 曝光
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
                        <input type="number" class="form-control" style="width: 285px;" id="into_price" name="into_price">
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
                       <input type="text" class="form-control" style="width: 285px;" id="puton_url" name="puton_url">
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
                       <input type="text" class="form-control" style="width: 285px;" id="owner_apiurl" name="owner_apiurl">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">投放时间</label>
                      <div class="col-sm-9">
                        <div class="input-append date form_datetime" id="form_datetime0">
                          开始时间：
                          <input size="16" type="text"  readonly style="width: 200px;" name="start_time" id="start_time">
                          <span class="add-on"><i class="icon-th"></i></span>
                      </div><br/>
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
                        <button type="submit" class="btn btn-default">修改</button>&nbsp;&nbsp;
                        <a class="btn btn-danger" onclick="closes()">关闭</a>
                      </div>
                    </div>
                  </form>
              </div>
          </div>
</div>
</div>

<script type="text/javascript">
    // $(function(){
    //     getall_zxcq();
    // });
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
    function add0(m){return m<10?'0'+m:m };//时间方法
    $("table #delete").on("click",function () {
        var id = $(this).attr("data-id");
        if(confirm("确定要删除吗？")) {
            $.ajax({
                type: 'get',
                url: "{{ url('/advertising/delete') }}/" + id,
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
        $('#advertiser_movie').css('display','none');
    }
    function exit(datac){
        $('#ad_id').val(datac.id);
        $('#ad_name').val(datac.ad_name);
        $('#pay_type').val(datac.pay_type);
        $('input[name="inlineRadi"]').removeAttr("checked");
        if(datac.pay_type==1){
            $('#inlineRadio1').prop("checked",'true');
        }else if(datac.pay_type==2){
            $('#inlineRadio2').prop("checked",'true');
        }else{
            $('#inlineRadio3').prop("checked",'true');
        }
        if(datac.urlencode==1){
            $('#inlin_urlencode1').prop("checked",'true');
        }else{
            $('#inlin_urlencode2').prop("checked",'true');
        }
        $('#into_price').val(datac.into_price/100);
        $('#puton_url').val(datac.puton_url);
        $('#owner_apiurl').val(datac.owner_apiurl);
        var time0 = new Date(datac.start_time*1000);
        var y0 = time0.getFullYear(); 
        var m0 = time0.getMonth()+1; 
        var d0 = time0.getDate(); 
        var heaven0=y0+'-'+add0(m0)+'-'+add0(d0);
        $('#start_time').val(heaven0);
        var time1 = new Date(datac.end_time*1000);
        var y1 = time1.getFullYear(); 
        var m1 = time1.getMonth()+1; 
        var d1 = time1.getDate();
        var heaven1=y1+'-'+add0(m1)+'-'+add0(d1);
        $('#end_time').val(heaven1);
        $('#remark').val(datac.remark);
        $.ajax({
            url:"{{url('advertising/pulldown')}}",
            type:'get',
            dataType: "json",
            success: function(data){
                var querySelect = document.getElementById("advertiser_id");
                var oOp = querySelect.children;//获取select列表的所有子元素。
                for(var c=0,len = oOp.length;c<len;c++){
                    querySelect.removeChild(oOp[0]);//循环删除所有子元素
                }
                if(data){
                    for(var a in data){
                        if(data[a].id==datac.advertiser_id){
                            querySelect.options.add(new Option(data[a].name, data[a].id));
                        } 
                    }
                    for(var i in data){
                        querySelect.options.add(new Option(data[i].name, data[i].id));
                    }
                }
                $('#advertiser_movie').show();
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

    function update() {
        var ad_name =$("#ad_name").val();
        var into_price =$("#into_price").val();
        var puton_url =$("#puton_url").val();
        var owner_apiurl =$("#owner_apiurl").val();
        if(ad_name!=''&&into_price!=''&&puton_url!=''&&owner_apiurl!=''){
            var data = $("#subform").serializeArray();
            $.ajax({
                url:"{{url('/advertising/update')}}",
                type:'post',
                data:data,
                dataType: "json",
                success: function(msg){
                    // console.log(msg);
                    if(msg.msg==0){
                      alert('任务名称不能为空');
                    }else if(msg.msg==1){
                      alert('任务名称已存在' );
                    }else if(msg.msg==2){
                      alert('任务名称长度超出范围');
                    }else if(msg.msg==3){
                      alert('下载链接/包地址格式错误');
                    }else if(msg.msg==4){
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
            alert('不可为空！');
        }
        return false;
    }
</script>
@include('common.footer')