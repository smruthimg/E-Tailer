<?php

class DB {
	private $dbh;
	
	function __construct(){
		try{
			$this->dbh=new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}",$_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);	//to swtich DBs
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	}
 
 	function getProductParameterized($id){
$bigString="";
		try{
		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT where ProductID=:ProductID");//instead of ? we have parameters
		$stmt->execute(array(":ProductID"=>$id));//:id=> or id=>
   $data=$stmt->fetch();
   
	if(count($data)>0){

 
 		$bigString.="
    <form action='admin.php' method='post'>\n
   <table>\n

					<tr><td ><h3>Edit Item:</h3></td></tr>\n
                  <tr>\n

					   <td>\n

						   ID:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='id' value=\"{$data['ProductID']}\" readonly/>\n

					   </td>\n

				   </tr>\n
   
				   <tr>\n

					   <td>\n

						   Name:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='name' value= \"{$data['ProdName']}\"/>\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Description:\n
					   </td>\n

					   <td>\n

						   <textarea name='description' value={$data['ProdDesc']}>{$data['ProdDesc']}</textarea>\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Price:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='price'  value={$data['Price']} />\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Quantity on hand:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='quantity' value={$data['QTY']} />\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Sale Price:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='salesPrice' value={$data['SalePrice']} />\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   New Image :\n
					   </td>\n

					   <td>\n

						   <input type='file' name='image' value=/>\n

					   </td>\n

				   </tr>\n

			   		<tr>\n

					   <td>\n

								<strong>Your Password: </strong>\n
						</td>\n

						<td>\n

							<input type='password' name='password' />\n

						</td>\n

			   </table>\n

			   <br />\n

			   <input type='reset' value='Reset' />\n
                   <input type='hidden' name='img' value={$data['Price']}/>\n

			   <input type='submit' name='update_prod' value='Update Product' />\n
 </form>";


		
}

			}
      
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
   return $bigString;
   }
   
   
   function getAllProductsAsTableClass(){
	
	$bigString="";
   $pagelim=5;
   if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
      $start_from = ($page-1) * $pagelim;  
 $data=$this->getAllProducts($start_from,$pagelim);
 echo "<h2> " .count($data) ." shoes in Catalog</h2>";
	if(count($data)>0){
		$bigString="<div  class='6u 12u(mobile)' >\n";


			foreach($data as $row){
    
			 	 $bigString.="
          <section class='box'  style='float:left>\n  
          
				  <a href='#' class='image featured'><img src={$row['ImageURL']} alt=''/></a>\n
               <header>{$row['ProdName']}</header>\n
        <p>{$row['ProdDesc']}</p>
          <footer>\n
          <div>Quantity Left:{$row['QTY']}</div>\n
						<div>$ {$row['Price']}</div>\n
      <div><form action='index.php' method='post'><input type='hidden' name='product' value={$row['ProductID']}><input type='hidden' name='Price' value={$row['Price']}>\n
      <input type='submit' name='add' value='Add To Cart'></form></div>\n
				  
				  </footer>\n           
         
				</section> \n";

                                                                                                                       
          
          
        
			
			}//foreach
 $bigString.=" </div>\n";
 $recCount=count($data);
 $totPages=ceil($recCount/$pagelim);
 $bigString.="<div >\n";
 for($i=1;$i<=$recCount;$i++){
 
   $bigString.="<a class='current' href='index.php?page=".$i."' style='padding: 0.75em 1.25em 0.75em 1.25em;'><strong>" .$i. "</strong></a>\n";
 }
 
	 $bigString.="</div>\n";
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}//if count
	return $bigString;
}//getAllProductsAsTable


function getAllProductsAsDropdown(){
	$data=$this->getAllProducts();
	$bigString="";
 
	if(count($data)>0){
		$bigString="<div  class='6u 12u(mobile)' >\n";


		
    
			 	 $bigString.="
      <div><form action='admin.php' method='post'>\n
      <select name='productName' >\n";
     	foreach($data as $row){
        $bigString.= "<option name={$row['ProductID']} value='" . $row['ProductID'] . "'>" . $row['ProdName'] . "</option>";
      	}//foreach
       	 $bigString.="</select><input type='submit' name='Select' value='Select'></form>\n";

                                                                                                                       
          
          
        
			
		
 $bigString.=" </div>\n";
	
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}//if count
	return $bigString;
}//getAllProductsAsTable

 function getAllSaleProductsAsTableClass(){
	$data=$this->getAllSaleProducts();
	$bigString="";
 
 echo "<h2> " .count($data) ." shoes on sale</h2>";
	if(count($data)>0){
		$bigString="<div  class='6u 12u(mobile)' >\n";


			foreach($data as $row){
    
			 	 $bigString.="
          <section class='box'  style='float:left>\n  
          
				  <a href='#' class='image featured'><img src={$row['ImageURL']} alt=''/></a>\n
               <header>{$row['ProdName']}</header>\n
        <p>{$row['ProdDesc']}</p>
          <footer>\n
          <div>Quantity Left:{$row['QTY']}</div>\n
						<div>Previously <s>$ {$row['Price']}</s> Now <em>$ {$row['SalePrice']}<em></div>\n
            <div><form action='index.php' method='post'>
            <input type='hidden' name='product' value={$row['ProductID']}>\n
            <input type='hidden' name='Price' value={$row['SalePrice']}>\n
            
            <input type='submit' name='add' value='Add To Cart'></form></div>\n
				  </footer>\n           
         
				</section> \n";

                                                                                                                       
          
          
        
			
			}//foreach
 $bigString.=" </div>\n";
	
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}//if count
	return $bigString;
}//getAllProductsAsTable



function getAllSaleProducts(){

try{
		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT Where salePrice>0 LIMIT 5");//instead of ? we have parameters
  
		$stmt->execute();//:id=> or id=>
		while($row=$stmt->fetch()){
			$data[]=$row;
		}
		return $data;
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}


}

function getAllProducts($start_from,$pagelim){

try{
		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT Where salePrice=0 LIMIT $start_from, $pagelim");//instead of ? we have parameters
  
		$stmt->execute();//:id=> or id=>
		while($row=$stmt->fetch()){
			$data[]=$row;
		}
		return $data;
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}


}//get all people

 
 	
	function addToCart($productID,$salePrice){
 $cartItemID=1;
  $cartID=1;
  $qty=1;
 
		try{
			$stmt=$this->dbh->prepare("insert into CARTITEM (UserID,ProductID,QTY,Amt) values (:UserID,:productID,:qty,:salePrice)");

      $stmt->bindParam(":UserID",$cartID);
      $stmt->bindParam(":productID",$productID);
      $stmt->bindParam(":qty",$qty);
      $stmt->bindParam(":salePrice",$salePrice);
      
			$stmt->execute();
			$lastinserted= $this->dbh->lastInsertId();
      if($lastinserted>=0){
         $this->updateProductCatalog($productID);
      
			}
      }
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	}
 
 function updateProductCatalog($productID){
 
 
		try{
			$stmt=$this->dbh->prepare("update  PRODUCT SET QTY=QTY-1 where ProductID=:productID");

      $stmt->bindParam(":productID",$productID);

			$stmt->execute();

 
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
  function updateProductCatalogAdd($productID){
 
 
		try{
			$stmt=$this->dbh->prepare("update  PRODUCT SET QTY=QTY+1 where ProductID=:productID");

      $stmt->bindParam(":productID",$productID);

			$stmt->execute();

 
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
 
 function deleteCart($UserId){
	$data=$this->getAllCart($UserId);
	if(count($data)>0){

			foreach($data as $row){
      $this->updateProductCatalogAdd($row['ProductID']);
      }
      }
		try{
   
			$stmt=$this->dbh->prepare("delete from  CARTITEM  where UserID=:UserID");

      $stmt->bindParam(":UserID",$UserId);

			$stmt->execute();

 
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
  function getSumCart($UserId){
 $data=array();
 
		try{
			$stmt=$this->dbh->prepare("Select Truncate(SUM(Amt),2) as sum from  CARTITEM  where UserID=:UserID");

      $stmt->bindParam(":UserID",$UserId);

			$stmt->execute();
      while($row=$stmt->fetch()){
			$data[]=$row;

		}
   if($data[0]['sum']!=NULL){
   
		return $data[0]['sum'];
}else
{
return 0;
}

			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
 
 function getAllCart($UserId){

try{
		$data=array();
		$stmt=$this->dbh->prepare("select PRODUCT.ProductID,PRODUCT.ProdName,PRODUCT.ProdDesc,CARTITEM.QTY,CARTITEM.Amt from CARTITEM JOIN PRODUCT on CARTITEM.ProductID=PRODUCT.ProductID  where CARTITEM.UserID=:UserID");//instead of ? we have parameters
        $stmt->bindParam(":UserID",$UserId);
		$stmt->execute();//:id=> or id=>
		while($row=$stmt->fetch()){
			$data[]=$row;
		}
		return $data;
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}


}//get all people

function getAllCartAsTableClass(){
	$data=$this->getAllCart(1);
	$bigString="";
 
 echo "<h2> " .count($data) ." shoes in Cart</h2>";
	if(count($data)>0){
		$bigString="<div  class='6u 12u(mobile)' >\n";


			foreach($data as $row){

			 	 $bigString.="<section class='box'  style='float:left'>\n  
  
         <h2> {$row['ProdName']}</h2>

    <h5>Description: {$row['ProdDesc']}</h5>\n
    </ br>\n
        <h2>Quantity: {$row['QTY']}</h2>\n
   </ br>\n
						<h2>Price: $ {$row['Amt']}</h2>\n

				</section> \n";

                                                                                                                       
          
          
        
			
			}//foreach
 $bigString.=" </div>\n";
	
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}//if count
	return $bigString;
}//getAllProductsAsTable

function addProduct($ProductID,$ProdName,$ProdDesc,$Price,$SalePrice,$QTY,$ImageURL){
		try{
			$stmt=$this->dbh->prepare("insert into PRODUCT (ProductID,ProdName,ProdDesc,Price,SalePrice,QTY,ImageURL)
			values (:ProductID,:ProdName,:ProdDesc,:Price,:SalePrice,:QTY,:ImageURL)");
			$stmt->execute(array("ProductID"=>$ProductID,"ProdName"=>$ProdName,"ProdDesc"=>$ProdDesc,"Price"=>$Price,"SalePrice"=>$SalePrice,"QTY"=>$QTY,"ImageURL"=>$ImageURL));
			return $this->dbh->lastInsertId();
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
}

 
function adminUpdateProduct($ProductID,$ProdName,$ProdDesc,$Price,$SalePrice,$QTY,$ImageURL){
echo $ProductID,$ProdName,$ProdDesc,$Price,$SalePrice,$QTY,$ImageURL;
		try{
			$stmt=$this->dbh->prepare("update PRODUCT set ProdName=:ProdName,ProdDesc=:ProdDesc,Price=:Price,SalePrice=:SalePrice,QTY=:QTY,ImageURL=:ImageURL where ProductID=:ProductID");
			$stmt->execute(array("ProductID"=>$ProductID,"ProdName"=>$ProdName,"ProdDesc"=>$ProdDesc,"Price"=>$Price,"SalePrice"=>$SalePrice,"QTY"=>$QTY,"ImageURL"=>$ImageURL));
			return $this->dbh->lastInsertId();
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
}
	}
 ?>