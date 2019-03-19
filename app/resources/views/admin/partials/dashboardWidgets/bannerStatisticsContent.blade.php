<?php
/**
 * dashboard widget Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: $
 */
?>
<!--[if lte IE 8]><script src="includes/template/javascript/flot/excanvas.min.js"></script><![endif]-->
<script src="includes/template/javascript/flot/jquery.flot.min.js"></script>
<script src="includes/template/javascript/flot/jquery.flot.resize.min.js"></script>

  <div class="flot-x-axis">
    <div class="flot-tick-label"><?php echo $widget['graphTitle'] ?></div>
  </div>
  <div id="banner-widget" class="flot_chart"></div>

  <script>
  (function() {
    var bannerWidgetBox = $('#banner-statistics .widget-body');
    var boxHeight = bannerWidgetBox.height();
    if (boxHeight < 115) boxHeight = 115;
    $('#banner-widget').width(bannerWidgetBox.width()-10).height(boxHeight);
    var data = <?php echo json_encode($widget['graphDatasets']); ?> ;
    var options = <?php echo json_encode(array_merge($widget['graphOptions'], array('xaxis'=>array('ticks'=>$widget['graphTicks'])))); ?> ;
    var plot = $("#banner-widget").plot(data, options).data("plot");
  })();
  </script>
