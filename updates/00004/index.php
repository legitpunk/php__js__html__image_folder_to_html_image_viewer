<?php


//need to create an apache_alias to the folder that holds the file files you want the explorer to navigate

$_SESSION['basename_file']		=	basename(__FILE__);
$_SESSION['drive_site_dir'] 			=	str_replace($_SESSION['basename_file'], '', $_SERVER["SCRIPT_FILENAME"]);		// asdasd  				C:/wamp650/www/LegitPunk.com/templates/file_explorer_iterator/
$_SESSION["site_dir"]						=	str_replace($_SESSION['basename_file'], '', $_SERVER["SCRIPT_NAME"]);		// asdasd          				/LegitPunk.com/templates/file_explorer_iterator/
$_SESSION['http_dir']						=	$_SESSION['http'].$_SESSION['domain'].$_SESSION["site_dir"].'updates/'.$_SESSION['version'].'/';
$_SESSION['http_site_dir']			=	$_SESSION['http'].$_SESSION['domain'].$_SESSION["site_dir"];

//if the page was loaded after a navigation button was pressed
if(isset($_POST['URI']))
{
	//assign dir variable for use
	$_SESSION['dir']							=	$_POST['URI'];	//+ &quot;'.$fileInfo->getFilename().'/&quot;\
	unset($_POST['URI']);
	
	//check if new page is set in the "previous_dir" array, to check if the user clicked back a navigation position
	foreach($_SESSION['previous_dir'] as $key => $value)
	{
		//this is if they DID
		if($_SESSION['dir'] === $value)
		{
			$keyy	=	1;
		}
	}
	
	/*
	If the user DID navigate back a postion in the folder directories, then remove the other directory nodes from the "previous_dir" array. 
	For example, if "previous_dir" array makes this directory string:   
	C:/folder/subfolder/another_folder/another_folder2/ 		
	and they navigated to the "subfolder" directory, then the "previous_dir" array would make the string:
	C:/folder/subdfolder
	*/
	
	if(isset($keyy))
	{
		if($keyy === 1)
		{
			//to search the "previous_dir" array for the clicked directory name, and get the index number of that element.
			if (($key = array_search($_SESSION['dir'], $_SESSION['previous_dir'])) !== false)
			{
				$position = array_search($key, array_keys($_SESSION['previous_dir']));
				if ($position !== false)
				{
					//remove the other directories after the clicked directory
					array_splice($_SESSION['previous_dir'], ($position + 1));
				}
			}
			else
	//else, if the clicked directory is a new directory not found in the "previous_dir" array, then add the newly clicked directory to the array.
			{
				array_push($_SESSION['previous_dir'], $_SESSION['dir']);		//str_replace($_SESSION['original_dir'], "", 
				array_push($_SESSION['dir_name'], str_replace($_SESSION['original_dir'], "", $_SESSION['dir'])); 
			}
		}
		else
		{
			array_push($_SESSION['previous_dir'], $_SESSION['dir']);		//str_replace($_SESSION['original_dir'], "", 
			array_push($_SESSION['dir_name'], str_replace($_SESSION['original_dir'], "", $_SESSION['dir'])); 
		}
	}
	else
	{
		array_push($_SESSION['previous_dir'], $_SESSION['dir']);		//str_replace($_SESSION['original_dir'], "", 
		array_push($_SESSION['dir_name'], str_replace($_SESSION['original_dir'], "", $_SESSION['dir'])); 
	}
	
	//this makes a variable that the browser can read to view and display the folders and files
	$_SESSION['apache_alias']						=	str_replace($_SESSION['original_dir'], $_SESSION['apache_alias'], $_SESSION['dir']);
}
else
{
	//on initial load, make a few array variables and assign some values to use 
	$_SESSION['dir_name']				=	[];
	$_SESSION['previous_dir']		=	[];
	$_SESSION['dir']							=	$_SESSION['original_dir']; 	
	$_SESSION['previous_dir'][0]	=	$_SESSION['original_dir'];
	$_SESSION['dir_name'][0]			=	$_SESSION['original_dir'];
	?>
<!DOCTYPE html>

<html>
	
	<head>
		
		<!-- stylesheets -->
		<link rel="stylesheet" href="<?= $_SESSION['http_dir'];?>css/images.css">
		<link rel="stylesheet" href="<?= $_SESSION['http_dir'];?>css/html5.css">
		<link rel="stylesheet" href="<?= $_SESSION['http_dir'];?>css/p.css">
		
		<!-- include the font 'Roboto' -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		
		<!-- include the jquery file for the ajaz functions and some css changing functions -->
		<script type="text/javascript" src="<?= $_SESSION['http_dir'] ?>js/jquery-3.3.1.js"></script>

	</head>
	
	<body>
	
		<header>
				
				<!-- LegitPunk.com logo -->
				<img class="logo" src="<?= $_SESSION['http_site_dir']; ?>images/<?= $_SESSION['version']; ?>/<?= $_SESSION['images_logo']; ?>" class=""></img>

		</header>
	
		<!-- buttons for changing the layout, example: list, icons, grid, grid with titles, etc -->
		<div id="layout">
			<button id="button_layout_1" class="layout_button" onclick="button_layout_1()"><div class="button_layout_div"><img class="img40" src="images/<?= $_SESSION['version']; ?>/Image1_2.png"></img><p class="button_layout_p"></p></div></button>
			<button id="button_layout_2" class="layout_button" onclick="button_layout_2()"><div class="button_layout_div"><img class="img40" src="images/<?= $_SESSION['version']; ?>/Image2_2.png"></img><p class="button_layout_p"></p></div></button>
			<!-- this button has inline css to "style" the button to show that it's the default selected type of layout view. -->
			<button id="button_layout_4" class="layout_button" onclick="button_layout_4()" style="border:1px solid green;"><div class="button_layout_div"><img class="img40" src="images/<?= $_SESSION['version']; ?>/Image3_2.png"></img><p class="button_layout_p"></p></div></button>
			<button id="button_layout_3" class="layout_button" onclick="button_layout_3()"><div class="button_layout_div"><img class="img40" src="images/<?= $_SESSION['version']; ?>/Image4_2.png"></img><p class="button_layout_p"></p></div></button>
			<button id="button_layout_6" class="layout_button" onclick="button_layout_6()"><div class="button_layout_div"><img class="img40" src="images/<?= $_SESSION['version']; ?>/Image5_2.png"></img><p class="button_layout_p"></p></div></button>
			<button id="button_layout_5" class="layout_button" onclick="button_layout_5()"><div class="button_layout_div"><img class="img40" src="images/<?= $_SESSION['version']; ?>/Image6_2.png"></img><p class="button_layout_p"></p></div></button>
		</div>
		
		<nav></nav>
			
		<main></main>

		<footer></footer>
	
		<script>
		
		function Button(URI)
			{
				$.ajax
				(
					{	
						
						data:{URI : URI},
						type: 'post',
						url: 'index.php',
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
			//buttons for changing the layouts 
			function button_layout_1()
			{
				$("head").append("<style>.items_button img{width:40px;height:40px;}.items_button p{display:inline-block;margin-left:10px;}.items_button{display:inline-block;width:94%;}.file_p{width:auto;}</style>");
				$("#button_layout_1").css({"border":"1px solid green"});
				$("#button_layout_2").css({"border":"none"});
				$("#button_layout_3").css({"border":"none"});
				$("#button_layout_4").css({"border":"none"});
				$("#button_layout_5").css({"border":"none"});
				$("#button_layout_6").css({"border":"none"});
			}
			function button_layout_2()
			{
				$("head").append("<style>.items_button img{width:70px;height:70px;}.items_button p{display:inline-block;margin-left:10px;}.items_button{display:inline-block;width:94%;}.file_p{width:auto;}</style>");
				$("#button_layout_2").css({"border":"1px solid green"});
				$("#button_layout_1").css({"border":"none"});
				$("#button_layout_3").css({"border":"none"});
				$("#button_layout_4").css({"border":"none"});
				$("#button_layout_5").css({"border":"none"});
				$("#button_layout_6").css({"border":"none"});
			}
			function button_layout_3()
			{
				$("head").append("<style>.items_button img{width:140px;height:140px;}.items_button p{display:block;margin-left:0px;}.items_button{display:inline-block;width:auto;}.file_p{width:auto;}</style>");
				$("#button_layout_3").css({"border":"1px solid green"});
				$("#button_layout_1").css({"border":"none"});
				$("#button_layout_2").css({"border":"none"});
				$("#button_layout_4").css({"border":"none"});
				$("#button_layout_5").css({"border":"none"});
				$("#button_layout_6").css({"border":"none"});
			}
			function button_layout_4()
			{
				$("head").append("<style>.items_button img{width:140px;height:140px;}.items_button p{display:block;margin-left:0px;}.items_button{display:inline-block;width:auto;}.file_p{width:100px;}</style>");
				$("#button_layout_4").css({"border":"1px solid green"});
				$("#button_layout_1").css({"border":"none"});
				$("#button_layout_2").css({"border":"none"});
				$("#button_layout_3").css({"border":"none"});
				$("#button_layout_5").css({"border":"none"});
				$("#button_layout_6").css({"border":"none"});
			}
			function button_layout_5()
			{
				$("head").append("<style>.items_button img{width:200px;height:200px;}.items_button p{display:block;margin-left:0px;}.items_button{display:inline-block;width:auto;}.file_p{width:auto;}</style>");
				$("#button_layout_5").css({"border":"1px solid green"});
				$("#button_layout_1").css({"border":"none"});
				$("#button_layout_2").css({"border":"none"});
				$("#button_layout_3").css({"border":"none"});
				$("#button_layout_4").css({"border":"none"});
				$("#button_layout_6").css({"border":"none"});
			}
			function button_layout_6()
			{
				$("head").append("<style>.items_button img{width:200px;height:200px;}.items_button p{display:block;margin-left:0px;}.items_button{display:inline-block;width:auto;}.file_p{width:100px;}</style>");
				$("#button_layout_6").css({"border":"1px solid green"});
				$("#button_layout_1").css({"border":"none"});
				$("#button_layout_2").css({"border":"none"});
				$("#button_layout_3").css({"border":"none"});
				$("#button_layout_5").css({"border":"none"});
				$("#button_layout_4").css({"border":"none"});
			}
		
		</script>

	</body>
	
	<!-- executed scripts get placed in the Run div, hidden from the displayed html -->
	<div id="Run"></div>
	
</html>

<?php

}

//echo '<script>var original_dir	=	"'.$_SESSION['original_dir'].'";</script>';

//empty the navs every time the user clicks folder to navigate to.
echo '<script>$("main").empty();</script>';
echo '<script>$("nav").empty();</script>';

//checks if there's more than 2 elements in the "previous_dir" array before continuing.
//if there is, then that means we don't use the "original_dir" as the "up" button.
if(isset($_SESSION['previous_dir'][count($_SESSION['previous_dir'])-2]))
{
	//assigns the "unique id" of the directory previously clicked to a javascript variable 
	$penultimate	=	$_SESSION['previous_dir'][count($_SESSION['previous_dir'])-2];
	echo '<script>var penultimate = "'.$penultimate.'";</script>';
	echo '<script>$("nav").append("<button id=\"button_up\" class=\"button nav_button nav_button_up\" onclick=\"Button(penultimate);\"><div class=\"button_up_div\"><img class=\"button_up_img\" src=\"images/'.$_SESSION['version'].'/up_directory4.png\"></img></div></button>");</script>';
}
else
{
	//if there isn't more than 2 elements in the "revious_dir" array, that means the user is viewing the initial page of the site and we need to assign a value to the "up" button javascript varaible.
	$penultimate	=	$_SESSION['original_dir'];
	echo '<script>var penultimate = "'.$penultimate.'";</script>';
	echo '<script>$("nav").append("<button id=\"button_up\" class=\"button nav_button nav_button_up\" onclick=\"Button(penultimate);\"><div class=\"button_up_div\"><img class=\"button_up_img\" src=\"images/'.$_SESSION['version'].'/up_directory4.png\"></img></div></button>");</script>';
}
$a=0;

//checks if the user has refreshed the page and removes a doubling of the session var elements in the "dir_name" array.
foreach($_SESSION['dir_name'] as $key => $value)
{
	if($key === 0)
	{
		
	}
	else
	{
		$asdf = $key - 1;
		if(strpos($_SESSION['dir_name'][$key], $_SESSION['dir_name'][$asdf ]) !== false)
		{
			$_SESSION['dir_name'][$key]	=	str_replace($_SESSION['dir_name'][$asdf ], "", $_SESSION['dir_name'][$key]);
		}
	}
}

//creates a new javascript variable per directory
if(!empty($_SESSION['previous_dir'][0]))
{
	foreach($_SESSION['previous_dir'] as $key => $element)
	{
		$asdf													=	str_replace("/", "_", $element);
		$asdf													=	str_replace(":", "_", $asdf);
		echo '<script>var a_'.$asdf.' 	= "'.$element.'";</script>';
		echo '<script>$("nav").append("<button class=\"nav_button\" onclick=\"Button(a_'.$asdf.');\"><div class=\"button_up_div\"><p class=\"nav_button_p\">'.$_SESSION['dir_name'][$a].'</p></div></button>");</script>';
		$a++;
	}
}

//scans the directory and puts data like files and folders into arrays.
foreach (new DirectoryIterator($_SESSION['dir']) as $fileInfo) 
{
	if($fileInfo->isDot()) continue;
	if($fileInfo->isDir())
	{
		$dirs[]	=	$fileInfo->getFilename();
	}
	elseif($fileInfo->isFile())
	{
		$files[]	=	$fileInfo->getFilename();
	}
}

//makes a folder button for each of the folders detected in the scan dir code.
if(isset($dirs))
{
	foreach ($dirs as $dir) 
	{
		$new_dir	=	''.$dir.'/';
		$js_new_dir	=	$_SESSION['dir'].$new_dir;
		echo 	'<script>var a_'.md5($_SESSION['dir'].$new_dir).' = "'.$_SESSION['dir'].$new_dir.'";</script>';
		$html	=	'<button class=\"button items_button\" onclick=\"Button(a_'.md5($_SESSION['dir'].$new_dir).')\"><div class=\"folder\"><img class=\"folder_img\" src=\"images/'.$_SESSION['version'].'/folder.png\"></img><p>'.$dir.'</p></div></button>';
		echo '<script>$("main").append("'.$html.'");</script>';
	}
}

//display an image file for each of the folders detected in the scan dir code.
if(isset($files))
{
	foreach ($files as $file) 
	{
		$filename	=	$file;
		if(strpos($filename, "thumbnail") !== false)
		{
				$file	=	$_SESSION['apache_alias'].$file;
				echo '<script>$("main").append("<button class=\"button items_button\" onclick=\"\"><div class=\"file \"><img class=\"file_img\" src=\"'.$file.'\"></img><p class=\"file_p\">'.$filename.'</p></div></button>");</script>';
		}
	}
}

?>

	
			










