@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')

 
<div class="row" style="margin-left: 0px;margin-right: 0px;">
 
  <div class="col-md-12 main-container">
    <div>
      <div class="listing-grid">
        <div class="detail-row">
          <h2>Profit & Loss</h2>
          <div class="m-t-20 row">
            <div class="col-md-12 col-md-12">
              
                <div class="row">
                  <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                      <label for="list">Search By Client Name</label>
                      <select id="list" name="list" class="form-control">
                          <option value="">Select Client</option>
                          @foreach($userModel as $key=>$val)
                          <option value="{{$val->id}}">{{$val->first_name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                      <label for="fromdate">From</label>
                      <input id="fromdate" class="form-control datepicker"  
                             name="fromdate" type="text" value="{{date('d-m-Y', strtotime('-7 days'))}}">
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                      <label for="todate1">To</label>
                      <input id="todate" class="form-control" name="todate" 
                             type="text" value="{{date('d-m-Y')}}">
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6">
                    <label>&nbsp;</label><br>
                    <button class="btn btn-diamond" onclick="getData();" type="button">Load</button>
                  </div>
                </div>
              
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="form-group" id="profitLossStats"></div>
            </div>
            <div class="col-md-12">
              <table class="table table-striped table-bordered" id="popupData">
                <thead>
                  <tr>
                    <th>Game Name</th>
                    <th>Game Type</th>
                    <th>Profit & Loss</th>
                  </tr>
                </thead>
                <tbody id="popupData-body">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="table-responsive data-table" style="overflow: hidden" id="tbldata"></div>
      </div>
    </div>
    <div class="modal fade" id="modal-profitloss-data" style="width: 100%;">
      <div class="modal-dialog" style="min-width: 70%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <div class="modal-body">
            <table class="table table-striped table-bordered" id="popupData">
              <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Game Name</th>
                  <th>Game Type</th>
                  <th>Profit & Loss</th>
                </tr>
              </thead>
              <tbody id="popupData-body">
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
    
  </div>

</div>


@endsection

@push('after-scripts')
<script type="text/javascript">
    $(document).ready(function (){
      $('#example').DataTable();
        $('#fromdate').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
        $('#todate').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
    });
</script>
@push('after-scripts')
<script type="text/javascript">
  function getData(){
    var sDate = $('#fromdate').val();
    var eDate = $('#todate').val();
    var user = $('#list').val();
    $.ajax({
      url: "{{ route('admin.account.profitlossList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'sDate':sDate,
          'eDate':eDate,
          'user':user,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
          showLoading('popupData');
      },
      complete:function(){
          hideLoading('popupData');
      },
      success: function(response){
        $('#popupData-body').html(response);
      },
    });
  }
  
</script>

@endpush
<script>
  $(document).ready(function(){
    $('#list').select2();
  });
 
</script>

@endpush
