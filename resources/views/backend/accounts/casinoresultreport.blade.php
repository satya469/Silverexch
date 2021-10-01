@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">


<div class="col-md-12 main-container">
  <div class="">
    <div class="listing-grid">
      <div class="detail-row">
        <h2>Casino Result Report</h2>
        <div class="row">
          <div class="col-md-2 col-sm-6">
          <div class="datepicker-wrapper form-group">
            <input id="fromdate" class="form-control datepicker"  name="start" type="text" value="{{date('d-m-Y')}}">
          </div>
          </div>
           <div class="col-md-2 col-sm-6">  
          <div class="select-report d-inline-block m-l-20 form-group">
            <select id="sportID" class="form-control" name="sportID">
              @foreach($sportModel as $key=>$data)
              <option value="{{$data->id}}">{{$data->match_name}}</option>
              @endforeach
            </select>
          </div>
          </div>
           <div class="col-md-2 col-sm-4">     
          <div class="d-inline-block m-l-20">
              <button class="btn btn-primary" value="submit" onclick="getData();" type="button">Submit</button>
          </div>
           </div>
        </div>
        <div class="table-responsive">
          <div id="divID" class="dataTables_wrapper no-footer">
            
                
                 
              
          </div>
        </div>
      </div>
    </div>
    <div id="modalresult" class="modal fade show" tabindex="-1">
      <div class="modal-dialog" style="min-width: 650px">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Result Details</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <div class="modal-body nopading" id="result-details" style="min-height: 300px"></div>
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
        $('#fromdate').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
    });
</script>
<script type="text/javascript">
  function getData(){
    var sportID = $('#sportID').val();
    var sDate = $('#fromdate').val();
    $.ajax({
      url: "{{ route('admin.account.casinoresultreportList')}}",
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