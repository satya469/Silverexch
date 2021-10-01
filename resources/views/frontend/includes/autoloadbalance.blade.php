
<script>
$( document ).ready(function() {
  setInterval(function(){ setBalanceTop(); }, 10000);
});
function setBalanceTop(){
  $.ajax({
      url: '{{route("frontend.getExBlance")}}',
      dataType: 'json',
      type: "get",
      cache: false,
      async: false,
      success: function(dataJson){
        if (typeof dataJson.exposureAmt !== 'undefined') {
          $('#headerExposureLimit').text(calc12(dataJson.exposureAmt));
        }
        if(typeof dataJson.headerUserBalance !== 'undefined') {
          $('#headerUserBalance').text(calc12(dataJson.headerUserBalance));
        }
      }
    });
}
function calc12(num) {
        var fixed = 2;
        var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
        return num.toString().match(re)[0];
    }
</script>