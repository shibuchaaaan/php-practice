$(function(){
    'use strict';
    
    $('#new_todo').focus();

    //チェックボックスがクリックされたとき（更新）
    $('#todos').on('click','.update_todo',function(){
        //update_todoの親要素liのdata-id(=DB内id)を取得
        var id = $(this).parents('li').data('id');
        //id,処理modeをajax.phpに送る
        $.post('_ajax.php',{
            id: id,
            mode: 'update',
            //tokenのvalue
            token: $('#token').val()
        }, function(res){
            //返ってきたtodoのstateが1の場合
            if(res.state === '1') {
                //#todoにid(番号)付与＆todo_titleクラスにdoneを追加
                $('#todo_' + id).find('.todo_title').addClass('done');
            } else {
                $('#todo_' + id).find('.todo_title').removeClass('done');
            }
        })

    });

    //xボタンを押したとき（削除）
    $('#todos').on('click','.delete_todo',function(){
        //id取得
        var id = $(this).parents('li').data('id');
        //Ajax処理
        if (confirm('are you sure?')) {
            $.post('_ajax.php',{
                id: id,
                mode: 'delete',
                token: $('#token').val()
            }, function(){
                //該当idの#todo_?を消す
                $('#todo_' + id).fadeOut(800);
            });
        }
    });

    //新規追加
    $('#new_todo_form').on('submit', function(){
        //title取得
        var title = $('#new_todo').val();
        //Ajax処理
        $.post('_ajax.php',{
            title: title,
            mode: 'create',
            token: $('#token').val()
        }, function(res){
            //todo_templateをcloneして新たにliを追加
            var $li = $('#todo_template').clone();
            //$liに対して様々な属性を付与する
            $li
                .attr('id','todo_' + res.id)
                .data('id', res.id)
                .find('.todo_title').text(title);
            //todosにフェードインで追加
            $('#todos').prepend($li.fadeIn());
            //new_todoを空にして,focus()でまた入れられるようにする
            $('#new_todo').val('').focus();
            });
        //submitしたとき画面遷移しないよう、falseを返す
        return false;
    });
});