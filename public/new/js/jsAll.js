<script>
  document.onreadystatechange = function () {
    var state = document.readyState
    if (state == 'interactive') {
    } else if (state == 'complete') {
        setTimeout(function(){
          document.getElementById('interactive');
          document.getElementById('load').style.visibility="hidden";
        },1000);
    }
  }

  var APP_URL = "http://diamondexch.com";
  var APP_NAME = "DIAMONDEXCH";
  var API_FRONT_BASE_URL = "http://diamondexch.com/api";
  var PUBLIC_PATH = "http://diamondexch.com/storage/";
  var SCOREBOARD_URL = "wss://sportsscore24.com";
  var SCORESTATS_URL = "https://royalexch999.com/d/scoreanimation";
  var dev_opts = {};
  var D_FRAME = "1";
  var REGISTER = "";
  var PAYMENT_ENABLE = "";
  var RECAPTCHA_SITE_KEY = "6LdB8XoUAAAAAPOghU04UiV1_cBhaebOFq81_rxP";
  Object.defineProperty(dev_opts, 'allow', {
      value: "",
      writable : false,
      enumerable : true,
      configurable : false
  });

  var placebet = {};

  Object.defineProperty(placebet, 'common', {
      value: "300",
      writable : false,
      enumerable : true,
      configurable : false
  });
  Object.defineProperty(placebet, 'oneday_poker', {
      value: "480",
      writable : false,
      enumerable : true,
      configurable : false
  });
  Object.defineProperty(placebet, 'six_poker', {
      value: "600",
      writable : false,
      enumerable : true,
      configurable : false
  });
  Object.defineProperty(placebet, 'open_teen', {
      value: "600",
      writable : false,
      enumerable : true,
      configurable : false
  });
  Object.defineProperty(placebet, 'andar_bahar', {
      value: "600",
      writable : false,
      enumerable : true,
      configurable : false
  });
  Object.defineProperty(placebet, 'cmeter', {
      value: "420",
      writable : false,
      enumerable : true,
      configurable : false
  });
  
  Object.freeze(placebet);
  Object.seal(placebet);
  Object.preventExtensions(placebet);
  
  var ipAddress = localStorage.getItem("clientAddr");
  var APK_URL = "http://sportsforallexch.com/app-diamond-release.apk";
  var DOMAIN = "diamondexch.com";
  var ENCRYPT_RESPONSE = "1";
</script>