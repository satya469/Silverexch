@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')


<div class="row" style="margin-left: 0px;margin-right: 0px;">
 

<div class="col-md-12 main-container">
  <div>
    <div class="listing-grid">
      <div class="detail-row">
        <h2>Casino Report</h2>
        <div class="m-t-20">
          <div class="col-md-12">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="fromdate">From</label>
                    <input type="text" id="fromdate" name="fromdate" class="form-control datepicker" value="2020-09-28" readonly="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="todate">To</label>
                    <input type="text" name="todate" id="todate" class="form-control datepicker" value="2020-10-05" readonly="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="type">Game Type</label>
                    <select name="type" class="form-control" id="type">
                      <option value="slot">Slot Game</option>
                      <option value="live">Live Casino</option>
                      <option value="live1">Live Casino 1</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <input type="hidden" name="_token" value="xYhYmY53OMXh7dlO4f1Xg1l6cRCt9oYIEyYJkNs6">
                  <label>&nbsp;</label><br>
                  <input type="submit" value="Submit" class="btn btn-diamond">
                </div>
              </div>
          </div>
        </div>
        <div class="table-responsive data-table" style="overflow: hidden">
          <div id="example123" class="dataTables_wrapper no-footer">
            <table id="example" class="custom-table table table-striped datatable dataTable no-footer" style="width: 100%;">
              <thead>
                <tr>
                  <th>User Name</th>
                  <th>Casino Type</th>
                  <th>Game Name</th>
                  <th>Transaction Id</th>
                  <th>Transaction Type</th>
                  <th>Game Id</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>User Name</td>
                  <td>Casino Type</td>
                  <td>Game Name</td>
                  <td>Transaction Id</td>
                  <td>Transaction Type</td>
                  <td>Game Id</td>
                  <td>Amount</td>
                  <td>Date</td>
                </tr>
                <tr>
                  <td>User Name</td>
                  <td>Casino Type</td>
                  <td>Game Name</td>
                  <td>Transaction Id</td>
                  <td>Transaction Type</td>
                  <td>Game Id</td>
                  <td>Amount</td>
                  <td>Date</td>
                </tr>
                <tr>
                  <td>User Name</td>
                  <td>Casino Type</td>
                  <td>Game Name</td>
                  <td>Transaction Id</td>
                  <td>Transaction Type</td>
                  <td>Game Id</td>
                  <td>Amount</td>
                  <td>Date123</td>
                </tr>
              </tbody>
            </table>
          </div>
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
        inputs.prop("disabled", false);
    });
  }
</script>

@endpush
