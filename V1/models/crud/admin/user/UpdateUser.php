<?php
require_once '../../../config/dsn.php';

session_start();
$pdo = connectToDatabase();

if (isset($_GET['userId']) && !empty($_GET['userId'])) {
    $userId = $_GET['userId'];
    $stmt = $pdo->prepare('SELECT * FROM User WHERE userId = :userId');
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (isset($_POST['save_changes'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $roleId = $_POST['roleId'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            $updateStmt = $pdo->prepare('UPDATE User SET username = :username, email = :email, password = :password, roleId = :roleId WHERE userId = :userId');
            $updateStmt->bindParam(':username', $username);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':roleId', $roleId);
            $updateStmt->bindParam(':userId', $userId);

            if ($updateStmt->execute()) {
                echo "Modifications enregistrées avec succès.";
                header('Location: ../../../views/pages/admin/admin_create_user.php');
            } else {
                echo "Une erreur s'est produite lors de l'enregistrement des modifications.";
            }
        }

?>
        <form action="" method="POST">
            <div>
                <label for="username">Nom:</label>
                <input type="text" id="username" name="username" value="<?= $user['username']; ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required>
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" value="<?= $user['password']; ?>">
            </div>
            <div>
                <label for="roleId">Rôle:</label>
                <select id="roleId" name="roleId" required>
                    <option value="1" <?= ($user['roleId'] == 1) ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?= ($user['roleId'] == 2) ? 'selected' : ''; ?>>Employé</option>
                    <option value="3" <?= ($user['roleId'] == 3) ? 'selected' : ''; ?>>Vétérinaire</option>
                </select>
            </div>
            <div>
                <button type="submit" name="save_changes">Enregistrer les modifications</button>
            </div>
        </form>
<?php
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "Identifiant d'utilisateur non spécifié.";
}
?>