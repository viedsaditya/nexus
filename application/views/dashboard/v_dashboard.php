<style>
/* .marquee {
  top: 1em;
  position: relative;
  box-sizing: border-box;
  animation: marquee 5s linear 0s infinite;
}
.marquee:hover {
  animation-play-state: paused;
}
@keyframes marquee {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(0, -100%);
  }
} */
</style>

<?php
    // if ($this->session->flashdata('pesan')) {
    //     echo '<div id="notif" class="alert alert-success alert-dismissible fade show" role="alert">
    //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                 <span aria-hidden="true">&times;</span>
    //             </button>';
    //     echo $this->session->flashdata('pesan');
    //     echo '</div>';
    // }
?>

<!-- <div id="previewimgdash">
</div> -->

<!-- Content Row -->
<div class="row">

    <!-- Card Example -->
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Pairing Flight</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800 count"><?= $totalflightdailypair ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-plane fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Schedule Arrival</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800 count"><?= $totalflightdailyarr ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-plane-arrival fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Schedule Departure</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800 count"><?= $totalflightdailydep ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-plane-departure fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Cancel Flight</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800 count"><?= $totalflightdailycancel ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ban fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- donut -->
    <div class="col-xl-12 col-lg-12 mb-3" style="display:none;">
      <div class="card shadow mb-2 mt-3">
        <div class="card-body">
          <div class="chart-pie">
            <!-- <canvas id="myPieChart"></canvas> -->
          </div>
        </div>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <marquee behavior="" direction=""><h6 class="m-0 font-weight-bold text-secondary">Welcome to Go Desktop : Stay Alert, Stay Healthy, Stay Alive...!</h6></marquee>
          <!-- <button title="Download Chart" onclick="dwc('aspos');" type="button" class="btn btn-tool">
            <i class="fas fa-"></i>
          </button> -->
        </div>
      </div>
    </div>

    <div class="col-xl-12 col-lg-12 mb-3">
      <div class="card shadow mb-2 mt-3">
          <div class="col mt-4">
              <div class="sidebar-brand-text d-flex align-items-center justify-content-center mx-auto" style="font-size:1.5vw;text-align:center;"><b>FLIGHT INFORMATION DISPLAY SYSTEM</b></div>
              
              <?php date_default_timezone_set("Asia/Bangkok"); ?>
              <div class="text-xs font-weight-bold text-gray text-uppercase d-flex align-items-center justify-content-center mx-auto" id="date_time" style="font-size:0.8vw"></div>   
          </div>
        <div class="card-body">
          <!-- FIDS -->
          <div class="container2">
            <!-- <div class="card shadow mb-4 mt-1">
              <div class="card-body"> -->
                <div class="table-responsive mb-4 mt-1">
                    <table class="table" id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                            <tr style='font-weight:bold'>
                                <th class="text-center">ARR</th>
                                <th class="text-center">DEP</th>
                                <th class="text-center">BAY</th>
                                <th class="text-center">GATE</th>
                                <th class="text-center">STA</th>
                                <th class="text-center">ETA</th>
                                <th class="text-center">ATA</th>
                                <th class="text-center">STD</th>
                                <th class="text-center">ETD</th>
                                <th class="text-center">ATD</th>
                                <!-- <th class="text-center">STATUS</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($seasonpairing as $key => $value) { ?>
                                <tr class="text-center">
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->arr_flightno ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->dep_flightno ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->arr_bay .'/'. $value->dep_bay ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->arr_gate .'/'. $value->dep_gate ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->arr_sta == NULL ? NULL:strtoupper(date('H:i', strtotime($value->arr_sta))) ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->arr_eta == NULL ? NULL:strtoupper(date('H:i', strtotime($value->arr_eta))) ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->arr_ata == NULL ? NULL:strtoupper(date('H:i', strtotime($value->arr_ata))) ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->dep_std == NULL ? NULL:strtoupper(date('H:i', strtotime($value->dep_std))) ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->dep_etd == NULL ? NULL:strtoupper(date('H:i', strtotime($value->dep_etd))) ?></td>
                                    <td style='text-align:center; padding-top: 20px;'><?= $value->dep_atd == NULL ? NULL:strtoupper(date('H:i', strtotime($value->dep_atd))) ?></td>
                                    <!-- <?php if ($value->d_flightstatus == 'OPERATED') { ?>
                                        <td class="bg-success" style='text-align:center; color:#fff; padding-top: 50px;'><div class="nprinsley-detaxt"><?= $value->d_flightstatus ?></div></td>
                                    <?php } else { ?>
                                        <td class="bg-danger" style='text-align:center; color:#fff; padding-top: 50px;'><?= $value->d_flightstatus ?></td>
                                    <?php } ?> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
          </div>
          <!-- FIDS -->
        </div>
      </div>
    </div>

</div>
<!-- Content Row -->

<script>
  $("#date_a").click(function(){
    $("#date_b").prop('required',true);
  });

  $(document).ready(function(){
    // $("#convertimgdash").on("click", function() {
    //   html2canvas(document.getElementById("htmlimgdash")).then(function (canvas) {			
    //     var anchorTag = document.createElement("a");
    //     document.body.appendChild(anchorTag);
    //     // document.getElementById("previewimgdash").appendChild(canvas);
    //     anchorTag.download = "jcp_dashboard.jpg";
    //     anchorTag.href = canvas.toDataURL();
    //     anchorTag.target = '_blank';
    //     anchorTag.click();
    //   });
    // });

    window.setTimeout(function() {
        $("#notif").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 4000); 

    new DataTable('#dataTable3', {
      fixedColumns: {
          start: 2,
          end: 0
      },
      scrollCollapse: true,
      scrollX: true,
      pageLength: 100,
      ordering: true,
      searching: true,
      paging: false,
      info: false
    });
  });

  $(window).keydown(function(event){
      if(event.keyCode === 13 && event.ctrlKey){
          return true;
      }else if(event.keyCode === 116 || event.keyCode === 13) {
          event.preventDefault();
          return false;
      }
  });

  $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, 
    {
        duration: 3000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now).toLocaleString('id-ID'));
    }
    });
  });	

  // function dwc(t){
	// 	var a = document.createElement('a');
		
	// 	if (t=="aspos"){
	// 		a.href = img1;
	// 		a.download = 'deposittopup.png';
	// 	}else if (t=="aspos2"){
	// 		a.href = img2;
	// 		a.download = 'cargoexportimport.png';
	// 	}else if (t=="aspos3"){
	// 		a.href = img3;
	// 		a.download = 'FBagLateReason.png';
	// 	}else if (t=="aspos4"){
	// 		a.href = img4;
	// 		a.download = 'LBagLateReason.png';
	// 	}

	// 	// trigger the download
	// 	a.click();
	// }

  // // DOUGHNUT
  // var img1 = "";
	// var img2 = "";
	// var img3 = "";
	// var img4 = "";
	
	// const plugin = {
	//   id: 'customCanvasBackgroundColor',
	//   beforeDraw: (chart,  args, options) => {
	// 	const {ctx} = chart;
	// 		ctx.save();
	// 		ctx.globalCompositeOperation = 'destination-over';
	// 		ctx.fillStyle = options.color || '#99ffff';
	// 		ctx.fillRect(0, 0, chart.width, chart.height);
	// 		ctx.restore();
	// 	},
	// };
	
	// const plugin2 = {
	// 	id: 'customImage',
	// 	 afterDraw: chart => {
	// 	  var ctx = chart.chart.ctx;
	// 	  ctx.save();
	// 	  var image = new Image();      
	// 	  image.src = '<?//php echo base_url('/assets/admin-template/img/jlogob.png'); ?>';     
	// 	  imageSize = 30;
	// 	  ctx.drawImage(image, chart.chart.width / 2 - imageSize / 2, (chart.chart.height+10) / 2, imageSize, imageSize);
	// 	  ctx.restore();
	// 	}
	// };

  // // agar tool tips muncul permanent
  // Chart.pluginService.register({
  //   beforeRender: function (chart) {
  //       if (chart.config.options.showAllTooltips) {
  //           chart.pluginTooltips = [];
  //           chart.config.data.datasets.forEach(function (dataset, i) {
  //               chart.getDatasetMeta(i).data.forEach(function (sector, j) {
  //                   chart.pluginTooltips.push(new Chart.Tooltip({
  //                       _chart: chart.chart,
  //                       _chartInstance: chart,
  //                       _data: chart.data,
  //                       _options: chart.options.tooltips,
  //                       _active: [sector]
  //                   }, chart));
  //               });
  //           });

  //           chart.options.tooltips.enabled = false;
  //       }
  //   },
  //   afterDraw: function (chart, easing) {
  //       if (chart.config.options.showAllTooltips) {
  //           if (!chart.allTooltipsOnce) {
  //               if (easing !== 1)
  //                   return;
  //               chart.allTooltipsOnce = true;
  //           }

  //           chart.options.tooltips.enabled = true;
  //           Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
  //               tooltip.initialize();
  //               tooltip.update();
                
  //               tooltip.pivot();
  //               tooltip.transition(easing).draw();
  //           });
  //           chart.options.tooltips.enabled = false;
  //       }
  //   }
  // });
    
	// var dc1 = $('#myPieChart').get(0).getContext('2d');
  // var aspos = new Chart(dc1, {
  //   type: 'doughnut',
  //   data: {
  //     labels: [
  //       'SQ',
  //       'MH',
  //       'NH',
  //       'SV',
  //       'CX',
  //       'QR',
  //       'BR',
  //       'MU',
  //       '3K',
  //       'EK',
  //       'EY',
  //       'PR',
  //       'TK',
  //       'QF',
  //       'OZ',
  //       'QR',
  //       '5J',
  //       'WY',
  //       '8K',
  //       'JX',
  //       'AK',
  //       'QZ',
  //       'QF',
  //       '8K',
  //       '8B',
  //       'IN',
  //       'FS',
  //       'JQ',
  //       'NZ',
  //       'FD',
  //     ],
  //     datasets: [
  //       {
  //         data: <?//php echo json_encode($all_code); ?>,
  //                 // backgroundColor: ['#f6c23e', '#1cc88a'],
  //                 // hoverBackgroundColor: ['#ffa500', '#17a673'],
  //                 // hoverBorderColor: "rgba(234, 236, 244, 1)",
  //         hoverOffset: 99,
  //         datalabels: {
  //           // color: '#8D8D8D',
  //           // font: {
  //           //   weight: 'bold',
  //           //   size: 12,
  //           // },
  //           // formatter: (value, ctx) => {
  //           //   let sum = ctx.dataset._meta[0].total;
  //           //   let percentage = (value * 100 / sum).toFixed(1) + "%";
  //           //   return value+' ('+percentage+')';
  //           // },
  //         }
  //       }
  //     ]
	//   },
  //   options: {
  //     // showAllTooltips: true,
  //     maintainAspectRatio : false,
  //     responsive : true,
  //     onClick: (e, item) => {
  //         if(item[0]){
  //           const xLabel = item[0]._view.label
  //           console.log(xLabel)
  //           }
  //         },
  //     animation: {
  //       onComplete: function () {
  //         img1 = aspos.toBase64Image();
  //       },
  //     },
  //     plugins: {
  //       customCanvasBackgroundColor: {
  //         color: 'white',
  //       },
  //     },
  //     tooltips: {
  //       xAlign: 'center',
  //       yAlign: 'bottom', 
  //       // callbacks: {
  //       //   afterLabel: function(tooltipItem, data) {
  //       //     var dataset = data.datasets[tooltipItem.datasetIndex];
  //       //     var meta = dataset._meta[Object.keys(dataset._meta)[0]];
  //       //     var total = meta.total;
  //       //     var currentValue = dataset.data[tooltipItem.index];
  //       //     var percentage = parseFloat((currentValue/total*100).toFixed(1));
  //       //     return '(' + percentage + '%)';
  //       //   }
  //       // }
  //     },
	//   },
	//   plugins: [plugin, plugin2],
		
  // });

	// var dc2 = $('#myPieChart2').get(0).getContext('2d');
  // var aspos2 = new Chart(dc2, {
  //   type: 'doughnut',
  //   data: {
  //     labels: [
  //       'EXPORT',
  //       'IMPORT',
  //     ],
  //     datasets: [
  //       {
  //         data: <?//php echo json_encode($all_sts);?>,
  //                 backgroundColor: ['#4e73df', '#1cc88a'],
  //                 hoverBackgroundColor: ['#2e59d9', '#17a673'],
  //                 hoverBorderColor: "rgba(234, 236, 244, 1)",
  //         hoverOffset: 99,
  //         datalabels: {
  //           color: 'white',
  //           font: {
  //             weight: 'bold',
  //             // size: 12,
  //           },
  //           formatter: (value, ctx) => {
  //             let sum = ctx.dataset._meta[1].total;
  //             let percentage = (value * 100 / sum).toFixed(1) + "%";
  //             return value+' ('+percentage+')';
  //           },
  //         }
  //       }
  //     ]
	//   },
  //   options: {
  //     // showAllTooltips: true,
  //     maintainAspectRatio : false,
  //     responsive : true,
  //     onClick: (e, item) => {
  //         if(item[0]){
  //           const xLabel = item[0]._view.label
  //           console.log(xLabel)
  //           }
  //         },
  //     animation: {
  //       onComplete: function () {
  //         img2 = aspos2.toBase64Image();
  //       },
  //     },
  //     plugins: {
  //       customCanvasBackgroundColor: {
  //         color: 'white',
  //       },
  //     },
  //     tooltips: {
  //       xAlign: 'center',
  //       yAlign: 'bottom',
  //       callbacks: {
  //         afterLabel: function(tooltipItem, data) {
  //           var dataset = data.datasets[tooltipItem.datasetIndex];
  //           var meta = dataset._meta[Object.keys(dataset._meta)[0]];
  //           var total = meta.total;
  //           var currentValue = dataset.data[tooltipItem.index];
  //           var percentage = parseFloat((currentValue/total*100).toFixed(1));
  //           return '(' + percentage + '%)';
  //         }
  //       }
  //     },
	//   },
	//   plugins: [plugin, plugin2],
		
  // });

function date_time(id) {
  date = new Date;
  year = date.getFullYear();
  month = date.getMonth();
  months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
  d = date.getDate();
  day = date.getDay();
  days = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
  h = date.getHours();

  if (h<10) {
    h = "0"+h;
  }
  m = date.getMinutes();
  if (m<10) {
    m = "0"+m;
  }
  s = date.getSeconds();
  if (s<10) {
    s = "0"+s;
  }

  result = ''+days[day]+', '+d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
  document.getElementById(id).innerHTML = result;
  setTimeout('date_time("'+id+'");','1000');

  return true;
}

window.onload = date_time('date_time');

setInterval(function(){
  window.location.reload(1);
}, 120000); // 1 menit 60000 = 10 menit 600000 = 2 menit 120000
</script>
