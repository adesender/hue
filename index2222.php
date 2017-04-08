<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Yandere - Game Management</title>
  <meta name="description" content="Login Page for Yonder Yandere">
  <meta name="author" content="The Escape Hatch">

  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <script src="scripts/jshue.js"></script>
  <script src="scripts/jquery-1.12.4.min.js"></script>
  
  <script>
	var hue = jsHue();
	var ip = "0.0.0.0";
	var username = "";
	//var username = "eVrBKtmLdQzHHZTDaUXDqNnCgNPD92bFui5cE1Iz";
	var user = "";
	
	hue.discover(
		function(bridges) {
			if(bridges.length === 0) {
				console.log();
				$("#resp").html('No bridges found. :(');
			}
			else {
				bridges.forEach(function(b) {	
					ip = b.internalipaddress;
					console.log('Bridge found at IP address %s.', ip);
					$("#resp").html('Bridge found at IP address -' + ip);
				});
				
				var bridge = hue.bridge(ip);
				
				bridge.createUser('hatch app2', function(data) {
					// extract bridge-generated username from returned data
					username = data[0].success.username;

					console.log('New username:', username);

					// instantiate user object with username
					user = bridge.user(username);
					$("#user").html('New User -->' + username);
				});				
				
				
				$("#on").mouseup(function() {				
					user = bridge.user(username);					
					user.setLightState(1, { on: true }, function(data) { /* ... */ });
				});
				
				$("#off").mouseup(function() {				
					user = bridge.user(username);					
					user.setLightState(1, { on: false }, function(data) { /* ... */ });
				});
				
			}
		},
		function(error) {
			console.error(error.message);
		}
	);
	
  </script>
</head>

<body>
	<div id="container">
		<h1>Hue Test</h1>
	  
		<p>Response: <span id="resp"></span></p>
		<p>User: </span id="user"></span></p>
		
		<input type="button" value="On!" id="on" />
		<input type="button" value="Off!" id="off" />
	</div>
</body>
</html>