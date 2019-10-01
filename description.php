<?php

include 'config.inc.php';

$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password, $pdo_options);

    if(isset($_POST['button'])){
        $requetemodif = $pdo -> prepare('UPDATE todo_list SET titre = :titre, descriptif= :descriptif WHERE id =:monId');
        $requetemodif -> bindValue(':titre', htmlspecialchars($_POST['titre']), PDO::PARAM_STR);
        $requetemodif -> bindValue(':descriptif', htmlspecialchars($_POST['descriptif']), PDO::PARAM_STR);
        $requetemodif -> bindValue(':monId', intval($_GET['id']), PDO::PARAM_INT);
        $modif = $requetemodif -> execute();
    }

    $requetePreparee = $pdo -> prepare('SELECT  id, titre, descriptif, statut from todo_list WHERE id =:monId'); // on utilise le prepare pour une question de sécurité avec un paramatre nommé
    $trouve = $requetePreparee -> execute([':monId' => intval($_GET['id'])]);
        if(!$trouve) {
            echo "l'id n'a ps été trouvé";
        }
    $task = $requetePreparee -> fetch();
?>

<?php include '_include/head.php'; ?>
<?php include '_include/menu.php'; ?>

        <!-- alert -->
    <div class="container">
        <?php
        if (isset($_POST['titre'])) {
            if($task){
                echo '<div class="alert alert-success col" role="alert"><strong>SUPER!</strong> la tâche a bien été modifié</div>';
            } else {
                echo '<div class="alert alert-danger col" role="alert"><strong>Attention!</strong> il faut au moins le titre </div>';
            }
        } ?>
    </div>

    <!-- description de la tâche -->
    <div class="container">
        <div class="center-block">
            <div class="row text-dark col-12 col-md-6 justify-content-between border-bottom mb-3">
                <h3>description de la tâche</h3>
                <div class="align-items-center">
                    <a href="/TodoList/index.php?id=<?php echo $task['id'] ?>&operation=1">
                    <span class="badge badge-pill badge-danger">delete</span></a>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <form action="description.php?id=<?php echo $task["id"]; ?>" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $task["titre"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="descriptif">description</label>
                        <textarea class="form-control" id="descriptif" name="descriptif" rows="3"><?php echo $task['descriptif'] ?></textarea>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-info" type="submit" name="button">edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include '_include/footer.php'; ?>
