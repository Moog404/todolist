<?php

include 'config.inc.php';

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password, $pdo_options);

$requetePreparee = $pdo -> prepare('INSERT INTO  todo_list (titre, descriptif, statut) VALUES (:titre, :descriptif, :statut)'); // on utilise le prepare pour une question de sécurité avec un paramatre nommé
    if (isset($_POST['titre']) AND isset($_POST['descriptif'])) {
        $requetePreparee -> bindValue(':titre', htmlspecialchars($_POST['titre']), PDO::PARAM_STR);
        $requetePreparee -> bindValue(':descriptif', htmlspecialchars($_POST['descriptif']), PDO::PARAM_STR);
        $requetePreparee -> bindValue(':statut', $_POST['statut'], PDO::PARAM_STR);
        $taskCreate = $requetePreparee -> execute();
    }
?>

<?php include '_include/head.php'; ?>
<?php include '_include/menu.php'; ?>

        <div class="container">
            <?php
            if (isset($_POST['titre'])) {
                if($taskCreate){
                    echo '<div class="alert alert-success col" role="alert"><strong>SUPER!</strong> la tâche a bien été ajouté</div>';
                } else {
                    echo '<div class="alert alert-danger col" role="alert"><strong>Attention!</strong> il faut au moins le titre </div>';
                }
            } ?>
        </div>
        <div class="container justify-content-center">

            <div class="text-dark col-12 col-md-6">
                <h3>ajouter une tâche</h3>
                <hr>
            </div>

            <div class="col-12 col-md-6">
                <form action="addTask.php" method="post">
                    <div class="form-group">
                        <label for="titre">titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" placeholder="titre de la tâche" required>
                    </div>
                    <div class="form-group">
                        <label for="descriptif">description</label>
                        <textarea class="form-control" id="descriptif" name="descriptif" value =" " rows="3"></textarea>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="statut" id="toDo" value="to do" checked>
                        <label class="form-check-label" for="toDo">to do</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="statut" id="inProgress" value="in progress">
                        <label class="form-check-label" for="inProgress">in progress</label>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-info" type="submit" name="button">ajouter</button>
                    </div>
                </form>
            </div>
        </div>

<?php include '_include/footer.php'; ?>
