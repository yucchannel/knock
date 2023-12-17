<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function(){
            // トピックのロード
            function loadTopics() {
                $.ajax({
                    type: "GET",
                    url: "load_topics.php",
                    success: function(data){
                        $("#topics").html(data);
                    }
                });
            }

            // ログインフォームの送信
            $("#login-form").submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "login.php",
                    data: $(this).serialize(),
                    success: function(data){
                        if (data === "success") {
                            // ログイン成功時の処理
                            loadTopics();
                        } else {
                            alert("ログイン失敗");
                        }
                    }
                });
            });

            // 投稿フォームの送信
            $("#post-form").submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "post_message.php",
                    data: $(this).serialize(),
                    success: function(data){
                        if (data === "success") {
                            // 投稿成功時の処理
                            loadTopics();
                            $("#message").val(""); // メッセージフィールドをクリア
                        } else {
                            alert("投稿失敗");
                        }
                    }
                });
            });

            // 削除ボタンのクリック
            $(document).on("click", ".delete-btn", function(){
                var messageId = $(this).data("message-id");
                $.ajax({
                    type: "POST",
                    url: "delete_message.php",
                    data: { messageId: messageId },
                    success: function(data){
                        if (data === "success") {
                            // 削除成功時の処理
                            loadTopics();
                        } else {
                            alert("削除失敗");
                        }
                    }
                });
            });

            // 初回トピックのロード
            loadTopics();
        });
    </script>
</head>
<body>

<div id="topics"></div>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    // ログインフォーム表示
    echo '
        <div id="login-container">
            <h2>Login</h2>
            <form id="login-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    ';
}
?>

<div id="post-container">
    <h2>Post a Message</h2>
    <form id="post-form">
        <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
        <button type="submit">Post</button>
    </form>
</div>

</body>
</html>
