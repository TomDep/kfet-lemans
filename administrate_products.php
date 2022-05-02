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
    <script src="js/administrate_products.js"></script>
    <link rel="stylesheet" type="text/css" href="css/administrate.css"/>
</head>
<body>

    <?php include('templates/nav.php') ?>

    <main>
        <h1 class="text-center">Gestion des produits</h1>

        <hr>

        <div class="container bg-light p-5">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab">Liste des produits</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" id="add-tab" href="#add" role="tab">Ajout</a>
                </li>
            </ul>
            <div class="tab-content border p-3">
                <div class="tab-pane fade show active" id="list" role="tabpanel">
                    <h2>Liste des produits</h2>

                    <form class="float-right mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="i-search">Rechercher</label>
                            </div>
                            <input id="i-search" class="form-control filter" data-tablefilter="#table" type="search" placeholder="Café, Boisson chaude ...">
                        </div>
                    </form>

                    <table id="table" class="table table-hover table-sm sortable-table table-striped bg-light administrate-table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col" class="sortable">Nom</th>
                                <th scope="col" class="sortable">Prix</th>
                                <th scope="col" class="sortable">Prix adhérent</th>
                                <th scope="col" class="sortable">Catégorie</th>
                                <th scope="col">Image</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
    <?php

        // Include the database connection file
        require_once('lib/connect.php');

        // Connect to the database
        $connection = connectToDatabase();
        if($connection == FALSE) {
            echo '<p>Il y a eu une erreur ...</p>';
            exit();
        }

        $req = 'SELECT * FROM products ORDER BY name ASC';
        if($result = $connection->query($req)) {
            while($product = $result->fetch_array()) {
    ?>
                            <tr>
                                <th scope="row"><?php echo htmlspecialchars($product['id']); ?></th>
                                <td>
                                    <a href="#" class="product-name" data-pk="<?php echo htmlspecialchars($product['id']); ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="product-price" data-pk="<?php echo htmlspecialchars($product['id']); ?>">
                                        <?php echo htmlspecialchars($product['price']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="product-bdlc-price" data-pk="<?php echo htmlspecialchars($product['id']); ?>">
                                        <?php echo htmlspecialchars($product['bdlc_price']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="product-category" data-value="<?php echo htmlspecialchars($product['category']); ?>" data-pk="<?php echo htmlspecialchars($product['id']); ?>"></a>
                                </td>
                                <td>
                                    <a href="#" class="product-image" data-pk="<?php echo htmlspecialchars($product['id']); ?>"><?php echo htmlspecialchars($product['image']); ?></a>
                                </td>
                                <td>
                                    <a class="delete-row" href="lib/admin/product_delete.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                                        <button type="button" title="Supprimer l'élément" class="btn btn-outline-danger">
                                            <i class="oi oi-x"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
    <?php
            }
        }

        $connection->close();
    ?>
                        </tbody>
                    </table>
                </div>
                <div id="add" role="tabpanel" class="tab-pane fade bg-light">

                <h2>Ajouter un produit</h2>

                <form id="add-product-form" enctype="multipart/form-data" method="post" action="lib/admin/product_add.php">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="i-product-name">Nom du produit</label>
                            <input class="form-control" type="text" id="i-product-name" name="name" required>
                        </div>
                        <div class="form-group col">
                            <label for="i-product-price">Prix pour les non adhérent.es</label>
                            <input class="form-control" type="number" id="i-product-price" step="0.01" min="0" name="price" required>
                        </div>
                        <div class="form-group col">
                            <label for="i-product-bdlc-price">Prix pour les adhérent.es</label>
                            <input class="form-control" type="number" id="i-product-bdlc-price" step="0.01" min="0" name="bdlc_price" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-auto">
                            <label for="i-product-category">Catégorie du produit</label>
                            <select class="form-control" id="i-product-category" name="category">
                                <option value="0">Boisson chaude</option>
                                <option value="1">Boisson froide</option>
                                <option value="2">Snack</option>
                                <option value="3">Formule</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label class="" for="i-product-image">Image du produit</label>
                            <input class="form-control-file" type="file" id="i-product-image" name="image" required>
                            <small class="form-text text-muted">Extensions valides : jpg, png</small>
                        </div>
                    </div>
                    <button id="add-product-submit" type="submit" class="btn btn-primary" name="submit">Ajouter</button>
                </form> 
            </div>
            </div>
        </div>

        <div id="add-success-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-success">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Le produit a bien été ajouté !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="add-error-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-danger">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Il y a eu un problème lors de l'ajout du produit ...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-success-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-success">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Le produit a bien été supprimé !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-error-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-danger">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Il y a eu un problème lors de la suppression du produit ...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>