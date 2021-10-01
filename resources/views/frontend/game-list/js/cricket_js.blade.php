<script type="text/javascript">
function setUserToDeposit(id,obj){
  $.ajax({
    url: "{{ route('admin.client.deposit')}}",
    type: "post",
    data: {
        'userid':id,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
//        showLoading();
    },
    complete:function(){
//        hideLoading();
    },
    success: function(response){
      
      jQuery.noConflict();
      $('#depName').text($(obj).closest('tr').find('.username').text());
      $("#modal-deposit-body").html(response);
      $("#modal-deposit").modal("show");  
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
//        showLoading();
    },
    complete:function(){
//        hideLoading();
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
  var loginAmt = $('#oldLoginAmount').val();
  var depAmt = $('#olddepositeAmount').val();
  
  var newloginAmt = (parseFloat(loginAmt)+parseFloat(amt));
  var newdepAmt = (parseFloat(depAmt)-parseFloat(amt));
  
  $('#newLoginAmount').val(newloginAmt.toFixed(2));
  $('#newdepositeAmount').val(newdepAmt.toFixed(2));
}

function setUserToLimit(id,obj){
  $.ajax({
    url: "{{ route('admin.client.userlimit')}}",
    type: "post",
    data: {
        'userid':id,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
//        showLoading();
    },
    complete:function(){
//        hideLoading();
    },
    success: function(response){
      
      jQuery.noConflict();
      $('#expName').text($(obj).closest('tr').find('.username').text());
      $("#modal-exposure-limit-body").html(response);
      $("#modal-exposure-limit").modal("show");  
    },
  });
}

function setUserToCredit(id,obj){
  $.ajax({
    url: "{{ route('admin.client.usercredit')}}",
    type: "post",
    data: {
        'userid':id,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
//        showLoading();
    },
    complete:function(){
//        hideLoading();
    },
    success: function(response){
      
      jQuery.noConflict();
      $('#creditName').text($(obj).closest('tr').find('.username').text());
      $("#modal-credit-body").html(response);
      $("#modal-credit").modal("show");  
    },
  });
}

function setUserToStatus(id,obj){
//  $.ajax({
//    url: "{{ route('admin.client.usercredit')}}",
//    type: "post",
//    data: {
//        'userid':id,
//        '_token': "{{ csrf_token() }}",
//    },
//    beforeSend: function(){
////        showLoading();
//    },
//    complete:function(){
////        hideLoading();
//    },
//    success: function(response){
      
      jQuery.noConflict();
      $('#statusName').text($(obj).closest('tr').find('.username').text());
//      $("#modal-credit-body").html(response);
      $("#modal-status").modal("show");  
//    },
//  });
}

function checkUserBetActive(obj){
  if($(obj).prop('checked') == true){
     alert("bet user Active");
  }else{
    alert("bet user unActive");
  }
}

function checkUserActive(obj){
  if($(obj).prop('checked') == true){
     alert("user Active");
  }else{
    alert("user unActive");
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

