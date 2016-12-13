<?php
/* Active Roster */
$config = include("config.php");
$url = $config->guild_members_url;
$result = file_get_contents($url, true);
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
		<thead id='0'>
		</thead>
		<tbody id='1'>
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
				sortList: [[0, 0]], 
				headers: { 2: { sorter: 'rangesort' }} 
			});
		} 
	); 
  
	var json = <?php echo $result; ?>;
	var log = <?php echo $log; ?>;
	
	jsonLength = json.length;
	logLength = log.length;
	
	var x = 0;
	var y = 0;
	
	while (x < jsonLength){
		values = json[x];
		name = values["name"];
		rank = values["rank"];
		date = values["joined"];
		icon = "";
		if (date != null){
			var hour = date.slice(11, -10);
			var date = date.slice(0, -14);
			var date = date.split('-').join('');
		} else {
			if (rank == "The Night"){
				date = '20120825';
			} else if (rank == "The Dusk"){
				date = '20130214';
			} else {
				date = '20130301';
			};
		};
		
		var promotion = "0000000";
		var invited = "";
		var invitedBy = "";
		
		log.forEach(function(item){
			var type = item["type"];
			var user = item["user"];
			if(type == 'rank_change'){
				if(user == name){
					var promoted = item["time"];
					json[x].promotion = promoted;
				} else {
				};
			} else {
			};
		});
		
		log.forEach(function(item){
			var type = item["type"];
			var user = item["user"];
			if(type == 'invited'){
				if(user == name){
					var invited = item["time"];
					var invitedBy = item["invited_by"];
					json[x].invite = invited;
					json[x].inviteBy = invitedBy;
				} else {
				};
			} else {
			};
		});
		
		if (rank == "The Night"){
			json[x].icon = 'https://render.guildwars2.com/file/973F5A460745C27AE8F9A3601B0D45660B023A9E/156381.png';
			json[x].number = 1;
			json[x].date = date;
			json[x].color = '#4C139D;';
		} else {
		};
		if (rank == "The Dusk"){
			json[x].icon = 'https://render.guildwars2.com/file/973F5A460745C27AE8F9A3601B0D45660B023A9E/156381.png';
			json[x].number = 2;
			json[x].date = date;
			json[x].color = '#4C139D;';
		} else {
		};
		if (rank == "The Dawn"){
			json[x].icon = 'https://render.guildwars2.com/file/973F5A460745C27AE8F9A3601B0D45660B023A9E/156381.png';
			json[x].number = 3;
			json[x].date = date;
			json[x].color = '#4C139D;';
		} else {
		};
		if (rank == "Lunar Ascended"){
			json[x].icon = 'https://render.guildwars2.com/file/EB3B3BC73EE3252092F162A855FA0A4425232A03/156377.png';
			json[x].number = 4;
			json[x].date = date;
			json[x].color = '#fb3e8d;';
		} else {
		};
		if (rank == "Nocturnal"){
			json[x].icon = 'https://render.guildwars2.com/file/30EB1BDA3850EF59AFEFAA005DA19605250D3620/156373.png';
			json[x].number = 5;
			json[x].date = date;
			json[x].color = '#ffa405;';
		} else {
		};
		if (rank == "Dusk Raider"){
			json[x].icon = 'https://render.guildwars2.com/file/E602B19395D6E435F42DECBDC4E85124A45A909F/156371.png';
			json[x].number = 7;
			json[x].date = date;
			json[x].color = '#1a9306;';
		} else {
		};
		if (rank == "Night Heart"){
			json[x].icon = 'https://render.guildwars2.com/file/472198686BB6034259507D7F08D7EF2AB9E614F9/156372.png';
			json[x].number = 6;
			json[x].date = date;
			json[x].color = '#fcd00b;';
		} else {
		};
		if (rank == "Night Spawn"){
			json[x].icon = 'https://render.guildwars2.com/file/71953C6503D2913D2CFDC6A9AD4106C391592363/156374.png';
			json[x].number = 9;
			json[x].date = date;
			json[x].color = '#2C2C2C;';
		} else {
		};
		if (rank == "Architect"){
			json[x].icon = 'https://render.guildwars2.com/file/5D416AF8469C2080EB7D95E9806FD8E57F480466/156380.png';
			json[x].number = 10;
			json[x].date = date;
			json[x].color = '#ffa405;';
		} else {
		};
		if (rank == "Night Crawler"){
			json[x].icon = 'https://render.guildwars2.com/file/F8F361CA6FEB963B7A7EED43BB745375909F7166/156375.png';
			json[x].number = 8;
			json[x].date = date;
			json[x].color = '#62A4DA;';
		} else {
		};
		if (rank == "invited"){
			json[x].icon = '';
			json[x].number = 11;
			json[x].date = date;
			json[x].color = '';
		} else {
		};

		//document.getElementById(number).innerHTML += '<tr><td height="32px" width="5%"><div>' + icon + '</div></td><td width="50%"><div>' + name + '</div></td><td width="15%"><div>' + rank + '</div></td><td width="15%"><div>' + date + '</div></td><td width="15%"><div>' + promoted + '</div></td></tr>';
		
		x = x + 1;
	};
	
	json.sort(function(a, b){
		return a.number-b.number || parseFloat(a.date) - parseFloat(b.date);
	});
	
	document.getElementById('0').innerHTML += '<tr id="tablehead" align="left"><th width="5%" align="center"><div id="icon">Icon</div></th><th width="30%"><div id="acc">Account Name</div></th><th width="15%"><div id="rank">Rank</div></th><th width="10%"><div id="date" align="center">Date Joined</div></th><th width="40%"><div id="promoted" align="center">Notes</div></th></tr>'
	
	x = 0;
	
	while (x < jsonLength){
		values = json[x];
		name = values["name"];
		rank = values["rank"];
		jdate = values["joined"];
		icon = values["icon"];
		num = values["number"];
		color = values["color"];
		promoted = values["promotion"];
		invitedBy = values["inviteBy"];
		
		if (jdate != null){
			var hour = date.slice(11, -10);
			var jdate = jdate.slice(0, -14);
			var jdate = jdate.split('-').reverse().join('/');
		} else {
			if (rank == "The Night"){
				jdate = '25/08/2012';
			} else {
				jdate = '01/03/2013';
			};
			
		};
		if (promoted != null){
			var hour = date.slice(11, -10);
			var promoted = promoted.slice(0, -14);
			var promoted = promoted.split('-').reverse().join('/');
			var promoted = "Promoted: " + promoted + "<br>";
		} else {
			if (rank == "The Night"){
				promoted = '';
			} else {
				promoted = '';
			};
			
		};
		
		if (invitedBy != null){
			var invitedBy = "Invited by: " + invitedBy;
		} else {
			if (rank == "The Night"){
				invitedBy = '';
			} else {
				invitedBy = '';
			};
			
		};
		
		if (rank == "The Dusk") {
			jdate = '14/02/2013';
		} else {
		};
			
		
		if (rank == "invited"){
			
		} else {
			document.getElementById('1').innerHTML += '<tr style="color: ' + color + '"><td height="32px" width="5%" align="center" rank-value="' + num + '"><div><img id="icon" src="' + icon + '" alt="icon" align="center" title="' + rank + '"/></div></td><td width="30%" style="font-weight: 600;"><div>' + name + '</div></td><td rank-value="' + num + '" width="10%">' + rank + '</td><td width="15%"><div align="center">' + jdate + '</div></td><td width="40%"><div align="center">' + promoted + '</div></td></tr>';
		};
		
		
		x = x + 1;
	};
	
	

	
</script>
</body>
</html>