<?php 
use App\Http\Controllers\Backend\ListClientController;
if(strtoupper($depositeUser->roles->first()->name) == 'USER'){
  $tot = ListClientController::getUserAvalableBalance($depositeUser->id);
}else{
  $tot = ListClientController::getUserAvalableBalanceADMIN($depositeUser->id);
}
$totLogin = $mainCal['AvailableBalance'];
?>

<style>
    .modal-content textarea,
    .modal-content input{
      border: 1px solid #ced4da !important;
    }
</style>

<div class="row" id="frmdeposite">
    <div class="col-sm-12">
        <table class="table">
            <tr>
                <th>
                    {{$loginUser->first_name}}
                </th>
                <td>
                    <input class="form-control" type="number" id="oldLoginAmount" name="oldLoginAmount" 
                           value="{{$totLogin}}" readonly="readonly">
                </td>
                <td>
                    <input class="form-control" type="number" id="newLoginAmount" name="newLoginAmount" 
                           value="" readonly="readonly">
                </td>
            </tr>
            <tr>
                <th>
                    {{$depositeUser->first_name}}
                </th>
                <td>
                    <input class="form-control" type="number" id="olddepositeAmount" name="olddepositeAmount" 
                           readonly="readonly" value="{{$tot}}">
                </td>
                <td>
                    <input class="form-control" type="number" id="newdepositeAmount" name="newdepositeAmount" 
                           readonly="readonly" value="">
                </td>
            </tr>
            <tr>
                <th>Amount</th>
                <td colspan="2">
                    <input class="form-control numberOnly" type="number" onkeyup="withdrawCal(this);" id="amount" name="amount" 
                           value="">
                </td>
            </tr>
            <tr>
                <th>Remark</th>
                <td colspan="2">
                    <textarea class="form-control" id="note" name="note"></textarea>
                </td>
            </tr>
            <tr>
                <th>Master Password</th>
                <td colspan="2">
                    <input class="form-control" type="password" id="m_pwd" name="m_pwd" 
                           value="">
                    <input type="hidden" id="balanceType" name="balanceType" value="WITHDRAWAL">
                    <input type="hidden" id="uuidwid" name="deposite_user_id" value="{{$depositeUser->uuid}}">
                    <input type="hidden" id="withdrawal_user_id" value="{{$depositeUser->id}}">
                    <input type="hidden" id="deposite_user_id" value="{{$loginUser->id}}">
                </td>
            </tr>
        </table>
    </div> 
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('.numberOnly').keypress(function(event) {
        if ((event.which != 46 ) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
    });
});
</script>
