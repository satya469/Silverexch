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
                <th>Old Limit</th>
                <td>
                    <input class="form-control" type="number" id="oldlimitAmount" name="oldlimitAmount" 
                           readonly="readonly" value="{{$depositeUser->exposelimit}}">
                </td>
            </tr>
            <tr>
                <th>New Limit</th>
                <td>
                    <input class="form-control numberOnly" type="number"  id="newlimitAmount" name="newlimitAmount" 
                           value="">
                </td>
            </tr>
            
            <tr>
                <th>Master Password</th>
                <td colspan="2">
                    <input class="form-control" type="password" id="m_pwd" name="m_pwd" 
                           value="">
                    
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
