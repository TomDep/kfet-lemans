<!DOCTYPE html>
<html>
<head>
    <?php include "templates/head.php"; ?>

    <title>Kfet - L'équipe</title>

    <style type="text/css">

        .header{
            position: fixed;
            z-index: 15;
            top: 0; 
            margin-top: 100px;
            background-color: #eb5757;
            width: 100%;
            height: auto;
        }

        @media(max-width: 600px){
            .header{
                margin-top: 60px;
            }
        }

        .header h1{
            font-size: 20px;
            text-align: center;
            margin-bottom: 10px;
            width: calc(100% - 40px);
            
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
        }

        .header p{
            margin: 0 20px;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid black;
        }

        #under{
            margin-top: 20px;
            height: auto;
            z-index: -1;
        }

        .presentation-card {
          float: left;
         
          filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
          border-radius: 10px;
          
          background-color: white;

          width: calc(100% / 4 - 40px);
          margin: 10px 20px;


        }

        .card-picture{
            border-radius: 50%;
            width: 70px;
            height: 70px;
            float: left;
            vertical-align: middle;
            margin: 10px 0 0 10px ;
        }

        .presentation-card .content{
          height: 90px;
          display: flex;
          justify-content: center;
          align-items: flex-start;
          flex-direction: column;
          margin-left: 100px;
        }

        .card-name{ 
            font-size: 16px;
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

        
    </style>


</head>
<body>
    <?php include "templates/nav.php";?>

    <div class="header" id="header">
        <h1>Présentation de l'équipe 2021-2022</h1>
        <p>L'équipe est là pour vous accueillir de nouveau et repartir pour une nouvelle année déchainé à vos côtés! <br><br>
        N'oubliez pas que l'équipe vous accompagne et gère également les recharges des comptes! <br></p>
    </div>
       


        <?php

            /*
            // Get all baristas from the database
            require_once('library/connect.php');

            // Connect to the database
            $connection = connectToDatabase();
            if($connection == FALSE) {
                echo '<p>Il y a eu une erreur ...</p>';
                exit();
            }

            if($result = $connection->query('SELECT * FROM baristas')) {
                while ($barista = $result->fetch_row()) {
                    var_dump($barista);
                }
            }

            */
        ?>

        <div id="under">
            <div class="presentation-card">
                    <img class="card-picture" src="res/icon.svg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale 2</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
        

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale 3</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

           <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale 4</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
                        <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
        

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

           <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
                        <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
        

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

           <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
                        <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
        

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

           <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
                        <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
        

            <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>

           <div class="presentation-card">
                    <img class="card-picture" src="res/images/products/Café.jpg">
                    <div class="content">
                        <h4 class="card-name">Tom de Pasquale</h4>
                        <h4 class="card-subtitles">4A info</h4>
                    </div> 
            </div>
        </div>

    <script type="text/javascript">
        var header = document.getElementById("header");
        var nav = document.getElementById("nav");
        console.log(nav.offsetHeight + header.offsetHeight);

        var sum = nav.offsetHeight + header.offsetHeight;
        var margin_top = "" + sum + "px";
        console.log(margin_top);

        document.getElementById("under").style.marginTop = margin_top;
    </script>
</body>
</html>