@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')
<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
<div class="col-md-10 report-main-content m-t-5">
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0">Casino Result Report</h4>
    </div>
    <div class="card-body container-fluid container-fluid-5">
      <div class="row row5 mt-2">
          <div class="" style="flex: 1 1 25%;float: left;">
              <div class="form-group mb-0" style="padding: 0 13px;">
            <select name="sportID" id="sportID" class="custom-select">
              <option value="" disabled="disabled">Sport Type</option>
              @foreach($sportModel as $key=>$data)
              <option value="{{$data->id}}">{{$data->match_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="" style="flex: 0 0 30%;float: left;">
            <div class="form-group mb-0" style="padding: 0 5px;">
             <input name="sdate" id="sdatepicker" type="text" autocomplete="off" 
                    value="{{date('d-m-Y')}}" placeholder="Select Date" class="mx-input"> 
             
          </div>
        </div>
        
        <div class="" style="flex:1 1 17%;float: left;"><button class="btn btn-primary btn-block" onclick="getData();">Submit</button></div>
      </div>
      <div class="row row5 mt-2"></div>
      <!----> 
      <div class="row row5 mt-2">
        <div class="col-12">
            <div class="table-responsive" id="divID">
            
          </div>
        </div>
      </div>
      <div class="row row5 mt-2">
        <div class="col-12">
          <!---->
        </div>
      </div>
    </div>
  </div>
</div>


</div>


@endsection

@push('after-scripts')
<script type="text/javascript">
    // When the document is ready
    $(document).ready(function () {
        $('#sdatepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
<script type="text/javascript">
  function getData(){
    var sportID = $('#sportID').val();
    var sDate = $('#sdatepicker').val();
    $.ajax({
      url: "{{ route('frontend.account.casinoresultreportList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'sDate':sDate,
          'sportID':sportID,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
          showLoading('divID');
      },
      complete:function(){
          hideLoading('divID');
      },
      success: function(response){
        $('#divID').html(response);
      },
    });
  }
 
</script>

@endpush
