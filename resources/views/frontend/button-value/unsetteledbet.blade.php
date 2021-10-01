@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
  
  @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 report-main-content m-t-5">
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0">Un-Setteled Bet</h4>
      </div>
      <div class="card-body container-fluid container-fluid-5 unsetteledbet">
        <div class="row row5">
          <div class="col-12">
            <div id="match_unmatched_delete" role="radiogroup" tabindex="-1">
                <div class="custom-control custom-control-inline custom-radio"><input onclick="getData(this.value);" id="matched" type="radio" name="match_unmatched_delete" autocomplete="off" value="1" class="custom-control-input"> <label for="matched" class="custom-control-label"><span>Matched</span></label></div>
              <div class="custom-control custom-control-inline custom-radio"><input onclick="getData(this.value);" id="unmatched" type="radio" name="match_unmatched_delete" autocomplete="off" value="2" class="custom-control-input"> <label for="unmatched" class="custom-control-label"><span>Un-Matched</span></label></div>
              <div class="custom-control custom-control-inline custom-radio"><input onclick="getData(this.value);" id="deleteed" type="radio" name="match_unmatched_delete" autocomplete="off" value="3" class="custom-control-input"> <label for="deleteed" class="custom-control-label"><span>Deleted</span></label></div>
            </div>
          </div>
        </div>
        <!----> 
        <div class="row row5 mt-2">
          <div class="col-12">
            <div class="table-responsive">
              <table role="table" aria-busy="false" aria-colcount="10" class="table b-table table-bordered" id="__BVID__58">
                <!----><!---->
                <thead role="rowgroup" class="">
                  <!---->
                  <tr role="row" class="">
                    <th role="columnheader" scope="col" aria-colindex="1" class="text-right">No</th>
                    <th role="columnheader" scope="col" aria-colindex="2" class="text-center">Event Name</th>
                    <th role="columnheader" scope="col" aria-colindex="3" class="text-center">Nation</th>
                    <th role="columnheader" scope="col" aria-colindex="4" class="text-center">Event Type</th>
                    <th role="columnheader" scope="col" aria-colindex="5" class="text-center">Market Name</th>
                    <th role="columnheader" scope="col" aria-colindex="6" class="text-center">Side</th>
                    <th role="columnheader" scope="col" aria-colindex="7" class="text-center">Rate</th>
                    <th role="columnheader" scope="col" aria-colindex="8" class="text-right">Amount</th>
                    <th role="columnheader" scope="col" aria-colindex="9" class="text-center">Place Date</th>
                  </tr>
                </thead>
                <tbody id="tabBody">
                  @include('frontend.button-value.unserreldbet-row')
                </tbody>
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


<script>
  function getData(reportType){
    var eDate = $('#edatepicker').val();
    $.ajax({
      url: "{{ route('frontend.account.unsetteledbetList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'reportType':reportType,
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
