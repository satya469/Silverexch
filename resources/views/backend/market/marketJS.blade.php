<script>
 
  function lockFancyBet(sportID,lockType,type){
    if(!confirm("Are You Sure?")){
      return false;
    }
    $.ajax({
      url: '{{route("admin.betLock.lockUnlock")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID='+sportID+'&lockType='+lockType+'&type='+type,
      success: function(dataJson){
        alert(dataJson.message);
      }
    });
  }
  function matchSuspend(sportID,type){
    if(!confirm("Are You Sure?")){
      return false;
    }
    $.ajax({
      url: '{{route("admin.betLock.lockUnlock")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID='+sportID+'&lockType=SUSPENDED&type='+type,
      success: function(dataJson){
        alert(dataJson.message);
      }
    });
  }
  function getUserBook(sportID,type){
    $.ajax({
      url: '{{route("frontend.betLock.userBooks")}}',
      dataType: 'text',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID='+sportID+'&lockType=SUSPENDED&type='+type,
      success: function(dataJson){
         
        if(type == 'UserBook'){
          $('.book-title').text('User Book');
        }else{
          $('.book-title').text('Bookmaker Book');
        }
        $('#modal-book-body').html(dataJson);
         $('#modal-book').modal("show"); 
      }
    });
  }
  function lockSelectedUserBet(sportID,lockType,type){
    
    $.ajax({
      url: '{{route("admin.betLock.getUserList")}}',
      dataType: 'text',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID='+sportID+'&lockType='+lockType+'&type='+type,
      success: function(dataJson){
        $('#modal-user').find('.typeClass').html(lockType);
        $('#modal-user').find('#lockType').val(lockType);
        $('#modal-user').find('#type').val(type);
        $('#modal-user').find('#sportID').val(sportID);
        $('#modal-user-body').html(dataJson);
        
        $('#modal-user').modal("show"); 
      }
    });
  }

  function saveUserSelectedUser(obj){
    var lockType = $('#modal-user').find('#lockType').val();
    var type = $('#modal-user').find('#type').val();
    var sportID = $('#modal-user').find('#sportID').val();
    var userlock = '';
    $('.lockUSer').each(function () {
      if(this.checked){
        if(userlock == ''){
          userlock = $(this).val();
        }else{
          userlock += ","+$(this).val();
        }
      }
    });
    $.ajax({
      url: '{{route("admin.betLock.lockUnlock")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID='+sportID+'&lockType='+lockType+'&type='+type+'&extra='+userlock,
      success: function(dataJson){
        alert(dataJson.message);
        $('#modal-user').modal("hide");
        $('#modal-book').modal('hide');
      }
    });
  }
    function getViewMoreBets(sportID){
        $.ajax({
            url: '{{route("admin.viewMoreBets")}}',
            dataType: 'text',
            type: "POST",
            data: '_token={{csrf_token()}}&sportID='+sportID,
            success: function(data){
              $('#addBodyContain').html(data);
              $('#viewMore').modal('show');
            }
        });
    }
    function searchBets(sportID,txt){
        if(txt == 'ViewALL'){
            $.ajax({
                url: '{{route("admin.viewMoreBets")}}',
                dataType: 'text',
                type: "POST",
                data: '_token={{csrf_token()}}&sportID='+sportID,
                success: function(data){
                  $('#addBodyContain').html(data);
                }
            }); 
        }else{
            var sAmount = $('#sAmount').val();
            var eAmount = $('#eAmount').val();
            var bet_side = $('#bet_side').val();
            var ipAddress = $('#ipAddress').val();
            var userid = $('#userid').val();
            var parameter = '';
            if(sAmount !='' && !isNaN(sAmount)){
                parameter += '&sAmount='+sAmount;
            }
            if(eAmount !='' && !isNaN(eAmount)){
                parameter += '&eAmount='+eAmount;
            }
            if(bet_side !=''){
                parameter += '&type='+bet_side;
            }
            if(ipAddress !=''){
                parameter += '&ipAddress='+ipAddress;
            }
            if(userid !='' && !isNaN(userid)){
                parameter += '&userid='+userid;
            }
            $.ajax({
                url: '{{route("admin.viewMoreBetsSearch")}}',
                dataType: 'text',
                type: "POST",
                data: '_token={{csrf_token()}}&sportID='+sportID+parameter,
                success: function(data){
                  $('#addBodyContain').html(data);
                }
            });
        }
    }
    function showDiv(txt){
        $('.bets').removeClass('btn-primary');
        $('.'+txt).addClass('btn-primary');
        if(txt =='metchBetsshow'){
            $('.matchBetTEXT').show();
            $('.matchBetTEXTUnMatch').hide();
        }else{
            $('.matchBetTEXT').hide();
            $('.matchBetTEXTUnMatch').show(); 
        }
    }
    $(document).ready(function() {
    $('.select2').select2();
  });
</script>