@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')



  <div class="row" style="margin-left: 0px;margin-right: 0px;">
    @include('frontend.game-list.leftSide')  
    <!----> 
    <div class="col-md-10 report-main-content m-t-5">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Account Statement</h4>
        </div>
        <div class="card-body container-fluid container-fluid-5 ">
            <div class="mobileView" style="width: 100%;">
            <div style="width: 50%;float: left;padding: 5px;">
                 <input name="date" type="text" autocomplete="off" 
                        placeholder="Select Date" id="sdatepicker" class="mx-input sdatepicker"> 
            </div> 
            <div style="width: 50%;float: left;padding: 5px;">
                <input name="date" type="text" autocomplete="off" placeholder="Select Date" 
                       id="edatepicker" class=" edatepicker mx-input">
            </div>
            <div style="width: 50%;float: left;padding: 5px;">
                <select id="reportType" name="reportType" class="custom-select">
                    <option value="1">ALL</option>
                  <option value="2">Deposit/Withdraw Report</option>
                  <option value="3">Game Report</option>
                </select>
            </div>
            <div style="width: 50%;float: left;padding: 5px;">
                <button onclick="getData();" class="btn btn-primary btn-block">Submit</button>
            </div>
            <div style="width: 100%;">
                <table role="table" aria-busy="false" aria-colcount="6" class="table b-table table-striped table-bordered" id="tabData">
                  
                  <thead role="rowgroup" class="">
                    
                    <tr role="row" class="">
                      <th role="columnheader" scope="col" aria-colindex="2" class="text-center">Sr no</th>  
                      <th role="columnheader" scope="col" aria-colindex="1" class="text-center">Date</th>
                      <th role="columnheader" scope="col" aria-colindex="3" class="text-right">Credit</th>
                      <th role="columnheader" scope="col" aria-colindex="4" class="text-right">Debit</th>
                      <th role="columnheader" scope="col" aria-colindex="5" class="text-right">Balance</th>
                      <th role="columnheader" scope="col" aria-colindex="6" class="text-center">Remark</th>
                    </tr>
                  </thead>
                  <tbody id="tabBody">
                    
                  </tbody>
                  
                </table>
            </div>  
          </div>  
          <div class="row row5 destopview">
            <div class="col-md-2">
              <div class="form-group mb-0">
                  <input name="date" type="text" autocomplete="off" value="{{date('d-m-Y', strtotime('-7 days'))}}"
                        placeholder="Select Date" id="sdatepicker" class="mx-input sdatepicker"> 
                      
              </div>
                
            </div>
            <div class="col-md-2">
              <div class="form-group mb-0">
                <input name="date" type="text" autocomplete="off" placeholder="Select Date" 
                    value="{{date('d-m-Y')}}"  id="edatepicker" class=" edatepicker mx-input">
              </div>
            </div>
            <div class="col-2">
              <div class="form-group mb-0">
                <select id="reportType" name="reportType" class="custom-select">
                  <option value="1">All</option>
                  <option value="2">Deposit/Withdraw Report</option>
                  <option value="3">Game Report</option>
                </select>
              </div>
            </div>
              <div class="col-1"><button onclick="getData();" class="btn btn-primary btn-block">Submit</button></div>
          </div>
          <!----> 
          <div class="row row5 mt-2 destopview">
            <div class="col-12 account-statement-tbl">
              <div class="table-responsive">
                <table role="table" aria-busy="false" aria-colcount="6" class="table b-table table-striped table-bordered" id="tabData">
                  <!----><!---->
                  <thead role="rowgroup" class="">
                    <!---->
                    <tr role="row" class="">
                      <th role="columnheader" scope="col" aria-colindex="2" class="text-center">Sr no</th>  
                      <th role="columnheader" scope="col" aria-colindex="1" class="text-center">Date</th>
                      <th role="columnheader" scope="col" aria-colindex="3" class="text-right">Credit</th>
                      <th role="columnheader" scope="col" aria-colindex="4" class="text-right">Debit</th>
                      <th role="columnheader" scope="col" aria-colindex="5" class="text-right">Balance</th>
                      <th role="columnheader" scope="col" aria-colindex="6" class="text-center">Remark</th>
                    </tr>
                  </thead>
                  <tbody id="tabBody">
                    
                  </tbody>
                  
                </table>
              </div>
            </div>
            <!---->
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
</div>

<div class="modal fade showBetsData" id="showBetsData">
    <div class="modal-dialog" style="max-width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">MATCHED</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body" id="modal-showBetsData">
          
      </div>
<!--        <div class="modal-footer">
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
        </div>-->
      </form>
    </div>
  </div>
</div>


@endsection

@push('after-scripts')
<script type="text/javascript">
    // When the document is ready
    
    $(document).ready(function () {
        var isMobile = false; //initiate as false
        // device detection
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
            isMobile = true;
            $('.destopview').remove();
        }else{
          $('.mobileView').remove();
        }
      
        $('#sdatepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
        $('#edatepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        }); 
        
//        $('#tabData').DataTable();
    });
</script>
<script>
 function showBetData(ids,matchID,id){
     var isCall = 'userSide';
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
        $('#showBetsData').modal('show');
      },
    });
  }   
 function getData(){
    var reportType = $('#reportType').val();
    var sDate = $('#sdatepicker').val();
    var eDate = $('#edatepicker').val();
    if(sDate == '' || eDate == ''){
      return false;
    }
    $.ajax({
      url: "{{ route('frontend.account.accountstatementList')}}",
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
