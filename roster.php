<?php
/* Active Roster */

$config = include("config.php");

$url = $config->guild_members_url;
$result = file_get_contents($url, true);

$url2 = $config->guild_log_url;
$log = file_get_contents($url2, true);

//$url3 = $config->guild_ranks_url;
//$rankInfo = file_get_contents($url3, true);

$json = json_decode($result, true);
$log = json_decode($log, true);

$jsonLength = count($json);
$logLength = count($log);

$members = array();

foreach ($json as $values){
	$name = $values["name"];
	$rank = $values["rank"];
	$date = $values["joined"];
	$icon = "";
	if($date != "" || $date != null){
		$date = substr($date, 0, -14);
		//$date = str_replace('-', '', $date);
	} else {
		if($name == "Guardian of Angels.9867"){
			$date = '2012-08-25';
		} elseif ($name == "The Dusk"){
			$date = '2013-02-14';
		} else {
			$date = '2013-03-01';
		};
	};
	
	if ($rank == "The Night"){
		$icon = 'https://render.guildwars2.com/file/973F5A460745C27AE8F9A3601B0D45660B023A9E/156381.png';
		$number = 1;
		$color = '#4C139D;';
	};
	if ($rank == "The Dusk"){
		$icon = 'https://render.guildwars2.com/file/973F5A460745C27AE8F9A3601B0D45660B023A9E/156381.png';
		$number = 2;
		$color = '#4C139D;';
	};
	if ($rank == "The Dawn"){
		$icon = 'https://render.guildwars2.com/file/973F5A460745C27AE8F9A3601B0D45660B023A9E/156381.png';
		$number = 3;
		$color = '#4C139D;';
	};
	if ($rank == "Lunar Ascended"){
		$icon = 'https://render.guildwars2.com/file/EB3B3BC73EE3252092F162A855FA0A4425232A03/156377.png';
		$number = 4;
		$color = '#fb3e8d;';
	};
	if ($rank == "Nocturnal"){
		$icon = 'https://render.guildwars2.com/file/30EB1BDA3850EF59AFEFAA005DA19605250D3620/156373.png';
		$number = 5;
		$color = '#ffa405;';
	};
	if ($rank == "Dusk Raider"){
		$icon = 'https://render.guildwars2.com/file/E602B19395D6E435F42DECBDC4E85124A45A909F/156371.png';
		$number = 7;
		$color = '#1a9306;';
	};
	if ($rank == "Night Heart"){
		$icon = 'https://render.guildwars2.com/file/472198686BB6034259507D7F08D7EF2AB9E614F9/156372.png';
		$number = 6;
		$color = '#fcd00b;';
	};
	if ($rank == "Night Spawn"){
		$icon = 'https://render.guildwars2.com/file/71953C6503D2913D2CFDC6A9AD4106C391592363/156374.png';
		$number = 9;
		$color = '#2C2C2C;';
	};
	if ($rank == "Architect"){
		$icon = 'https://render.guildwars2.com/file/5D416AF8469C2080EB7D95E9806FD8E57F480466/156380.png';
		$number = 10;
		$color = '#ffa405;';
	};
	if ($rank == "Night Crawler"){
		$icon = 'https://render.guildwars2.com/file/F8F361CA6FEB963B7A7EED43BB745375909F7166/156375.png';
		$number = 8;
		$color = '#62A4DA;';
	};
	if ($rank == "invited"){
		$icon = '';
		$number = 11;
		$color = '';
	};
	
	$promoted = "";
	
	foreach ($log as $item){
		$type = $item["type"];
		$user = $item["user"];
		if($type == 'rank_change'){
			if($user == $name){
				$promoted = $item["time"];
			};
		};
	};
	
	$array = array("name" => $name, "rank" => $rank, "date" => $date, "promoted" => $promoted, "icon" => $icon, "number" => $number, "color" => $color);
	array_push($members, $array);
};

function get($members){
	foreach($members as $item){
		$name = $item["name"];
		$rank = $item["rank"];
		$date = $item["date"];
		$promoted = $item["promoted"];
		$color = $item["color"];
		$icon = $item["icon"];
		$number = $item["number"];
		
		if ($date != "" || $date != null){
			$date = explode("-", $date);
			$date = $date[2] . "/" . $date[1] . "/" . $date[0];
		};
		
		if ($promoted != "" || $promoted != null){
			$promoted = substr($promoted, 0, -14);
			$promoted = explode("-", $promoted);
			$promoted = $promoted[2] . "/" . $promoted[1] . "/" . $promoted[0];
			$promoted = "Promoted: " . $promoted;
		};
		
		if($rank != "invited"){
			echo '<tr style="color:'.$color.'"><td height="32px" width="5%" align="center" rank-value="'.$number.'"><div><img id="icon" src="'.$icon.'" alt="icon" align="center" title="'.$rank.'"/></div></td><td width="30%" style="font-weight: 600;"><div>'.$name.'</div></td><td rank-value="'.$number.'" width="10%">'.$rank.'</td><td width="15%"><div align="center">'.$date.'</div></td><td width="40%"><div align="center">'.$promoted.'</div></td></tr>';
		};
	};
};

?>

<html>
<head>
<link href="roster.css" type="text/css" rel="stylesheet" />
<script language="javascript" type="text/javascript"></script>
<script type="text/javascript" src="/tablesorter/jquery-latest.js"></script> 
<script type="text/javascript" src="/tablesorter/jquery.tablesorter.js"></script> 
</head>
<body>
<div id="main">
	<table id="maintable" class="tablesorter" width="100%">
		<thead id='tableHead'>
			<tr id="tablehead" align="left"><th width="5%" align="center"><div id="icon">Icon</div></th><th width="30%"><div id="acc">Account Name</div></th><th width="15%"><div id="rank">Rank</div></th><th width="10%"><div id="date" align="center">Date Joined</div></th><th width="40%"><div id="promoted" align="center">Notes</div></th></tr>
		</thead>
		<tbody id='tableBody'>
			<?php get($members); ?>
		</tbody>
	</table>
</div>
<script>

	$(document).ready(function() 
		{ 
			$.tablesorter.addParser({
				// set a unique id 
				id: 'rangesort',
				is: function (s) {
					// return false so this parser is not auto detected 
					return false;
				},
				format: function (s, table, cell, cellIndex) {
					// get data attributes from $(cell).attr('data-something');
					// check specific column using cellIndex
					return $(cell).attr('rank-value');
				},
				// set type, either numeric or text 
				type: 'numeric'
			});
		
			$("#maintable").tablesorter({
				cancelSelection: true,
				dateFormat: "uk",
				sortList: [[2,0],[3,0]],
				headers: { 2: { sorter: 'rangesort' }} 
			});
		} 
	); 
  
</script>
</body>
</html>