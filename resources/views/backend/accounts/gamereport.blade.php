@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')



  <div class="row" style="margin-left: 0px;margin-right: 0px;">
    

<div class="col-md-12 main-container">
  <div>
    <div class="listing-grid">
        <div class="detail-row">
        <h2>Game Report</h2>
        <div class="m-t-20">
          <div class="col-md-12">
            <form id="gamereport" action="" method="post">
              <div class="row">
                <div class="col-md-2 col-sm-6">
                  <div class="form-group">
                    <label for="fromdate">From</label>
                    <input id="fromdate" class="form-control datepicker"  
                           name="fromdate" type="text" value="{{date('d-m-Y', strtotime('-7 days'))}}">
                  </div>
                </div>
                <div class="col-md-2 col-sm-6">
                  <div class="form-group">
                    <label for="todate">To</label>
                    <input id="todate" class="form-control datepicker"  
                           name="todate" type="text" value="{{date('d-m-Y')}}">
                  </div>
                </div>
                <div class="col-md-2 col-sm-6">
                  <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" class="form-control" name="type">
                      <option value="ALL">All</option>
                      <option value="MATCH">Match</option>
                      <option value="FANCY">Fancy</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6">
                  <label>&nbsp;</label><br>
                  <a style="color: #FFFFFF;" class="btn btn-diamond" onclick="changeGame();">Game List</a>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <select name="gameview" id="gameview" class="form-control">
                      <!--<option value="all">All</option>-->
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <button type="button" class="btn btn-diamond" onclick="getData('GAME-REPORT');" style="margin-right: 5px;">Show Game Report</button>
                  <button type="button" class="btn btn-diamond" onclick="getData('MASTER-REPORT');">Master Game Report</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
        <div id="addloader" class="table-responsive data-table" style="overflow: hidden">
          <div class="row">    
            <div class="col-md-6">  
              <table id="subDataTbl" class="table table-bordered table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="subDataTbl-body">
                   <tr>
                       <th colspan="3">No Record Avalible </th>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table id="plusDataTbl" class="table table-bordered table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="plusDataTbl-body">
                  <tr>
                       <th colspan="3">No Record Avalible </th>
                  </tr>
                </tbody>
              </table>    
            </div>
          </div>
      </div>
    </div>
  </div>
  <script>
    function changeGame() {
      showLoading('addloader');
      var fromdate = $('#fromdate').val();
      var type = $('#type').val();
      var todate = $('#todate').val();
      $.ajax({
          url:"{{route('admin.account.getgameandfancylist')}}",
          method:'POST',
          data:{'type':type,'fromdate':fromdate,'todate':todate,'_token':"{{ csrf_token() }}"},
          success:function(data){
            
             $('#gameview').html(data);
          },
          complete: function(){
              hideLoading('addloader');
          } 
      });
    }
    
    function getData(gtype){
        
        showLoading('addloader');
        var gameview = $("#gameview").val();
        var type = gtype;
        $.ajax({
            type: "POST",
            dataType: 'json',
            url:"{{route('admin.account.getgamereportList')}}",
            data: {
                "gameview":gameview,
                "type": type,
                '_token':"{{ csrf_token() }}"
            },
            success: function ( response ) {
              $("#plusDataTbl-body").html(response.plus);
              $("#subDataTbl-body").html(response.sub);
            },
            complete: function(){
                hideLoading('addloader');
            }   
        });
        return false;
    }
  </script>
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
  // Callback handler that will be called regardless
  // if the request failed or succeeded
  request.always(function () {
      // Reenable the inputs
      inputs.prop("disabled", false);
  });
  }
</script>

@endpush
