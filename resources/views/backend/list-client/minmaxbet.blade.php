@extends('backend.layouts.app')

@section('title', app_name() . ' | Add Account')

@section('content')


<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="add-account">
        <h2 class="m-b-20">Bet Min-Max Update</h2>
        <form id="account_createForm" method="post" action="{{route('admin.client.minmaxstore',$client->uuid)}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              <h4 class="m-b-20 col-md-12">Personal Detail</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    {{ html()->text('last_name',$client->last_name)
                                    ->class('form-control')
                                    ->placeholder('Full Name')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                    <span id="fullname-error" class="error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Phone:</label>
                    {{ html()->number('phone',$client->phone)
                                    ->class('form-control')
                                    ->placeholder('Phone')
                                    ->attribute('maxlength', 10)
                                    ->required() }}
                    <span id="phone-error" class="error"></span>
                  </div>
                </div>
              </div>
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
                    <td>1000</td>
                    <td>1000</td>
                    <td>1000</td>
                  </tr>
                  <tr>
                    <td>
                      {{ html()->number('minbet_cricket',$client->minbet_cricket)
                                    ->class('form-control')
                                    ->placeholder('1000') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->number('minbet_football',$client->minbet_football)
                                    ->class('form-control')
                                    ->placeholder('1000') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->number('minbet_tennic',$client->minbet_tennic)
                                    ->class('form-control')
                                    ->placeholder('1000') }}  
                      <span class="error"></span>
                    </td>  
                  </tr>
                  <tr>
                    <td rowspan="2">Max Bet</td>
                    <td>5000000</td>
                    <td>2500000</td>
                    <td>1000000</td>
                  </tr>
                  <tr>
                    <td>
                      {{ html()->number('maxbet_cricket',$client->maxbet_cricket)
                                    ->class('form-control')
                                    ->placeholder('5000000') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->number('maxbet_football',$client->maxbet_football)
                                    ->class('form-control')
                                    ->placeholder('2500000') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->number('maxbet_tennic',$client->maxbet_tennic)
                                    ->class('form-control')
                                    ->placeholder('1000000') }}  
                      <span class="error"></span>
                    </td>  
                  </tr>
                  <tr>
                    <td rowspan="2">Delay</td>
                    <td>5.00</td>
                    <td>5.00</td>
                    <td>5.00</td>
                  </tr>
                  <tr>
                    <td>
                      {{ html()->number('delay_cricket',$client->delay_cricket)
                                    ->class('form-control')
                                    ->placeholder('5.00') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->number('delay_football',$client->delay_football)
                                    ->class('form-control')
                                    ->placeholder('5.00') }}  
                      <span class="error"></span>
                    </td>
                    <td>
                      {{ html()->number('delay_tennic',$client->delay_tennic)
                                    ->class('form-control')
                                    ->placeholder('5.00') }}  
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
                <button class="btn btn-submit" type="submit">Create Account</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script>
      var csrf = $('meta[name=csrf-token]').attr("content");
      var path = $('meta[name=path]').attr("content");
      var token = $('meta[name=token]').attr("content");
      function checkUserName(username){
      
          $.ajax({
              url: path+"/check-username/"+token,
              type: "post",
              data: {'username':username,'_token':csrf},
              success: function(data){
                  if(data == 0)
                  {
                      $("#username").val('');
                      $("#username").focus();
                      $("#username-error").show();
                  }
                  else {
                      $("#username-error").hide();
                  }
              },
          });
      }
    </script>
    <script>
      $(function () {
          $( "#accounttype" ).on('change',function( event ) {
              if($("#accounttype").val() != 'User')
              {
                  $("#taxpartnership0").attr('required',true);
                  $("#taxpartnership0").attr('max','0');
                  $("#taxpartnership0").attr('min','0');
      
                  $("#taxpartnership1").attr('required',true);
                  $("#taxpartnership1").attr('max','0');
                  $("#taxpartnership1").attr('min','0');
      
                  $("#taxpartnership2").attr('required',true);
                  $("#taxpartnership2").attr('max','0');
                  $("#taxpartnership2").attr('min','0');
      
      
                  $("#taxcommition0").attr('required',true);
                  $("#taxcommition0").attr('max','0');
                  $("#taxcommition0").attr('min','0');
      
                  $("#taxcommition1").attr('required',true);
                  $("#taxcommition1").attr('max','0');
                  $("#taxcommition1").attr('min','0');
      
                  $("#taxcommition2").attr('required',true);
                  $("#taxcommition2").attr('max','0');
                  $("#taxcommition2").attr('min','0');
              }
              else
              {
                  $("#minbettext0").attr('required',true);
                  $("#minbettext0").attr('max','5000000');
                  $("#minbettext0").attr('min','1000');
      
                  $("#maxbettext0").attr('required',true);
                  $("#maxbettext0").attr('max','5000000');
                  $("#maxbettext0").attr('min','1000');
      
      
                  $("#delaytext0").attr('required',true);
                  $("#delaytext0").attr('min','5.00');
      
                  $("#minbettext1").attr('required',true);
                  $("#minbettext1").attr('max','2500000');
                  $("#minbettext1").attr('min','1000');
      
                  $("#maxbettext1").attr('required',true);
                  $("#maxbettext1").attr('max','2500000');
                  $("#maxbettext1").attr('min','1000');
      
                  $("#delaytext1").attr('required',true);
                  $("#delaytext1").attr('min','5.00');
      
                  $("#minbettext2").attr('required',true);
                  $("#minbettext2").attr('max','1000000');
                  $("#minbettext2").attr('min','1000');
      
                  $("#maxbettext2").attr('required',true);
                  $("#maxbettext2").attr('max','1000000');
                  $("#maxbettext2").attr('min','1000');
      
                  $("#delaytext2").attr('required',true);
                  $("#delaytext2").attr('min','5.00');
              }
              return;
              event.preventDefault();
          });
      })
    </script>
    <script>
      $(".partnership, .tdcommission").bind("keyup mouseup", function(){
          var id  = $(this).attr('id');
          var upline = parseInt($("#"+id+"-upline").text());
          if($(this).val() == "" || $(this).val() < 0 || $(this).val() > upline){
              $(this).val("");
          }
          $("#"+id+"-d").text(upline - $(this).val());
      });
    </script>
    <script>
      $(function () {
          $("#accounttype").change(function () {
              acctype = $("#accounttype").val();
              if(acctype == 'User')
              {
                  $("#commission-div").find(':input').prop("disabled", "disabled");
                  $("#partnership-div").find(':input').prop("disabled", "disabled");
                  $("#min-max-bet-div").show();
                  $("#exposer-limit").show();
              }else{
                  $("#commission-div").find(':input').prop("disabled", false);
                  $("#partnership-div").find(':input').prop("disabled", false);
                  $("#min-max-bet-div").hide();
                  $("#exposerlimit").val(0);
                  $("#exposer-limit").hide();
              }
          });
      })
    </script>
  </div>
</div>


@endsection


@push('after-scripts')
<script type="text/javascript">
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


/* List Client Withdraw */
function getCasinoGameDetails(id, accountType) {
    $.ajax({
        url: "http://diamondexch.com/admin/casinogamedetails/ad9233c22844b8a4a7fdf8461d4d008ae6688174",
        type: "post",
        data: {
            'userid':id,
            '_token': csrf,
            'accountType':accountType
        },
        beforeSend: function(){
            showLoading();
        },
        complete:function(){
            hideLoading();
        },
        success: function(response){
            if(response.success == true){
                $("#casino-game-details").html(response.html);
                $("#modal-casinogame").modal("show");  
            }
        },
    });
}

$('.maxlength12').keypress(function(e){
    var amount = $(this).val();
    if(amount.length > 12){
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
});

</script>

@endpush
