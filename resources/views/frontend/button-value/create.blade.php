@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 featured-box">
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0">Change Button Values</h4>
      </div>
      <div class="card-body container-fluid container-fluid-5 button-value">
          <div class="row"><div class="col-12" id="msg"></div></div>
        <div class="row row5 mb-1">
          <div class="col-3">
            <div class="button-title"><span><b>Price Label</b></span></div>
          </div>
          <div class="col-3">
            <div class="button-title"><span><b>Price Value</b></span></div>
          </div>
        </div>
          <form method="post" id="btnfrm">
              @csrf
          <div class="row row5 mb-1">
            <div class="col-3">
                <div class="form-group mb-0"><input value="{{$setting['label'][0]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][0]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][1]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][1]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][2]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][2]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][3]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][3]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][4]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][4]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][5]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][5]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][6]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][6]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][7]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][7]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][8]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][8]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mb-1">
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['label'][9]}}" name="btnSetting[label][]" placeholder="Button Name" type="text" maxlength="7" class="form-control"></div>
            </div>
            <div class="col-3">
              <div class="form-group mb-0"><input value="{{$setting['price'][9]}}" name="btnSetting[price][]" placeholder="Button Value" type="number" min="1" max="99999999" maxlength="9" class="form-control"></div>
            </div>
          </div>
          <div class="row row5 mt-2">
              <div class="col-12"><a href="javascript:void(0);" class="btn btn-primary" onclick="saveValue();">Update</a></div>
          </div>
        </form>  
      </div>
    </div>


  </div>
</div>


@endsection

@push('after-scripts')
<script>
  function saveValue(){
    
    var data = $("#btnfrm").serialize();
    var inputs = $("#btnfrm").find("input, select, button, textarea");
    inputs.prop("disabled", true);

    request = $.ajax({
        url: "{{route('frontend.btnvaluestore')}}",
        type: "post",
        dataType: "JSON",
        data: data
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
      var html = '';
      if(response.status == true){
        html += '<div class="alert alert-success">'+response.message+'</div>';
//        inputs.val('');
      }else{
        html += '<div class="alert alert-danger">'+response.message+'</div>';
      }
      $("#msg").html(html);
    });
  request.always(function () {
      // Reenable the inputs
      inputs.prop("disabled", false);
  });
  }
</script>

@endpush
