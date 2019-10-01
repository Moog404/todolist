<?php

include 'config.inc.php';
// $delete = $pdo -> exec('DELETE from todo_list WHERE id ='.$_GET["id"]);
$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password, $pdo_options);
$list = $pdo -> query('SELECT id, titre, descriptif, statut from todo_list');

    if (isset($_GET['id']) && isset($_GET['statut']) && $_GET['operation'] == 0){
        $modifstatut = $pdo -> prepare('UPDATE todo_list SET statut= :statut WHERE id=:monId');
        $modifstatut -> bindValue(':monId', $_GET['id'], PDO::PARAM_INT);
        if  ( $_GET['statut'] == 'to do' )  {
            $modifstatut -> bindValue(':statut', "in progress", PDO::PARAM_STR);
        } else if ($_GET['statut'] == "in progress"){
            $modifstatut -> bindValue(':statut', "complete", PDO::PARAM_STR);
        } else {
            $modifstatut -> bindValue(':statut', "to do", PDO::PARAM_STR);
        }
        $modifstatut -> execute();
        $list = $pdo -> query('SELECT id, titre, descriptif, statut from todo_list');
    }


    if (isset($_GET['id']) && $_GET['operation'] == 1) {
        $delete = $pdo -> exec('DELETE from todo_list WHERE id ='.$_GET["id"]);
        $list = $pdo -> query('SELECT id, titre, descriptif, statut from todo_list');
    }


    function statutChange($task) {
        if ($task == "to do") {
            return '<i class="far fa-circle align-middle text-light fa-lg"> </i>';
        } else if ($task == "in progress"){
            return '<i class="fas fa-check-circle align-middle text-warning fa-lg"> </i>';
        } else {
            return '<i class="fas fa-check-circle align-middle text-success fa-lg"> </i>';
        }
    }
?>

<?php include '_include/head.php'; ?>
<?php include '_include/menu.php'; ?>

    <div class="container">
        <div class="text-dark col-12 col-md-6 mb-1 pb-1 border-bottom">
            <h3>à faire absolument</h3>
        </div>
        <?php foreach ($list as $key => $task) { ?>
        <div class="row col-12 col-md-6 mb-1 pb-1 border-bottom">
            <div class="col-9 col-md-8">
                <a href="/TodoList/index.php?id=<?php echo $task['id'] ?>&statut=<?php echo $task['statut'] ?>&operation=0">
                <?php echo statutChange($task['statut']) ?></a>
                <span><?php echo $task['titre']; ?></span>
            </div>
            <div class="col-3 col-md-4 text-right">
                <a href="/TodoList/description.php?id=<?php echo $task['id'] ?>">
                    <span class="badge badge-pill badge-info">info</span>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>

<?php include '_include/footer.php'; ?>
