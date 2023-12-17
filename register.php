<?php
// register.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['new-username'];
    $new_password = $_POST['new-password'];

    // ダミーユーザー情報を読み込み（実際のアプリケーションではデータベースを使用）
    $users = file_get_contents('users.txt');
    $users = explode("\n", $users);

    // 既存ユーザーの重複チェック
    foreach ($users as $user) {
        list($stored_username, $stored_password) = explode(':', $user);
        if ($new_username === $stored_username) {
            echo 'duplicate';
            exit;
        }
    }

    // ユーザーを新規登録
    $new_user_data = $new_username . ':' . $new_password . "\n";
    file_put_contents('users.txt', $new_user_data, FILE_APPEND);

    echo 'success';
} else {
    // POSTリクエスト以外のアクセスは拒否
    echo 'failure';
}
?>
