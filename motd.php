<?php
/* MOTD */

$config = include("config.php");
$url = $config->guild_log_url;
$result = file_get_contents($url);
?>

<html>
<head>
<link href="roster.css" type="text/css" rel="stylesheet" />
</head>
<body style="background: #ececec;">
<table width="100%">
<thead>
	<tr>
		<th>Message of the day</th>
	</tr>
</thead>
<tbody id="motd">
</tbody>
</table>
<div align="right" id="updated" style="font-size: 14px;"></div>
<script language="javascript" type="text/javascript"> 
	var json = <?php echo $result ?>;
	
	jsonLength = json.length

	var x = 0;
	
	while (x < jsonLength){
		values = json[x];
		if (values["type"] == "motd"){
			motd = values["motd"];
			date = values["time"];
			user = values["user"];
			date = date.slice(0, -14);
			date = date.split('-').reverse().join('.');
			document.getElementById('motd').innerHTML += '<tr><td style="padding: 10px;" align="center">' + motd + '</td></tr>';
			document.getElementById('updated').innerHTML += '- updated on ' + date + ' (by ' + user + ')';
			break
		} else {
		};
		x = x + 1;
	};
</script>
</body>
</html>