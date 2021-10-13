<?php


//auto detects directories where the page is and auto assigns variables with correct directory names in them.
$_SESSION['http_dir']						=	$_SESSION['http'].$_SESSION['domain'].$_SESSION["site_dir"].'updates/'.$_SESSION['version'].'/';

?>

<!DOCTYPE html>

<html>

	<head>
		
		<!-- adds stylesheets -->
		<link rel="stylesheet" href="<?= $_SESSION['http_dir']; ?>css/images.css">
		<link rel="stylesheet" href="<?= $_SESSION['http_dir']; ?>css/html5.css">
		<link rel="stylesheet" href="<?= $_SESSION['http_dir']; ?>css/p.css">
		
		<!-- adds 'Roboto' font -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		
		<!-- adds jquery -->
		<script type="text/javascript" src="<?= $_SESSION['http_site_dir'] ?>js/jquery-3.3.1.js"></script>
		
		<script>
			
		</script>
		
	</head>

	<body>
	
		<header>
			
			<img class="logo" src="<?= $_SESSION['http_site_dir']; ?>images/<?= $_SESSION['version']; ?>/<?= $_SESSION['images_logo']; ?>" class=""></img>
			
			<!-- just a spacing div to make formatting of html page seem more tidy -->
			<div class="spacer44"></div>
			
			<p class="subtitle_p">File Explorer Iterator Config File Editor</p>
			
			<!-- just a spacing div to make formatting of html page seem more tidy -->
			<div class="spacer44"></div>
			
		</header>
		
		<center>
		
			<content>
			
				<?php
				
				//defaults to the "drive_site_dir" variable's location, for example: "C:/wamp/www/domain_name.com/LegitPunk.com/templates/file_explorer_iterator/config.cfg".
				$lines	=	file($_SESSION['drive_site_dir'].'config.cfg');		

				foreach($lines as $line)
				{
					$linee						=	preg_replace('/\s+/', '', $line);
					$array_of_lines[]	=	str_replace(";", "", $linee);
				}

				if($array_of_lines[0] === '1')
				{
					$_SESSION['http']							=	'http://';
				}
				else
				{
					$_SESSION['http']							=	'https://';
				}

				$_SESSION['version']						=	$array_of_lines[1];
				$_SESSION['domain']						=	$array_of_lines[2];
				$_SESSION['images_logo']			=	$array_of_lines[3];
				$_SESSION['apache_alias']			=	$array_of_lines[4];  	 //		'http://localhost/refit_cars_00001/';
				$_SESSION['original_dir']				=	$array_of_lines[5];  	//		'F:/AMD_Pictures/refit_cars_00001/'


				$dirs = array_filter(glob($_SESSION['drive_site_dir'].'updates/*'), 'is_dir');

				foreach($dirs as $dir)
				{
					$array_dir[]		=	str_replace($_SESSION['drive_site_dir'].'updates/', '', $dir);
				}

				//put selected version to the top of the select list array. 
				$a=0;
				foreach($array_dir as $dir)
				{
					if($dir === $_SESSION['version'])
					{
						unset($array_dir[$a]);
					}
					$a++;
				}
				
				array_unshift($array_dir , $_SESSION['version']);

				?>

				<div class="list">
					<p class="list_p">Encryption</p>
					<select id="select_encryption">
						<option>http</option>
						<option>https</option>
					</select>
				</div>

				<script>
					$("#select_encryption").on
					(
						'change', function() 
						{
							/*alert(this.value);*/
							$.ajax
							(
								{	
									
									data:{type : "select_encryption", value : this.value},
									type: "post",
									url: "<?php echo $_SESSION['http_site_dir']; ?>config/change_config.php",
									success: function(data)
									{
										/*
										script = $(data).text();		//useful for printing errors
										$.globalEval(script);			//can eval javascript code if needed
										alert(data);							//for error checking
										*/
										
										$("#Run").append(data);
									}
								}
							);
						}
					);
				</script>

				<!-- adds html select options of http or https version -->
				<div class="list">
					<p class="list_p">Version</p>
					<select id="select_version">
						<?php
						foreach($array_dir as $dir)
						{
							echo '<option>'.$dir.'</option>';
						}
						?>
					</select>
				</div>

				<script>
					$("#select_version").on
					(
						'change', function() 
						{
							/*alert(this.value);*/
							$.ajax
							(
								{	
									
									data:{type : "select_version", value : this.value},
									type: "post",
									url: "<?php echo $_SESSION['http_site_dir']; ?>config/change_config.php",
									success: function(data)
									{
										//script = $(data).text();
										//$.globalEval(script);
										//alert(data);
										
										$("#Run").append(data);
									}
								}
							);
						}
					);
				</script>

				<!-- adds edit "Domain" config variable -->
				<div class="list">
					<p class="list_p">Domain</p>
					<input class="list_input" value="localhost" onkeyup="select_domain(this.value)"></input>
				</div>

				<script>

				function	select_domain(value)
				{
					$.ajax
					(
						{	
							data:{type : "select_domain", value : value},
							type: "post",
							url: "<?php echo $_SESSION['http_site_dir']; ?>config/change_config.php",
							success: function(data)
							{
								//script = $(data).text();
								//$.globalEval(script);
								//alert(data);
								$("#Run").append(data);
							}
						}
					);
				}

				</script>

				<!-- adds edit "logo" config variable -->
				<div class="list">
					<p class="list_p">Images Logo (/images/logo.png)</p>
					<input class="list_input" value="logo.png" onkeyup="select_logo(this.value)"></input>
				</div>

				<script>

				function	select_logo(value)
				{
					$.ajax
					(
						{	
							data:{type : "select_logo", value : value},
							type: "post",
							url: "<?php echo $_SESSION['http_site_dir']; ?>config/change_config.php",
							success: function(data)
							{
								//script = $(data).text();
								//$.globalEval(script);
								//alert(data);
								$("#Run").append(data);
							}
						}
					);
				}

				</script>

				<!-- adds edit "apache2 alias" config variable -->
				<div class="list">
					<p class="list_p">Apache Alias to C:/Dir/Folder with images</p>
					<input class="list_input" onkeyup="select_alias(this.value)" value="<?php echo $_SESSION['apache_alias']; ?>"></input>
				</div>

				<script>

				function	select_alias(value)
				{
					$.ajax
					(
						{	
							data:{type : "select_alias", value : value},
							type: "post",
							url: "<?php echo $_SESSION['http_site_dir']; ?>config/change_config.php",
							success: function(data)
							{
								//script = $(data).text();
								//$.globalEval(script);
								//alert(data);
								$("#Run").append(data);
							}
						}
					);
				}

				</script>

				<!-- adds edit "C:/folder" config variable -->
				<div class="list">
					<p class="list_p">C:/Dir/Folder with images</p>
					<input class="list_input" onkeyup="select_folder(this.value)" value="<?php echo $_SESSION['original_dir']; ?>"></input>
				</div>

				<script>

				function	select_folder(value)
				{
					$.ajax
					(
						{	
							data:{type : "select_folder", value : value},
							type: "post",
							url: "<?php echo $_SESSION['http_site_dir']; ?>config/change_config.php",
							success: function(data)
							{
								//script = $(data).text();
								//$.globalEval(script);
								//alert(data);
								$("#Run").append(data);
							}
						}
					);
				}

				</script>
			
			</content>
			
		</center>
		
		<footer>
		
		</footer>
		
	</body>
	
	<!-- executed scripts get placed in the Run div, hidden from the displayed html -->
	<div id="Run"></div>
	
</html>
		