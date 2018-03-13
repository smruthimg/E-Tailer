<?php

//connect to mysql db
//$con = mysqli_connect("localhost","root","","db_tweets") or die('Could not connect: ' . mysql_error());
	$connection=new mysqli($_SERVER['DB_SERVER'],$_SERVER['DB_USER'],$_SERVER['DB_PASSWORD'],$_SERVER['DB']);
	if($connection->connect_error){
		echo "connection failed: " .mysqli_connect_error();
		die();
	}

// prepare your insert query
$stmt = mysqli_prepare($connection, 'INSERT INTO PRODUCT(ProductID, ProdDesc, Price,OnSale,QTY,ImageURL) VALUES (?, ?, ?,?,?,?)');

// bind the upcoming variable names to the query statement
mysqli_stmt_bind_param($stmt, 'ssssss', $ProductID, $ProdDesc, $Price,$salePrice,$QTY,$ImageURL);

// loop over JSON files
$jsonfile="http://serenity.ist.rit.edu/~sg1626/341/Project_E_Tailer/data/productsData.json";


    //read the json file contents
    $jsondata = file_get_contents($jsonfile);   

    //convert json object to php associative array
    $data = json_decode($jsondata, true);

    foreach ($data as $u => $z){
        foreach ($z as $n => $line){
    echo $line["id"];
            $ProductID = $line["id"];
            $ProdDesc = $line["description"];
			//$prod_type=$line['product_type'];
            $Price = $line["price"];
			
			$salePrice=rand(0,$Price);
			$QTY=rand(1,100);
			$ImageURL=$line["imageURLs"];
		
			echo $ProductID, $ProdDesc, $Price,$salePrice,$QTY,$ImageURL;
            // execute this insertion
            mysqli_stmt_execute($stmt);
        }
    }
	
?>
