<?php
require_once __DIR__ . '/../db.php';

$pdo = new PDO(DSN, USER, PASS);

$statement = $pdo->query('SELECT * FROM users');
$users = $statement->fetchAll(PDO::FETCH_ASSOC);
$errors = [];
if (isset($_POST['name'])) {
    $name = trim($_POST['name']);
    
    // Validate data
    if (empty($name)) {
        $errors[] = 'The name is required<br>';
    }
    // Save names
    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO users (name) VALUES (:name)");
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->execute();
        header('Location: /');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Liste des candidats</title>
</head>

<body>
    <!-- Header section -->
    <header>
        <h1>
            <img src="https://www.wildcodeschool.com/assets/logo_main-e4f3f744c8e717f1b7df3858dce55a86c63d4766d5d9a7f454250145f097c2fe.png" alt="Wild Code School logo" />
            Les Argonautes
        </h1>
    </header>

    <!-- Main section -->
    <main>

        <!-- New member form -->
        <h2>Ajouter un(e) Argonaute</h2>
        <form action="index.php" method="post" class="new-member-form">
            <div class="input">
                <label for="name">Nom de l&apos;Argonaute</label>
                <input id="name" name="name" type="text" placeholder="Charalampos" />
            </div>
            <input class="submit-button" type="submit" value="Ajouter à la liste"></input><br>
            <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo $error;
                    }
                }
            ?>
        </form>

        <!-- Member list -->
        <h2>Membres de l'équipage</h2>
        <section class="member-list">
            <?php
                foreach ($users as $user){
                    echo '<div class="name">' . $user['name'] . '</div>';
                }
            ?>
        </section>
    </main>

    <footer>
        <p>Réalisé par Davy en Anthestérion de l'an 516 avant JC</p>
    </footer>
</body>

</html>