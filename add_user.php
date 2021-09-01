<!DOCTYPE html>
<html>
<head>
    <?php include 'templates/head.php'; ?>

    <title>Kfet - Ajouter un.e utilisateurice</title>
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <h1>Ajouter un.e utilisateurice</h1>

    <form method="post" autocomplete="off" action="lib/simple_user_add.php" class="standard-form">
        <label for="student_number">Numéro étudiant.e</label>
        <input type="number" name="student_number" required placeholder="182355"> 

        <label for="username">Nom de l'utilisateurice</label>
        <input type="text" id="username" name="username" required>

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>