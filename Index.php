<?php
$link = mysql_connect('db824.perfora.net', 'dbo282224548', '8mp3vWxp');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("db282224548") or die('Could not select db: ' . mysql_error()); 

$IPAddress = getIpAddress();
function getIpAddress() {
return (empty($_SERVER['HTTP_CLIENT_IP'])?(empty($_SERVER['HTTP_X_FORWARDED_FOR'])?
$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['HTTP_CLIENT_IP']);
}

putenv("TZ=PST8PDT");

$ClickedOn = date("Y/m/d");
$ClickedTime = date("h:i:s");
mysql_query("INSERT INTO Clicks(IPAddress,ClickedOn,ClickedTime)
VALUES('$IPAddress', '$ClickedOn', '$ClickedTime')");

$query = "SELECT * FROM PrayerTimes";	 
$result = mysql_query($query) or die('Could not select: ' . mysql_error());							
$row = mysql_fetch_array($result);

$query = "SELECT * FROM Ayahs WHERE Date='".date("Y-m-d")."'";
$result = mysql_query($query) or die('Could not select: ' . mysql_error());							
$ayahRow = mysql_fetch_array($result);

if(strlen($ayahRow['Quran'])<5){
	$query = "SELECT * FROM AyahCounter LIMIT 1";	
	$result = mysql_query($query) or die('Could not select: ' . mysql_error());	
	$acRow = mysql_fetch_array($result);	
	
	if(strtotime($acRow['CounterDate'])!=strtotime($ClickedOn)){
		$increment = ($acRow['AyahID']+1);
		if($increment==28 || $increment==247 || $increment==264){
			$increment=$increment+1;
		}
		else if($increment>374){
			$increment=1;
		}
		mysql_query("UPDATE AyahCounter SET AyahID =".$increment.",CounterDate='".$ClickedOn."'");
		$query = "SELECT * FROM AyahCounter LIMIT 1";	
		$result = mysql_query($query) or die('Could not select: ' . mysql_error());	
		$acRow = mysql_fetch_array($result);
	}
	$query = "SELECT * FROM Ayahs WHERE AyahID='".$acRow['AyahID']."'";
	$result = mysql_query($query) or die('Could not select: ' . mysql_error());							
	$ayahRow = mysql_fetch_array($result);
}

$query = "SELECT * FROM RamadanSchedule WHERE Date='".date("Y-m-d")."'";	 
$result = mysql_query($query) or die('Could not select: ' . mysql_error());							
$ramadanRow = mysql_fetch_array($result);

mysql_close($link);

if(strlen($ramadanRow['RamadanID'])==1){
	if($ramadanRow['RamadanID']=="1"){
		$rSuffix="st";
	}
	else if($ramadanRow['RamadanID']=="2"){
		$rSuffix="nd";
	}
	else if($ramadanRow['RamadanID']=="3"){
		$rSuffix="rd";
	}
	else{
		$rSuffix="th";
	}
}
else if(strlen($ramadanRow['RamadanID'])==2){
	if($ramadanRow['RamadanID']=="21"){
		$rSuffix="st";
	}
	else if($ramadanRow['RamadanID']=="22"){
		$rSuffix="nd";
	}
	else if($ramadanRow['RamadanID']=="23"){
		$rSuffix="rd";
	}
	else{
		$rSuffix="th";
	}
}
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">	
	<head>
		<meta name="generator" content="HTML Tidy for Windows (vers 12 April 2005), see www.w3.org">
		<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
		<link rel="stylesheet" href="images/altaqwaStyle.css" type="text/css">
		<link rel="stylesheet" href="images/tabber.css" TYPE="text/css" MEDIA="screen">	
		<script type="text/javascript" src="images/Ramadan.js"></script>	
		<script type="text/javascript" src="images/tabber.js"></script>	
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="images/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
		<script type="text/javascript" src="images/fancybox/jquery.fancybox-1.3.1.js"></script>		
		<link rel="stylesheet" type="text/css" href="images/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
		
		<script type="text/javascript">			
		$(document).ready(function() {
			
			$("a.zoom").fancybox();

			$("a.zoom1").fancybox({
				'overlayOpacity'	:	0.7,
				'overlayColor'		:	'#FFF'
			});

			$("a.zoom2").fancybox({
				'zoomSpeedIn'		:	500,
				'zoomSpeedOut'		:	500
			});
			
			$("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$("#various3").fancybox({
				'width'				: '250',
				'height'			: '250',
				'autoScale'			: true,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
			
			var currentTime = new Date();
			document.getElementById("TodaysDate").innerHTML=currentTime.toLocaleDateString();
			
											
			<?php 
			
			 /*Ramadan schedule (Un-comment this next Ramadan Insha-Allah)*/
				
				if(strlen($ramadanRow['IftarHour'])>0){
					echo 'countdown_Iftar('.$ramadanRow["IftarHour"].','.$ramadanRow["IftarMinute"].');';
				}
				else{
					echo 'document.getElementById("dvIftar").innerHTML = "O my Allah, for Thee, I fast, and with the food Thou gives me I break the fast, and I rely on Thee.";';
					echo '$("#dvIftarLabel").hide("slow");';
					echo '$("#dvIftar").css("padding-top","30px");';
				}
				
			 /*Ramadan schedule (Un-comment this next Ramadan Insha-Allah)*/
			 
			?>			
		});
		
		document.write('<style type="text/css">.tabber{display:none;}<\/style>');
		</script>		
		<script type="text/javascript">
			function bodyOnLoad(){
				
							
				
			}
		</script>
		<title>Masjid Al-Taqwa</title>
	</head>
	<body><!--<sup style="color:#291711;font-weight:lighter;">New</sup>-->
		<div id="mainDiv" align="center">
			<div id="header">
				<img id="Bismillah" src="images/MasjidHeaderFinal.gif" usemap="#menu" alt=""> 
				<map name="menu">
					<area shape="rect" coords="55,160,90,175" href="index.php" alt="Home">
					<area shape="rect" coords="100,160,155,175" href="aboutus.php"	alt="About Us">
					<area shape="rect" coords="165,160,228,175" href="contactus.php"	alt="Contact Us">
					<!--<area shape="rect" coords="238,160,278,175" href="activity.html" alt="Activities">-->
				</map>
			</div>
			<div id="spacer">
			</div>
			<table id="content" cellpadding=0 cellspacing=0>				
				<tr>
					<td id="LailahaIllalah">
						<div class="dvTopLeft">
							<img id="imgLailahaIllalah" src="images/lailahaillaLlahu1.gif"	alt="">
						</div>
					</td>
					<td id="content_right" rowspan="2" style="height:auto;">
						<div class="dvRight" style="overflow:hidden;margin-top:0px;padding-top:0px;height:auto;">
							<table>
								<tr>
									<td style="vertical-align:bottom;">
										<div class="tabber">
										 
											<!--<div class="tabbertab">
												<h2>Islamic Studies Classes</h2>
												<img style="float:left;" src="http://www.altaqwamasjid.com/images/fiqh.jpg"	alt="">
												<div style="margin-left:10px;padding-top:10px;text-align:center;">
												Alhamdulillah, Imam Jihad Safir's Islamic Studies class is held every Friday after Isha prayer, and is well attended.
												This class is informative and very well taught. Insha-Allah, we will post the class notes online.
												<br/><br/> <a style="font-weight:bold;" href="http://altaqwamasjid.com/IslamicStudiesClass.php">Get current notes..</a>
												</div>
											</div>-->
											
											
											<!--(Un-comment this next Ramadan Insha-Allah)-->
											
											<div class="tabbertab">
												<h2>Ramadan</h2>
												<img style="float:left;" src="http://www.altaqwamasjid.com/images/ramandan2011.jpg"	alt="">
												<div style="margin-left:10px;padding-top:20px;text-align:center;">
												 <p>O ye who believe! Fasting is prescribed to you as it was prescribed to those before you, that ye may (learn) self-restraint (2:183)</p>												 
									                        </div>
											</div>
											
											<!--(Un-comment this next Ramadan Insha-Allah)-->
											
											<!--(Consider deleting this Insha-Allah)
											<div class="tabbertab">
												<h2>Ramadan Begins!</h2>
												<img style="float:left;" src="http://www.altaqwamasjid.com/images/niger1.jpg"	alt="">
												<div style="margin-left:10px;padding-top:2px;text-align:center;">
												<span style="font-weight:bold;">Insha-Allah Friday, 7/20/2012 is the first Day of Ramadan.</span><br/>
												Thursday night is the first Taraweeh, Salat starts at 9:45 pm. Brother Tariq is our imam this Ramadan, he was with us three
												years ago and it was wonderful.<br/> 
												Please join us!
												</div>
											</div>
											<ul>
								          <li style="margin-bottom:6px;"><a style="font-weight:bold;" target="_blank" href="https://docs.google.com/viewer?a=v&pid=explorer&chrome=true&srcid=1f8CeXWXJeM4lQs8sAbzDcAE0-PTKdIS1Tg2lMVtXpep4PUy_YDaX_3R48P49&hl=en_US">Tuesdays - Sisters' Ramadan Halaqa</a></li>								                                                                                
										      <li style="margin-bottom:6px;"><a style="font-weight:bold;" target="_blank" href="https://docs.google.com/viewer?a=v&pid=explorer&chrome=true&srcid=1HpO11HxafN_s61SBmNTcuYjvVwmAA_p_sLQ-prMUFB6LUWjW7ST1QzeH9C76&hl=en_US">Sundays - Ramadan Ta'leem series</a></li>
									       </ul>
											-->
											
											<div class="tabbertab">
												<h2>Current</h2>
												<img style="float:left;" src="http://www.altaqwamasjid.com/images/events12272011.jpg"	alt="">
												<div style="float:right;width:370px;">
												 <ul>
												  <!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://docs.google.com/open?id=1t_PVcpGmZciEmW8nMjiHqB1TUMwDPgx8B0AjJDtFK2_lLuL0-o6Ipho-Z7F3">5<sup>th</sup> Annual Invited Guest Series</a><sup style="color:red;font-weight:lighter;font-style:italic;">New</sup></li>-->
												 	<!--<li style="margin-bottom:6px;"><a style="font-weight:bold;" href="http://www.altaqwamasjid.com/contactus.php">New Mailing Addres</a></li>-->
												  <!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://docs.google.com/open?id=1y2ukKBtxkdQk0PA_T1k6ei2lMhb3ibcmGlOmAW3EU5XKmA3BrJs5kh60W7mW">Ali's (RA) letter to his son (used in Juma Khutba)</a></li>-->
												  <!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://docs.google.com/open?id=1xpEohX7ApXmFzcoNfEMuC-52ASQq8g45YoH2ko3E_8j7WenSu_qMxhxUydTS">Masjid Suggestion Form</a></li>-->									
												  <!--<li style="margin-bottom:6px;"><a style="font-weight:bold;" href="https://docs.google.com/open?id=1d2eaSNPfa3bADOswpvQgBy-OHKhrSGtGNqPH-0XoAmOhzyum6ztov8CQB_c1">Family fun snow day</a></li>-->
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://docs.google.com/document/pub?id=1MpCRwTwRoebpyiws7fc26TCz8IJNsGa4g2S8RYosYmI">Reflection on Surah Kahf</a></li>-->													
													
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://drive.google.com/file/d/0B5XpVTjOtlqLaVY0Um9mQW5hVHBIaUl4cFhWeHNmZjgyVUxv/view?usp=sharing">December Calendar</a><sup style="color:#291711;font-weight:lighter;">New</sup></li>-->
													<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://www.flickr.com/photos/95261231@N08/sets/">Picture Albums</a></li>
													
													
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="http://www.flickr.com/photos/95261231@N08/sets/72157633321495440/">Masjid shoe drive and peace walk pictures</a></li>-->
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="http://www.flickr.com/photos/92961370@N06/sets/72157632694952969/">Masjid visit pictures</a></li>-->
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://docs.google.com/open?id=0B5XpVTjOtlqLeE53TUhVMXpWM2c">Masjid's Winter Drive</a></li>-->
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="http://www.brownpapertickets.com/event/348127">Purchase tickets for the Native Deen featuring event</a></li>-->													
													<!--<li style="margin-bottom:6px;"><a target="__blank" style="font-weight:bold;" href="https://docs.google.com/open?id=0B5XpVTjOtlqLN20xUHNyVnAyTE0">Sixth Annual Invited Giuest Series</a></li>-->													
												 </ul>
												</div>
											</div>
											
											<!--
											<div class="tabbertab">
												<h2>Quranic Classes</h2>
												<img style="float:left;" src="http://www.altaqwamasjid.com/images/QuranKid.jpg"	alt="">
												<div style="margin-left:10px;padding-top:20px;text-align:center;">
												Alhamdulillah, the Saturday kids Quranic class has been successfully underway for many months. The class is open
												for new enrollment.<br/> <a style="font-weight:bold;" href="http://altaqwamasjid.com/KQC.php">Learn more..</a>
												</div>
											</div>
											-->
											
											<!--
											<div class="tabbertab">												
												<h2>Events</h2>
												<table style="width:100%;color:#FBEB77;margin-top:10px;">													
													<tr>
														<td style="text-align:center;background-color:#CC7D29;">
															<a style="color:#FBEB77;font-weight:bold;" href="http://altaqwamasjid.com/cooking.php">Monthly Cooking Classes</a>																																												
														</td>
														<td style="text-align:center;background-color:#CC7D29;">
															<a style="color:#FBEB77;font-weight:bold;" href="http://altaqwamasjid.com/KQC.php">Kids' Quranic Classes</a>
														</td>
													</tr>
													<tr>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
													</tr>
													<tr>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
													</tr>
												</table>												
											</div>
											-->
											
											<!--
											<div class="tabbertab" style="vertical-align:middle;">												
												<h2>Activities</h2>
												<table style="width:100%;color:#FBEB77;margin-top:10px;">
													<tr>
														<td colspan="2" style="text-align:center;margin-bottom:10px;background-color:#8CA436;font-weight:bold;">Activities happening at Masjid Al-Taqwa</td>
													</tr>
													<tr>
														<td style="text-align:center;background-color:#CC7D29;">
															<a style="color:#FBEB77;font-weight:bold;" href="http://altaqwamasjid.com/FridayNightLecture.php">Friday Night Lecture Series</a>																																												
														</td>
														<td style="text-align:center;background-color:#CC7D29;">
															<a style="color:#FBEB77;font-weight:bold;" href="http://altaqwamasjid.com/KQC.php">Kids' Quranic Classes</a>
														</td>
													</tr>
													<tr>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
													</tr>
													<tr>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
														<td style="text-align:center;background-color:#CC7D29;">
															
														</td>
													</tr>
												</table>
												<div style="display:none;background-color:yellow;color:green;margin-top:5px;width:100%;text-align:center;">
												 <span style="background-color:yellow;color:green;">Please join us tonight for <a style="color:green;font-weight:bold;" href="http://altaqwamasjid.com/FridayNightLecture.php">Friday Night Lecture Series</a></span>
											    </div>
											</div>											
											-->
											
											<!--
											<div class="tabbertab">
												<h2>Welcome</h2>
												<img id="Ws" src="images/W.gif"	alt="">elcome to Masjid Al-Taqwa's website. Insha-Allah you will find it informational. The prayer times are updated promptly and the holy text of Quran and the hadith are updated daily.<br/><br/> Please use the 
												Masjid guest book to give us your feedback including suggestions for the Masjid, or this website. JazakAllah.
											</div>
											-->
											
											<div class="tabbertab">
												<h2>Multimedia</h2>
												<table style="width:100%;margin-top:20px;">
													<tr>
														<td style="text-align:center;font-weight:bold;">
															<a href="http://www.altaqwamasjid.com/JumahKhutba.php">Listen to Khutbah Recordings</a>
														</td>														
													</tr>													
												</table>												
											</div>											
											<div class="tabbertab">
												<h2>Links/Job Postings</h2>
												<table>
													<tr>
														<td>
															<a href="http://www.sunnipath.com" target="_blank">Sunnipath</a>
														</td>
													</tr>
													<tr>
														<td>
															<a href="http://english.aljazeera.net/" target="_blank">Al-Jazeera English</a>
														</td>
													</tr>
													<tr>
														<td>
															<a href="http://www.searchtruth.com" target="_blank"> Quran & Hadith Search</a>
														</td>
													</tr>
													<tr>
														<td>
															<a href="http://www.islamic-relief.com/" target="_blank"> Islamic-relief</a>
														</td>
													</tr>
                                                                                                        <tr>
														<td>
															<a href="https://docs.google.com/document/d/16dCffXlBtoAPD_b95SapJczju07TMqL8dX3dHB3DK8Y/edit?usp=sharing" target="_blank">Warehouse position</a>
														</td>
													</tr>
                                                                                                        <tr>
														<td>
															<a href="https://docs.google.com/document/d/1-GsdR_hdeyx2F0SC9zXGO919L6HKkQHPEOqm5aRoSO4/edit?usp=sharing" target="_blank"> Customer service position</a>
														</td>
													</tr>													
												</table>
											</div>											
										</div>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
								</tr>
							</table>							
							
							<!--Ramadan Announcement (Un-comment this a few days before Ramadan Insha-Allah)-->
							<!--
							<div style="width:577px;margin-left:3px;color:#473D19;text-align:center;background-color:#8CA436;font-size:14px;">
								Insha-Allah, Thursday, June 18<sup style="font-weight:lighter;">th</sup> will be the first day of Ramadan. Tonight will be first Taraweeh.
								<p style="font-weight:bold;">Isha at 9:40 PM<br/>Taraweeh prayer after Isha.</p>
							</div>
							-->
							<!--Ramadan Announcement (Un-comment this a few days before Ramadan Insha-Allah)-->
							
							<!--Ramadan (Un-comment this next Ramadan Insha-Allah)-->
							
							<div style="width:577px;margin-left:3px;color:#473D19;">
							 <img style="float:right;" src="http://www.altaqwamasjid.com/images/ramadan.jpg"	alt="">
							 <div id="dvIftarLabel" style="padding-top:10px;padding-left:20px;">
								<p style="font-weight:bold;"><?php echo $ramadanRow['RamadanID'] ?><sup style="font-weight:lighter;"><?php echo $rSuffix ?></sup> Ramadan Iftar Time: <?php echo " ".$ramadanRow['IftarTime']." "; ?>PM</p>
								<span>Time left for Iftar:</span>
							 </div>
							 <div id="dvIftar" style="padding-top:5px;text-align:center;margin-right:3px;">							 	
							 </div>
							</div>
												
							<!--Ramadan (Un-comment this next Ramadan Insha-Allah)-->

							<!--Eid Announcement (Un-comment this a few days before Eid Insha-Allah)-->
							<br /><br />                                                        
							<div style="width:577px;margin-left:3px;color:#473D19;text-align:center;">
                                                          <hr />
								Insha-Allah, <span style="font-weight:bold;">Friday, July 17<sup style="font-weight:lighter;">th</sup></span> will be Eid ul Fitr. Prayer will be at 8 AM sharp, followed by our traditional breakfast and Children's gift celebration at the Masjid.
                                                                <br /><span style="font-weight:bold;">Please bring your favorite breakfast item.</span>
                                                                <br /></br><a href="https://drive.google.com/file/d/0B5XpVTjOtlqLdWtNcUtOb3lPU1lWNXVpc29KbTlrc0lYbzRZ/view" target="_blank">Masjid Al-Taqwa is co-sponsoring Unity Eid LA on Saturday July 18th</a>
                                                                <br /><a href="http://events.r20.constantcontact.com/register/event?oeidk=a07eb48lupce6198e17&llr=d6cqsnlab" target="_blank">Eid Celebration at New Horizon Pasadena on Friday July 17th</a>
                                                          <hr />
							</div>
							<br />
							

							<!--Eid-Mubarak Announcement (Un-comment this the evening of Eid Insha-Allah)
							<div style="width:577px;margin-left:3px;color:#473D19;">
							 <img style="float:right;" src="http://www.altaqwamasjid.com/images/eid.jpg"	alt="">		 								
								<p style="font-weight:bold;">Takbeer starts at 7:30 AM Thursday at the Masjid.</p>				
								<p style="padding-top:5px;">Insha-Allah let's continue to come to the masjid the rest of the year in the same spirit that we had for Ramadan.</p>				
							</div>							
							-->

							<!--Dhul-Hijjah
							<div style="width:567px;padding:5px;margin-left:3px;color:#FBEB77;text-align:center;background-color:#CC7D29;font-weight:bold;">
								First ten days of Dhul-Hijjah
							</div>
							<div style="width:567px;height:80px;padding:5px;margin-left:3px;background-color:#FBEB77;color:black;">
								The first ten days of Dhul-hijjah are the most blessed days of the entire year. Please watch the video below to understand the importance of these days.<br /><br />
								Insha-Allah, Tuesday, October 15<sup style="font-weight:lighter;">th</sup> is Eid-ul-Adha. Takbeer starts at 7:30 AM at the Masjid.
							</div>							
							-->
							
							<!--Day of Arafat
							<div style="width:577px;margin-left:3px;color:#473D19;height:150px;">
							 <img style="float:left;" src="http://www.altaqwamasjid.com/images/arafat.bmp"	alt="">
							 <div style="padding-left:10px;padding-top:20px;text-align:center;">
							  <p>Insha-Allah, Monday, November 15<sup style="font-weight:lighter;">th</sup> is the <strong>Day of Arafat.</strong>
							  	 The Masjid will be arranging Iftar on this day and invites all to join. The time of Iftar will be 4:50 PM.</p>
							  <p><a id="various1" href="#inline1" title="Hadith about Day of Arafat"><strong>It is highly recommended to fast on this day.</strong></a></p>
							 </div>								
							</div>							
							<div style="display: none;">
								<div id="inline1" style="width:400px;height:100px;overflow:auto;">
									It was reported from Abu Qutaadah (may Allaah be pleased with him) that the Messenger of Allaah (peace and blessings of Allaah be upon him) was asked about fasting on the Day of Arafaah. He said, 'It expiates for the sins of the previous year and of the coming year.' Narrated by Muslim.
								</div>
							</div>
							-->
							
							<!--Eid-Al-Adha Announcement
							<p style="width:577px;margin-left:3px;color:#473D19;text-align:center;background-color:#8CA436;">
								<strong>Insha-Allah, Saturday, October 4<sup style="font-weight:lighter;">th</sup> will be Eid-Al-Adha. Takbeer starts at 8:30 AM and prayer at 9:00 AM at Masjid Al-Taqwa.</strong>
							</p>
							-->
							
							<!--Illustrated Surah Al-Asr
							<p style="width:577px;padding:5px;color:#473D19;text-align:left;background-color:#8CA436;">
								<strong>Alhamdulillah great video below! This is a short explaination of Surat-ul-Asr. Great for kids too.</strong>
							</p>
							-->							
							
							<table id="verses">
								<tr>
									<td>
										<img id="ayah" src="images/ayah.gif"	alt="">
										<div class="QuranHadith">
											<?php echo $ayahRow['Quran']." "; ?>
										</div>
									</td>
									<td>
										<img id="ayah2" src="images/hadith.gif"	alt="">
										<div class="QuranHadith">
											<?php echo $ayahRow['Hadith']." "; ?>
										</div>
									</td>
								</tr>
							</table>
							
							<!--
								<div style="margin-left:3px;text-align:center;padding-top:10px;padding-bottom:10px;background-color:#291711;border:solid 1px #CC7D29;width:574px;">
								 <a target="_blank" href="http://www.pbs.org/muhammad/virtualhajj.shtml"><img src="images/virtualHajj.jpg"	alt=""></a>
								</diV>
							-->
							<div style="margin-left:3px;text-align:center;padding-top:10px;padding-bottom:10px;background-color:#291711;border:solid 1px #CC7D29;width:574px;">							
									
									<!--<p style="color:white;">Imam Jihad Safir teaching a children's class</p>-->
									<!--<iframe title="YouTube video player" class="youtube-player" type="text/html" width="480" height="300" src="http://www.youtube.com/embed/0hwXWTUXGWc" frameborder="0" allowFullScreen></iframe>-->
									
									<!--Fajr Salat
							    <object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/goXV_zPo9ao?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/goXV_zPo9ao?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
							    -->
							    
							    <!--Is this the bext Quran-->
									<!--<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/uVmPgEE-0d8?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/uVmPgEE-0d8?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>-->
																											
									<!--Iran Quran Recitation-->
									<!--<iframe width="480" height="385" src="http://www.youtube.com/embed/jivNz_i9QTU" frameborder="0" allowfullscreen></iframe>-->
																										  
								  <!--O son of Adam Hadith-->
								  <!---->
								  <iframe width="480" height="385" src="http://www.youtube.com/embed/-Ed7lyvvS00" frameborder="0" allowfullscreen></iframe>
								  
								  <!--<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/-Ed7lyvvS00?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/-Ed7lyvvS00?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>-->								  
								  								  
								  <!--Hadith-->
									<!--<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/hTHH3NfOMpw?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/hTHH3NfOMpw?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>-->									
									
									<!--Azan-->
									<!--<iframe width="480" height="349" src="http://www.youtube.com/embed/mUHDYlJHaOQ" frameborder="0" allowfullscreen></iframe>-->
									<!--<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/5Ti2nhffpVc?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/5Ti2nhffpVc?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>-->
									
									<!--First ten days of Dhul-Hijja-->
									<!--<iframe width="420" height="315" src="http://www.youtube.com/embed/QDPJhI3WcrI" frameborder="0" allowfullscreen></iframe>-->
									<!--<iframe width="560" height="315" src="//www.youtube.com/embed/VTYHWSPiAbc" frameborder="0" allowfullscreen></iframe>-->
									
									<!--Somali Child-->
									<!--<iframe width="420" height="315" src="http://www.youtube.com/embed/GwMAJc1tvsY" frameborder="0" allowfullscreen></iframe>-->
									
									<!--Dawah behind bars-->
									<!--<iframe width="420" height="315" src="http://www.youtube.com/embed/qg8cMqbQMac" frameborder="0" allowfullscreen></iframe>-->
									
									<!--Nouman Ali Khan Khutba-->
									<!--Illustartions-->
									
									<!--
									<iframe width="560" height="315" src="//www.youtube.com/embed/-cGxv7ehfUU" frameborder="0" allowfullscreen></iframe>
									-->
									
									<!--<p style="color:white;">A  MUST WATCH VIDEO</p>-->
									<!--<iframe width="480" height="315" src="http://www.youtube.com/embed/0HyR3FeWv8w" frameborder="0" allowfullscreen></iframe>-->
									
									<!--
									<p style="color:white;">GREAT VIDEO!! MUST WATCH!!!</p>
									<iframe width="480" height="315" src="http://www.youtube.com/embed/yfflgF_H0kY" frameborder="0" allowfullscreen></iframe>
									-->
									
									
									<!--
									<p style="color:white;">GREAT VIDEO!! MUST WATCH!!!</p>
									<iframe width="560" height="315" src="http://www.youtube.com/embed/z4IiwrbXTGw" frameborder="0" allowfullscreen></iframe>
									-->
									<!--Nouman Ali Khan Khutba-->
									
									<!--Hijab-->
									<!--<iframe width="480" height="315" src="http://www.youtube.com/embed/arXHPNoszGE" frameborder="0" allowfullscreen></iframe>-->
									
									<!--
									<p style="color:white;">Please Watch and DONATE to your favorite AID agency</p>
									<iframe width="480" height="315" src="http://www.youtube.com/embed/ltgIOOWaupQ" frameborder="0" allowfullscreen></iframe>
									-->
									
									<!--
									<p style="color:white;">Very informative Zakah lecture</p>
									<iframe width="560" height="315" src="http://www.youtube.com/embed/0YHg2uaVers" frameborder="0" allowfullscreen></iframe>
									-->
									
							</diV>							
						</div>
					</td>
				</tr>
				<tr>
					<td id="tdBottomLeft">
					<div class="dvBottomLeft" style="height:auto;">						
					
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="MMHR4FXDBPT5C">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form><br/>
					
						<div id="TodaysDate" class="TodaysDate"></div><br/>
						<div class="TodaysDate" style="border-bottom:dotted 1px #FBEB77">Prayer Times</div>
						<table class="tblPrayer">
							<tr>
								<th scope="col" class="prayerName" style="width:50px;">Prayer</th>
								<th scope="col" style="width:50px;text-align:left;">Adhan</th>
								<th scope="col" style="width:50px;text-align:left;">Salat</th>
							</tr>
							<tr style="font-size:10pt;height:19px;">
								<td class="prayerName">Fajr</td>
								<td id="FA" align="left"><?php echo $row['FA']." "; ?>AM</td>
								<td id="FS" align="left"><?php echo $row['FS']." "; ?>AM</td>
							</tr>
							<tr style="font-size:10pt;height:19px;">
								<td class="prayerName">Zuhr</td>
								<td id="ZA" align="left"><?php echo $row['ZA']." "; ?>PM</td>
								<td id="ZS" align="left"><?php echo $row['ZS']." "; ?>PM</td>
							</tr>
							<tr style="font-size:10pt;height:19px;">
								<td class="prayerName">Asr</td>
								<td id="AA" align="left"><?php echo $row['AA']." "; ?>PM</td>
								<td id="AS" align="left"><?php echo $row['AS']." "; ?>PM</td>
							</tr>
							<tr style="font-size:10pt;height:19px;">
								<td class="prayerName">Maghrib</td>
								<td id="MA" align="left"><?php echo $row['MA']." "; ?></td>
								<td id="MS" align="left"><?php echo $row['MS']." "; ?></td>
							</tr>
							<tr style="font-size:10pt;height:19px;">
								<td class="prayerName">Isha</td>
								<td id="IA" align="left"><?php echo $row['IA']." "; ?>PM</td>
								<td id="IS" align="left"><?php echo $row['IS']." "; ?>PM</td>
							</tr>
							<tr style="font-size:10pt;height:19px;">
								<td class="prayerName">Jumah</td>
								<td id="JA" align="left"><?php echo $row['JA']." "; ?>PM</td>
								<td id="JS" align="left"><?php echo $row['JS']." "; ?>PM</td>
							</tr>
					  </table>
					  <br/>
					  <!--Masjid Iftar in news-->
						<a style="font-weight:bold;" href="http://www.pasadenanow.com/main/enduring-hotter-longer-days-local-muslims-celebrate-ramadan" alt="" target="__blank">Masjid Iftar in News</a><br/><br/>
						
					  <a href="http://altaqwamasjid.com/guestbook.php">Masjid Guest Book</a><br/><br/>
					  <a href="http://www.altaqwamasjid.com/JumahKhutba.php">Khutbah Recordings</a><br/><br/>					  
					  <a style="background-color:#8CA436;" href="http://www.altaqwamasjid.com/cooking.php?photono=1">Cooking Class Pictures</a><br/><br/>
						<a href="http://altaqwamasjid.com/IslamicStudiesClass.php">Islamic Studies Class Notes</a><br/><br/>
						
						<!--<a style="font-weight:bold;" href="http://www.altaqwamasjid.com/events.php">Events</a>-->						
						
						<!--
					  <p style="background-color:#8CA436;"><a href="http://www.youtube.com/user/altaqwamasjid#p/a">Taraweeh 2010 Videos</a></p>
						<a style="background-color:#8CA436;" href="http://www.altaqwamasjid.com/eid2010pics.php?photono=1">Eid 2010 Pictures</a><br/><br/>
						<a href="http://www.altaqwamasjid.com/photos.php?photono=10">Summer Camp Pictures</a>
						-->
						
					</div>
					</td>
				</tr>
			</table>	
			<table>
				<tr>
					<td style="font-size:xx-small;" align="center">
          	Copyright &copy; <?php echo date('Y').' Masjid Al Taqwa'?> <br/><img src="/tinc?key=NGnhHiM5">
          </td>		
        </tr>
      </table>
		</div>
	</body>
</html>
