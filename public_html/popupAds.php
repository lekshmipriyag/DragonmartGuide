<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->


<style>

	html, body {
		padding: 0px;
		margin: 0px;
	}

	.Aprnt {
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, .5);
		z-index: 1032;
		position: fixed;
		text-align: center;
		top: 0px;
	}
	.Abtn {
		border-radius: 50%;
		border: solid 1px #ccc;
		background: rgba(255, 255, 255, .5);
		width: 30px;
		height: 30px;
		padding: 3px;
		font-size: 17px;
		text-align: center;
		position: absolute;
	}
	.AcoseTL {
		left: 5px;
		top: 5px;
	}
	.AcoseTR {
		right: 5px;
		top: 5px;
	}
	.AcoseBL {
		left: 5px;
		bottom: 5px;
	}
	.AcoseBR {
		right: 5px;
		bottom: 5px;
	}
	

	
</style>
<div class="Aprnt video-container" id="Aprnt">
<a href="#"><div id="Axbtn" class="Abtn AcoseBL">X</div></a>

<img id="Apopup" src="http://beta.dragonmartguide.com/images/products/206_cubboards.jpg" alt="Advertisment" />






<!--
<style>
		.video-container {
	position:relative;
	padding-bottom:56.25%;
	padding-top:30px;
	height:0;
	overflow:hidden;
}

.video-container iframe, .video-container object, .video-container embed {
	position:absolute;
	top:0;
	left:0;
	width:95%;
	height:95%;
}
	</style>
<iframe width="560" height="315" src="https://www.youtube.com/embed/y8NDRElMWwk?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>
-->
</div>

<script type="text/javascript">

$(document).ready(function(){
        var img = $("#Apopup");
		var AdocWdt = $(window).width();
		var AdocHit = $(window).height();
        // Create dummy image to get real width and height
        $("#Apopup").attr("src", $(img).attr("src")).load(function(){
            var realWidth = this.width;
            var realHeight = this.height;
			if(realHeight > AdocHit){
				$('#Apopup').height(AdocHit);
			}else if(realWidth > AdocWdt){
				$('#Apopup').width(AdocWdt);
				var AftrHt = $('#Apopup').height();
				var MargT = (AdocHit - AftrHt)/2
				$('#Apopup').css('margin-top', MargT);
			}else{
				var MargT = (AdocHit - realHeight)/2
				$('#Apopup').css('margin-top', MargT);
			}
			var AixL = ((AdocWdt - realWidth)/2);
			var AixT = ((AdocHit - realHeight)/2);
			var AixR = ((AdocWdt + realWidth)/2)-30;
			var AixB = ((AdocHit + realHeight)/2)-30;
			
			var Arand = Math.floor(Math.random() * 4) + 1;
			if(Arand == 1){
				$('#Axbtn').css('left', AixL).css('top', AixT);
			}else if(Arand == 2){
				$('#Axbtn').css('left', AixR).css('top', AixT);
			}else if(Arand == 3){
				$('#Axbtn').css('left', AixR).css('top', AixB);
			}else if(Arand == 4){
				$('#Axbtn').css('left', AixL).css('top', AixB);
			}
        });
	
	$("#Axbtn").click(function(){
		$('#Aprnt').hide();
	});
});

</script>



