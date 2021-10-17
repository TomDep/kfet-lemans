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

    <title>Administrer les baristas</title>

    <script src="js/administrate.js"></script>
    <script src="js/administrate_baristas.js"></script>
    <link rel="stylesheet" type="text/css" href="css/administrate.css"/>
</head>
<body>

    <?php include('templates/nav.php') ?>

    <main>
        <h1 class="text-center">Gestion des Baristas</h1>

        <hr>

        <div class="container bg-light p-5">
            <div>
                <h2>Liste des Baristas</h2>

                <form class="float-right mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="i-search">Rechercher</label>
                        </div>
                        <input id="i-search" class="form-control filter" data-tablefilter="#table" type="search" placeholder="Nom, Classe ...">
                    </div>
                </form>

                <table id="table" class="table table-hover table-sm sortable-table table-striped bg-light administrate-table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Numéro étudiant.e</th>
                            <th scope="col" class="sortable">Nom</th>
                            <th scope="col" class="sortable">Classe</th>
                            <th scope="col">Photo</th>
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

    $req = 'SELECT b.id AS barista_id, b.class, b.photo, u.username, u.student_number FROM baristas b INNER JOIN users u ON b.user_id = u.id';
    if($result = $mysqli->query($req)) {
        while($barista = $result->fetch_assoc()) {
?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($barista['barista_id']); ?></th>
                            <td><?php echo htmlspecialchars($barista['student_number']); ?></td>
                            <td><?php echo htmlspecialchars($barista['username']); ?></td>
                            <td>
                                <a href="#" class="barista-class" data-pk="<?php echo htmlspecialchars($barista['barista_id']); ?>">
                                    <?php echo htmlspecialchars($barista['class']); ?>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="barista-photo" data-pk="<?php echo htmlspecialchars($barista['barista_id']); ?>">
                                    <?php echo htmlspecialchars($barista['photo']); ?>
                                </a>
                            </td>
                            <td>
                                <a class="delete-row" href="lib/admin/barista_delete.php?id=<?php echo htmlspecialchars($barista['barista_id']); ?>">
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

                <h2>Ajouter un.e barista</h2>

                <form id="add-barista-form" autocomplete="off" enctype="multipart/form-data" method="post" action="lib/admin/barista_add.php">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="i-barista-sutdent-number">Numéro étudiant</label>
                            <input class="form-control" type="number" id="i-barista-sutdent-number" list="student_numbers" name="student_number" required>
                            <datalist id="student_numbers">
                                <?php
                                    // Connect to the database
                                    $mysqli = connectToDatabase();
                                    if($mysqli == FALSE) {
                                        $databaseError = TRUE;
                                        $databaseErrorMessage = $mysqli->error;
                                    }

                                    if($result = $mysqli->query('SELECT student_number FROM users')) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option>' . htmlspecialchars($row['student_number']) . '</option>';
                                        }
                                    } else {
                                        $databaseError = TRUE;
                                        $databaseErrorMessage = $mysqli->error;
                                    }

                                    $mysqli->close();
                                ?>
                            </datalist>
                        </div>
                        <div class="form-group col">
                            <label for="i-barista-class">Classe</label>
                            <input class="form-control" type="text" id="i-barista-class" name="class" required>
                        </div>
                        <div class="form-group col">
                            <label class="" for="i-product-image">Photo</label>
                            <input class="form-control-file" type="file" id="i-barista-photo" name="photo" required>
                            <small class="form-text text-muted">Extensions valides : jpg, png, svg</small>
                        </div>
                    </div>
                    <button id="add-product-submit" type="submit" class="btn btn-primary" name="submit">Ajouter</button>
                </form> 
            </div>
        </div>
    </main>
</body>
</html>