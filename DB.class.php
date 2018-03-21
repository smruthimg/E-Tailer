//This file has all the functions that are used to query the database

<?php
 include ("Classes/Product.class.php");
 include ("Classes/User.class.php");
 include ("Classes/Cart.class.php");
class DB {
	private $dbh;


// constructor to make DB cconnection	
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
 //Desc:function to get the details for the product selected in the admin dropdown to edit item
 //input:product id
 //output:HTML form to update a product
 	function getProductParameterized($id){
$bigString="";
		try{
 
		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT where ProductID=:ProductID ");//instead of ? we have parameters
    $stmt->bindParam(":ProductID",$id);  
		$stmt->execute();//:id=> or id=>
        
    $stmt->setFetchMode(PDO::FETCH_CLASS,'Product');//fetching data
    $data=$stmt->fetch();

	if(count($data)>0){

 
 		$bigString.="
    <form action='admin.php' enctype='multipart/form-data' method='post'>\n
   <table>\n

					<tr><td ><h3>Edit Item:</h3></td></tr>\n
                  <tr>\n

					   <td>\n

						   ID:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='id' value=\"{$data->getID()}\" readonly/>\n

					   </td>\n

				   </tr>\n
   
				   <tr>\n

					   <td>\n

						   Name:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='name' value= \"{$data->getProdName()}\"/>\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Description:\n
					   </td>\n

					   <td>\n

						   <textarea name='description' value={$data->getProdDesc()}>{$data->getProdDesc()}</textarea>\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Price:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='price'  value={$data->getPrice()} />\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Quantity on hand:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='quantity' value={$data->getQTY()} />\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   Sale Price:\n
					   </td>\n

					   <td>\n

						   <input type='text' name='salesPrice' value={$data->getSalePrice()} />\n

					   </td>\n

				   </tr>\n

				   <tr>\n

					   <td>\n

						   New Image :\n
					   </td>\n

					   <td>\n

						   <input type='file' name='image' />\n

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
                   <input type='hidden' name='img' value='{$data->getImageURL()}'/>\n

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
   
   //Desc:Function to display all the products in catalog that are not on sale and qty>0
 //input:None
 //output:HTML divs with product details 
   function getAllProductsAsTableClass(){
	
	$bigString="";
   $pagelim=6;
   $total =$this->getAllProducts(0,150);
   if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
      $start_from = ($page-1) * $pagelim;  
 $data=$this->getAllProducts($start_from,$pagelim);
 echo "<h2>Showing " .count($data) ." shoes in Catalog</h2>";
	if(count($data)>0){
		$bigString="<div class='row' >\n";


			foreach($data as $row){
    
			 	 $bigString.="<div class='4u 12u(mobile)' >\n
                                             
          <section class='box'>\n  
          
				  <a href='#' class='image featured'><img src={$row->getImageURL()} alt=''/></a>\n
               <header>{$row->getProdName()}</header>\n
        <p>{$row->getProdDesc()}</p>\n
          <footer>\n
          <div>Quantity Left:{$row->getQTY()}</div>\n
						<div>$ {$row->getPrice()}</div>\n
      <div><form action='index.php' method='post'><input type='hidden' name='product' value={$row->getID()}><input type='hidden' name='Price' value={$row->getPrice()}>\n
      <input type='submit' name='add' value='Add To Cart'></form></div>\n
				  
				  </footer>\n           
         
				</section> </div>\n";

                                                                                                                       
          
          
        
			
			}//foreach
 $bigString.=" </div>\n";
 $recCount=count($total);
 $totPages=ceil($recCount/$pagelim);
 $bigString.="<div >\n";
if(isset($_GET["page"])){
$pgNo=$_GET["page"];
}
else{
$pgNo=1;
}


if($pgNo>1){
$bigString.="<a class='current' href='index.php?page=1'  style='padding: 0.75em 1.25em 0.75em 1.25em'><strong> << </strong></a>\n";
$bigString.="<a class='current' href='index.php?page=". ($pgNo-1)."'  style='padding: 0.75em 1.25em 0.75em 1.25em'><strong> < </strong></a>\n";
  
}
 for($i=$pgNo;$i<=$pgNo;$i++){
  
   $bigString.="<a class='current' href='index.php?page=$i'  style='padding: 0.75em 1.25em 0.75em 1.25em'><strong>" .$i. "</strong></a>\n";
  
 }
 if($pgNo<$totPages ){
$bigString.="<a class='current' href='index.php?page=". ($pgNo+1)."'  style='padding: 0.75em 1.25em 0.75em 1.25em'><strong> > </strong></a>\n";
  $bigString.="<a class='current' href='index.php?page=$totPages'  style='padding: 0.75em 1.25em 0.75em 1.25em'><strong> >> </strong></a>\n";
}

	 $bigString.="</div>\n";
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}
	return $bigString;
}//

//Desc:Function to get all products for the dropdown in admin page to choose a product to edit
 //input:None
 //output:HTML form with dropdown
function getAllProductsAsDropdown(){
	$data=$this->getAllCatProducts();
	$bigString="";
 
	if(count($data)>0){
		$bigString.="<div  class='6u 12u(mobile)' >\n";


		
    
			 	 $bigString.="
      <div><form action='admin.php' method='post'>\n
      <select name='productName' >\n";
     	foreach($data as $row){
        $bigString.= "<option name={$row->getID()} value='" . $row->getID() . "'>" . $row->getProdName() . "</option>";
      	}//foreach
       	 $bigString.="</select><input type='submit' name='Select' value='Select'></form>\n";

                                                                                                                       
          
          
        
			
		
 $bigString.=" </div>\n";
	
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}//if count
	return $bigString;
}


//Desc:FUnction to get all products on sale and display it in the HTML format
 //input:NOne
 //output:HTML divs with product details
 function getAllSaleProductsAsTableClass(){
	$data=$this->getAllSaleProducts();
	$bigString="";
 
 echo "<h2> Showing " .count($data) ." shoes on sale</h2>";
	if(count($data)>0){
			$bigString="";


			foreach($data as $row){
    
			 	 $bigString.="<div class='6u 12u(mobile)' style='float: left;'>\n
                                             
          <section class='box' >\n  
          
				  <a href='#' class='image featured'><img src={$row->getImageURL()} alt=''/></a>\n
               <header>{$row->getProdName()}</header>\n
        <p>{$row->getProdDesc()}</p>
          <footer>\n
          <div>Quantity Left:{$row->getQTY()}</div>\n
						<div>Previously <s>$ {$row->getPrice()}</s> Now <em>$ {$row->getSalePrice()}<em></div>\n
            <div><form action='index.php' method='post'>
            <input type='hidden' name='product' value={$row->getID()}>\n
            <input type='hidden' name='Price' value={$row->getSalePrice()}>\n
            
            <input type='submit' name='add' value='Add To Cart'></form></div>\n
				  </footer>\n           
         
				</section>\n
        </div>\n";

                                                                                                                       
          
          
        
			
			}//foreach
 $bigString.="";
	
	} else {
		$bigString="<h2>No products on sale!</h2>";
	}//if count
	return $bigString;
}//


//Desc:Function to get all the prudtcs on sale
 //input:None
 //output:array of product objects
function getAllSaleProducts(){

try{

		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT Where salePrice>0 and QTY>0");//instead of ? we have parameters
  
		$stmt->execute();//:id=> or id=>
    $stmt->setFetchMode(PDO::FETCH_CLASS,'Product');//fetching data
		while($product=$stmt->fetch()){
			$data[]=$product;
      
		}
   
		return $data;
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}


}

//Desc:FUnction to get all products in catalog not on sale
 //input:The paging start and end values
 //output:array of product objects
function getAllProducts($start_from,$pagelim){
//include('/Classes/Product.class.php');
try{
//include('Classes/Product.class.php');
		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT Where salePrice=0 and QTY>0 LIMIT $start_from, $pagelim");//instead of ? we have parameters
 // $stmt->bindParam(":start_from",$start_from);
//      $stmt->bindParam(":pagelim",$pagelim);
		$stmt->execute();//:id=> or id=>
   $stmt->setFetchMode(PDO::FETCH_CLASS,'Product');//fetching data
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


//Desc:Function to get all products in the database
 //input:None
 //output:array of product objects
 function getAllCatProducts(){

try{
		$data=array();
		$stmt=$this->dbh->prepare("select * from PRODUCT  ");//instead of ? we have parameters
  
		$stmt->execute();//:id=> or id=>
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Product");//fetching data
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
 	
  //Desc:Function to insert details in the cart table and deduct the qty in product table
 //input:Product id, sale price,Userid
 //output:last inserted id
	function addToCart($productID,$salePrice,$UserID){
  $qty=1;
 
		try{
			$stmt=$this->dbh->prepare("insert into CARTITEM (UserID,ProductID,QTY,Amt) values (:UserID,:productID,:qty,:salePrice)");

      $stmt->bindParam(":UserID",$UserID);
      $stmt->bindParam(":productID",$productID);
      $stmt->bindParam(":qty",$qty);
      $stmt->bindParam(":salePrice",$salePrice);
      
			$stmt->execute();
			$lastinserted= $this->dbh->lastInsertId();
      if($lastinserted>0){
         $this->updateProductCatalog($productID);
      
			}
      }
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	}
 
 //Desc:Function to update the product qty once the item is added to cart
 //input:priduct id
 //output:None
 function updateProductCatalog($productID){
 
 
		try{
			$stmt=$this->dbh->prepare("update  PRODUCT SET QTY=QTY-1 where ProductID=:productID and QTY>0");

      $stmt->bindParam(":productID",$productID);

			$stmt->execute();

 
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
 
 //Desc:Function to add back the qty for the product once the cart is emptied 
 //input:product id
 //output:None
  function updateProductCatalogAdd($productID){
 
 
		try{
			$stmt=$this->dbh->prepare("update  PRODUCT SET QTY=QTY+1 where ProductID=:productID ");

      $stmt->bindParam(":productID",$productID);

			$stmt->execute();

 
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
 
 //Desc:Function to initiate delete cart items. Passes the product id to updateProductCatalogAdd add the qty back
 //input:User id
 //output:None
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
 
 //Desc:Function to get the total amount of the cart for the user
 //input:User id
 //output:Total amount 
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
 
 
 //Desc:Function to get all items in the user's cart
 //input:User id
 //output:Array of product details
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


}


//Desc:Function to display all the items in cart
 //input:user id
 //output:HTML divs with item detials
function getAllCartAsTableClass($UserID){
	$data=$this->getAllCart($UserID);
	$bigString="";
 
 echo "<h2> " .count($data) ." shoes in Cart</h2>";
	if(count($data)>0){
		$bigString="<div  class='6u 12u(mobile)' >\n";


			foreach($data as $row){

			 	 $bigString.="<section class='box' >\n  
  
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
		$bigString="<h2>Nothing to display</h2>";
	}//if count
	return $bigString;
}


//Desc:Function to add the product to the database
 //input:Product details
 //output:Last inserted id
function addProduct($ProdName,$ProdDesc,$Price,$SalePrice,$QTY,$ImageURL){

		try{
			$stmt=$this->dbh->prepare("insert into PRODUCT (ProdName,ProdDesc,Price,SalePrice,QTY,ImageURL)
			values (:ProdName,:ProdDesc,:Price,:SalePrice,:QTY,:ImageURL)");
			$stmt->execute(array("ProdName"=>$ProdName,"ProdDesc"=>$ProdDesc,"Price"=>$Price,"SalePrice"=>$SalePrice,"QTY"=>$QTY,"ImageURL"=>$ImageURL));
      $result=$this->dbh->lastInsertId();
 
      
			return $result;
			}
		catch(PDOException $e){
      $e->getMessage();
			die();
		}
}

 //Desc:Function to update the fields from Admin page
 //input:The values from the edit form
 //output:last updated field
function adminUpdateProduct($ProductID,$ProdName,$ProdDesc,$Price,$SalePrice,$QTY,$ImageURL){

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


//Desc:Function to check if user id and password are valid
 //input:user id and password
 //output:the matching row from database or null if not found
function checkValidUser($userId,$password){
$data=array();
 
		try{
			$stmt=$this->dbh->prepare("Select * from  USER  where UserID=:UserID and Password=:Password");

      $stmt->bindParam(":UserID",$userId);
      $stmt->bindParam(":Password",$password);

			$data=$stmt->execute();
}
	catch(PDOException $e){
			echo $e->getMessage();
			die();
      }
	
   return $stmt->rowCount();
	}
 
 //Desc:Function to insert new user
 //input:the form values from registration form
 //output: last inserted id
 function registerUser($UserID,$FirstName,$LastName,$UserType,$Password){
 try{
			$stmt=$this->dbh->prepare("insert into USER (UserID,FirstName,LastName,UserType,Password)
			values (:UserID,:FirstName,:LastName,:UserType,:Password)");
			$stmt->execute(array("UserID"=>$UserID,"FirstName"=>$FirstName,"LastName"=>$LastName,"UserType"=>$UserType,"Password"=>$Password));
			return $this->dbh->lastInsertId();
			}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 }
 
 }
 ?>
