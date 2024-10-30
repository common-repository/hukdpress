<?php
header("Content-type: text/css");
if (isset($_GET['basecolor']) && !empty($_GET['basecolor'])) $basecolor = '#'.$_GET['basecolor']; else $basecolor = '#414243';
if (isset($_GET['basetextcolor']) && !empty($_GET['basetextcolor'])) $basetextcolor = '#'.$_GET['basetextcolor']; else $basetextcolor = '#fff';
if (isset($_GET['baserowcolor']) && !empty($_GET['baserowcolor'])) $baserowcolor = '#'.$_GET['baserowcolor']; else $baserowcolor = '#fff';
if (isset($_GET['basealtrowcolor']) && !empty($_GET['basealtrowcolor'])) $basealtrowcolor = '#'.$_GET['basealtrowcolor']; else $basealtrowcolor = '#eee';
if (isset($_GET['basehotcolor']) && !empty($_GET['basehotcolor'])) $basehotcolor = '#'.$_GET['basehotcolor']; else $basehotcolor = '#fe2323';
if (isset($_GET['basecoldcolor']) && !empty($_GET['basecoldcolor'])) $basecoldcolor = '#'.$_GET['basecoldcolor']; else $basecoldcolor = '#577df9';
?>
div.hp_container {
	font-family: 'Lucida Grande', 'Lucida Sans Unicode', Calibri, Arial, Helvetica, Sans, FreeSans, Jamrul, Garuda, Kalimati;
	background-color: #fff;
}

div.hp_deal_powered {
	background-image: url(../images/poweredby.png);
	height: 30px;
	width: 113px;
	float: right;
	background-color: <?php echo $basecolor; ?>;
}

div.hp_deal_powered.notrans {
	color: <?php echo $basetextcolor; ?>;
	width: 150px;
	height: 15px;
	text-align: right;
	font-size: 10px;
	padding-right: 12px;
}

div.notrans a:link, div.notrans a:visited {
	color: <?php echo $basetextcolor; ?>;
}

div.hp_deal_top {
	height: 20px;
	overflow: visible;
	background-color: <?php echo $basecolor; ?>;
	color: <?php echo $basetextcolor; ?>;
}

div.hp_deal_top_left {
	height: 18px;
	float: left;
	padding-top: 2px;
	font-size: 11px;
	padding-left: 12px;
	background: url(../images/top_left_trans.png) no-repeat left top;
}

div.hp_deal_selector {
	text-align: center;
	float: left;
	padding-top: 16px;
	height: 13px;
}

div.hp_selector_dot {
	float: left;
	background: url(../images/dot.png) no-repeat center center;
	padding: 2px;
	cursor: pointer;
	height: 6px;
	width: 6px;
}

div.hp_selector_dot.selected {
	background: url(../images/selected_dot.png) no-repeat center center;
}

div.hp_deal_top_right {
	height: 18px;
	text-align: right;
	float: right;
	padding-top: 2px;
	font-size: 10px;
	padding-right: 12px;
	background: url(../images/top_right_trans.png) no-repeat right top;
}

div.hp_deal_top a:link, div.hp_deal_top a:visited {
	color: <?php echo $basetextcolor; ?>;
	font-style: italic;
}

div.hp_deal_status {
	float: left;
	height: 15px;
	width: 196px;
	font-size: 9px;
	color: <?php echo $basetextcolor; ?>;
	padding-top: 15px;
	background-color: <?php echo $basecolor; ?>;
	background-image: url(../images/status.png);
}

div.hp_container .notrans {
	background: none;
}

div.hp_deal_bottom.notrans {
	background-color: <?php echo $basecolor; ?>;
	height: 15px;
	border-left: 1px solid <?php echo $basecolor; ?>;
	border-right: 1px solid <?php echo $basecolor; ?>;
}

div.hp_deal_status.notrans {
	padding-top: 0px;
}

div.hp_deal_bot_left_trans.notrans, div.hp_deal_bot_right_trans.notrans {
	display: none;
}

div.hp_deal_status_text {
	padding-left: 12px;
}

div.hp_deal_set {
	border-right: 1px solid <?php echo $basecolor; ?>;
	border-left: 1px solid <?php echo $basecolor; ?>;
	overflow: hidden;
}

div.hp_deal_bottom {
	background-color: #fff;
	overflow: visible;
	border-bottom: 1px solid <?php echo $basecolor; ?>;
	height: 29px;
}

div.hp_deal {
	overflow: hidden;
	background-color: <?php echo $baserowcolor; ?>;
}

div.hp_deal_error {
	padding: 10px;
	color: #f00;
}

div.hp_deal.altrow {
	background-color: <?php echo $basealtrowcolor; ?>;
}

div.hp_deal_title {
	overflow: hidden;
}

div.hp_deal_left {
	float: left;
	width: 60px;
	padding: 11px 5px 10px 5px;
}

div.hp_deal_right {
	padding: 5px 5px 5px 0px;
}

div.hp_deal_tweet {
	display: block;
	background: url(../images/twitter_16.png);
	margin-left: 5px;
	height:16px;
	width:16px;
	float: left;
}

div.hp_deal_tweet a:hover {
	text-decoration: none;
}

div.hp_deal_temp {
	height: 15px;
	font-size: 13px;
	text-align: center;
	padding-left: 5px;
	padding-top: 3px;
	padding-bottom: 3px;
}

div.hp_deal_temp.hot {
	color: <?php echo $basehotcolor; ?>;
}

div.hp_deal_cost {
	text-align: center;
	font-size: 16px;
}

div.hp_deal_cost.largecost {
	font-size: 12px;
}

div.hp_deal_cost.mediumcost {
	font-size: 14px;
}

div.hp_deal_info {
	float: left;
	font-size: 10px;
	font-style: italic;
}

div.hp_deal_temp.cold {
	color: <?php echo $basecoldcolor; ?>;
}