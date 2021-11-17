<?php
//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}

include("Connections/dragonmartguide.php");
include("Connections/frontend_function.php");

if(isset($_GET['search']) && $_GET['search'] != ''){$Skeywords = $_GET['search'];
//if(isset($_GET['mall']) && $_GET['mall'] != ''){$mall = $_GET['mall'];}
//if(isset($_GET['rate']) && $_GET['rate'] != ''){$rate = ', ';}
//
//
//
//$qs

$wordings = extractCommonWords($Skeywords);
	$qury1 = "";
if(count($wordings) > 1){
	foreach($wordings as $iwords){
		$qury1.= " OR sd.shop_name like '%$iwords%' OR sd.shop_mall like '%$iwords%' OR sd.shop_address like '%$iwords%' OR sd.shop_picture like '%$iwords%' OR pd.prodt_category like '%$iwords%' OR pd.prodt_name like '%$iwords%' OR pd.prodt_picture like '%$iwords%' OR pd.prodt_description like '%$iwords%' OR pd.prodt_specifications like '%$iwords%' OR pd.prodt_brand like '%$iwords%'";
	}
}
													
$SkeywordSearch = $Skeywords;


$qury0= "Select * from shop_details AS sd inner join product_details AS pd on sd.shop_id = pd.prodt_company_id where (sd.shop_name like '%$Skeywords%' OR sd.shop_mall like '%$Skeywords%' OR sd.shop_address like '%$Skeywords%' OR sd.shop_picture like '%$Skeywords%' OR pd.prodt_category like '%$Skeywords%' OR pd.prodt_name like '%$Skeywords%' OR pd.prodt_picture like '%$Skeywords%' OR pd.prodt_description like '%$Skeywords%' OR pd.prodt_specifications like '%$Skeywords%' OR pd.prodt_brand like '%$Skeywords%'$qury1) AND sd.shop_status = 'on' AND pd.prodt_status = 'on'  ORDER BY sd.shop_priv_type ASC, shop_view_count DESC";

$Squery0 = mysqli_query($db, $qury0);
$total = mysqli_num_rows($Squery0);													
													
$adjacents = 3;
$targetpage = "search.php"; //your file name
$limit = 5; //how many items to show per page
$page = $_GET['page'];
$Psarch = $Skeywords;

if($page){ 
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}

/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1









$qury= "Select * from shop_details AS sd inner join product_details AS pd on sd.shop_id = pd.prodt_company_id where (sd.shop_name like '%$Skeywords%' OR sd.shop_mall like '%$Skeywords%' OR sd.shop_address like '%$Skeywords%' OR sd.shop_picture like '%$Skeywords%' OR pd.prodt_category like '%$Skeywords%' OR pd.prodt_name like '%$Skeywords%' OR pd.prodt_picture like '%$Skeywords%' OR pd.prodt_description like '%$Skeywords%' OR pd.prodt_specifications like '%$Skeywords%' OR pd.prodt_brand like '%$Skeywords%' $qury1) AND sd.shop_status = 'on' AND pd.prodt_status = 'on'  ORDER BY sd.shop_priv_type ASC, shop_view_count DESC limit $start ,$limit ";
//echo $qury;
$Squery = mysqli_query($db, $qury);

}else{$Squery = "";}
?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home - Dragon Mart Guide - Dubai - China Mall</title>
<link rel="icon" type="image/png" href="images/favicon.png">
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap.css" />-->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" >
<!--<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.css" />
<link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css" />-->
<link type="text/css" rel="stylesheet" href="css/mystyle.css" >
<link rel="stylesheet" href="css/font-awesome.min.css">

<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
<!--<script type="text/javascript" src="js/bootstrap.js" ></script>-->
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" ></script>-->

<!-- Insert to your webpage before the </head> -->
<script src="carouselengine/jquery.js"></script>
<script src="carouselengine/amazingcarousel.js"></script>
<link rel="stylesheet" type="text/css" href="carouselengine/initcarousel-1.css">
<script src="carouselengine/initcarousel-1.js"></script>


<!--<script src="carouselengine/amazingcarousel.js"></script>-->
<link rel="stylesheet" type="text/css" href="carouselengine3/initcarousel-3.css">
    <script src="carouselengine3/initcarousel-3.js"></script>
<!-- End of head section HTML codes -->

<script type="text/javascript" src="js/banner.js"></script>
<script type="text/javascript">
jQuery(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})
</script>

<style>
/****** Style Star Rating Widget *****/
.rating { 
  border: none;
  float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
  margin: 1px;
  font-size: 14px;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before { 
  content: "\f089";
  position: absolute;
}

.rating > label { 
  color: #ddd; 
 float: right; 
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

.rating > input:checked + label:hover, /* hover current star when changing rating */
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
</style>

</head>

<body>
<?php
include('header.php');

?>

<!-- company containtr start -->
<div class="container-fluid" style="margin-bottom:20px;">
	<div class="row">
		<div class="col-md-12" >
			<img style="width:100%;" alt="Search Advertisement" src="images/advertisements/searchAds.jpg" />
		</div>
	</div>
  
    
    <div class="row">
		<div class="col-md-12">
			<h3 class="text-info" style="border-bottom:solid 3px gold; margin-bottom:25px;">
				<span style="text-transform:uppercase;"><span id="Scount"></span> Results for</span> <b>"<?php if(isset($SkeywordSearch)){echo $SkeywordSearch;}else{echo "No search";}  ?>"</b>
			</h3>
		</div>
	</div>
    
    
	<div class="row">
		<div class="col-md-2 col-sm-4 col-xs-12">
        	<div class="list-group">
              <a href="#" class="list-group-item" style="color:gold; background-color:#333333; border:solid 1px #333333; font-weight:bold;"> Quick Search </a>
              <?php if(isset($_GET['q'])) {$q = $_GET['q'];}else{$q = "null";} ?>
              <a href="?q=Dragon Mart 1" class="list-group-item<?php if($q=="Dragon Mart 1"){echo " active";}?>">Dragon Mart 1</a>
              <a href="?q=Dragon Mart 2" class="list-group-item<?php if($q=="Dragon Mart 2"){echo " active";}?>">Dragon Mart 2</a>
              <a href="?q=Featured" class="list-group-item<?php if($q=="Top Rated"){echo " active";}?>">Featured</a>
              <a href="?q=Most Viewed" class="list-group-item<?php if($q=="Most Viewed"){echo " active";}?>">Most Viewed</a>
              <a href="?q=Latest Products" class="list-group-item<?php if($q=="Latest Products"){echo " active";}?>">Latest Products</a>
            </div>
		</div>
        <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="row" id="row">
        

        
	<?php
			$TotalSearchCount = 0;
			if(isset($Squery) && $Squery != ''){
			while($row = mysqli_fetch_array($Squery)){
	?>
        <div class="col-md-12 col-sm-12 col-xs-12 RsrchListM">
        	<div class="col-md-2 col-sm-2 col-xs-12"><a href="#" class="thumbnail">
      <?php
		if(isset($row['prodt_picture']) && $row['prodt_picture'] != ''){
			echo "<img src='".$row['prodt_picture']."' alt='".$row['prodt_name']."'>";
		}elseif(isset($row['shop_picture']) && $row['shop_picture'] != ''){
			echo "<img src='".$row['shop_picture']."' alt='".$row['shop_name']."'>";
		}else{
			echo "<img src='templogo.jpg' alt='temp img'>";
		}	
	 ?>
      
      
      
    </a></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
            	
            	<header>
              <?php
				
				if(isset($row['prodt_name']) && $row['prodt_name'] != ''){
				
               echo "<span class='Rheartf'><i class='fa fa-heart' aria-hidden='true' title='My Favorite'></i></span> <a title='Product Name' href='productdetails.php?pt=".$row['prodt_id']."&sh=".$row['shop_id']."'>".strip_tags($row['prodt_name'])."</a> | "; 
              
				}
				
				if($row['shop_mall'] == 'Dragon Mart 1'){$dmg = 'DM1';}elseif($row['shop_mall'] == 'Dragon Mart 2'){$dmg = 'DM2';}
					?>
              <a title="Shop Name" href="companydetails.php?sh=<?php echo $row['shop_id']; ?>"><?php echo strip_tags($row['shop_name']); ?></a> <span class="btn btn-default" style="padding: 0 5px !important;" title="<?php echo $row['shop_mall']; ?>"><?php echo $dmg; ?></span></header>
               <?php
				if(isset($row['prodt_description']) && $row['prodt_description'] != ''){
					echo "<p>".substr(strip_tags($row['prodt_description']), 0, 150)."...</p>";
				}else{echo "<p>".substr(strip_tags($row['shop_description']), 0, 150)."...</p>";}
				?>
                
                <?php
				
				if(isset($row['prodt_category'])){$catePrint = json_decode($row['prodt_category'], true);}
				
				if(isset($catePrint)){
					echo "<pre>";
					foreach($catePrint as $key => $cateArray){
						if(isset($cateArray['cate_level'])){$catLevel = $cateArray['cate_level'];}else{$catLevel = '';}
												
						if($catLevel == 2){echo $cateArray['cate_main'].", ";}
						elseif($catLevel == 3){echo $cateArray['cate_list'].", ";}
					}
					echo "</pre>";
				}
				
				?>
              
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
            <p>Views (<?php if(isset($row['prodt_views_count'])){echo $row['prodt_views_count'];}else{echo '0';} ?>)</p>
            <p>
            <fieldset class="Rrate rating">
     <input type="radio" checked="checked" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
    <input type="radio" checked="checked" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
    <input type="radio" checked="checked" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
        </fieldset>
        </p>

            <p>
            
            Review (<?php
				if(isset($row['prodt_id'])){
				$enquiry = mysqli_query($db, "SELECT count(*) FROM `enquiry_dmg` WHERE `em_product_id`='".$row['prodt_id']."' AND `em_status`='on'"); 
				$Ecount	= mysqli_fetch_array($enquiry);
				echo $Ecount[0];
					}
				?>)
            </p>
				<?php
				if(isset($row['prodt_name']) && $row['prodt_name'] != ''){
				
               echo "<a title='View product details' href='productdetails.php?pt=".$row['prodt_id']."&sh=".$row['shop_id']."'><button class='btn btn-primary Rsrsulbtn' value='View More...'>View More</button></a>"; 
              
				}
					?>
            
            
            
            
            </div>
        </div>
        <?php
				++$TotalSearchCount;
			}
			}else{
				echo "<div style='width:100%; text-align:center;'>There is no record found...</div>";
			}
		?>
        <script>
			$('#Scount').text(<?php echo $total; ?>);
			</script>
        
        

        </div>
        
        
        <?php
		include('pagination.php');
		echo $pagination; 
		?>
        
        
        </div>

		<div class="col-md-2 col-sm-4 col-xs-12">
		<?php 
		
		$objProduct = new Product();
		$objProduct->advType		=	'productlist_slide';
		$getAdData					=   $objProduct->getAdvertisement();
		
		$rowCount			=	mysqli_num_rows($getAdData);
		while($getAdDataResult	=	mysqli_fetch_array($getAdData )){
		$adTypeVal			=	$getAdDataResult['sett_val1'];
		$adTypeID				=	$getAdDataResult['Ad_Type'];
		$advIDD					=	$getAdDataResult['Ad_Id'];		
		$objProduct->updateViewCount($advIDD,$adTypeID);	
			if($rowCount <= $adTypeVal){?>
			<div class="row" style="margin-bottom:15px; width:50%">
       			 <div class="col-md-12" style="padding:0px;">
       			 	<img class="adImageClick" id = "<?php echo $advIDD;?>" alt="<?php if(isset($getAdDataResult['shop_name'])) echo $getAdDataResult['shop_name']; ?>" src="<?php echo $getAdDataResult['Ad_Picture']; ?>" width="175" />
       			 </div>
      		</div>
			<?php }?>
		
			
		<?php }
	 ?>
		</div>
	</div>
</div>
<?php
if(isset($SkeywordSearch)){
	include('Connections/search-datas.php');
}

?>
			
			
			
			
<!-- company container end -->



<script>
var shortNumber = $("#clickToShow").text().substring(0,  $("#clickToShow").text().length - 8);
var eventTracking = "_gaq.push(['_trackEvent', 'EVENT-CATEGORY', 'EVENT-ACTION', 'EVENT-LABEL']);";
$("#clickToShow").hide().after('<button id="clickToShowButton" onClick="' + eventTracking + '">' + shortNumber + '... (click to show number)</button>');
$("#clickToShowButton").click(function() {
    $("#clickToShow").show();
    $("#clickToShowButton").hide();
});
</script>
<script>
	 //for advertisement product image link
	$('.adImageClick').click(function(){
		var imageID =  this.id ;	
				$.ajax({
					url:"ajax_ad.php",
					data:{
							"imageID"		:imageID
						},
					async:false,
					method: 'POST',
					success: function(data)
						{  
							window.open(data, '_blank');
						}	
				});
	});
	 
	 
 </script>
<script src="js/list.js"></script>
<!--footer-->
<?php include("footer.php"); ?>
<!--header-->

</body>
</html>