<?php
    session_start();

    require_once('lib/redirect.php');
    auth_level(2);
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('templates/head.php') ?>
    <?php include('templates/administrate_includes.php') ?>

    <title>Administrer les produits</title>

    <script src="js/administrate.js"></script>
    <script src="js/administrate_events.js"></script>
    <link rel="stylesheet" type="text/css" href="css/administrate.css"/>
</head>
<body>

    <?php include('templates/nav.php') ?>

    <main>
        <h1 class="text-center">Gestion des événements</h1>

        <hr>

        <div class="container bg-light p-5">
            <div>
                <h2>Liste des événements</h2>

                <form class="float-right mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="i-search">Rechercher</label>
                        </div>
                        <input id="i-search" class="form-control filter" data-tablefilter="#table" type="search" placeholder="Nom, image ...">
                    </div>
                </form>

                <table id="table" class="table table-hover table-sm sortable-table table-striped bg-light administrate-table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col" class="sortable">Nom/Description</th>
                            <th scope="col">Image</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
<?php

    // Include the database connection file
    require_once('lib/connect.php');

    // Connect to the database
    $mysqli = connectToDatabase();
    if($mysqli == FALSE) {
        echo '<p>Il y a eu une erreur ...</p>';
        exit();
    }

    $req = 'SELECT * FROM events';
    if($result = $mysqli->query($req)) {
        while($event = $result->fetch_assoc()) {
?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($event['id']); ?></th>
                            <td>
                                <a href="#" class="event-name" data-pk="<?php echo htmlspecialchars($event['id']); ?>">
                                    <?php echo htmlspecialchars($event['name']); ?></td>    
                                </a>
                            <td>
                                <a href="#" class="event-image" data-pk="<?php echo htmlspecialchars($event['id']); ?>">
                                    <?php echo htmlspecialchars($event['image']); ?>
                                </a>
                            </td>
                            <td>
                                <a class="delete-row" href="lib/admin/event_delete.php?id=<?php echo htmlspecialchars($event['id']); ?>">
                                    <button type="button" title="Supprimer l'élément" class="btn btn-outline-danger">
                                        <i class="oi oi-x"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
<?php
        }
    }

    $mysqli->close();
?>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="bg-light">

                <h2>Ajouter un événement</h2>

                <form id="add-event-form" autocomplete="off" enctype="multipart/form-data" method="post" action="lib/admin/event_add.php">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="i-event-name">Nom</label>
                            <input class="form-control" type="text" id="i-event-name" name="name" required>
                        </div>
                        <div class="form-group col">
                            <label class="" for="i-event-image">Photo</label>
                            <input class="form-control-file" type="file" id="i-event-image" name="image" required>
                            <small class="form-text text-muted">Extensions valides : jpg, png, svg</small>
                        </div>
                    </div>
                    <button id="add-event-submit" type="submit" class="btn btn-primary" name="submit">Ajouter</button>
                </form> 
            </div>
        </div>
    </main>
</body>
</html>