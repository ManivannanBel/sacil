
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    getLocation();
  });

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        var lo = document.getElementById("gpsloc");
        lo.value = "x+x";
      
    }
}

function showPosition(position) {
  var lo = document.getElementById("gpsloc");
  lo.value = position.coords.longitude+","+position.coords.latitude;
   
}
</script>
<div id="location_info" style=" display: block;">
    <input type="" name="gpsloc" id="gpsloc">   
  </div>  