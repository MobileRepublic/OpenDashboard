<?php
ini_set('display_errors', '0');
include('include/api.php');
$call = new Api;
$pie_rest = $call->getresult('pie');
$pie = $pie_rest['pie'];
$bar = $pie_rest['jbar'];
$yr = $pie_rest['yr'];
$total = $pie_rest['total'];
$asrr = $pie_rest['asrr'];
$line = $pie_rest['jlson'];
$statarr = $call->getresult('state');
$state = $pie_rest['state'];

//echo "<pre>";print_r($statarr);exit;
/*$tot2001 = $total['2001'];
$tot2006 = $total['2006'];
$tot2011 = $total['2011'];*/

 ?>	
<!DOCTYPE html>
<html>
  <head>    
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Employment Dashboard</title>
   <!--<script type="text/javascript" src="d3/d3.v2.js"></script>-->
   <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script src="http://d3js.org/d3.v2.js"></script>
	<!-- Note: I made good use of the sample code provided by the D3JS community and extended it to fit my needs to create this simple dashboard -->
    <link href="css/style.css" rel="stylesheet"> 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
     <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
    
	var tot2001 = "18,972,350";
	var tot2006 = "20,061,646";
	var tot2011 = "21,727,158";
     
	$(function() {
        $( "#slider" ).slider({
            value:400,
            min: 2001,
            max: 2011,
            step: 5,
            slide: function( event, ui ) {
		if(ui.value=="2011"){
                    $(".census_count").html(tot2011);
                }else if(ui.value=="2006"){
                    $(".census_count").html(tot2006);
                }else{
                    $(".census_count").html(tot2001);
                }
                updatedonut(ui.value);
            }
        });
    });
	
	$( document ).ready(function() {
        dsPieChart(2001);
		dsBarChart(2001);
		dsLineChart(2001);
		dsStackChart(2001,1);
		$("#slideval").val(2001);
        $(".census_count").html(tot2001);
    })
    
    function updatedonut(d) {
		$("#slideval").val(d);
        $("#pieChart").html('');               
		$("#barChart").html(''); 
		$("#lineChart").html(''); 
		$("#stackChart").html('');
		dsPieChart(d);
		dsBarChart(d);
		dsLineChart(d);
		
		if($("#dpState").val() == ""){
			dsStackChart(d,1);
		}else{
			dsStackChart($("#dpState").val(),2);
			if($("#dpState").val() == "Victoria")
			{
				$('#mapimag').attr('src', 'images/Victoria_'+d+'_all.jpg');
			}
		}
		
    }
    </script>

	<style>
		.barchart:hover { opacity:0.5;}
		
		.axis path,
		.axis line {
		  fill: none;
		  stroke: #000;
		  shape-rendering: crispEdges;
		}
		
		.x.axis path {
  display: none;
}
		
		.line {
  			stroke: steelblue;
  			stroke-width: 1.5px;
		}
		#lineChart svg { position:relative; top:0px; border:1px solid #060606;}
		#pieChart { padding-top:20px;}
		select { padding:5px; width:50%;}
	</style>
	
	
  </head>
  <body>
  
  
      <div id="slideout">
        <img alt="Other Datasets" src="images/otherdb.png">
        <div id="slideout_inner">
        <ul>
            <li>Crash Stats </li>
            <li>Birth Rates </li>
            <li>Housing </li>
        </ul>
        </div>
	</div>


      <div style="width:100%; float: left;">
          <h3 class="title" style="position:fixed; background:#f7f7f7; width:100%; float:left; z-index:999; color:#419dce; padding:10px 10px; line-height:50px; font-size:24px; border-bottom:1px solid #e5e5e5;">
              <div style="width:35%; float: left;">
                  <img src="images/Logo.png" alt="GovHack" style="float:left; height:50px; padding:0px 10px;"/>
              </div>
              <div style="width:65%; float: left;">
                  <a target="_new" href="http://hackerspace.govhack.org/content/open-dashboard
"> <span style="float:left; margin-left:7%;color:#cb355f;">Open Dashboard by Accendo Republic</span></a>
              </div>
          </h3>
          <div style="width:1004px; margin:90px auto 0 auto;background:#fff;">
              <div style="width:100%; float:left;">
                  
                  <div class="full-width" style="background:#fff;min-height:250px!important">
                      <div class="half-left" style="padding:7% 0 0 8%; margin: 0px; text-align:center; ">
                          <img src="images/header-img.jpg" align="header" alt="Census" usemap="#censusmap">
                          <map name="censusmap">
                              <area shape="circle" coords="338,60,40" href="http://www.goodcountry.org/country/AUS" target="_blank" alt="Venus">
                          </map>
                          <h5 class="crashNotext" style="margin:0; text-align:right; ">Good Country Index </h5>
                          <div class="census_text">
                              National Population<br/>
                              <span class="census_count"></span>
                          </div>
                      </div>
                      
                     	<div class="half-left" style="margin-top: 0px; padding-top:40px;background:#fff; text-align:center; min-height:250px!important">
						   <div id="lineChart"></div>
						   <h4 class="crashNotext subhead" style="margin:0;">Health Spend </h4>
                      	</div>
						<div style="clear:left;"> </div>
					</div>	 
				<div class="full-width">		  
					  <div class="half-left" style="margin-top: 0px;background:#fff; text-align:center; min-height:402px!important">
                          <div id="pieChart"></div>
						  <h4 class="crashNotext subhead">R&D Investment in $m </h4>
                      </div>
                      
                      <div class="half-left  border-right" style="background:#fff; text-align:center;">
                           <div id="barChart" style="padding-bottom:10px;"></div> 
						    <h4 class="crashNotext subhead" style="margin-left:20px;">Employment By Sector </h4>
                      </div>
				</div>
				 
				 <div class="full-width">
                      
					   
						  <div style="background: #fff; text-align: center; padding: 25px; ">
                          <!--/*<h4 class="crashNotext">Employment Based On Years </h4>*/-->
                          <div id="slider" style="width:auto" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all scale">
                              <a class="ui-slider-handle ui-state-default1 ui-corner-all" href="#" style="left: 20%; "></a>
                              <input type="hidden" value="" id="slideval"/>
                          </div>
						  
						  <div>
						    
						  </div>
                          <div class="steps">
                              <span style="display:inline-block;width: 7%;text-align:left;margin-right: 15%; float: left; position: relative;left:-1%;">|<br>2001</span>
                              <span style="display:inline-block;width: 7%;text-align:center;margin-right: 19%;">|<br>2006</span>
                              <span style="display:inline-block;width: 7%;text-align:center;margin-right: -4%; float: right;">|<br>2011</span>
                          </div>
                      </div>
					  
					  
                  </div>
                  
              </div>
			  
			  <div id="drildownmap" style="width:100%; float:left;background:#fff;">
        
					<div class="full-width">
						<div class="half-left map-img" style="background:#fff; text-align:center;height:470px;">
							<img id="mapimag" src="images/img0.jpg" alt="default" />
						</div>
						
						<div class="half-left" style="background:#fff; text-align:center;">
							
							<select onChange="updateStackChart(this.id);" id="dpState"> <option value="" selected="selected">Employment by State</option>
									  <?php foreach($state as $st){ ?>
									  <option value="<?php echo $st; ?>"><?php echo $st; ?> </option>
									  <?php } ?>
                    		</select>
							
							<div id="stackChart"></div>
				 			
							<div style="height=0;important!">
                    			<a href="javascript:void(0);" onClick="changeImage()" ><img src="images/btn-all.png" /> </a>
                			</div>	

						
						</div>
					</div>
					
					
				</div>
			  
			  
          </div>
      </div>
<script type="text/javascript">

	function changeImage(){
		if($("#dpState").val() == "Victoria")
		{
			$('#mapimag').attr('src', 'images/Victoria_'+$("#slideval").val()+'_all.jpg');
		}else{
			$('#mapimag').attr('src','images/img0.jpg');
		}
	}

  /*
    ################ FORMATS ##################
    -------------------------------------------
  */
    var     formatAsPercentage = d3.format("%"),
            formatAsPercentage1Dec = d3.format(".1%"),
            formatAsInteger = d3.format(","),
            fsec = d3.time.format("%S s"),
            fmin = d3.time.format("%M m"),
            fhou = d3.time.format("%H h"),
            fwee = d3.time.format("%a"),
            fdat = d3.time.format("%d d"),
            fmon = d3.time.format("%b")
            ;
    /*
    ############# PIE CHART ###################
    -------------------------------------------
    */
	var datasetPieChart = <?php echo $pie; ?>;
	// set initial group value
	//var group = "2001";
	function datasetPieChosen(group) {
		//alert(group);
		var ds = [];
		for (x in datasetPieChart) {        
		if(datasetPieChart[x].year==group){
				ds.push(datasetPieChart[x]);
				//alert(datasetPieChart[x].employment);
			}
		}
		return ds;
	}
	
	
    function dsPieChart(d){
        //alert(d); //datasetPieChosen(group)
		
        var dataset = datasetPieChosen(d);
		//alert(dataset);
        var width = 300,
            height = 300,
            	
			outerRadius = Math.min(width, height) / 2,
          //  innerRadius = outerRadius * .999,   
            // for animation
            innerRadiusFinal = outerRadius * .5,
            innerRadiusFinal3 = outerRadius* .45,
            color = d3.scale.category20()    //builtin range of colors
            ;	    
        var vis = d3.select("#pieChart")
                     .append("svg:svg")              //create the SVG element inside the <body>
                    .data([dataset])                   //associate our data with the document
                        .attr("width", width)           //set the width and height of our visualization (these will be attributes of the <svg> tag
                        .attr("height", height)
                        .on("mouseover", function (d) {
                            d3.select("#tooltip")       
                                        .style("left", d3.event.pageX + "px")
                                        .style("top", d3.event.pageY + "px")
                                        .style("opacity", 1)
                                        .select("#value")
                                        .text(function(d) { return d.measure; });   
                            })
                        .on("mouseout", function () {
                            // Hide the tooltip
                            d3.select("#tooltip")
                            .style("opacity", 0);
                        })
                        .append("svg:g")                //make a group to hold our pie chart
                        .attr("transform", "translate(" + outerRadius + "," + outerRadius + ")")    //move the center of the pie chart from 0, 0 to radius, radius
                    ;
            var arc = d3.svg.arc()              //this will create <path> elements for us using arc data
                                    .outerRadius(outerRadius);//.innerRadius(innerRadius);

    // for animation
    var arcFinal = d3.svg.arc().innerRadius(0).outerRadius(outerRadius);
    //var arcFinal3 = d3.svg.arc().innerRadius(innerRadiusFinal3).outerRadius(outerRadius);

    var pie = d3.layout.pie()           //this will create arc data for us given a list of values
    .value(function(d) { return d.measure; });    //we must tell it out to access the value of each element in our data array

    var arcs = vis.selectAll("g.slice")     //this selects all <g> elements with class slice (there aren't any yet)
    .data(pie)                          //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties) 
    .enter()                            //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
        .append("svg:g")                //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
           .attr("class", "slice")    //allow us to style things in the slices (like text)
           .on("mouseover", mouseover)
                            .on("mouseout", mouseout)
                            //.on("click", up)
                            ;

    arcs.append("svg:path")
           .attr("fill", function(d, i) { return color(i); } ) //set the color for each slice to be chosen from the color function defined above
                            .attr("d", arc)     //this creates the actual SVG path using the associated data (pie) with the arc drawing function
                            .append("svg:title") //mouseover title showing the figures
                            .text(function(d) { return d.data.category + ": " + d.data.measure; })
							;			

    d3.selectAll("g.slice").selectAll("path").transition()
                        .duration(750)
                        .delay(10)
                        .attr("d", arcFinal )
                        ;

      // Add a label to the larger arcs, translated to the arc centroid and rotated.
      // source: http://bl.ocks.org/1305337#index.html
      arcs.filter(function(d) { return d.endAngle - d.startAngle > .2; })
                    .append("svg:text")
          .attr("dy", ".35em")
          .attr("text-anchor", "middle")
          .attr("transform", function(d) { return "translate(" + arcFinal.centroid(d) + ")rotate(" + angle(d) + ")"; })
          //.text(function(d) { return formatAsPercentage(d.value); })
          //.text(function(d) { return d.data.category; })
          ;

       // Computes the label angle of an arc, converting from radians to degrees.
            function angle(d) {
                var a = (d.startAngle + d.endAngle) * 90 / Math.PI - 90;
                return a > 90 ? a - 180 : a;
            }


            // Pie chart title			
            vis.append("svg:text")
            	.attr("dy", ".35em")
          		.attr("text-anchor", "middle")
          		//.text("Employment Stat V/s Industry")
          		.attr("class","title");		    

    function mouseover() {
      d3.select(this).select("path").transition()
          .duration(750)
                            .attr("stroke","red")
                            .attr("stroke-width", 1.5)
                            //.attr("d", arcFinal3)
                            ;
    }

    function mouseout() {
      d3.select(this).select("path").transition()
          .duration(750)
                            .attr("stroke","")
                            .attr("stroke-width",0)
                            .attr("d", arcFinal)
                            ;
    }

    function up(d, i) {

							//alert(d.data.category);
						//updateBarChart(d.data.category, color(i));
					//	$("#barChart").html('');
					//	$('html,body').animate({scrollTop:$("#bardiv").offset().top - 59}, 1800);
						//updateStackChart(d.data.category,color(i));

    }
	
    }

//dsPieChart();

var datasetBarChart = <?php echo $bar; ?>;
var datasetLineChart = <?php echo $line; ?>;

/************* Line Graph Ends *********************/
function datasetLineChartChosen(group) {
	var ds = [];
	for (x in datasetLineChart) {
		 if(datasetLineChart[x].group==group){
		 	ds.push(datasetLineChart[x]);
		 } 
		}
	return ds;
}

function dsLineChartBasics() {

	var margin = {top: 20, right: 10, bottom: 0, left: 50},
	    width = 400 - margin.left - margin.right,
	    height = 150 - margin.top - margin.bottom
	    ;
		
		return {
			margin : margin, 
			width : width, 
			height : height
		}			
		;
}

function dsLineChart(group) {

	var firstDatasetLineChart = datasetLineChartChosen(group);    
	
	var basics = dsLineChartBasics();
	
	var margin = basics.margin,
		width = basics.width,
	   height = basics.height
		;

	var xScale = d3.scale.linear()
	    .domain([0, firstDatasetLineChart.length-1])
	    .range([0, width])
	    ;

	var yScale = d3.scale.linear()
	    .domain([0, d3.max(firstDatasetLineChart, function(d) { return d.measure; })])
	    .range([height, 0])
	    ;
	

	
	var line = d3.svg.line()
	    //.x(function(d) { return xScale(d.category); })
	    .x(function(d, i) { return xScale(i); })
	    .y(function(d) { return yScale(d.measure); })
	    ;
	
	var svg = d3.select("#lineChart").append("svg")
	    .datum(firstDatasetLineChart)
	    .attr("width", width + margin.left + margin.right)
	    .attr("height", height + margin.top + margin.bottom)
	    // create group and move it so that margins are respected (space for axis and title)
	    
	var plot = svg
	    .append("g")
	    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	    .attr("id", "lineChartPlot")
	    ;

		/* descriptive titles as part of plot -- start */
	var dsLength=firstDatasetLineChart.length;

	plot.append("text")
		.text(firstDatasetLineChart[dsLength-1].measure)
		.attr("id","lineChartTitle2")
		.attr("x",width/2)
		.attr("y",height/2)	
	
		;
	/* descriptive titles -- end */
	    
	plot.append("path")
	    .attr("class", "line")
	    .attr("d", line)	
	    // add color
		.attr("stroke", "lightgrey")
	    ;
	  
	plot.selectAll(".dot")
	    .data(firstDatasetLineChart)
	  	 .enter().append("circle")
	    .attr("class", "dot")
	    //.attr("stroke", function (d) { return d.measure==datasetMeasureMin ? "red" : (d.measure==datasetMeasureMax ? "green" : "steelblue") } )
	    .attr("fill", function (d) { return d.measure==d3.min(firstDatasetLineChart, function(d) { return d.measure; }) ? "red" : (d.measure==d3.max(firstDatasetLineChart, function(d) { return d.measure; }) ? "green" : "white") } )
	    //.attr("stroke-width", function (d) { return d.measure==datasetMeasureMin || d.measure==datasetMeasureMax ? "3px" : "1.5px"} )
	    .attr("cx", line.x())
	    .attr("cy", line.y())
	    .attr("r", 3.5)
	    .attr("stroke", "lightgrey")
	    .append("title")
	    .text(function(d) { return d.category + ": " + formatAsInteger(d.val); })
	    ;

	svg.append("text")
		.text("")
		.attr("id","lineChartTitle1")	
		.attr("x",margin.left + ((width + margin.right)/2))
		.attr("y", 10)
		;

}

/************* Line Graph Ends *********************/
/*
############# BAR CHART ###################
-------------------------------------------
*/

function datasetBarChosen(group) {
	var ds = [];
	for (x in datasetBarChart) {
		 if(datasetBarChart[x].group==group){
		 	ds.push(datasetBarChart[x]);
		 } 
		}
	return ds;
}

function dsBarChartBasics() {

		var margin = {top: 30, right: 5, bottom: 20, left: 50},
		width = 450 - margin.left - margin.right,
	    height = 360 - margin.top - margin.bottom,
		colorBar = d3.scale.ordinal().range(["#ffd810", "#c1ff24","#39b3f2","#fd5100","#32b3b8","#ff7eeb","#c9c9c9"]),
		barPadding = 1
		;
		
		return {
			margin : margin, 
			width : width, 
			height : height, 
			colorBar : colorBar, 
			barPadding : barPadding
		}			
		;
}

function dsBarChart(group) {			

	var firstDatasetBarChart = datasetBarChosen(group);         	
	
	var basics = dsBarChartBasics();
	
	var margin = basics.margin,
		width = basics.width - margin.left - margin.right,
	   height = basics.height - margin.top - margin.bottom,
		colorBar = basics.colorBar,
		barPadding = basics.barPadding
		;
					
	var 	xScale = d3.scale.linear()
						.domain([0, firstDatasetBarChart.length])
						.range([0, width])
						;
						
	// Create linear y scale 
	// Purpose: No matter what the data is, the bar should fit into the svg area; bars should not
	// get higher than the svg height. Hence incoming data needs to be scaled to fit into the svg area.  
	var yScale = d3.scale.linear()
			// use the max funtion to derive end point of the domain (max value of the dataset)
			// do not use the min value of the dataset as min of the domain as otherwise you will not see the first bar
		   .domain([0, d3.max(firstDatasetBarChart, function(d) { return d.measure; })])
		   // As coordinates are always defined from the top left corner, the y position of the bar
		   // is the svg height minus the data value. So you basically draw the bar starting from the top. 
		   // To have the y position calculated by the range function
		   .range([height, 0])
		   ;
	
	//Create SVG element
	
	var svg = d3.select("#barChart")
			.append("svg")
		    .attr("width", width + margin.left + margin.right)
		    .attr("height", height + margin.top + margin.bottom)
		    .attr("id","barChartPlot")
			
 		    ;
	
	var plot = svg
		    .append("g")
		    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
		    ;
	            
	plot.selectAll("rect")
		   .data(firstDatasetBarChart)
		   .enter()
		   
		   .append("rect")
		   .on('click',down)
		   .attr("class",'barchart')
			.attr("x", function(d, i) {
 			    return xScale(i);
			})
		   .attr("width", width / firstDatasetBarChart.length - barPadding)   
			.attr("y", function(d) {
 			    return yScale(d.measure);
			})  
			.attr("height", function(d) {
			    return height-yScale(d.measure);
			})
			.attr("fill", function(d, i) { return colorBar(i); } ) 
			.append("title")
  			.text(function(d) { return d.category; });
			;
	
		
	// Add y labels to plot	
	
	plot.selectAll("text")
	.data(firstDatasetBarChart)
	.enter()
	.append("text")
	.text(function(d) {
			return formatAsInteger(d3.round(d.measure));
	})
	.attr("text-anchor", "middle")
	
	// Set x position to the left edge of each bar plus half the bar width
	.attr("x", function(d, i) {
			return (i * (width / firstDatasetBarChart.length)) + ((width / firstDatasetBarChart.length - barPadding) / 2);
	})
	.attr("y", function(d) {
			return yScale(d.measure) + 14;
	})
	.attr("class", "yAxis")
	/* moved to CSS			   
	.attr("font-family", "sans-serif")
	.attr("font-size", "11px")
	.attr("fill", "white")
	*/
	;
	
	// Add x labels to chart	
	
	var xLabels = svg
		    .append("g")
		    .attr("transform", "translate(" + margin.left + "," + (margin.top + height)  + ")")
		    ;
	
	xLabels.selectAll("text.xAxis")
		  .data(firstDatasetBarChart)
		  .enter()
		  .append("text")
		  .text("")
		  .attr("text-anchor", "middle")
			// Set x position to the left edge of each bar plus half the bar width
						   .attr("x", function(d, i) {
						   		return (i * (width / firstDatasetBarChart.length)) + ((width / firstDatasetBarChart.length - barPadding) / 2);
						   })
		  .attr("y", 15)
		  .attr("class", "xAxis")

		  //.attr("style", "font-size: 12; font-family: Helvetica, sans-serif")
		  ;			
	 
	// Title
	
	svg.append("text")
		.attr("x", (width + margin.left + margin.right)/2)
		.attr("y", 15)
		.attr("class","title")				
		.attr("text-anchor", "middle")
		.text("")
		;
 	function down(d,i)
	{
 	   category = d.category;
	   //drildownmap
	   $('html, body').animate({
        scrollTop: $("#drildownmap").offset().top
    }, 2000);
	}	
	 
}

/************* Bar Graph Ends *********************/

/* updates bar chart on request */
var datasetStackedState = <?php echo $statarr; ?>; 
function datasetStackedBar(group) {
	yr = $("#slideval").val();
	var ds = [];
	for (x in datasetStackedState) {
		 if(datasetStackedState[x].group==group && datasetStackedState[x].year == yr){
		 	ds.push(datasetStackedState[x]);
		 } 
		}
	return ds;
}

/************** function to load stackgraph with state data ***********/

function updateStackChart(id)
{ 

	group = $('#'+id).val();
	yr = $("#slideval").val();
	if(group == "Victoria")
	{
		$('#mapimag').attr('src', 'images/Victoria_'+yr+'_all.jpg');
	}else
	{
		$('#mapimag').attr('src','images/img0.jpg');
	}
    $("#stackChart").html('');
	if(group == ""){
		dsStackChart(yr,1);
	}else{
		dsStackChart(group,2);      
	}
		      	
}

function dsStackChart(group,isdefault)
{
  if(isdefault == 1) { //Default Loading for the Data
  		firstDatasetStackChart = datasetBarChosen(group);
  }else{ // Loading Victoria Data
  		firstDatasetStackChart = datasetStackedBar(group);
  }		
  
  var killed = '[';
	for (i = 0; i < firstDatasetStackChart.length; i++) 
	{
	 
	  killed += "{month: '"+firstDatasetStackChart[i].category+"',count: "+firstDatasetStackChart[i].measure+"}";
	 
	if(i != firstDatasetStackChart.length-1)
	{
	  killed +=","; 
	}
	
	}
	killed += "]";
 	
	//alert(killed);alert(injured);
	
	var finaldata = "[{data: "+killed+",name: 'Males'}]";
 	// Create linear y scale 
	// Purpose: No matter what the data is, the bar should fit into the svg area; bars should not
	// get higher than the svg height. Hence incoming data needs to be scaled to fit into the svg area.  
	var yScale = d3.scale.linear()
	// use the max funtion to derive end point of the domain (max value of the dataset)
	// do not use the min value of the dataset as min of the domain as otherwise you will not see the first bar
	.domain([0, d3.max(firstDatasetStackChart, function(d) { return d.measure; })])
	// As coordinates are always defined from the top left corner, the y position of the bar
	// is the svg height minus the data value. So you basically draw the bar starting from the top. 
	// To have the y position calculated by the range function
	.range([height, 0])
	;
	 
  				
var margins = {
    top: 12,
    left: 48,
    right: 24,
    bottom: 24
},
legendPanel = {
    width: 180
},
    width = 450 - margins.left - margins.right - legendPanel.width,
    height = 381 - margins.top - margins.bottom,
    dataset =  eval("("+finaldata+")") ,
    series = dataset.map(function (d) {
        return d.name;
    }),
    dataset = dataset.map(function (d) {
        return d.data.map(function (o, i) {
            // Structure it so that your numeric
            // axis (the stacked amount) is y
            return {
                y: o.count,
                x: o.month
            };
        });
    }),
    stack = d3.layout.stack();

stack(dataset);

var dataset = dataset.map(function (group) {
    return group.map(function (d) {
        // Invert the x and y values, and y0 becomes x0
        return {
            x: d.y,
            y: d.x,
            x0: d.y0
        };
    });
}),
    svg = d3.select('#stackChart')
        .append('svg')
        .attr('width', width + margins.left + margins.right + legendPanel.width)
        .attr('height', height + margins.top + margins.bottom)
        .append('g')
        .attr('transform', 'translate(' + margins.left + ',' + margins.top + ')'),
    xMax = d3.max(dataset, function (group) {
        return d3.max(group, function (d) {
            return d.x + d.x0;
        });
    }),
    xScale = d3.scale.linear()
        .domain([0, xMax])
        .range([0, width]),
    months = dataset[0].map(function (d) {
        return d.y;
    }),
    _ = console.log(months),
    yScale = d3.scale.ordinal()
        .domain(months)
        .rangeRoundBands([0, height], .1),
    xAxis = d3.svg.axis()
        .scale(xScale)
        .orient('bottom'),
    yAxis = d3.svg.axis()
        .scale(yScale)
        .orient('left'),
	
    //colours = d3.scale.category10(),
	colours = d3.scale.ordinal().range(["#ffd810", "#c1ff24","#39b3f2","#fd5100","#32b3b8","#ff7eeb","#c9c9c9"]),
    groups = svg.selectAll('g')
        .data(dataset)
        .enter()
        .append('g')
        .style('fill', function (d, i) {
        return colours(i); }),
		
    rects = groups.selectAll('rect')
        .data(function (d) {
        return d;
    })
		.enter() 
		.append('rect')
		.on('click',downStack)
		.attr("class",'stackchart')
        .attr('x', function (d) { 
        return xScale(d.x0);
    })
        .attr('y', function (d, i) {
        return yScale(d.y);
    })
        .attr('height', function (d) {
        return yScale.rangeBand();
    })
        .attr('width', function (d) {
        return xScale(d.x);
    })
		.attr("fill", function(d, i) { return colours(i); } ) 
        .on('mouseover', function (d) {
        var xPos = parseFloat(d3.select(this).attr('x')) / 2 + width / 2;
        var yPos = parseFloat(d3.select(this).attr('y')) + yScale.rangeBand() / 2;

        d3.select('#tooltip')
            .style('left', xPos + 'px')
            .style('top', yPos + 'px')
            .select('#value')
            .text(d.x);

        d3.select('#tooltip').classed('hidden', false);
    })
        .on('mouseout', function () {
        d3.select('#tooltip').classed('hidden', true);
    })

   /* svg.append('g')
        .attr('class', 'axis')
        .attr('transform', 'translate(0,' + height + ')')
        .call(xAxis);

svg.append('g')
    .attr('class', 'axis xtextaxis')
    .call(yAxis);*/

/*svg.append('rect')
    .attr('fill', 'gray')
    .attr('width', 160)
    .attr('height', 30 * dataset.length)
    .attr('x', width + margins.left)
    .attr('y', 0);*/

/*series.forEach(function (s, i) {;
    svg.append('text')
        .attr('fill', 'black')
//	    .attr('class', 'xtextaxis')
        .attr('x', 270 + width + margins.left)
        .attr('y', i * 24 + 24)
        .text(s);
    svg.append('rect')
        .attr('fill', colours(i))
        .attr('width', 20)
        .attr('height', 20)
        .attr('x', width + margins.left + 75)
        .attr('y', i * 24 + 6);
});*/
	function downStack(d,i)
	{
		category = d.category;
		colorcode = $(this).attr('fill');
		colorcode = colorcode.replace("#","-");
		yr = $("#slideval").val();
		if($("#dpState").val() == "Victoria")
		{
			$('#mapimag').attr('src', 'images/Victoria_'+yr+'_'+colorcode.replace("-","")+'.jpg');
		}else{
			$('#mapimag').attr('src', 'images/default'+colorcode+'.jpg');	
		} 
	 	
	}
}


function updateBarChart(group, colorChosen) { //alert(group);

		var currentDatasetBarChart = datasetBarChosen1(group);
		alert(currentDatasetBarChart);
		var basics = dsBarChartBasics();
	
		var margin = basics.margin,
			width = basics.width,
		   height = basics.height,
			colorBar = basics.colorBar,
			barPadding = basics.barPadding
			;
		
		var 	xScale = d3.scale.linear()
			.domain([0, currentDatasetBarChart.length])
			.range([0, width])
			;
		
			
		var yScale = d3.scale.linear()
	      .domain([0, d3.max(currentDatasetBarChart, function(d) { return d.measure; })])
	      .range([height,0])
	      ;
	      
	   var svg = d3.select("#barChart svg");
	   var plot = d3.select("#barChartPlot")
	   	.datum(currentDatasetBarChart)
		   ;
	
	  		/* Note that here we only have to select the elements - no more appending! */
	  	plot.selectAll("rect")
	      .data(currentDatasetBarChart)
	      .transition()
			.duration(750)
			.attr("x", function(d, i) {
			    return xScale(i);
			})
		   .attr("width", width / currentDatasetBarChart.length - barPadding)   
			.attr("y", function(d) {
			    return yScale(d.measure);
			})  
			.attr("height", function(d) {
			    return height-yScale(d.measure);
			})
			.attr("fill", colorChosen)
			;
		 
		
		plot.selectAll("text.yAxis") // target the text element(s) which has a yAxis class defined
			.data(currentDatasetBarChart)
			.transition()
			.duration(750)
		   .attr("text-anchor", "middle")
		   .attr("x", function(d, i) {
		   		return (i * (width / currentDatasetBarChart.length)) + ((width / currentDatasetBarChart.length - barPadding) / 2);
		   })
		   .attr("y", function(d) {
		   		return yScale(d.measure) + 14;
		   })
		   .text(function(d) {
				return formatAsInteger(d3.round(d.measure));
		   })
		   .attr("class", "yAxis")					 
		;
		

		svg.selectAll("text.title") // target the text element(s) which has a title class defined
			.attr("x", (width + margin.left + margin.right)/2)
			.attr("y", 15)
			.attr("class","title")				
			.attr("text-anchor", "middle")
			.text(group + " Employment Number")
		;
}


    </script>
  </body>
</html>