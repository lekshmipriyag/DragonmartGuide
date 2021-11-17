<!--<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->

<style>
/*	right side start*/
.float{
	position:fixed;
	width:50px;
	height:50px;
	bottom:20px;
	right:20px;
	background-color:gold;
	color:#333333;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
	z-index:1000;
	animation: bot-to-top 2s ease-out;
}

ul.RFul{
	position:fixed;
	right: 0px;
	padding-bottom:20px;
	bottom:40px;
	z-index:100;
}

ul.RFul li{
	list-style:none;
	margin-bottom:10px;
	position: relative;
}

ul.RFul li a{
	background-color:gold;
	color:#333333;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
	width:40px;
	height:40px;
	display:block;
}

ul.RFul:hover{
	visibility:visible!important;
	opacity:1!important;
}


.my-float{
	font-size:35px;
	margin-top:8px;
}

a#menu-share + ul{
  visibility: hidden;
}

a#menu-share:hover + ul{
  visibility: visible;
  animation: scale-in 0.5s;
}

a#menu-share i{
	animation: rotate-in 0.5s;
}

a#menu-share:hover > i{
	animation: rotate-out 0.5s;
}
	.RFspan {
		position: absolute; right: 50px; top: 10px; white-space: nowrap; background-color: #333; color: gold; font-size: 14px; font-weight: bold; padding: 2px 7px; border-radius: 3px;
	}
	
/*	right side end*/	
	
	
	
	
	
	
	
	
	
	
	
/*	left side start*/
	
	.float2{
	position:fixed;
	width:50px;
	height:50px;
	bottom:20px;
	left:20px;
	background-color:gold;
	color:#333333;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
	z-index:1000;
	animation: bot-to-top 2s ease-out;
}

ul.RFul2{
	position:fixed;
	left:-10px;
	padding-bottom:20px;
	bottom:40px;
	z-index:100;
}

ul.RFul2 li{
	list-style:none;
	margin-bottom:10px;
	position: relative;
	left: -5px;
}

ul.RFul2 li a{
	background-color:gold;
	color:#333333;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
	width:40px;
	height:40px;
	display:block;
}

ul.RFul2:hover{
	visibility:visible!important;
	opacity:1!important;
}


.my-float{
	font-size:35px;
	margin-top:8px;
}

a#menu-share2 + ul{
  visibility: hidden;
}

a#menu-share2:hover + ul{
  visibility: visible;
  animation: scale-in 0.5s;
}

a#menu-share2 i{
	animation: rotate-in 0.5s;
}

a#menu-share2:hover > i{
	animation: rotate-out 0.5s;
}
	.RFspan2 {
		position: absolute; left: 50px; top: 10px; white-space: nowrap; background-color: #333; color: gold; font-size: 14px; font-weight: bold; padding: 2px 7px; border-radius: 3px;
	}
@keyframes bot-to-top {
    0%   {bottom:-40px}
    50%  {bottom:40px}
}

@keyframes scale-in {
    from {transform: scale(0);opacity: 0;}
    to {transform: scale(1);opacity: 1;}
}

@keyframes rotate-in {
    from {transform: rotate(0deg);}
    to {transform: rotate(360deg);}
}

@keyframes rotate-out {
    from {transform: rotate(360deg);}
    to {transform: rotate(0deg);}
}
/*	left side end*/	
	.RiS1 {
		font-size: 25px !important;
	}
</style>
</head>

<body>

<a href="#" class="float2" id="menu-share2">
<i class="fa fa-life-ring my-float"></i>
</a>
<ul class="RFul2">
<li><span class="RFspan2">Office Service</span><a href="tel:+971501481234">
<i class="fa fa-question-circle my-float RiS1"></i> 
</a></li>
<li><span class="RFspan2">Police</span><a href="tel:+971563893761">
<i class="fa fa-user my-float RiS1"></i> 
</a></li>

<li><span class="RFspan2">Wheelchair</span><a href="tel:+971501481234">
<i class="fa fa-wheelchair my-float RiS1"></i> 
</a></li>
<li><span class="RFspan2">Medical</span><a href="tel:+971501481234">
<i class="fa fa-medkit my-float RiS1"></i>
</a></li>
<li><span class="RFspan2">ATM</span><a href="tel:+971501481234">
<i class="fa fa-credit-card-alt my-float RiS1"></i>
</a></li>
</ul>






<a href="#" class="float" id="menu-share">
<i class="fa fa-taxi fa-2x my-float"></i>
</a>
<ul class="RFul">
<li><span class="RFspan">Shuttle</span><a href="tel:+971501481234">
<i class="fa fa-bus RiS1 my-float"></i>
</a></li>

<li><span class="RFspan">Taxi Service</span><a href="tel:+971501481234">
<i class="fa fa-truck RiS1 my-float"></i>
</a></li>
<li><span class="RFspan">Pickup Service</span><a href="tel:+971501481234">
<i class="fa fa-taxi RiS1 my-float"></i> 
</a></li>
</ul>

<!--</body>
</html>-->