@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
   

<div class="col-md-12 main-container">
  <div>
    <div class="listing-grid">
      <div class="detail-row">
        <h2>Account Statement</h2>
        
          <div class="m-t-20">
            <div class="row">
              <div class="col-md-2 col-sm-6">
                <div class="form-group">
                  <label for="type">Account Type</label>
                  <select onchange="getDameDetails(this.value);" name="type" id="accounttype" class="form-control">
                    <option value="1">All</option>
                    <option value="2">Balance Report</option>
                    <option value="3">Game Report</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                <div class="form-group">
                  <label for="gamename">Game Name</label>
                  <select name="gamename" id="gamename" class=" select2 form-control">
                       <!-- <option value="UPPER">Upper</option>
                        <option value="DOWN">Down</option>-->
                        <option value="ALL">All</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                <div class="form-group">
                  <label for="list-ac">Search By Client Name</label>
                    <select id="list-ac" name="list" class="select2 form-control">
                      <!--<option value="ALL">All</option>-->  
                      @foreach($userModel as $key=>$data)
                        <option value="{{$data->id}}">{{$data->first_name}}</option>
                      @endforeach
                    </select>
                  
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                <div class="form-group">
                  <label for="fromdate">From</label>
                  <input id="fromdate" class="form-control datepicker" 
                         readonly="" name="fromdate" type="text" 
                         value="{{date('d-m-Y', strtotime('-7 days'))}}">
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                <div class="form-group">
                  <label for="todate">To</label>
                  <input id="todate" class="form-control datepicker" 
                         readonly="" name="todate" type="text" 
                         value="{{date('d-m-Y')}}">
                </div>
              </div>
              <div class="col-md-2 col-sm-6">
                
                <label style="width: 100%">&nbsp;</label>
                <button type="button" onclick="getData();" class="btn btn-diamond" id="loaddata">Load</button>
              </div>
            </div>
          </div>
        
      </div>
      <div class="table-responsive data-table" id="tbldata">
        <div id="example_wrapper" class="">
           <table id="example" class="table table-bordered" style="width:100%" role="grid" aria-describedby="example_info">
            <thead>
              <tr>
                <th>Date</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>closing</th>
                <th>Description</th>
                <th>Fromto</th>
              </tr>
            </thead>
            <tbody id="tabBody">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ReportMatchbetModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="ReportMatchbetHeading">Client Ledger</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="">
                <form>
                  <input type="hidden" value="" id="marketidgamereport">
                  <div class="account-radio">
                    <input type="radio" value="all" name="cnt-lgr" id="cnt-lgr1" class="clientledger" checked=""><label for="cnt-lgr1">All</label>
                    <input type="radio" value="matched" name="cnt-lgr" id="cnt-lgr2" class="clientledger"><label for="cnt-lgr2">Matched</label>
                    <input type="radio" value="deleted" name="cnt-lgr" id="cnt-lgr3" class="clientledger"><label for="cnt-lgr3">Deleted</label>
                  </div>
                </form>
              </div>
              <table id="ReportMatchbettable" class="table table-bordered" cellspacing="0" cellpadding="0" border="0"></table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>


  <!--</div>-->
</div>
<div class="modal fade showBetsData" id="showBetsData">
    <div class="modal-dialog" style="max-width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Client Ledger : (Total Win Loss : <span id="winlosspop"></span>)(Total Count : <span id="totCountpop">1</span>)(Total Soda : <span id="sodapop"></span>)</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body" id="modal-showBetsData">
          
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection

@push('after-scripts')
<script type="text/javascript">
    $(document).ready(function (){
//      $('#example').DataTable();
        $('#fromdate').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
        $('#todate').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
    });
</script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
<script>
    function showBetData(ids,matchID,id){
        jQuery.noConflict();
     var isCall = '';
    $.ajax({
      url: "{{ route('admin.account.getbetList')}}",
      type: "post",
      dataType: 'json',
      data: {
          'matchID':matchID,
          'user_id': ids,
          'id':id,
          'isCallSide':isCall,
          '_token': "{{ csrf_token() }}",
      },
      
      success: function(response){
        $('#modal-showBetsData').html(response.html);
        $('#sodapop').text(response.count);
        $('#winlosspop').text(response.tot);
        $('#showBetsData').modal('show');
      },
    });
  }  
  function getDameDetails(txtVal){
    $.ajax({
      url: "{{ route('admin.account.getGameDropdownList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'accounttype':txtVal,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
          showLoading('gamename');
      },
      complete:function(){
          hideLoading('gamename');
      },
      success: function(response){
        $('#gamename').html(response);
      },
    });
  }
  
  function getData(){
    var reportType = $('#accounttype').val();
    var gameID = $('#gamename').val();
    var sDate = $('#fromdate').val();
    var eDate = $('#todate').val();
    var userID = $('#list-ac').val();
//    if(sDate == '' || eDate == ''){
//      return false;
//    }
    $.ajax({
      url: "{{ route('admin.account.accountstatementList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'reportType':reportType,
          'sDate':sDate,
          'eDate':eDate,
          'gameID':gameID,
          'user_id': userID,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
          showLoading('tabBody');
      },
      complete:function(){
          hideLoading('tabBody');
      },
      success: function(response){
        $('#tabBody').html(response);
      },
    });
  }
</script>

@endpush
