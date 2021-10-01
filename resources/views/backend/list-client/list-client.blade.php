@extends('backend.layouts.appClient')

@section('title', app_name())

@section('content')
<style>
    .second th{
        border: 1px solid #dadada;
    }
</style>

<div class="row">
  <div class="col-md-12 main-container">
    <div class="listing-grid">
      <div class="detail-row">
        <h2 class="d-inline-block">Account List</h2>
        <div class="float-right m-b-10">
          <p class="text-right">
           @if($isParent == true)   
            <a href="{{ route('admin.add-account') }}" class="btn btn-diamond">Add Account </a>
            @endif
          </p>
        </div>
      </div>
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <!--<div class="dt-buttons"> <button class="dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="clientListTable" type="button"><span>PDF</span></button> <button class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="clientListTable" type="button"><span>Excel</span></button> </div>-->
          <table id="clientListTable" class="table table-striped table-bordered dataTable no-footer" style="width:100%" role="grid" aria-describedby="clientListTable_info">
            <thead>
              <tr role="row">
                <th>User Name</th>
                <th>Credit Referance</th>
                <th>Balance</th>
                <th>Client (P/L)</th>
                <th>Exposure</th>
                <th>Available Balance</th>
                <th>U St</th>
                <th>B St</th>
                <th>Exposure Limit</th>
                <th>Default %</th>
                <th>Account Type</th>
                <th>Casino Total</th>
                <th style="min-width:210px;">Actions</th>
              </tr>
              <tr class="second">
                <th></th>
                <th class="text-right" id="crTotal"></th>
                <th class="text-right" id='balTotal'></th>
                <th class="text-right" id='CPLTotal'></th>
                <th class="text-right" id='EXTotal'></th>
                <th class="text-right" id='ABTotal'></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                
              </tr>
            </thead>
            @foreach($clients as $client)
              <tr id="ROW_{{$client->uuid}}">
              @include('backend.list-client.list-client-row')
              </tr>
            @endforeach
              
              
            </tbody>
          </table>
         </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-deposit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Deposit : <span id="depName"></span></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <form id="DepositForm" method="post" autocomplete="off" onsubmit="return false">
            <div class="modal-body" id="modal-deposit-body">
             
            </div>
            <div class="modal-footer">
              <div id="showLoaderDep"> </div>  
              <input type="hidden" name="uid" id="uid">
              <!--<button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>-->
              <button type="submit" id="dep-submit" onclick="saveDeposite(this);" class="btnclick btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-withdraw">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Withdrawal : <span id="widName"></span></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <form action="" id="WithdrawForm" method="post" autocomplete="off" onsubmit="return false">
            <div class="modal-body" id="modal-withdraw-body">
            </div>
            <div class="modal-footer">
              <span class="massageWid"> </span>  
              <!--<button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>-->
              <button type="submit" onclick="saveWithdraw(this);" class="btnclick btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-exposure-limit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Exposure Limit : <span id="expName"></span></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <form action="" id="LimitForm" method="post" autocomplete="off" onsubmit="return false">
            <div class="modal-body" id="modal-exposure-limit-body">
            
            </div>
            <div class="modal-footer">
              <span id="message"> </span>
              <input type="hidden" name="uid" id="limit-uid">
              <!--<button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>-->
              <button type="submit" onClick="saveExposureLimit(this);" class="btnclick btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-credit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Credit : <span id="creditName"></span></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <form action="" id="CreditForm" method="post" autocomplete="off" onsubmit="return false">
            <div class="modal-body" id="modal-credit-body">
                
            </div>
            <div class="modal-footer">
              <span id="message"> </span>
              <input type="hidden" id="credit-uid">
              <!--<button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>-->
              <button type="submit" onclick="saveUserToCredit(this);" class="btnclick btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-password">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Password : <span id="passuser"></span></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          
            <form action="" id="PasswordForm" method="post" autocomplete="off" onsubmit="return false">
                <div class="modal-body">
              <div class="container-fluid">
                <div class="row m-b-20">
                  <div class="col-md-4">
                    <label>New Password</label>
                  </div>
                  <div class="col-md-8">
                    <input type="Password" class="text-right" id="new-password" required="" maxlength="20">
                  </div>
                </div>
                <div class="row m-b-20">
                  <div class="col-md-4">
                    <label>Confirm Password</label>
                  </div>
                  <div class="col-md-8">
                    <input type="Password" class="text-right" id="confirm-password" required="" maxlength="20">
                  </div>
                </div>
                <div class="row m-b-20">
                  <div class="col-md-4">
                    <label>Master Password</label>
                  </div>
                  <div class="col-md-8">
                    <input type="Password"  id="m_pwd"  maxlength="20">
                  </div>
                </div>
              
            
            </div>
          </div>
          <div class="modal-footer">
            <span id="message"> </span>  
            <input type="hidden" id="password-uid">
            <!--<button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>-->
            <button type="submit" onclick="ChangePassword(this);" class="btnclick btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
          </div>
                </form>
        </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-status">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Change Status : <span id="statusName"></span></h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <form action="" id="PasswordForm" method="post" autocomplete="off" onsubmit="return false">
                <div class="modal-body" id='userStatusHtml'>  
          
          </div>      
          <div class="modal-footer">
              <span id="message"> </span>
            <input type="hidden" id="status-uid">
            <!--<button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>-->
            <button type="submit" onclick="saveUserStatus(this);" class="btnclick btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
          </div>
              </form>
        </div>
      </div>
    </div>
    <div class="modal modalHideClass fade" id="modal-casinogame">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Casino Game Details</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
            <div class="modal-body" id="casino-game-details">
              
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection


@push('after-scripts')
<!--@include('backend.reloadJS')-->
@include('backend.list-client.allJS')

<script>

</script>
<script type="text/javascript">

  $(document).ready(function() {
    
      var table = $('#clientListTable').DataTable( {
            "pageLength": 50,
            aaSorting: [[0, 'asc']],
            orderCellsTop: true,
            dom: 'Bfrtip',
            buttons: [
//                {
//                    extend: 'pdfHtml5',
//                    title: 'Client List Report',
//                    exportOptions: {
//                        columns: "thead th:not(.noExport)"
//                    }
//                },
//                {
//                    extend: 'excel',
//                    title: 'Client List Report',
//                    exportOptions: {
//                        columns: "thead th:not(.noExport)"
//                    }
//                }
            ],
          "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            crTotal = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            balTotal = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            CPLTotal = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            EXTotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            ABTotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $('#crTotal').text(crTotal.toFixed(2));
            $('#balTotal').text(balTotal.toFixed(2));
            $('#CPLTotal').text(CPLTotal.toFixed(2));
            $('#EXTotal').text(EXTotal.toFixed(2));
            $('#ABTotal').text(ABTotal.toFixed(2));
        }  
      });
       var indexes = table.rows().eq( 0 ).filter( function (rowIdx) {    //check column 0 of each row for tradeMsg.message.coin
          return table.cell( rowIdx, 0 ).data() === 'Ashton Cox' ? true : false;
        } );

        // grab the data from the row
        var data = table.row(indexes).data();

        // populate the .second header with the data
//        for (var i = 0; i< data.length; i++) {
//          $('.second').find('th').eq(i).html( data[i] );
//        }

        // remove the row from the table
        table.row(indexes).remove().draw(false);
      
  } );
</script>

@endpush
