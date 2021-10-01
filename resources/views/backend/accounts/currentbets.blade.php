@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')
<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="listing-grid">
        <div class="detail-row">
          <h2>Current Bets</h2>
          <div class="m-t-20">
            <div class="col-md-12">
              
                <div class="row">
                  <div class="col-md-2 col-sm-8">
                    <div class="form-group">
                      <label for="s_type">Choose Type</label>
                      <select id="s_type" class="form-control" name="s_type">
                        <option value="matched">Matched</option>
                        <option value="unmatched">UnMatched</option>
                        <option value="deleted">Deleted</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-4">
                    <label>&nbsp;</label><br>
                    <input type="hidden" name="_token" value="xYhYmY53OMXh7dlO4f1Xg1l6cRCt9oYIEyYJkNs6">
                    <button type="button" onclick="getData();" class="btn btn-diamond">Load</button>
                  </div>
                </div>
              
            </div>
          </div>
        </div>
        <div class="table-responsive data-table">
            <table id="table-data" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Event Type</th>
                        <th>Event Name</th>
                        <th>User Name</th>
                        <th>Runner Name</th>
                        <th>Bet Type</th>
                        <th>User Rate</th>
                        <th>Amount</th>
                        <th>Place Date</th>
                    </tr>
                </thead>
                <tbody id="tabBody">
                     @include('backend.accounts.currentBel-row')
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@push('after-scripts')
<script type="text/javascript">
  function getData(){
    var type = $('#s_type').val();
    $.ajax({
      url: "{{ route('admin.account.currentbetsList')}}",
      type: "post",
      dataType: 'text',
      data: {
          'type':type,
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
  $(document).ready(function() {
      var table = $('#table-data').DataTable( {
            "pageLength": 50,
            "order": [],
            orderCellsTop: true,
            dom: 'Bfrtip',
            buttons: [
               
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
               return nRow;
            },
      });
      
      
  } );
</script>

@endpush

