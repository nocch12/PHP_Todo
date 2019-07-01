$(function () {
    'use strict';

    // 初期状態でinputにフォーカス
    $('#new_todo').val('').focus();


    // ボタンクリックで「本当に削除しますか？」を表示
    $(document).on('click', '.delete_btn', function () {
        $(this).toggleClass('active');
        $(this).next('.delete_confirm').toggleClass('active');
    });


    $('#todos').on('click', '.delete_confirm', function () {
        // クリックしたTodoのid番号を取得
        // このidはデータベース上のidと同じ値
        let id = $(this).parents('li').data('id');

        // _ajax.phpに情報をPOST送信
        $.post('_ajax.php', {
            // id項目に上の変数idをセット
            id: id,
            // mode項目に'delete'
            mode: 'delete',
            // tokenも渡す（セキュリティチェック）
            token: $('#token').val()
        }, function (res) {
            // 消えるときのアニメーション
            $('#todo_' + id).hide(600).animate(
                { marginLeft: "500px" },
                {
                    // 0.4s
                    duration: 400,
                    // hideと同時にアニメーション開始
                    queue: false
                }
            );
            // 表示が消えた後に要素自体を消す
            setTimeout(function () {
                $('#todo_' + id).remove();
            }, 600);
        });
    });

    $('#new_todo_form').on('submit', function () {
        let title = $("#new_todo").val();

        $.post('_ajax.php', {
            title: title,
            mode: 'create',
            token: $('#token').val()
        }, function (res) { // resには_ajax.phpでjsonにechoした値が返ってくる

            //li要素のひな形をクローン
            let $li = $('#todo_template').clone();

            $li // 各属性とテキストを追加
                .attr('id', 'todo_' + res.id)
                .data('id', res.id)
                .find('.card-text').text(title);

            // 先頭にスライド表示
            $($li).prependTo('#todos').hide().slideDown();

            // インプットにフォーカスを戻す
            $('#new_todo').val('').focus();

            // ひな形のli以外を取得
            let todoList = $("li.todo:not('#todo_template')");
            // その数を数える
            let count = todoList.length;

            // 表示数が5件を超える場合は
            // 最後尾のliを消す
            if (count > 5) {
                $("li.todo:not('#todo_template')").filter(":last").slideUp().queue(function () {
                    $(this).remove();
                });
            }
        });

        // 処理を終了
        return false;
    });



});