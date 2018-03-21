<!DOCTYPE HTML>

<html>
<head>
		<title>Shoe Town</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="stylesheet" href="assets/css/main.css" />

 
 
   
	</head>
 <body class="homepage">

 <form action="admin.php" enctype="multipart/form-data" method='post'>
   <table>

					<tr><td ><h3>Add Item:</h3></td></tr>
                 
   
				   <tr>

					   <td>

						   Name:
					   </td>

					   <td>

						   <input type="text" name="name" value="" />

					   </td>

				   </tr>

				   <tr>

					   <td>

						   Description:
					   </td>

					   <td>

						   <textarea name="description" ></textarea>

					   </td>

				   </tr>

				   <tr>

					   <td>

						   Price:
					   </td>

					   <td>

						   <input type="text" name="price"  value="" />

					   </td>

				   </tr>

				   <tr>

					   <td>

						   Quantity on hand:
					   </td>

					   <td>

						   <input type="text" name="quantity" value="" />

					   </td>

				   </tr>

				   <tr>

					   <td>

						   Sale Price:
					   </td>

					   <td>

						   <input type="text" name="salesPrice" value="0" />

					   </td>

				   </tr>

				   <tr>

					   <td>

						   Image :
					   </td>

					   <td>

						   <input type="file" name="image"  value=""/>

					   </td>

				   </tr>

			   		<tr>

					   <td>

								<strong>Your Password: </strong>
						</td>

						<td>

							<input type="password" name="password" />

						</td>

			   </table>

			   <br />

			   <input type="reset" value="Reset" />
        <input type="hidden" name="product" value=""/>
			   <input type="submit" name="add_item" value="Add Product" />
 </form>
</body>
</html>