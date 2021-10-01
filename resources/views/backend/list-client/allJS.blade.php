<script type="text/javascript">
function addAmountAdmin(){
  var amount = $('#amountAdmin').val();
  $.ajax({
    url: "{{ route('admin.client.depositstore')}}",
    type: "post",
    dataType: 'json',
    data: {
        'amount':amount,
        'supperAdmin':'1',
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
//        showLoading();
    },
    complete:function(){
//        hideLoading();
    },
    success: function(response){
      
      if(response.status == true){
        alert(response.message);
        $("#modal-deposit").modal("hide");
//        $('.massageAdmin').html(response.message);
        getClientRow(obj,uuid);
      }else{
        alert(response.message);
        $("#modal-deposit").modal("hide");
//        $('.massageAdmin').html(response.message);
      }
      
    },
  });
}
function setUserToDeposit(id,obj){
  $.ajax({
    url: "{{ route('admin.client.deposit')}}",
    type: "post",
    data: {
        'userid':id,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-deposit');
    },
    complete:function(){
        hideLoading('modal-deposit');
    },
    success: function(response){
      jQuery.noConflict();
      $('#depName').text($(obj).closest('tr').find('.username').text());
      $("#modal-deposit-body").html(response);
      
      $("#modal-deposit").modal("show");  
    },
  });
}

function saveDeposite(obj){
  var deposite_user_id = $("#modal-deposit").find('#deposite_user_id').val();
  var withdrawal_user_id = $("#modal-deposit").find('#withdrawal_user_id').val();
  var note = $("#modal-deposit").find('#note').val();
  var m_pwd = $("#modal-deposit").find('#m_pwd').val();
  var amount = $("#modal-deposit").find('#amount').val();
  var uuid = $("#modal-deposit").find('#uuidDep').val();
  var balanceType = $("#modal-deposit").find('#balanceType').val();
  
  $.ajax({
    url: "{{ route('admin.client.depositstore')}}",
    type: "post",
    dataType: 'json',
    data: {
        'deposite_user_id':deposite_user_id,
        'withdrawal_user_id':withdrawal_user_id,
        'note':note,
        'm_pwd':m_pwd,
        'amount':amount,
        'balanceType':balanceType,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-deposit');
    },
    complete:function(){
        hideLoading('modal-deposit');
    },
    success: function(response){
    $('.btn-submit').removeAttr("disabled");
      if(response.status == true){
        alert(response.message);
        $(".modalHideClass").modal("hide");
        getClientRow(obj,uuid);
      }else{
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $('.massageDep').html(response.message);
      }
      
//      setTimeout(function(){ $("#modal-deposit").modal("hide"); }, 4000);
    },
  });
}

function saveWithdraw(obj){
  var deposite_user_id = $("#modal-withdraw").find('#deposite_user_id').val();
  var withdrawal_user_id = $("#modal-withdraw").find('#withdrawal_user_id').val();
  var note = $("#modal-withdraw").find('#note').val();
  var m_pwd = $("#modal-withdraw").find('#m_pwd').val();
  var amount = $("#modal-withdraw").find('#amount').val();
  var uuid = $("#modal-withdraw").find('#uuidwid').val();
  var balanceType = $("#modal-withdraw").find('#balanceType').val();
  $.ajax({
    url: "{{ route('admin.client.depositstore')}}",
    type: "post",
    dataType: 'json',
    data: {
        'deposite_user_id':deposite_user_id,
        'withdrawal_user_id':withdrawal_user_id,
        'note':note,
        'm_pwd':m_pwd,
        'amount':amount,
        'balanceType':balanceType,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-withdraw');
    },
    complete:function(){
        hideLoading('modal-withdraw');
    },
    success: function(response){
      if(response.status == true){
          $('.btn-submit').removeAttr("disabled");
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $('.massageWid').html(response.message);
        getClientRow(obj,uuid);
      }else{
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $('.massageWid').html(response.message);
      }
       
//      setTimeout(function(){ $("#modal-withdraw").modal("hide");  }, 4000);
    },
  });
}

function depositeCal(obj){
  var amt = $(obj).val();
  var loginAmt = $('#oldLoginAmount').val();
  var depAmt = $('#olddepositeAmount').val();
  
  var newloginAmt = (parseFloat(loginAmt)-parseFloat(amt));
  var newdepAmt = (parseFloat(depAmt)+parseFloat(amt));
  
  $('#newLoginAmount').val(newloginAmt.toFixed(2));
  $('#newdepositeAmount').val(newdepAmt.toFixed(2));
}

function setUserToWithdraw(id,obj){
  $.ajax({
    url: "{{ route('admin.client.withdraw')}}",
    type: "post",
    data: {
        'userid':id,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-withdraw');
    },
    complete:function(){
        hideLoading('modal-withdraw');
    },
    success: function(response){
      jQuery.noConflict();
      $('#widName').text($(obj).closest('tr').find('.username').text());
      $("#modal-withdraw-body").html(response);
      $("#modal-withdraw").modal("show");  
    },
  });
}

function withdrawCal(obj){
  var amt = $(obj).val();
  var loginAmt = $("#modal-withdraw-body").find('#oldLoginAmount').val();
  var depAmt = $("#modal-withdraw-body").find('#olddepositeAmount').val();
  
  var newloginAmt = (parseFloat(loginAmt)+parseFloat(amt));
  var newdepAmt = (parseFloat(depAmt)-parseFloat(amt));
  
  $("#modal-withdraw-body").find('#newLoginAmount').val(newloginAmt.toFixed(2));
  $("#modal-withdraw-body").find('#newdepositeAmount').val(newdepAmt.toFixed(2));
}

function setUserToLimit(token,obj){
  $.ajax({
    url: "{{ route('admin.client.userlimit')}}",
    type: "post",
    data: {
        'userid':token,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-exposure-limit');
    },
    complete:function(){
        hideLoading('modal-exposure-limit');
    },
    success: function(response){
      jQuery.noConflict();
      $('#expName').text($(obj).closest('tr').find('.username').text());
      $('#limit-uid').val(token);
      $('#message').html('');
      $("#modal-exposure-limit-body").html(response);
      $("#modal-exposure-limit").modal("show");  
    },
  });
}

function saveExposureLimit(obj){
  var newLimit = $(obj).closest('#modal-exposure-limit').find('#newlimitAmount').val();
  var token = $(obj).closest('#modal-exposure-limit').find('#limit-uid').val();
  var m_pwd = $(obj).closest('#modal-exposure-limit').find('#m_pwd').val();
  
  $.ajax({
    url: "{{ route('admin.client.userlimitstore')}}",
    type: "post",
    dataType: 'json',
    data: {
        'userid':token,
        'exposelimit':newLimit,
        'm_pwd':m_pwd,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-exposure');
    },
    complete:function(){
        hideLoading('modal-exposure');
    },
    success: function(response){
      jQuery.noConflict();
      $('.btn-submit').removeAttr("disabled");
      if(response.status = true){
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-exposure-limit').find('#message').html(response.message);
        getClientRow(obj,token);
      }else{
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-exposure-limit').find('#message').html(response.message);
      }   
//       setTimeout(function(){ $("#modal-exposure").modal("hide"); }, 4000);
    },
  });
}

function setUserToCredit(token,obj){
  $.ajax({
    url: "{{ route('admin.client.usercredit')}}",
    type: "post",
    data: {
        'userid':token,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-credit');
    },
    complete:function(){
        hideLoading('modal-credit');
    },
    success: function(response){
      
      jQuery.noConflict();
      $('#creditName').text($(obj).closest('tr').find('.username').text());
      $('#credit-uid').val(token);
      $('#message').html('');
      $("#modal-credit-body").html(response);
      $("#modal-credit").modal("show");  
    },
  });
}
function saveUserToCredit(obj){
  var newLimit = $(obj).closest('#modal-credit').find('#newcreditAmount').val();
  var token = $(obj).closest('#modal-credit').find('#credit-uid').val();
  var m_pwd = $(obj).closest('#modal-credit').find('#m_pwd').val();
  $.ajax({
    url: "{{ route('admin.client.usercreditstore')}}",
    type: "post",
    dataType: 'json',
    data: {
        'userid':token,
        'credit_ref':newLimit,
        'm_pwd':m_pwd,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-credit');
    },
    complete:function(){
        hideLoading('modal-credit');
    },
    success: function(response){
      jQuery.noConflict();
      $('.btn-submit').removeAttr("disabled");
      if(response.status = true){
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-credit').find('#message').html(response.message);
        getClientRow(obj,token);
      }else{
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-credit').find('#message').html(response.message);
      }  
//      setTimeout(function(){ $("#modal-credit").modal("hide"); }, 4000);
    },
  });
}
function getClientRow(obj,token){
  $.ajax({
    url: "{{ route('admin.client.userclientrows')}}",
    type: "post",
    data: {
        'userid':token,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('ROW_'+token);
    },
    complete:function(){
        hideLoading('ROW_'+token);
    },
    success: function(response){
      jQuery.noConflict();
      $('#ROW_'+token).html(response);
    },
  });
}
function setUserToPassword(token,obj){
  $('#passuser').text($(obj).closest('tr').find('.username').text());
  $('#modal-password').find('#message').html('');
  $('#password-uid').val(token);
  
}
function ChangePassword(obj){
  var newpass = $(obj).closest('#modal-password').find('#new-password').val();
  var confpass = $(obj).closest('#modal-password').find('#confirm-password').val();
  var token = $(obj).closest('#modal-password').find('#password-uid').val();
  var m_pwd = $(obj).closest('#modal-password').find('#m_pwd').val();
  if(newpass != confpass){
    $(obj).closest('#modal-password').find('#message').html("<div class='alert alert-danger'>New OR Confirm Password are not match</div>");
    return false;
  }
  $.ajax({
    url: "{{ route('admin.client.updatePassword')}}",
    type: "post",
    dataType: 'json',
    data: {
        'userid':token,
        'password':newpass,
        'm_pwd':m_pwd,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-password');
    },
    complete:function(){
        hideLoading('modal-password');
    },
    success: function(response){
      jQuery.noConflict();
      if(response.status = true){
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-password').find('#message').html(response.message);
      }else{
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-password').find('#message').html(response.message);
      }  
      $('.btn-submit').removeAttr("disabled");
      $(obj).closest('#modal-password').find('#new-password').val('');
      $(obj).closest('#modal-password').find('#confirm-password').val('');
      $(obj).closest('#modal-password').find('#m_pwd').val('');
    },
  });
}
function setUserToStatus(token,obj){
  $('#statusName').text($(obj).closest('tr').find('.username').text());
  $.ajax({
    url: "{{ route('admin.client.userstatusview')}}",
    type: "post",
    data: {
        'userid':token,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-status');
    },
    complete:function(){
        hideLoading('modal-status');
    },
    success: function(response){
      jQuery.noConflict();
      $("#modal-status").find('#userStatusHtml').html(response);
      $('#modal-status').find('#status-uid').val(token);
      checkUserBetActivePHP();
      $("#modal-status").modal("show");
    },
  });
  

 
}

function saveUserStatus(obj){
  var isBetActive = $(obj).closest('#modal-status').find('#status-bet-active').val();
  var isActive = $(obj).closest('#modal-status').find('#status-user-active').val();
  
  var token = $(obj).closest('#modal-status').find('#status-uid').val();
  var m_pwd = $(obj).closest('#modal-status').find('#m_pwd').val();
  $(obj).closest('#modal-status').find('#m_pwd').val('');
  $.ajax({
    url: "{{ route('admin.client.userstatuschange')}}",
    type: "post",
    dataType: 'json',
    data: {
        'userid':token,
        'isBetActive':isBetActive,
        'isActive':isActive,
        'm_pwd':m_pwd,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
        showLoading('modal-status');
    },
    complete:function(){
        hideLoading('modal-status');
    },
    success: function(response){
      jQuery.noConflict();
      $('.btn-submit').removeAttr("disabled");
      if(response.status = true){
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-status').find('#message').html(response.message);
        getClientRow(obj,token);
      }else{
        alert(response.message);
        $(".modalHideClass").modal("hide");
//        $(obj).closest('#modal-status').find('#message').html(response.message);
        getClientRow(obj,token);
      }  
    },
  });
}

function checkUserBetActive(obj){
  if($(obj).prop('checked') == true){
    $('#status-bet-active').val(1);
    $('.betActive').find('.off').css('display','none');
    $('.betActive').find('.on').css('display','block');
  }else{
    $('#status-bet-active').val(0);
    $('.betActive').find('.off').css('display','block');
    $('.betActive').find('.on').css('display','none')
  }
}

function checkUserBetActivePHP(){
  if($("#status-user-active-s").prop('checked') == true){
    $('#status-bet-active').val(1);
    $('.betActive').find('.off').css('display','none');
    $('.betActive').find('.on').css('display','block');
  }else{
    $('#status-bet-active').val(0);
    $('.betActive').find('.off').css('display','block');
    $('.betActive').find('.on').css('display','none')
  }
  
  if($("#status-bet-active-s").prop('checked') == true){
    $('#status-bet-active').val(1);
    $('.betActive').find('.off').css('display','none');
    $('.betActive').find('.on').css('display','block');
  }else{
    $('#status-bet-active').val(0);
    $('.betActive').find('.off').css('display','block');
    $('.betActive').find('.on').css('display','none')
  }
}
function checkUserActive(obj){
  if($(obj).prop('checked') == true){
    $('#status-user-active').val(1);
    $('.activeuser').find('.off').css('display','none');
    $('.activeuser').find('.on').css('display','block');
  }else{
    $('#status-user-active').val(0);
    $('.activeuser').find('.off').css('display','block');
    $('.activeuser').find('.on').css('display','none');
  }
}

function hideShow(types){
  if(types == 'down'){
    $('#up').show();
    $('#down').hide();
    $('#hideShowDiv').fadeIn(1000);
  }else{
    $('#up').hide();
    $('#down').show();
    $('#hideShowDiv').fadeOut(1000);
  }
  
}
</script>

