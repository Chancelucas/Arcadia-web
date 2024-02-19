<?php
require_once '../../componants/admin/admin_navbar.php';
require_once '../../../config/dsn.php';

session_start();
$pdo = connectToDatabase();

if (!$_SESSION['password']) {
    header('Location: ../views/pages/public/login_page.php');
}

$collectUser = $pdo->query('SELECT * FROM User');

while ($user = $collectUser->fetch()) {
?>
    <p>
        <?php
        echo $user['email'];
        ?>
        <a href="../../../controllers/crud/admin/DeleteUser.php?userId=<?= $user['userId'];?>">
            Supprimer 
        </a>
    </p>
<?php
};
