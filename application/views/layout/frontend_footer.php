<?php
/**
 * Created by IntelliJ IDEA.
 * User: jonam
 * Date: 23/7/16
 * Time: 11:08 AM
 */


?>


<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

<!-- Counter Up  -->
<script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
<script src="assets/plugins/counterup/jquery.counterup.min.js"></script>

<!-- circliful Chart -->
<script src="assets/plugins/jquery-circliful/js/jquery.circliful.min.js"></script>
<script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- skycons -->
<script src="assets/plugins/skyicons/skycons.min.js" type="text/javascript"></script>

<!-- Page js  -->
<script src="assets/pages/jquery.dashboard.js"></script>

<!-- Custom main Js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
        $('.circliful-chart').circliful();
    });

    /* BEGIN SVG WEATHER ICON */
    if (typeof Skycons !== 'undefined'){
        var icons = new Skycons(
            {"color": "#00b19d"},
            {"resizeClear": true}
            ),
            list  = [
                "clear-day", "clear-night", "partly-cloudy-day",
                "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                "fog"
            ],
            i;

        for(i = list.length; i--; )
            icons.set(list[i], list[i]);
        icons.play();
    };

</script>

</body>

<!-- Mirrored from coderthemes.com/minton_1.6/green_hori/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jul 2016 21:45:33 GMT -->
</html>

