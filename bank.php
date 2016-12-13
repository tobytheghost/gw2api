<?php
/* My Bank */

if(isset($_GET["access_token"])){
	$access_token = $_GET["access_token"];
} else {
	$config = include("config.php");
	$access_token = $config->api_key;
};


function connect($type, $access_token){
	
	$url = 'https://api.guildwars2.com/v2/account/' . $type . '?access_token=' . $access_token;
	
	$result = file_get_contents($url);
	$json = json_decode($result, true);
	
	return $json;
};

function main($json){
	
	foreach ($json as $item) {
		$id = print_r($item["id"], true);
		if($id != "" || $id != null){
			$idList = $idList . $id . ",";
		};
	}; 
	
	$idList = substr_replace($idList, "", -1);
	
	$url = 'https://api.guildwars2.com/v2/items?ids=' . $idList;
	$result = file_get_contents($url);
	$call = json_decode($result, true);
	$elementCount  = count($call);
	
	$count = 1;
	$row = -1;
	foreach ($json as $number){
		if($number == null){
			echo "<div class='image' style='margin: 2px; height:64px; width:64px; position: relative; float:left; border: solid #AAA 2px;'></div>";
		};
		$count = print_r($number["count"], true);
		$row = $row + 1;
		if($row == 30){
			echo "<div class='image' style='margin: 2px; height:20px; width:100%; position: relative; float:left;'></div>";
			$row = 0;			
		};
		foreach ($call as $item){
			if($item["id"] == $number["id"]){
				$name = $item["name"];
				$render = $item["icon"];
				$id = $item["id"];
				$title = 'title="' . $name . '"';
				$rarity = $item["rarity"];
				if($rarity == "Legendary"){
					$color = "#4C139D";
				} elseif ($rarity == "Ascended"){
					$color = "#fb3e8d";
				} elseif ($rarity == "Exotic"){
					$color = "#ffa405";
				} elseif ($rarity == "Rare"){
					$color = "#fcd00b";
				} elseif ($rarity == "Masterwork"){
					$color = "#1a9306";
				} elseif ($rarity == "Fine"){
					$color = "#62A4DA";
				} else {
					$color = "black";
				};
				if($count == 0){
					//Leave Blank
				} elseif($count == 1) {
					echo "<div id='" . $id . "' class='image' style='margin: 2px; height:64px; width:64px; position: relative; float:left; border: solid " . $color . " 2px;'><img " . $title . " src='" . $render . "' style='height:64px; width:64px;' class='item'></img><h3 " . $title . " align='center' style=' height:64px; width:64px; position: absolute; top: -10px; left: 0px; color: #ffeeaa; font-size: 26px; text-align: center; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black, 0px 0px 2px black, 0px 0px 2px black, 0px 0px 2px black, 0px 0px 2px black; width:100%;'></h3></div><div style='margin-top: 68px; margin: 2px; position: relative; float:left; height: 136px; width: 100%; display: none;'><div style='margin-left: auto; margin-right: auto; margin-top: -2px; width:208px; height: 136px; background-color: #AAA; border: solid black 2px;'></div></div>";
				} else {
					echo "<div id='" . $id . "' class='image' style='margin: 2px; height:64px; width:64px; position: relative; float:left; border: solid " . $color . " 2px;'><img " . $title . " src='" . $render . "' style='height:64px; width:64px;' class='item'></img><h3 class='unselectable' " . $title . " align='center' style=' height:64px; width:64px; position: absolute; top: -10px; left: 0px; color: #ffeeaa; font-size: 26px; text-align: center; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black, 0px 0px 2px black, 0px 0px 2px black, 0px 0px 2px black, 0px 0px 2px black; width:100%;'>" . $count . "</h3></div><div style='margin-top: 68px; margin: 2px; position: relative; float:left; height: 136px; width: 100%; display: none;'><div style='margin-left: auto; margin-right: auto; margin-top: -2px; width: 208px; height: 136px; background-color: #AAA; border: solid black 2px;'></div></div>";
				};
			};
	
		};
	};
};

?>

<html>
<head>
<link href="roster.css" type="text/css" rel="stylesheet" />
<script language="javascript" type="text/javascript"></script>
</head>
<body style="background: #ececec;">
	<table width="100%">
		<thead>
			<tr>
				<th>My Bank</th>
			</tr>
		</thead>
		<tbody id="motd">
		</tbody>
	</table>
	<div align="center" id="updated" style="margin-left: auto; margin-right: auto; width: 720px; font-size: 14px;"><?php main(connect("bank", $access_token)); ?></div>
</body>
</html>