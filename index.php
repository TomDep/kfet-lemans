<?php
	/*session_start();

	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
		header('Location: login.php');
	}*/	

	// Include the database connect file
	require_once('lib/connect.php');
	$mysqli = connectToDatabase();

	// Update the session variables
	$req = 'SELECT bdlc_member, credit FROM users WHERE id = ?';
	if($stmt = $mysqli->prepare($req)) {
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();

		$stmt->bind_result($bdlc_member, $credit);
		while($stmt->fetch()) {
			$_SESSION['bdlc_member'] = $bdlc_member;
			$_SESSION['credit'] = $credit;
		}
	}
	
	function displayCategory($category) {
		// Get all products
		$mysqli = connectToDatabase();

		$result = $mysqli->query('SELECT * FROM products WHERE category = ' . $category);
		while($row = $result->fetch_assoc()) {
			$actualPrice = ($_SESSION['bdlc_member']) ? $row['bdlc_price'] : $row['price'];
?>
<div class="presentation-card" id="<?php echo htmlspecialchars($row['id']); ?>" onclick="toggleItem(<?php echo htmlspecialchars($category+1); ?>, <?php echo htmlspecialchars($row['id']); ?>)">
  <img class="card-picture" id="card-picture" src="res/images/products/<?php echo htmlspecialchars($row['image']); ?>">
  <div class="content">
      <h4 class="card-name"><?php echo htmlspecialchars($row['name']); ?></h4>
      <h4 class="card-subtitles">Prix unitaire: <?php echo htmlspecialchars($actualPrice); ?> €</h4>
  </div> 
</div>
<?php
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include "templates/head.php"; ?>
		<title>Kfet - Accueil</title>
		<style type="text/css">

			.index-profile {        
        margin: 100px 20px 10px 20px;
        height: 60px;
      }

      @media(max-width:  600px) {
      	.index-profile {        
    	    margin: 60px 20px 10px 20px;
  	      height: 60px;
	      }
      }

      .index-profile-picture{
          border-radius: 50%;
          width: 50px;
          height: 50px;
          float: left;
          vertical-align: middle;
          margin: 10px 0;
      }

      .index-profile .content{
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        flex-direction: column;
        margin-left: 60px;
      }

      .index-name{ 
          font-size: 14px;
          font-weight: bold;
      }

      .index-money{
          font-size: 12px;
          /*font-style: italic;*/
      }

      .sub-categories-title{
      	margin-left: 20px;
      	font-size: 14px;
      	margin-bottom: 0px;
      	
      }

      .menuspan{
			  height: 2px;
			  background: black;

			  display: block;
			  position: absolute;
			  border-radius: 3px;
			}

			#span-event{
				width: calc(100% - 120px);
			  margin: -5px 20px 0px 100px;
			}

			#span-like{
				width: calc(100% - 230px);
			  margin: -5px 20px 0px 210px;
			}

			.sub-categories{
				margin-bottom: 10px;
				/*
				*  15vh for the box and 20px for the title 
 				*/
				height: calc(15vh + 20px);
			}

			.carousel-item img{
				height: 15vh;
				width: calc(100% - 40px);
				margin: 0 20px;
			}

			.carousel-indicators{
				bottom: -15px;
				z-index: 1;
			}

			.carousel-control-prev, .carousel-control-next{
				height: 15vh;
				margin: 15px 20px;
				margin-bottom: 0;
			}

			.sub-categories .favorites-items{
				height: 15vh;
				width: calc(100% - 40px);   	/*Same size as .carousel-item img : must use a variable for that*/
				margin: 0 20px;

				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
				justify-content: space-between;
				align-items: flex-start;
				align-content: flex-start;
			}

			.favorites-items .sub-presentation-card{
				height: 100%;
				width: 100px;
				background-color: white;
				border-radius: 10px;
				padding-top: 5px;
			}

			.favorites-items .sub-presentation-card .card-picture{
				padding-top: 10px;
				
				display: block;
				margin: 0 auto;
				
				float: none;

				width: 60px;
				height: 60px;
			}

			.favorites-items .sub-presentation-card .content{
				padding-top: 10px;
				height: auto;
			}

			.favorites-items .sub-presentation-card .content h4{
				width: 50%;
			}

			.favorites-items .sub-presentation-card .content .card-name{
				font-size: 14px;
				float: left;
				padding-left: 5px;
			}

			.favorites-items .sub-presentation-card .content .card-subtitles{
				float: right;
				text-align: right;
				padding-right: 5px;
			}

			.centered-text{
				text-align: center;
				margin-left: 0px;
				margin-bottom: -10px;
			}

			#categories-items{
				height: calc(35vh + 20px);
			}
			/* Create two equal columns that floats next to each other */
			.column {
			  width: calc(50% - 10px);
			  height: 15vh;
			  /*background-color: grey;*/
			  margin: 5px;
				background-size: 100% auto;
			  cursor: pointer;
			}

			.row{
				width: calc(100% - 40px);
				margin: 10px 20px;
				justify-content: space-between;
			}

			.underline{
				border-bottom: black 2px solid;
				margin:  -5px 20px;
			}


			/*********************************/

			  .header h1{
          font-size: 20px;
          text-align: center;
          margin-top: 20px;
          margin-bottom: 10px;
        }

        .header p{
            margin: 0 15px;
            font-size: 14px;
        }

        #shop .header h1{
        	border-top: 1px solid black;
        	padding: 10px 0;
        	font-size: 24px;
        }

        .presentation-card {
          float: left;
         
          filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
          border-radius: 10px;
          
          background-color: white;

          width: calc(100% / 4 - 40px);
          margin: 10px 20px;

          cursor: pointer;
        }

        .card-picture{
            border-radius: 50%;
            width: 40px;
            height: 40px;
            float: left;
            margin: 10px 0 0 10px ;     
        }

        .presentation-card .content{
          height: 60px;
          display: flex;
          justify-content: center;
          align-items: flex-start;
          flex-direction: column;
          margin-left: 70px;
        }

        .card-name{ 
            font-size: 18px;
            font-weight: bold;
        }

        .card-subtitles{
            font-size: 14px;
            /*font-style: italic;*/
        }

        /* 
        *   We are adding a new breakpoint for having a better view of the team on middle sized screen
        *
        *   Tips : Using calc function to share the space fairly on the screen
        *   width = size of the box / number of columns - margin's sides size * 2  
        */

        @media(max-width: 1200px){
            .presentation-card{
                width: calc(100% / 2 - 40px);
                margin: 10px 20px;
            }
        }

        @media(max-width: 600px){
            .presentation-card{
                width: calc(100% - 20px);
                margin: 5px 10px;
            }
        }

        			/*********************************/

        .shoping-cart .icon{
        	color:  black;
        	border-radius: 100%;
        	height: 60px;
        	width: 60px;
        	font-size: 2em;
        	padding: 5px 10px;

        	position: fixed;
        	right: 0;
        	bottom: 0;
        	margin: 0 20px 20px 0;

        	z-index: 15;
					background-color: #f1f2f6;
					background-image: linear-gradient(315deg, #f1f2f6 0%, #c9c6c6 74%);

					filter: drop-shadow(3px 5px 2px rgb(0 0 0 / 0.4));

					box-shadow:  5px 5px 100px #c2c2c2,
					             -5px -5px 100px #ffffff;
        }

        .shoping-cart .icon .fa-layers-counter{
        	position: fixed;
        	right: 0;
        	bottom: 0;
        	margin: 0 0 40px 0;
        	font-size: 20px;
        	background-color: #ff8c00;
        	border-radius: 100%;

        	height: 30px;
        	width: 30px;
        }

        .shoping-cart #order-summary{
        	display: none;
        	position: fixed;
        	font-size: 500px;
        	width: calc(100vw - 40px);
        	margin: 0 20px;
        	height: calc(80vh - 200px);
        	background-color: white;
        	z-index: 10;
        	top: 100px;
          filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));

        	border-radius: 5px;

        	overflow: scroll;
        }

        .shoping-cart #order-summary h1{
        	font-size: 24px;
        	font-weight: bold;
        	border-bottom: black 1px solid;
        	padding-left:10px ;
        	background-image: url("res/food_pattern.svg");
        	background-repeat: no-repeat;
				  background-attachment: fixed;
				  background-size: 100% 100%;
        	height: 50px;
        	position: relative;
        	bottom: 0;
        	padding-top: 10px;
        }

        @media (max-width: 600px){
        	.shoping-cart #order-summary h1{
        		margin-left: -50px;
        	}
        }

        .shoping-cart #order-summary .check{
        	background-color: #ff8c00;
        	
        	font-size: 24px;
        	border-radius: 100%;
        	z-index: 15;

        	position: fixed;
        
        	top: 0;
        	right: 0;
        	padding: 6px 15px;
        	margin: 20px 20px 0 0;

        	filter: drop-shadow(3px 5px 2px rgb(0 0 0 / 0.4));

        	border: none;
        }

        .shoping-cart #order-summary .presentation-card{
					box-shadow: var(--color-secondary) 0px 10px 30px -10px;        
				}

        .presentation-card .content-sm .card-subtitles{
        	margin-bottom: 2px;
        	font-size: 12px;
        }

        .presentation-card .delete{
        	position: fixed;
        	right: 0;
        	bottom: 0;
        	font-size: 14px;
        	
        	height: 61px;
        	padding-top: 20px;
        	width: 30px;
        }

        .shoping-cart #order-summary #order-form .presentation-card{
          width: calc(100% - 20px);
          margin: 5px 10px;
        }

        .shoping-cart #order-summary #order-form .presentation-card .content-sm{
        	margin-left: 70px;
        }

        .shoping-cart #order-summary #order-form .presentation-card .content-sm .card-name{
        	margin: 5px 0;
        }

        @media (min-width: 600px){
        	.shoping-cart #order-summary{
						height: calc(100vh - 180px);
						width: 20%;
						margin: 0 40%;
						overflow: hidden;
        	}
        	
        }

        @media (max-width:  600px){
        	.shoping-cart #order-summary{
        		top: 70px;
        		height: calc(100vh - 180px);
        	}
        }

        /************************/

        .detailed-item{
        	display: none;
        	position: fixed;
        	font-size: 500px;

        	background-color: white;
        	z-index: 5;
        	top: 100px;
          filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));

        	border-radius: 5px;

        	height: calc(100vh - 180px);
					width: 20%;
					margin: 0 40%;
        }

				.detailed-item .item-presentation{
        	height: 60%;

        }

        .detailed-item .item-description{
        	height: 40%;
        }

        .detailed-item .item-presentation .item-picture{
        	position: fixed;
        	top: 0;
        	width: calc(100% - 60px);
        	margin: 0 30px;
        	padding: 30px 0;
        	height: 60%;
        }

        .detailed-item .item-presentation .item-name{
        	position: fixed;
        	background-color: black;
        	font-size: 20px;
        	color: white;
        	margin: 0 30px;
        	bottom: 40%;
        	width: calc(100% - 60px);
        	text-transform: capitalize;
        	z-index: 10;
        	line-height: 1.6;
        }

        .detailed-item .item-description{
        	margin: 0 30px;
        	width: calc(100% - 60px);
        	padding: 10px 0;
          /*box-shadow: var(--color-secondary) 0px 20px 30px 10px;*/        
        }

        .detailed-item .item-description .item-price,
        .detailed-item .item-description .item-quantity{
        	font-size: 16px;
        	margin-bottom: 2px;
        	margin-left: 15px;
        }

        .detailed-item .close{
        	position: fixed;
        	right: 0;
        	top: 0;
        	font-size: 24px;
        	
        	height: 61px;
        	padding-top: 5px;
        	padding-left: 5px;
        	width: 30px;
        }

        .detailed-item .item-add #btn-validate-lg{
        	position: absolute;
        	bottom: 0;
        	z-index: 10;
        	text-transform: none;
        	width: calc(100% - 60px);
        	margin-left: 0;
        	margin-bottom: 10%;
        	/*margin-left: calc((100% - 200px) / 2);*/
        } 

        @media (max-width: 600px){
        	.detailed-item .item-add #btn-validate-lg{
        		margin-bottom: 10px;
        	}
        }

        .detailed-item .item-control{
        	background-color: #ccc;
        	border-radius: 20px;
        	position: fixed;
        	right: 35px;
        	width: 40px;
        	height: 20%;
        	top: 65%;
        }

        .detailed-item .item-control .item-control-plus,
        .detailed-item .item-control .item-control-minus{
        	position: fixed;
        	right: 35px;
        	font-size: 24px;
        	width: 40px;
        	height: 40px;
        	border-radius: 100%;
        	color: white;
        	background-color: black;
        	padding-left: 10px;
        	padding-top: 1px;
        }

        .detailed-item .item-control .item-control-plus{
        	top: 65%;
        }

        .detailed-item .item-control .item-control-minus{
        	top: 80%;
        }

        @media (max-width:  600px){
        	.detailed-item{
        		top: 70px;
        		height: calc(100vh - 180px);
        		width: calc(100vw - 40px);
	        	margin: 0 20px;
	        	overflow: hidden;
        	}
        }        

        .blur{
			    filter: blur(5px);
			    -webkit-filter: blur(5px);
			    -moz-filter: blur(5px);
			    -o-filter: blur(5px);
			    -ms-filter: blur(5px);
				}

				.return-button{
					width: auto;
					font-size: 12px;
					margin-bottom: -10px;
				}

				.return-button i{
					display: inline-block;
					vertical-align: middle;
					padding-left: 10px;
					padding-right: 5px;
				}

				.return-button p{
					display: inline-block;
					vertical-align: middle;
					margin-bottom: 0;
				}

				.return-button p:hover{
					text-decoration: underline;
				}
</style>
	</head>

	<body>

	<div id="container">
	<?php include "templates/nav.php";?>

	<div class="index-profile" onclick="document.location.href = 'profile.php';">
      <img class="index-profile-picture" src="res/icon.svg">

      <div class="content">
          <h4 class="index-name"><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
          <h4 class="index-money">Solde : <?php echo htmlspecialchars($_SESSION['credit']); ?> €</h4>
      </div>
  </div>

	<div id="home" class="default-linked-section linked-section">
		<!-- Identification de l'étudiant -->
			
    <!-- Evénéments à promouvoir ou des rappels! Exemple : mardi/jeudi viennoiseries, wei, etc -->

		<div class="sub-categories carousel slide " data-ride="carousel" id="event">
			<h4 class="sub-categories-title">Evénements</h4><span class="menuspan" id="span-event"></span>

		  <!-- Indicators -->
		  <ul class="carousel-indicators">
		    <li data-target="#event" data-slide-to="0" class="active"></li>
		    <li data-target="#event" data-slide-to="1"></li>
		    <li data-target="#event" data-slide-to="2"></li>
		  </ul>

		  <!-- The slideshow -->
		  <div class="carousel-inner">
		    <div class="carousel-item active">
		      <img src="https://images.pexels.com/photos/624015/pexels-photo-624015.jpeg" alt="Los Angeles">
		    </div>
		    <div class="carousel-item">
		      <img src="https://images.pexels.com/photos/15286/pexels-photo.jpg" alt="Chicago">
		    </div>
		    <div class="carousel-item">
		      <img src="https://images.pexels.com/photos/3408744/pexels-photo-3408744.jpeg" alt="New York">
		    </div>
		  </div>

		  <!-- Left and right controls -->
		  <a class="carousel-control-prev" href="#event" data-slide="prev">
		    <span class="carousel-control-prev-icon"></span>
		  </a>
		  <a class="carousel-control-next" href="#event" data-slide="next">
		    <span class="carousel-control-next-icon"></span>
		  </a>
		</div>

		<!-- La liste de mes préférés! -->

		<div class="sub-categories">		
			<h4 class="sub-categories-title">J'adore ça, donnez m'en plus!</h4><span class="menuspan" id="span-like"></span>

			<div class="favorites-items">
			
				<?php

						require_once('lib/favorites.php');
						$favorites = getFavorites($_SESSION['id'], 3);

						foreach ($favorites as $favorite_id => $quantity) {
							$query = 'SELECT id, image, name, price, bdlc_price, category FROM products WHERE id = ?';
							if($stmt = $mysqli->prepare($query)) {
								$stmt->bind_param('i', $favorite_id);
								$stmt->execute();
								$stmt->bind_result($id, $image, $name, $price, $bdlc_price, $category);

								while ($stmt->fetch()) {?>

									<div class="sub-presentation-card" id="<?php echo $id; ?>" onclick="toggleItem(<?php echo $category . ',' . $id; ?> )">
										<img class="card-picture" src="<?php echo 'res/products/' . $image ;?>">
										<div class="content">
											<h4 class="card-name"><?php echo $name;?></h4>
											<h4 class="card-subtitles"><?php echo ($_SESSION['bdlc_member']) ? $bdlc_price : $price;?></h4>
										</div>
									</div>

								<?php
								}
							}
						}
				?>
	
			</div>

		</div>

		<!-- La répartition du shop avec mes 4 catégories -->

		<div class="sub-categories" id="categories-items">
			<h4 class="sub-categories-title centered-text underline">Catégories</h4>

			<div class="row">
				<div class="column" style="background-image:url(https://images.pexels.com/photos/585750/pexels-photo-585750.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260);" onclick="window.location = 'index.php#hot-drinks'">
					<p>Boisson<br>Chaude</p>
				</div>
				<div class="column" 
						style="background-image:url(https://images.pexels.com/photos/7235673/pexels-photo-7235673.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);" onclick="window.location = 'index.php#cold-drinks'">
					<p>Boisson<br>Froide</p>
				</div>
			</div>
			<div class="row">
				<div class="column" style="background-image:url(https://images.pexels.com/photos/4087610/pexels-photo-4087610.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);" onclick="window.location = 'index.php#snacks'">
					<p>Snacks</p>
				</div>
				<div class="column" style="cursor:not-allowed;background: grey;">
					<p>Formules</p>
				</div>
			</div>		
		</div>
	</div>

	<div id="shop">
		<div id="hot-drinks" class="linked-section">

			<!--Add button to return main menu
			-->
			<div class="return-button" onclick="window.location = 'index.php';">
				<i class="fas fa-undo-alt"></i><p>Retour vers le menu</p>
			</div>

			<div class="header">
	      <h1>Les boisons chaudes</h1>
	    </div>
	   	
	    <?php displayCategory(0); ?>
		</div>
		<div id="cold-drinks" class="linked-section">
			<div class="header">
	      <h1>Les boisons froides</h1>
	    </div>
	  	
	  	<?php displayCategory(1); ?>  
	  </div>
		<div id="snacks" class="linked-section">
			<div class="header">
	      <h1>Les trucs à grignoter</h1>
	    </div>
	   
	   	<?php displayCategory(2); ?>
		</div>
		<div id="formules" class="linked_section" style="display: none;">
			<div class="header">
	      <h1>Formules</h1>
	    </div>
	  
		</div>
  </div>

	</div>
	
	<div id="detailed-item" class="detailed-item" >
		<div class="item-presentation">
			<img class="item-picture" id="item-picture" src="">
			<h2 class="item-name text-center" id="item-name"></h2>
		</div>

		<div class="item-description">
				<h4 class="item-price">Prix unitaire: <span id="item-price"></span>€</h4>
				<h4 class="item-quantity">Quantité: <span id="item-quantity"></span></h4>
				<div class="item-control">
					<div class="item-control-plus" onclick="quantityItem(1)"><i class="fas fa-plus"></i></div>
					<div class="item-control-minus" onclick="quantityItem(-1)"><i class="fas fa-minus"></i></div>
				</div>
				<div class="item-add">
		  		<input type="submit" value="Ajouter pour 1.20€" id="btn-validate-lg" onclick="addItem()">
				</div>
		</div>

		

  	<div class="close" onclick="toggleItem(0,0)"><i class="fas fa-times"></i></div>
	</div>

	<div class="shoping-cart">
		<div class="icon" onclick="toggleShop()">
			<span id="icon" class="fa-layers fa-fw">
		    <i class="fas fa-shopping-cart" id="shopping-cart"></i>
		    <span class="fa-layers-counter" id="number-item"></span>
		  </span>
		</div>

		<div id="order-summary">
			<h1 class="text-center">Total panier: <span id="total"></span></h1>

			<form method="post" action="lib/command.php" id="order-form">
				<button type="submit" class="check"><i class="fas fa-check"></i></button>
    	</form>
    </div>
	</div>	

<script type="text/javascript" src="js/linked_sections.js"></script>
<script type="text/javascript">
		function quantityItem(x){
			var qty = parseInt(document.getElementById("item-quantity").innerHTML);

			if(x==0){
				document.getElementById("item-quantity").innerHTML = "1";
			}else{
				qty += x;
				if(qty==0){
					qty = 1;
				}
				document.getElementById("item-quantity").innerHTML = String(qty);
			}
			calculateItemPrice();
		}

		function calculateItemPrice(){
			var qty = parseInt(document.getElementById("item-quantity").innerHTML);
			var price = parseFloat(document.getElementById("item-price").innerHTML);

			var totalPrice = qty * price;
			totalPrice = totalPrice.toFixed(2);

			document.getElementById("btn-validate-lg").value = "Ajouter pour " + totalPrice + "€";
		}

		function calculateTotalPrice(){
			var form = document.getElementById("order-form");
			var inputs = form.getElementsByTagName("input");

			var sum = 0;
			for(var i=0; i< inputs.length; i=i+2){
				var qty = inputs[i].value;
				var price = inputs[i+1].value;
			  sum += qty * price;
			}

			sum = sum.toFixed(2);
			document.getElementById("total").innerHTML = sum + "€";

			if(sum == 0){
				var x = document.createElement("div");

				x.style.backgroundImage = "url(res/empty-john-travolta.gif)";
				x.style.backgroundRepeat = "no-repeat";
				x.style.backgroundSize = "100% auto";
				x.style.marginTop = "80px";
				x.style.marginLeft = "40px";
				x.style.marginRight = "40px";
				x.style.width = "auto";
				x.style.height = "200px";
				x.setAttribute("id","easter-egg");

			  document.getElementById("order-form").appendChild(x);
			}else{
				do{
					var x = document.getElementById("easter-egg");
					if(x != null){
						x.remove();
					}
				}while(x != null)
				
			}
		}

		function calculateTotalItems(){
			var form = document.getElementById("order-form");
			var inputs = form.getElementsByTagName("input");
			var num = 0;

			for(var i=0; i<inputs.length; i++){
				if(inputs[i].name != "price"){
					num += parseInt(inputs[i].value);
				}
			}

			var elmt = document.getElementById("number-item");

			if(num == 0){
				elmt.style.display = "none";
			}else{
				elmt.style.display = "block";
				elmt.innerHTML = num;
			}

			return num;
		}

		function findById(myArray, id) {
			for(let i=0; i<myArray.length;i++){
				if(myArray[i].className == "presentation-card"){
					if(myArray[i].id == id){
						return i;
					}
				}
			}
		}

		function toggleItem(categories, id){
			var x = document.getElementById("detailed-item");
			if(id==0 && categories==0){
		  	x.style.display = "none";
		  	blur(0);
		  	return;
		  }

			if (x.style.display === "none" || x.style.display === "") {
				switch(categories){
					case 1: var elmtList = document.getElementById("hot-drinks").childNodes; break;
					case 2: var elmtList = document.getElementById("cold-drinks").childNodes; break;
					case 3: var elmtList = document.getElementById("snacks").childNodes; break;
					case 4: var elmtList = document.getElementById("formules").childNodes; break;
				}

				let myArray = Array.from(elmtList);
				console.log(myArray);
				let idArray = findById(myArray, String(id));

				var img = myArray[idArray].firstElementChild.currentSrc;
				var name = myArray[idArray].children[1].children[0].textContent;
				var price = myArray[idArray].children[1].children[1].textContent;
				var priceFloat = price.match(/\d\W\S\d/g);
				priceFloat = parseFloat(priceFloat).toFixed(2);

				document.getElementById("item-picture").setAttribute("src",img);
				document.getElementById("item-name").innerHTML = name;
				document.getElementById("item-price").innerHTML = String(priceFloat);

				document.getElementById("btn-validate-lg").setAttribute("onclick","addItem(" + id + ")");

				quantityItem(0);

		    x.style.display = "block";
		    blur(1);
		  } else {
		    x.style.display = "none";
		    blur(0);
		  }
		}

		function toggleShop(){
			var x = document.getElementById("order-summary");
		  if (x.style.display === "none" || x.style.display === "") {
		    x.style.display = "block";
		    toggleItem(0, 0);

		    // Remove shopping cart and counter
		    var shoppingCart = document.getElementById("shopping-cart");
		    shoppingCart.remove();
		    var counter = document.getElementById("number-item");
		    counter.remove();

		    // Replace by a time
		    var icon = document.createElement("i");
		    icon.classList.add("fas");
		    icon.classList.add("fa-times");
		    icon.setAttribute("id","icon-times");

		    icon.style.fontSize = "40px";
		    icon.style.marginLeft = "7px";
		    icon.style.marginTop = "5px";

		    var divIcon = document.getElementById("icon");
		    divIcon.appendChild(icon);

		    blur(1);
		  } else {
		    x.style.display = "none";

		    // Remove time
		    var times = document.getElementById("icon-times");
		    times.remove();

		    var shoppingCart = document.createElement("i");
		    shoppingCart.classList.add("fas");
		    shoppingCart.classList.add("fa-shopping-cart");
		    shoppingCart.setAttribute("id", "shopping-cart");

		    var counter = document.createElement("span");
		    counter.classList.add("fa-layers-counter");
		    counter.setAttribute("id", "number-item");

		    var divIcon = document.getElementById("icon");
		    divIcon.appendChild(shoppingCart);
		    divIcon.appendChild(counter);

		    blur(0);
		    calculateTotalItems();
		  }			
		}

		function addItem(id){
			var presentation = document.createElement("div");
			presentation.classList.add("presentation-card");
			presentation.setAttribute("id",id);

			var img = document.createElement("img");
			img.classList.add("card-picture");

			var src = document.getElementById("item-picture").getAttribute("src");
			img.setAttribute("src",src);
			presentation.appendChild(img);

			var content = document.createElement("div");
			content.classList.add("content-sm");
			presentation.appendChild(content);

			var titre = document.createElement("h4");
			titre.classList.add("card-name");
			var title = document.getElementById("item-name").innerHTML;
			titre.innerHTML = title;
			content.appendChild(titre);

			var titre = document.createElement("h4");
			titre.classList.add("card-subtitles");
			var price = parseFloat(document.getElementById("item-price").innerHTML);
			price = price.toFixed(2);
			titre.innerHTML = "Prix unitaire: " + price + "€";
			content.appendChild(titre);

			var titre = document.createElement("h4");
			titre.classList.add("card-subtitles");
			var quantity = document.getElementById("item-quantity").innerHTML;
			titre.innerHTML = "Quantité: " + quantity;
			content.appendChild(titre);

			var input = document.createElement("input");
			input.setAttribute("type","number");
			input.setAttribute("name",id);
			input.setAttribute("value",quantity);
			input.setAttribute("hidden","");
			presentation.appendChild(input);

			var input = document.createElement("input");
			input.setAttribute("type","number");
			input.setAttribute("name","price");
			input.setAttribute("value",price);
			input.setAttribute("hidden","");
			presentation.appendChild(input);


			var close = document.createElement("div");
			close.classList.add("delete");
			var f = "deleteItem(" + id + ")";
			close.setAttribute("onclick",f);
			presentation.appendChild(close);

			var btn_del = document.createElement("i");
			btn_del.classList.add("fas");
			btn_del.classList.add("fa-times");
			close.appendChild(btn_del);

			

			document.getElementById("order-form").appendChild(presentation);

			calculateTotalItems();
			calculateTotalPrice();
			toggleItem(0,0);	
		}

		function deleteItem(id){
			var elmtList = document.getElementById("order-form").childNodes;
			let myArray = Array.from(elmtList);
			let idArray = findById(myArray, String(id));
			myArray[idArray].remove();

			calculateTotalItems();
			calculateTotalPrice();
		}
		

		function blur(state){	
			// State 1 : blur the background and activate the overlay
			// State 0 : remove the overlay and blur effect	
			
			var containerElement = document.getElementById("container");		    
			var nav = document.getElementById("nav");

			if(state == 1){
		    containerElement.setAttribute("class", "blur");

		    // Fixing the margin problem with the navbar while applying a filter
		    if(parseInt(nav.offsetHeight) == "60"){
		    	nav.style.top = "-60px";
		    }else{
		      nav.style.top = "-100px";
		    }
			} else{
		    containerElement.setAttribute("class", null);
		    nav.style.top = "0";
			}
		}

		calculateTotalItems();
		calculateTotalPrice();
	</script>
</body>
</html>