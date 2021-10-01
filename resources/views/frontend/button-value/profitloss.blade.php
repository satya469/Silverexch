@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
    @include('frontend.game-list.leftSide')
  <!----> 
  

<div class="col-md-10 report-main-content m-t-5">
  <div class="card">
    <div class="card-header">
      <h4 class="mb-0">Profit & Loss</h4>
    </div>
    <div class="card-body container-fluid container-fluid-5">
      <div class="row row5">
        <div style="width:30%;padding: 5px;">
          <div class="form-group mb-0">
              <input name="date" id="sdatepicker" type="text" autocomplete="off" 
                value="{{date('d-m-Y', strtotime('-7 days'))}}" placeholder="Select Date" class="mx-input"> 
          </div>
        </div>
        <div style="width:30%;padding: 5px;">
          <div class="form-group mb-0">
            <input name="date" id="edatepicker" type="text" autocomplete="off" 
                value="{{date('d-m-Y')}}" placeholder="Select Date" class="mx-input">
          </div>
        </div>
          <div style="width:30%;padding: 5px;"><button onclick="getData();" class="btn btn-primary btn-block">Submit</button></div>
      </div>
      <!----> 
      <div class="row row5 mt-2">
        <div class="col-12">
          <div class="table-responsive">
            <table role="table" aria-busy="false" aria-colcount="3" class="table b-table table-striped table-bordered" id="__BVID__70">
              <!----><!---->
              <thead role="rowgroup" class="">
                <!---->
                <tr role="row" class="">
                  <th role="columnheader" scope="col" aria-colindex="1" class="text-center">Event Type</th>
                  <th role="columnheader" scope="col" aria-colindex="2" class="text-center">Event Name</th>
                  <th role="columnheader" scope="col" aria-colindex="3" class="text-right">Amount</th>
                </tr>
              </thead>
              <tbody id="popupData-body">
                
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
 <script type="text/javascript">
  function getData(){
    var sDate = $('#sdatepicker').val();
    var eDate = $('#edatepicker').val();
    $.ajax({
      url: "{{ route('frontend.account.profitlossList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'sDate':sDate,
          'eDate':eDate,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
          showLoading('popupData-body');
      },
      complete:function(){
          hideLoading('popupData-body');
      },
      success: function(response){
        $('#popupData-body').html(response);
      },
    });
  }
  
</script>

@endpush
