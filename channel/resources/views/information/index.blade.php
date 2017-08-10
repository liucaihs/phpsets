@include('common.header')
@include('common.menu')
<!--右边内容-->
<div class="col-md-10 col-sm-9 col-xs-9"  data-nav="collapseOne">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="panel panel-success">
                          <div class="panel-heading">
                            <h3 class="panel-title">基本信息</h3>
                          </div>
                          <form class="form-horizontal" style="margin-top: 20px;margin-left: 25%;">
                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">媒体名称</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" style="width: 285px;" value="{{$row->name}}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">所属平台</label>
                                <div class="col-sm-9">
                                 <input type="text" class="form-control" style="width: 285px;" value="{{$row->platform}}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">行业</label>
                                <div class="col-sm-9">
                                 <input type="text" class="form-control" style="width: 285px;" value="{{$row->channel_type}}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">联系人</label>
                                <div class="col-sm-9">
                                 <input type="text" class="form-control" style="width: 285px;" value="{{$row->contacts}}">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">联系方式</label>
                                <div class="col-sm-9">
                                 <input type="number" class="form-control" style="width: 285px;" value="{{$row->phone}}">
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

</script> 
@include('common.footer')