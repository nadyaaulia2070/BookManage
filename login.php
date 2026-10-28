<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

require "includes/bahasa.php";
require "includes/csrf.php";
require "config/database.php";

$error    = [];
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!csrf_valid()) {
        $error[] = t("err_csrf");
    }

    if ($username === "") {
        $error[] = t("err_username_kosong");
    }
    if ($password === "") {
        $error[] = t("err_password_kosong");
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([":username" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"]      = $user["id"];
            $_SESSION["username"]     = $user["username"];
            $_SESSION["nama_lengkap"] = $user["nama_lengkap"];

            header("Location: dashboard.php");
            exit;
        } else {
            $error[] = t("err_login_salah");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($bahasa); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars(t("judul_login")); ?> - BookManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/BookManage/assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">

<div class="login-quote tulisan-tangan">“<?php echo htmlspecialchars(t("tagline")); ?>”</div>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-11 col-sm-9 col-md-6 col-lg-4">

            <div class="text-end mb-3">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="/BookManage/set_bahasa.php?lang=id"
                       class="btn <?php echo ($bahasa === 'id') ? 'btn-primary' : 'btn-light'; ?>">ID</a>
                    <a href="/BookManage/set_bahasa.php?lang=en"
                       class="btn <?php echo ($bahasa === 'en') ? 'btn-primary' : 'btn-light'; ?>">EN</a>
                </div>
            </div>

            <div class="card login-card">
                <div class="login-head d-flex align-items-center gap-3">
                    <i class="bi bi-book-half logo"></i>
                    <div>
                        <h3>Book<span>Manage</span></h3>
                        <small><?php echo htmlspecialchars(t("app_sub")); ?></small>
                    </div>
                </div>

                <div class="login-body">
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger rounded-4">
                            <?php foreach ($error as $e) { ?>
                                <div><?php echo htmlspecialchars($e); ?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <form method="POST" action="login.php">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo htmlspecialchars(t("username")); ?></label>
                            <div class="input-ikon">
                                <i class="bi bi-person"></i>
                                <input type="text" name="username" class="form-control"
                                       placeholder="<?php echo htmlspecialchars(t("placeholder_username")); ?>"
                                       value="<?php echo htmlspecialchars($username); ?>">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label"><?php echo htmlspecialchars(t("password")); ?></label>
                            <div class="input-ikon">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" class="form-control"
                                       placeholder="<?php echo htmlspecialchars(t("placeholder_password")); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i><?php echo htmlspecialchars(t("btn_login")); ?>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>