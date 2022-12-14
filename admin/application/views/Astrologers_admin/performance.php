
<script>
window.onload = function () {

// user

var chart_user = new CanvasJS.Chart("chartContainer_user", {
  animationEnabled: true,
  theme: "light2",
  title:{
    text: ""
  },
  axisX:{
    valueFormatString: "DD MMM",
    crosshair: {
      enabled: true,
      snapToDataPoint: true
    }
  },
  axisY: {
    title: " Earnings",
    minimum: 0,
     maximum: <?php echo  $new_user_data_total->max_user + 100;  ?>,
    labelAngle: -180,
    crosshair: {
      enabled: true
    }
  },
  toolTip:{
    shared:true
  },  
  legend:{
    cursor:"pointer",
    verticalAlign: "bottom",
    horizontalAlign: "left",
    dockInsidePlotArea: true,
    itemclick: toogleDataSeries
  },
 
  data: [ <?php if (count($new_user_data) > 0): ?>{
  type: "area",
    showInLegend: true,
    name: "Amount",
    markerType: "triangle",
    xValueFormatString: "DD MMM, YYYY",
    color: "red",
    dataPoints: [
      <?php foreach ($new_user_data as $key): 
        $year= date('Y', strtotime($key->created_at));
        $month= date('m', strtotime($key->created_at." -1 month"));
        $day= date('d', strtotime($key->created_at))
      ?>
      { x: new Date(<?= $year.', '.$month.', '.$day ?>), y: <?=$key->score_user +0?> },
      <?php endforeach ?>
    ]
  }
  <?php endif ?>


  ]
});
chart_user.render();

function toogleDataSeries(e){
  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    e.dataSeries.visible = false;
  } else{
    e.dataSeries.visible = true;
  }
  chart.render();
}

}
</script>
      <div class="content-wrapper">
         <section class="content-header">
            <h1>
               Graph
               <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
             <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
               <li class="active">Graph</li>
            </ol>
         </section>
      
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">    
                 Last 30 Days Earnings
               </h3>
            </div>
            <section class="content">
               <div class="row">
                  <div id="chartContainer_user" style="height: 370px; width: 100%;">
                  
                  </div>
               </div>
            </section>
         </div>
         
      </div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
