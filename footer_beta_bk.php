<div class="row">
	<div class="col-md-12">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Front page - 1 (dragonmartguide.com) -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1972450229731838"
     data-ad-slot="5058938508"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</div>
</div>
<footer class="footer1">
  <div class="container">
    <div class="row"><!-- row -->
      <div class="col_md-12 hidden-sm RKlink">
      	<h1>ibis hotel dragon mart</h1>
      	The iconic hotel apartments IBIS dragon mart, is just a walk way distance from dragon mart 1 and 2.
     	<h1>What's New At Dragon</h1>
     	Explore the new trends of dragon mart with plenty of new innovative life style and electronic gadgets.
     	<h1>China market Dubai</h1>
     	The only largest china collections in Dubai - Dragon mart, the complete collections of china made products at its best.
      	<?php
		  
//		  include('Connections/dragonmartguide.php');
//		  
//		  $Rqry = "SELECT * FROM `categories` WHERE `cate_main`!='999' and `status`='on' ORDER BY `cate_main` ASC ";
//		  $rlink = mysqli_query($db, $Rqry);
//		  while($RLrow = mysqli_fetch_array($rlink)){
//			  if(isset($RLrow['cate_level']) && $RLrow['cate_level'] == 2){
//				  echo "<a href='http://".$_SERVER['HTTP_HOST']."/search.php?search=".$RLrow['cate_main']."'>".$RLrow['cate_main']."</a> | ";
//			  }elseif($RLrow['cate_level'] == '3'){
//				 echo "<a href='http://".$_SERVER['HTTP_HOST']."/search.php?search=".$RLrow['cate_list']."'>".$RLrow['cate_list']."</a> | "; 
//			  }
//			  
//		  }
		  ?>
	  
      </div>
      <div class="col-lg-3 col-md-3"><!-- widgets column left -->
        <ul class="list-unstyled clear-margins">
          <!-- widgets -->
          
          <li class="widget-container widget_nav_menu"><!-- widgets list -->
            
            <h1 class="title-widget">Useful links</h1>
            <ul style="color:gold;">
              <li><a class="Rblink" href="http://www.trakhees.ae"><i class="fa fa-angle-double-right"></i> Trakhees</a></li>
              <li><a  class="Rblink" href="http://www.nakheel.com"><i class="fa fa-angle-double-right"></i> Nakheel</a></li>
              <li><a  class="Rblink" href="http://www.nakheel.com/en/corporate/our_divisions/
retail-corp"><i class="fa fa-angle-double-right"></i> Retail Corp</a></li>
              <li><a  class="Rblink" href="http://www.dubaided.gov.ae"><i class="fa fa-angle-double-right"></i> DED</a></li>
              <li><a  class="Rblink" href="http://www.thedubaimall.com"><i class="fa fa-angle-double-right"></i> Dubai Mall</a></li>
              <li><a  class="Rblink" href="http://www.malloftheemirates.com"><i class="fa fa-angle-double-right"></i> Mall of the Emirates</a></li>
              <li><a  class="Rblink" href="http://www.rakbank.ae"><i class="fa fa-angle-double-right"></i> RAK Bank</a></li>
              <li><a  class="Rblink" href="http://www.emiratesnbd.com"><i class="fa fa-angle-double-right"></i> Emirates NBD Bank</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- widgets column left end -->
      
      <div class="col-lg-3 col-md-3"><!-- widgets column left -->
        
        <ul class="list-unstyled clear-margins">
          <!-- widgets -->
          
          <li class="widget-container widget_nav_menu"><!-- widgets list -->
            
            <h1 class="title-widget">Youtube</h1>
            
				<div style="width: auto; height: 300px; overflow-y: scroll;">
            	<?php
	
					//Get videos from channel by YouTube Data API
				$API_key    = 'AIzaSyC5vPVHH2CKZbmLS4Il62RKzNXZMk8-SLI';
				$channelID  = 'UCC0Pvkw5TNhDECrVe_7Rdjg';
				$maxResults = 10;

				$videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelID.'&maxResults='.$maxResults.'&key='.$API_key.''));

					foreach($videoList->items as $item){
					//Embed video
					if(isset($item->id->videoId)){
					   ?>
									<?php 
									 echo $thumb_src = '<iframe width="100%" src="https://www.youtube.com/embed/'.$item->id->videoId.'?rel=0" frameborder="0" allowfullscreen></iframe>';
									?>
					<?php
					}
				}

				?>
			</div>

          </li>
        </ul>
      </div>
      <!-- widgets column left end -->
      
      <div class="col-lg-3 col-md-3"><!-- widgets column left -->
        
        <ul class="list-unstyled clear-margins">
          <!-- widgets -->
          
          <li class="widget-container widget_nav_menu"><!-- widgets list -->
            
            <h1 class="title-widget">Facebook</h1>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=149924948835237";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-page" data-href="https://www.facebook.com/Dragon-Mart-Guide-830670617022198/" data-tabs="timeline" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Dragon-Mart-Guide-830670617022198/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Dragon-Mart-Guide-830670617022198/">Dragon Mart Guide</a></blockquote></div>

<!--
            <ul>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Enquiry Form</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Online Test Series</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Grand Tests Series</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Subject Wise Test Series</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Smart Book</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Test Centres</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Admission Form</a></li>
              <li><a class="Rblink" href="#"><i class="fa fa-angle-double-right"></i> Computer Live Test</a></li>
            </ul>
-->
          </li>
        </ul>
      </div>
      <!-- widgets column left end -->
      
      <div class="col-lg-3 col-md-3"><!-- widgets column center -->
        
        <ul class="list-unstyled clear-margins">
          <!-- widgets -->
          
          <li class="widget-container widget_recent_news"><!-- widgets list -->
            
            <h1 class="title-widget">Contact Detail </h1>
            <div class="footerp">
              <h2 class="title-median">Dragon Mart Guide</h2>
              <p><b>Email id:</b> <a class="Rblink" href="mailto:enquiry@dragonmartguide.com">enquiry@dragonmartguide.com</a></p>
              <p class="Rbaddress"><b>Helpline Numbers (8AM to 10PM):</b> +971 50 253 6343 </p>
              <address class="Rbaddress">
              <b>Corp Office / Postal Address</b>
              </address>
              <address class="Rbaddress">
              <b>Phone Numbers : </b>+971 44 47 78 71
              </address>
              
            </div>
            <div class="social-icons">
              <ul class="nomargin">
                <a style="color:gold;" href="https://www.facebook.com/Dragon-Mart-Guide-830670617022198"><i class="fa fa-facebook-square fa-3x social-fb" id="social"></i></a> <a style="color:gold;" href="https://twitter.com/bootsnipp"><i class="fa fa-twitter-square fa-3x social-tw" id="social"></i></a> <a style="color:gold;" href="https://plus.google.com/+Bootsnipp-page"><i class="fa fa-google-plus-square fa-3x social-gp" id="social"></i></a> <a style="color:gold;" href="mailto:bootsnipp@gmail.com"><i class="fa fa-envelope-square fa-3x social-em" id="social"></i></a>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<div class="footer-bottom">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="copyright"> © 2015 - <?php echo date('Y'); ?>, Dragon Mart Guide.</div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <div class="design" style="text-align: center;">
      	<a href="privacy-policy.php">Privacy policy</a> |
      <a href="terms-of-use.php">Terms of use</a> |
      <a href="contact.php">Advertise with us</a>
      </div>
      
		</div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="design"> <a target="_blank" href="http://www.massdubai.com">Web design by Mass publishing LLC 5 star</a> </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54c50a6b175faf20"></script>

<?php include('floatingMenu.php'); ?>
<?php
//include("simple_html_dom.php");
//$dom = file_get_html('http://webappi.com/poweredBy/webappi.php');
//$divs = $dom->find('div#webappi');
//echo $divs[0];
?>
