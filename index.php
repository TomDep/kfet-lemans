<?php
	session_start();

	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include "templates/head.php"; ?>
		<title>Kfet - Accueil</title>
		<style type="text/css">

			#shop{
				height: calc(100vh - 10vh);
			}

			.index-profile {        
        margin: 10px 20px;
        height: 60px;
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

			.sub-categories .grey{
				height: 15vh;
				background-color: grey;
				width: calc(100% - 40px);   	/*Same size as .carousel-item img : must use a variable for that*/
				margin: 0 20px;
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
			  background-color: grey;
			  margin: 5px;

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


		</style>

	</head>

	<body>
	<?php include "templates/nav.php";?>

	<div class="margin-top" id="shop">
		<!-- Identification de l'étudiant -->

		<div class="index-profile">
      <img class="index-profile-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="index-name">Tom de Pasquale</h4>
          <h4 class="index-money">Solde : 0.00€</h4>
      </div>
    </div>
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

		<div class="sub-categories" id="liked-items">		
			<h4 class="sub-categories-title">J'adore ça, donnez m'en plus!</h4><span class="menuspan" id="span-like"></span>
			<div class="grey"></div>
		</div>

		<!-- La répartition du shop avec mes 4 catégories -->

		<div class="sub-categories" id="categories-items">
			<h4 class="sub-categories-title centered-text underline">Catégories</h4>

			<div class="row">
				<div class="column" onclick="location.href='index.php#hot-drinks'">
					<p>Boisson<br>Chaude</p>
				</div>
				<div class="column">
					<p>Boisson<br>Froide</p>
				</div>
			</div>
			<div class="row">
				<div class="column">
					<p>Snacks</p>
				</div>
				<div class="column">
					<p>Formules</p>
				</div>
			</div>		
		</div>
	</div>

	<div>
		<div class="header" id="hot-drinks">
      <h1>Les boisons les plus chaudes de ta région</h1>
    </div>
    
    <div class="presentation-card" onclick="myFunction()">
      <img class="card-picture" src="res/images/products/Café.jpg">
      <div class="content">
          <h4 class="card-name">Café</h4>
          <h4 class="card-subtitles">Prix unitaire: 0.40€</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card" onclick="myFunction()">
      <img class="card-picture" src="res/images/products/Café.jpg">
      <div class="content">
          <h4 class="card-name">Café</h4>
          <h4 class="card-subtitles">Prix unitaire: 0.40€</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card" onclick="myFunction()">
      <img class="card-picture" src="res/images/products/Café.jpg">
      <div class="content">
          <h4 class="card-name">Café</h4>
          <h4 class="card-subtitles">Prix unitaire: 0.40€</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card" onclick="myFunction()">
      <img class="card-picture" src="res/images/products/Café.jpg">
      <div class="content">
          <h4 class="card-name">Café</h4>
          <h4 class="card-subtitles">Prix unitaire: 0.40€</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
    <div class="presentation-card">
      <img class="card-picture" src="res/icon.svg">
      <div class="content">
          <h4 class="card-name">Tom de Pasquale</h4>
          <h4 class="card-subtitles">4A info</h4>
      </div> 
    </div>
	</div>
	
	<div class="detailed-item">
		
	</div>

	</body>

<script type="text/javascript">
	function myFunction(){
		return console.log("Test");
	}
</script>

</html>