@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
  

<div class="col-md-10 report-main-content m-t-5">
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0">Bet History</h4>
    </div>
    <div class="card-body container-fluid container-fluid-5">
      <div class="row row5 mt-2">
        <div style="width:30%;padding: 5px;">
          <div class="form-group mb-0">
            <select name="reportType" id="reportType" class="custom-select">
              <option value="" disabled="disabled">Sport Type</option>
              <option value="SOCCER">Football</option>
              <option value="TENNIS">Tennis</option>
              <option value="CRICKET">Cricket</option>
            </select>
          </div>
        </div>
        <div style="width:30%;padding: 5px;">
          <div class="form-group mb-0">
            <select name="reportType" class="custom-select">
              <option value="" disabled="disabled">Bet Status</option>
              <option value="1">Matched</option>
              
            </select>
          </div>
        </div>
        <div style="width:30%;padding: 5px;">
          <div class="form-group mb-0">
             <input name="sdate" id="sdatepicker" type="text" autocomplete="off" 
                value="{{date('d-m-Y', strtotime('-7 days'))}}"    placeholder="Select Date" class="mx-input"> 
          </div>
        </div>
        <div style="width:30%;padding: 5px;">
          <div class="form-group mb-0">
            <input name="edate" id="edatepicker" type="text" autocomplete="off" 
                value="{{date('d-m-Y')}}"   placeholder="Select Date" class="mx-input"> 
          </div>
        </div>
          <div style="width:30%;padding: 5px;"><button class="btn btn-primary btn-block" onclick="getData();">Submit</button></div>
      </div>
      <div class="row row5 mt-2"></div>
      <!----> 
      <div class="row row5 mt-2">
        <div class="col-12">
          <div class="table-responsive">
            <table role="table" aria-busy="false" aria-colcount="8" class="table b-table table-bordered" id="tabData">
              <!----><!---->
              <thead role="rowgroup" class="">
                <tr role="row" class="">
                  <th role="columnheader" scope="col" aria-colindex="1" class="text-center">Event Name</th>
                  <th role="columnheader" scope="col" aria-colindex="2" class="text-center">Nation</th>
                  <th role="columnheader" scope="col" aria-colindex="3" class="text-center">Bet Type</th>
                  <th role="columnheader" scope="col" aria-colindex="4" class="text-center">User Rate</th>
                  <th role="columnheader" scope="col" aria-colindex="5" class="text-right">Amount</th>
                  <th role="columnheader" scope="col" aria-colindex="6" class="text-right">Profit/Loss</th>
                  <th role="columnheader" scope="col" aria-colindex="7" class="text-center">Place Date</th>
                </tr>
              </thead>
              <tbody id="tabBody">
                
              </tbody>
              <!---->
            </table>
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
        $('#edatepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
<script>
  function getData(){
    var reportType = $('#reportType').val();
    var sDate = $('#sdatepicker').val();
    var eDate = $('#edatepicker').val();
    $.ajax({
      url: "{{ route('frontend.account.bethistoryList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'reportType':reportType,
          'sDate':sDate,
          'eDate':eDate,
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
