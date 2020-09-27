<?php require_once("inputCheck.php"); ?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>商品購入入力フォーム</title>
    </head>
    <body>
        <h1>PHPの練習です。</h1>
        <h2>商品購入入力フォーム</h2>
        <form action="confirm.php" method="POST">
            <!-- 隠しフィールドで単価をPOST -->
            <input type="hidden" name="tanka" value="<?php echo $tanka; ?>">
            <ul>
                <li><label>お名前：<input type="text" name="name"></label></li>
                <li><label>郵便番号：<input type="text" name="zipCode"></label></li>
                <li><label>商品単価：<?php echo $tanka; ?>円</label></li>
                <li><label>個数：<input type="number" name="kosu">個</label></li>
                <li><label>クーポンコードをお持ちの場合は入力してください：<br>
                <input type="text" name="discountCode"></label></li>
                <li><label><input type="submit" value="入力内容確認"></label></li>
            </ul>
        </form>
    </body>
</html>