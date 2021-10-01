@extends('backend.layouts.app')

@section('title', app_name())

@section('content')
<?php
$upLinkPatnareship = $loginUserModel->partnership;
//if(isset($request->old)){
//dd($request->old());
//}
?>

<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="add-account">
        <h2 class="m-b-20">Add Account</h2>
        <form id="account_createForm" method="post" action="{{route('admin.auth.user.store')}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              <h4 class="m-b-20 col-md-12">Personal Detail</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Client Name:</label>
                    {{ html()->text('first_name')
                                    ->class('form-control')
                                    ->placeholder('Client Name')
                                    ->attribute('onchange', 'checkUserName(this.value)')
                                    ->required()
                                    ->autofocus() }}
                    <!--<input placeholder="Client Name" id="first_name" name="first_name" value="" onchange="checkUserName(this.value)" type="text" class="form-control" required="">-->
                    <span id="username-error" class="error" style="display: none">Client Name already taken</span>
                    <span id="username-required" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">User password:</label>
                    {{ html()->password('password')
                                    ->class('form-control')
                                     ->attribute('onchange', 'checkUserpass(this.value)')
                                    ->placeholder('Password')
                                    ->required() }}
                    <span id="password-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password_confirmation">Retype password:</label>
                    {{ html()->password('password_confirmation')
                                    ->class('form-control ')
                                     ->attribute('onchange', 'checkUserpass(this.value)')
                                    ->placeholder('Retype Password')
                                    ->required() }}
                    <span id="password_confirmation-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    {{ html()->text('last_name')
                                    ->class('form-control')
                                    ->placeholder('Full Name') }}
                    <span id="fullname-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="city">City:</label>
                    {{ html()->text('city')
                                    ->class('form-control')
                                    ->placeholder('City')
                                    ->attribute('maxlength', 191)
                                     }}
                    <span id="city-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Phone:</label>
                    {{ html()->number('phone')
                                    ->class('form-control numberOnly')
                                    ->placeholder('Phone')
                                    ->attribute('maxlength', 10)
                                    }}
                    <span id="phone-error" class="error"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 account-detail">
              <h4 class="m-b-20 col-md-12">Account Detail</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="account_type">Acount Type:</label>
                    {{ html()->select('roles[]',$roles)
                                    ->class('form-control')
                                    ->placeholder('Select Acount Type')
                                    ->attribute('onchange', 'showExposer(this.value)')
                                    ->required() }}
                    <span id="accounttype-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="credit_ref">Credit Reference:</label>
                    {{ html()->number('credit_ref')
                                    ->class('form-control numberOnly')
                                    ->placeholder('Credit Reference') }}
                    <span id="creit-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" id="exposer-limit" style="display:none;">
                    <label for="exposerlimit">Exposer Limit:</label>
                    {{ html()->number('exposelimit')
                                    ->class('form-control numberOnly exposelimit')
                                    ->placeholder('Exposer Limit') }}
                   <span id="exposerlimit-error" class="error"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row m-t-20" id="commission-div">
            <div class="col-md-12">
              <h4 class="m-b-20 col-md-12">Commission Settings</h4>
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>Cricket</th>
                    <th>Football</th>
                    <th>Tennis</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Upline</td>
                    <td id="taxcommition0-upline">0</td>
                    <td id="taxcommition1-upline">0</td>
                    <td id="taxcommition2-upline">0</td>
                  </tr>
                  <tr>
                    <td>Downline</td>
                    <td>
                      {{ html()->text('commission_cricket','0')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('0') }}
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('commission_football','0')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('0') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('commission_tennic','0')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('0') }}  
                      <span class="error"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>Our</td>
                    <td id="taxcommition0-d">0</td>
                    <td id="taxcommition1-d">0</td>
                    <td id="taxcommition2-d">0</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row m-t-20" id="partnership-div">
            <div class="col-md-12">
                <h4 class="m-b-20 col-md-12">Partnership<input type="number" max="100" style="margin-left: 10px;" id="uolinkInput" value=""></h4>
                <table  class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>Cricket</th>
                    <th>Football</th>
                    <th>Tennis</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                        Upline
                        <input type="hidden" id="upLinkPatnareship" value="<?= $upLinkPatnareship ?>">
                    </td>
                    <th id="taxpartnership0-upline"><?= $upLinkPatnareship ?></th>
                    <th id="taxpartnership1-upline"><?= $upLinkPatnareship ?></th>
                    <th id="taxpartnership2-upline"><?= $upLinkPatnareship ?></th>
                  </tr>
                  <tr>
                    <td>Downline</td>
                    <td>
                      {{ html()->text('partnership_cricket','0')
                                    ->class('form-control downlinkP')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('0') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('partnership_football','0')
                                    ->class('form-control downlinkP')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('0') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('partnership_tennic','0')
                                    ->class('form-control downlinkP')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('0') }}  
                      <span class="error"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>Our</td>
                    <td class="uplinkP">0</td>
                    <td class="uplinkP">0</td>
                    <td class="uplinkP">0</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row m-t-20" id="min-max-bet-div">
            <div class="col-md-12">
              <h4 class="m-b-20 col-md-12">Min Max Bet</h4>
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>Cricket </th>
                    <th>FootBall</th>
                    <th>Tennis </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td rowspan="2">Min Bet</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                  </tr>
                  <tr>
                    <td>
                      {{ html()->text('minbet_cricket','100')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('100') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('minbet_football','100')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('100') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('minbet_tennic','100')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('100') }}  
                      <span class="error"></span>
                    </td>  
                  </tr>
                  <tr>
                    <td rowspan="2">Max Bet</td>
                    <td>10000000</td>
                    <td>10000000</td>
                    <td>10000000</td>
                  </tr>
                  <tr>
                    <td>
                      {{ html()->text('maxbet_cricket','10000000')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('10000000') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('maxbet_football','10000000')
                                    ->class('form-control')
                                    ->attribute('readonly', 'readonly')
                                    ->placeholder('10000000') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('maxbet_tennic','10000000')
                                    ->class('form-control')
                                    ->placeholder('10000000') }}  
                      <span class="error"></span>
                    </td>  
                  </tr>
                  <tr>
                    <td rowspan="2">Delay</td>
                    <td id="uplimit_delay_cricket"><?= $loginUserModel->delay_cricket ?></td>
                    <td id="uplimit_delay_football"><?= $loginUserModel->delay_football ?></td>
                    <td id="uplimit_delay_tennic"><?= $loginUserModel->delay_tennic ?></td>
                  </tr>
                  <tr>
                    <td>
                      {{ html()->text('delay_cricket',$loginUserModel->delay_cricket)
                                    ->class('form-control numberOnly')
                                    ->attribute('onchange', 'checkDelay(this)')
                                    ->placeholder($loginUserModel->delay_cricket) }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('delay_football',$loginUserModel->delay_football)
                                    ->class('form-control numberOnly')
                                    ->attribute('onchange', 'checkDelay(this)')
                                    ->placeholder($loginUserModel->delay_football) }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->text('delay_tennic',$loginUserModel->delay_tennic)
                                    ->class('form-control numberOnly')
                                    ->attribute('onchange', 'checkDelay(this)')
                                    ->placeholder($loginUserModel->delay_tennic) }}  
                      <span class="error"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="form-group col-md-3 float-right">
                <label for="m_pwd">Master Password:</label>
                <input required="" maxlength="15" placeholder="Master Password" name="m_pwd" id="m_pwd" value="" type="password" class="form-control">
                <span id="m_pwd-error" class="error"></span>
              </div>
            </div>
          </div>
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="float-right">
                @csrf
                
                <input type="hidden" name="email" value="{{ rand(1111,9999)."@admin.com" }}">
                <input type="hidden" name="active" value="1">
                <input type="hidden" name="confirmed" value="1">
                <input type="hidden" name="permissions[]" value="view frontend">
                <button class="btn btn-submit" type="submit">Create Account</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    
  </div>
</div>


@endsection

@push('after-styles')
<Style>
    .add-account{
        box-shadow: none;
        background-color: var(--primary-bg);
    }
</style>
@endpush

@push('after-scripts')
<script type="text/javascript">
  $('#uolinkInput').keyup(function(){
    calPat(this);
  });
  function checkDelay(obj){
    var dealyText = $('#uplimit_delay_cricket').text();
    if(parseFloat(dealyText) > $(obj).val()){
      $(obj).val(dealyText);
      alert("Please check delay Limit");
      return false;
    }
  }
  function checkUserpass(){
    var pass = $('#password').val();
    var con_pass = $('#password_confirmation').val();
    if(pass != '' && con_pass != '' && con_pass != pass){
      $('#password').val('');
      $('#password_confirmation').val('');
      alert("Password Mismatch!");
      return false;
    }
  }
  function calPat(obj){
    var uuplinkp = $('#upLinkPatnareship').val();
    var downLink = $(obj).val();
    var uplinkp = (parseInt(uuplinkp)-parseInt(downLink));
    
    if(parseInt(uplinkp) < 0 || isNaN(uplinkp)){
      alert("Please Check Upline OR DownLine Partnership Limit");
      return false;
    }
    $('.downlinkP').val(downLink);
    $('.uplinkP').text(uplinkp);
  }
  $(document).ready(function() {
      $('#clientListTable').DataTable( {
            "pageLength": 50,
            "order": [],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'excel',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
      });
  } );

  function checkUserName(username){
      if(username == ''){
        return false;
      }
      $.ajax({
          url: '{{ route("admin.client.checkusername")}}',
          type: "post",
          dataType: 'json',
          data: {'username':username,'_token':'{{csrf_token()}}'},
          success: function(data){
              if(data.status == false)
              {
                  $("#first_name").val('');
                  $("#first_name").focus();
                  $("#username-error").show();
              }else {
                  $("#username-error").hide();
              }
          },
      });
  }
      
function showExposer(name){
  if(name == 'user'){
    $('#exposer-limit').css('display',"block");
   // $('#min-max-bet-div').show();
//    $('#partnership-div input').attr('readonly','readonly');
    $('#uolinkInput').hide();
    $('.uplinkP').text($('#taxpartnership0-upline').text());
  }else{
    //$('#min-max-bet-div').hide();
//    $('#partnership-div input').attr('readonly',false);
    $('#exposer-limit').css('display',"none");
    $('.exposelimit').val('');
    $('#uolinkInput').show();
  }
}

$(document).ready(function () {
  $(".numberOnly").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
       return false;
    }
   });
});
</script>

@endpush
