<?php
// login.php

session_start();

// ダミーユーザー情報を読み込み（実際のアプリケーションではデータベースを使用）
$users = file_get_contents('users.txt');
$users = explode("\n", $users);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    foreach ($users as $user) {
        list($stored_username, $stored_password) = explode(':', $user);

        if ($input_username === $stored_username && $input_password === trim($stored_password)) {
            $_SESSION['user'] = $input_username;
            echo 'success';
            exit; // ログイン成功時はここで処理終了
        }
    }

    // ユーザーが見つからないか、パスワードが一致しない場合
    echo 'failure';
} else {
    // POSTリクエスト以外のアクセスは拒否
    echo 'failure';
}
?>
