@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')


<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="listing-grid">
        <div class="detail-row">
          <h2>General Report</h2>
          <div class="m-t-20">
            <div class="col-md-12">
              
                <div class="row">
                  <div class="col-md-2 col-sm-8">
                    <div class="form-group">
                      <label for="password">Select Type</label>
                      <select id="generaltype" class="form-control" name="generaltype">
                        <option value="1">General Report</option>
                        <option value="2">Credit Refrance Report</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4">
                    <label>&nbsp;</label><br>
                    <button type="button" onclick="getData();" class="btn btn-diamond">Load</button>
                  </div>
                </div>
              
            </div>
          </div>
        </div>
          <table id="table-data" class="table table-striped table-bordered datatable dataTable no-footer" style="width:100%">
            <thead>
              <tr>
                <th style="">Sr. No</th>
                <th style="">Name</th>
                <th style="">Amount</th>
                
              </tr>
            </thead>
            <tbody id="tabBody">
              @include('backend.accounts.general-report-row')
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th  style="text-align:left">Total:</th>
                    <th id="total"></th>
                </tr>
            </tfoot>
          </table>
      </div>
    </div>
  </div>
</div>

@endsection

@push('after-scripts')
<script type="text/javascript">
  
  $(document).ready(function() {
      var table = $('#table-data').DataTable( {
            "pageLength": 500,
            "order": false,
            orderCellsTop: false,
            dom: 'Brtip',
            buttons: [
               
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
              $("td:first", nRow).html(iDisplayIndex +1);
              var api = this.api(), data;
 
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
 
              // Total over all pages
                total = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total over this page
                pageTotal = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 2 ).footer() ).html(
                    pageTotal
                );
              return nRow;
            },
      });
      
      
  } );
  
  function getData(){
    var type = $('#generaltype').val();
    $.ajax({
      url: "{{ route('admin.account.generalreport')}}",
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
</script>
@endpush
