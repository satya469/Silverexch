

<html>
  <head>
    <title>Diamond Exch</title>
    <meta name="csrf-token" content="eKELiau2NEdEpxhEqu5pY3ZPcecfE8VIbEHCvwTs">
    <meta name="token" content="7673a33096f2e0fe0922c9ba5399301de556542d">
    <meta name="path" content="http://diamondexch.com/admin">
    <meta name="front-path" content="http://diamondexch.com">
    <link rel="icon" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/fav-icon.png">
    <link rel="stylesheet" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/vendor/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/vendor/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/themes/diamondexch.com/admin/theme.css">
    <link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @include('frontend.includes.sideColor')
  </head>
  <body oncontextmenu="return false;" oncopy="return false;" oncut="return false;" onpaste="return false;">
    <div class="mtree-skin-selector">
      <ul class="button-group radius">
        <li><button class="small skin active">bubba</button></li>
        <li><button class="small skin">skinny</button></li>
        <li><button class="small skin">transit</button></li>
        <li><button class="small skin">jet</button></li>
        <li><button class="small skin">nix</button></li>
        <li><button class="small csl active">Close Same Level</button></li>
      </ul>
    </div>
    <div id="divLoading" class=""></div>
    <div class="wrapper">
        <div class="main">
        <div class="container-fluid">
                    @yield('content')
                 </div>
      </div>
      <footer>
        <div class="modal fade" id="modal-user-detail">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">User Detail</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
              </div>
              <div class="modal-body" id="search-user-details"></div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <script src="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/js/all.js"></script>
    <script type="text/javascript" src="https://dzm0kbaskt4pv.cloudfront.net/v1/static/js/customjs.js"></script>
    <script src="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/js/custom.js"></script>
    <script src="https://dzm0kbaskt4pv.cloudfront.net/v1/static/js/custom.js"></script>
    <script>
      document.onkeydown = function(e) {
          if(event.keyCode == 123) {
              return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
              return false;
          }
          if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
              return false;
          }
          if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
              return false;
          }
      }
    </script>
    <script>
      var ASSET_PATH = 'https://dzm0kbaskt4pv.cloudfront.net/v1/static';
      var ENCRYPT_RESPONSE = "1";
      var CLIENT_ADDR = localStorage.getItem("clientAddr");
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $( function() {
          $.getJSON("https://api.ipify.org?format=jsonp&callback=?", function (json) {
              CLIENT_ADDR = json.ip;
              localStorage.setItem("clientAddr", json.ip);
          });
          var cache = {};
          $( "#tags" ).autocomplete({
              source: function (request, response) {
                  var term = request.term;
      
                 /* if ( term in cache ) {
                    response( cache[ term ] );
                    return;
                  }*/
                  
                  /*if(term.length > 3){
                      
                      var userCache = JSON.parse(sessionStorage.getItem("userCache"));
                      console.log(userCache)
                      response( userCache);
                      return;
                  }*/
      
                  $.ajax({
                      url: "http://diamondexch.com/admin/searchuserlist/7673a33096f2e0fe0922c9ba5399301de556542d",
                      dataType: "json",
                      data:{"term":request.term},
                      method: "POST",
                      success: function( res ) {
                          response( res.results);
                      },
                  });
                 
              },
              select: function( event, ui ) {
                  console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
                  $("#clientList").data("value", ui.item.id);
              },
              minLength: 3,
          });
      } );
      
      $(document).on("click", "#clientList", function(){
          var userId = $(this).data("value");
          if($.trim(userId) == ""){
              alert("Please select user!");
              return;
          }
          $.ajax({
              url: "http://diamondexch.com/admin/useralldetails/7673a33096f2e0fe0922c9ba5399301de556542d",
              dataType: "json",
              data:{"uid": userId},
              method: "POST",
              beforeSend: function(){
                  showLoading();
              },
              success: function(response) {
                  if(response.success == true){
                      $("#search-user-details").html(response.html);
                      $("#modal-user-detail").modal("show");
                  }
              },
              complete: function(){
                  hideLoading();
              }
          });
      });
      
      $(document).on("click", "#user-balance", function(){
          var userId = $(this).data("value");
          $.ajax({
              url: "http://diamondexch.com/admin/getuserbalancelist/7673a33096f2e0fe0922c9ba5399301de556542d",
              dataType: "json",
              method: "POST",
              beforeSend: function(){
                  showLoading();
              },
              success: function(response) {
                  if(response.success == true){
                      $("#master-balance-detail").html(response.html);
                  }
              },
              complete: function(){
                  hideLoading();
              }
          });
      });
      
      function call_header()
      {
        setTimeout(ajax_fun, 1000);
      }
      
      function ajax_fun(){
          $.ajax({
              type: "POST",
              url: "http://diamondexch.com/admin/checktoken/7673a33096f2e0fe0922c9ba5399301de556542d",
              success: function ( apiResponse ) {
                  let response = CryptojsDecrypt(apiResponse);
                  if (response.redirect) {
                      window.location.href = response.redirect;
                  }
              },
              complete: function(){
                  call_header();
              }
          });
      }
      
      $(document).ready(function(){
          ajax_fun()
      })
      
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
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
            url: "http://diamondexch.com/admin/casinogamedetails/7673a33096f2e0fe0922c9ba5399301de556542d",
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
    <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
    <div role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></div>
  </body>
</html>