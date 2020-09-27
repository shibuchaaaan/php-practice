<?php
    //税金定義
    const TAX = 1.08;
    //単価設定
    const TANKA = 2500;
    $tanka = number_format(TANKA);
    //割引率の定義
    const DISCOUNT = 0.8;
    
    //各エラーメッセージを入れる配列
    $errors = [];

    //名前チェック
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        if($name === ""){
            //空白の時エラー
            $errors[] = "お名前を入力してください";
        }
    }else{
        //値がセットされていない時もエラー
        $errors[] = "お名前を入力してください";
    }

    //郵便番号チェック
    if(isset($_POST['zipCode'])){
        $zip = $_POST['zipCode'];
        //郵便番号パターンを登録
        $pattern = '/^[0-9]{3}-[0-9]{4}$/';
        //パターンと一致しない場合
        if(!preg_match($pattern,$zip)){
            $errors[] = '郵便番号は「000-0000」の形で指定してください';
        }
    }else{
        $errors[] = '郵便番号を正しく入力してください';
    }

    //個数チェック
    if(isset($_POST['kosu'])){
        $kosu = $_POST['kosu'];
        if(!ctype_digit($kosu)){
            $errors[] = "個数を整数で入力してください";
        }else if($kosu == 0){
            $errors[] = "個数は1個以上で入力してください";
        }
    }else{
        $errors[] = "個数を整数で入力してください";
    }

    //$errorsが無い場合、値段を計算
    if(count($errors) <= 0){
        //割引の確認
        $off = (1 - DISCOUNT) * 100;
        $discountMsg = "<h2>このページでのご購入は{$off}% OFFになります！<h2>";
        
        //クーポンコード受け取りの確認
        $isDiscount = false;
        $discountErrorMsg = null;
        
        if(isset($_POST['discountCode'])){
            $discountCode = $_POST['discountCode'];
            if($discountCode === 'A5236'){
                $isDiscount = true;
                $price = TANKA * $kosu;
                $discountPrice = number_format($price * DISCOUNT);
                $discountTotalPrice = number_format($discountPrice * TAX);

            }else{
                $discountErrorMsg = "クーポンコードが違います";
            }
        }else{
            //小計計算
            $price = TANKA * $kosu;
            //合計
            $totalPrice = $price * TAX;
            //format使って3桁毎にカンマ付けする
            $price = number_format($price);
            $totalPrice = number_format($totalPrice);
        }
    }

?>