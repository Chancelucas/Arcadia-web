<?php
require_once '../../componants/admin/admin_navbar.php';
require_once '../../../config/dsn.php';

session_start();
$pdo = connectToDatabase();

if (!$_SESSION['user_id']) {
    header('Location: ../views/pages/public/login_page.php');
}

$collectUser = $pdo->query('SELECT * FROM User');

require_once '../../componants/admin/form_add_employee.php';

while ($user = $collectUser->fetch()) {
?>
    <p>
        <?php
        echo $user['email'];
        ?>
        <a href="../../../controllers/crud/admin/DeleteUser.php?userId=<?= $user['userId'];?>">
            Supprimer 
        </a>
        <a href="../../../controllers/crud/admin/ModifyUser.php?userId=<?= $user['userId'];?>">
            Modifier 
        </a>
    </p>
<?php
};
