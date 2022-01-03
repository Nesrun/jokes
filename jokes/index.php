<?php
include_once "config" . DIRECTORY_SEPARATOR . "Database.php";

$database = new Database();
$db = $database->getConnection();

	// Checking if there is a category
	if (isset($argv[1])){
		echo "Entered category : ".$argv[1]." \n";
		// If there is a category, the jokes in that category will be listed and saved in the database.
		function get_content($URL){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $URL);
			$data = curl_exec($ch);
			curl_close($ch);
			return json_decode($data);
		}
		$URL = "https://api.chucknorris.io/jokes/random?category=".$argv[1];
		$jokes = get_content($URL);
		if (!isset($jokes->status)) {
			$cat_title = $jokes->categories[0];
			$jokes_contents = $jokes->value;
			$sqlCtgry = "SELECT cat_id FROM category WHERE title = '$cat_title'";
			$rsCtgry = mysqli_query($db, $sqlCtgry);
			if ($rsCtgry && $stnCtgry = mysqli_fetch_object($rsCtgry)) {
				$sqlJoin = "INSERT INTO jokes (cat_id,contents) VALUE ($stnCtgry->cat_id,'$jokes_contents')";
				$rsJoin = mysqli_query($db, $sqlJoin);
				if (!$rsJoin) echo "Error";
			}
			echo $jokes_contents;
		}else{
			echo 	"No data found for the entered category.";
		}
	}else{
		echo "Category not entered \n";
		echo "--------------------\n";
		// If there is no category, the categories on the site will be listed and saved in the database.
		$categorys = json_decode(file_get_contents("https://api.chucknorris.io/jokes/categories"));
		$cat_arr = [];
		$sqlSelect = "SELECT title FROM category ";
		$rsSelect = mysqli_query($db,$sqlSelect);
		if ($rsSelect){
			while ($stnSelect = mysqli_fetch_object($rsSelect)){
				array_push($cat_arr,$stnSelect->title);
			}
		}
		// save to database
		$i=1;
        foreach ($categorys as $item) {
			if (!in_array($item,$cat_arr)) {
				$sqlInsert = "INSERT INTO category (title) VALUE ('$item')";
				$rsInsert = mysqli_query($db, $sqlInsert);
				if (!$rsInsert) echo "Error";
			}
			echo $i.") ".$item."\n";
		$i++; }
		echo "--------------------\n";
       // print_r($categorys);
        echo "\nEnter one of the categories";
	}
