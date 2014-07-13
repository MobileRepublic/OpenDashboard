<?php
class Api {
 
   public function getresult($type) 
   {
       
	   switch($type)
	   {
	     case 'pie' :
                            $url = file_get_contents("json/employement.json");
                            $arr = json_decode($url,true);

                            $actarray = array();
                            $cat = array();
                            $exparrbar = array(); 
                            $exparrline = array();
							$totalcnt = array();
                            $i=0; 
                            foreach($arr as $data)
                            {                                
                                $actarray[$i]["year"] = trim($data["Time"]);
                                $actarray[$i]['state'] = trim($data["State"]);
                                $actarray[$i]["region"] = trim($data["Region Type"]);
                                $actarray[$i]["industry"] = trim($data["Industry of Employment"]);
                                $actarray[$i]["gender"] = trim($data["Sex"]);
                                $actarray[$i]["emp_value"] = trim($data["Value"]);
                                $yr[$i] = trim($data["Time"]);
								$company[$i] = trim($data["Industry of Employment"]);
								$stat[$i] = trim($data["State"]); 
                                $total =  $i;
                                $i++;
                            }
                            $yr = array_unique($yr);
                            sort($yr); 
							$company = array_unique($company);
							$stat = array_unique($stat);                           
                            /****/
                            
							$expB = array();
                           // print_r($actarray);
							foreach($actarray as $dt)
                            {                                
                                $expp[$dt['year']][$dt['industry']]["employment"] += $dt['emp_value'];
								//$expp[$dt['year']]["totalcnt"] += $dt['emp_value'];
								
								if($dt['gender'] == "Males"){
									$expB[$dt['year']][$dt['industry']]["male_cnt"] += $dt['emp_value'];
								}elseif($dt['gender'] == "Females"){
									$expB[$dt['year']][$dt['industry']]["female_cnt"] += $dt['emp_value'];
								}
								
                            }
							
							$i=0;
							foreach($expp as $key=>$val){
								foreach($val as $ky=>$vl){
									$exparrbar[$i]["group"] = $key;
									$exparrbar[$i]["category"] = $ky;
									$exparrbar[$i]["measure"] = $vl['employment'];
									$i++;
								}
							}
							
							//print_r($exparrbar);exit;
							
							$urlpie = file_get_contents("json/budget.json");
                            $arrpie = json_decode($urlpie,true);
							$finalpiedata = array();$i=0;
							$colors = array('#88BB88','#8AA8CC','#8888CC','#AA8888');
							$piearr = array();

							foreach($arrpie as $arpie){ 
									$piearr[2001][$arpie['BugEstimate']] = $arpie['2001-02'];
									$piearr[2006][$arpie['BugEstimate']] = $arpie['2006-07'];
									$piearr[2011][$arpie['BugEstimate']] = $arpie['2011-12'];
							}
							
							foreach($piearr as $ky=>$va){
								foreach($va as $key=>$val){
									$finalpiedata[$i]['year'] = $ky;
									$finalpiedata[$i]['category'] = $key;
									$finalpiedata[$i]['measure'] = $val;
									$finalpiedata[$i]['color'] = $colors[rand(0,3)];
									$i++;
								}
							}
													
							$finalBM = array();	$i=0; $finalBF = array();
                            foreach($expB as $key=>$dat){
								foreach($company as $ct)
								{
									/*$finalBM[$i]["year"] = $key;*/
									/*$finalBF[$i]["year"] = $key;*/
									$finalBM[$i]["group"] = $key;
									$finalBF[$i]["group"] = $key;
									if(isset($dat[$ct])){
										if(isset($dat[$ct]["male_cnt"])){
											$finalBM[$i]["category"] = $ct;
											$finalBM[$i]["measure"] = $dat[$ct]["male_cnt"];
										}else{
											$finalBM[$i]["category"] = $ct;
											$finalBM[$i]["measure"] = 0;
										}
										
										if(isset($dat[$ct]["female_cnt"])){
											$finalBF[$i]["category"] = $ct;
											$finalBF[$i]["measure"] = $dat[$ct]["female_cnt"];
										}else{
											$finalBF[$i]["category"] = $ct;
											$finalBF[$i]["measure"] = 0;
										}
										
									}else{
										$finalBM[$i]["category"] = $ct;
										$finalBM[$i]["measure"] = 0;
										$finalBF[$i]["category"] = $ct;
										$finalBF[$i]["measure"] = 0;
									}
									$i++;
								}
							}
							
							$urlhealth = file_get_contents("json/health.json");
                            $arrhealth = json_decode($urlhealth,true);
							$i=0; //print_r($arrhealth);exit;
							foreach($arrhealth as $arhlt)
							{   
								$exparrline[$i][2001]['measure'] = $arhlt['2001-02'];
								$exparrline[$i][2001]['category'] = $arhlt['Sum of real_expenditure_millions'];
								$exparrline[$i][2006]['measure'] = $arhlt['2006-07'];
								$exparrline[$i][2006]['category'] = $arhlt['Sum of real_expenditure_millions'];
								$exparrline[$i][2011]['measure'] = $arhlt['2011-12'];
								$exparrline[$i][2011]['category'] = $arhlt['Sum of real_expenditure_millions'];
								$i++;	
							}
							$expLinearray = array();
							$i=0;
							foreach($exparrline as $ftset){
								foreach($ftset as $k=>$final){ //print_r($final);exit;
									$expLinearray[$i]['group'] = $k;
									$expLinearray[$i]['category'] = $final['category'];
									$expLinearray[$i]['measure'] = $final['measure']/1000;
									$expLinearray[$i]['val'] = $final['measure'];
									$i++;
								}
							}
 						 //  print_r($stat);exit;
					   return array('pie'=>json_encode($finalpiedata),
		 			   'jbar'=>json_encode($exparrbar),
					   'jlson'=>json_encode($expLinearray),
					   'yr'=>$yr,
					   'state'=>$stat
					   );					
		 				break;
						
		case 'state' :	
						$url = file_get_contents("json/employement.json");
                        $arr = json_decode($url,true);
						
						$actarray = array();
						$cat = array();
						$exparrbar = array(); 
						$exparrline = array();
						$totalcnt = array();
						$i=0; 
						foreach($arr as $data)
						{                                
							$actarray[$i]["year"] = trim($data["Time"]);
							$actarray[$i]['state'] = trim($data["State"]);
							$actarray[$i]["region"] = trim($data["Region Type"]);
							$actarray[$i]["industry"] = trim($data["Industry of Employment"]);
							$actarray[$i]["gender"] = trim($data["Sex"]);
							$actarray[$i]["emp_value"] = trim($data["Value"]);
							$yr[$i] = trim($data["Time"]);
							$company[$i] = trim($data["Industry of Employment"]);
							$stat[$i] = trim($data["State"]); 
							$total =  $i;
							$i++;
						}
						$yr = array_unique($yr);
						sort($yr); 
						$company = array_unique($company);
						$stat = array_unique($stat); 
						
						$statedt = array();
						$statarray = array();$i=0;
						foreach($actarray as $dt)
						{                                
							$statedt[$dt['year']][$dt["state"]][$dt['industry']] += $dt['emp_value'];
						}
//							echo'<pre>';print_r($statedt);exit;
						
						foreach($statedt as $key=>$st){

							foreach($stat as $ct)
							{
								foreach($company as  $t=>$cp){
										$statarray[$i]['year']=$key;
										$statarray[$i]['group']=$ct;
										$statarray[$i]['category']= $cp;
										$statarray[$i]['measure']=$st[$ct][$cp];
										$i++;
									}
							}
						}
						return json_encode($statarray);	
						break;				
	   }
   }
   public function gettotaltrash()
   {
		$url = file_get_contents("json/ABS_CENSUS2011_T33_Data.json");
		$arr = json_decode($url,true);
		$total =  count($arr['Value']);
		return $total;
   }
    
 
}
?>