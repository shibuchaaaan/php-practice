<?php
    require_once("inputCheck.php");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>入力内容確認</title>
</head>
<body>
    <div>
        <!-- エラーがあった時 -->
        <?php if(count($errors) > 0): ?>
        <!-- エラー内容を表示 -->
            <ul>
                <?php foreach($errors as $error){
                    echo '<li class="error">'.$error.'</li>';
                }
                ?>
            </ul>
        <!-- エラーがなかった時 -->
        <?php else: ?>
            <p><span>こんにちは、<?php echo $name ?>さん</span></p>
            <p><span>郵便番号：<?php echo $zip ?></span></p>
            
            <!-- 割引きコードを受け取った場合 -->
            <?php if($isDiscount): ?>
                    <?php echo $discountErrorMsg; ?>
                    <?php echo  $discountMsg; ?>
                    <ul>
                        <li>単価：<?php echo $tanka ?>円</li>
                        <li>個数：<?php echo $kosu ?>個</li>
                        <li>小計（税抜き）：<?php echo $discountPrice ?>円</li>
                        <li>合計（税込み）：<?php echo $discountTotalPrice ?>円</li>
                    </ul>

            <!-- 割引きコード無しの場合 -->
            <?php else: ?>
            <ul>
                <li>単価：<?php echo $tanka ?>円</li>
                <li>個数：<?php echo $kosu ?>個</li>
                <li>小計（税抜き）：<?php echo $price ?>円</li>
                <li>合計（税込み）：<?php echo $totalPrice ?>円</li>
            </ul>
            <?php endif; ?>
        <?php endif; ?>
        <p><a href="inputform.php">入力画面に戻る</a></p>
    </div>
</body>
</html>