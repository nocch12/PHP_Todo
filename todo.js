$(function () {
    'use strict';

    $('#new_todo').val('').focus();


    $(document).on('click', '.delete_btn', function () {
        $(this).toggleClass('active');
        $(this).next('.delete_confirm').toggleClass('active');
    });


    $('#todos').on('click', '.delete_confirm', function () {
        let id = $(this).parents('li').data('id');

        $.post('_ajax.php', {
            id: id,
            mode: 'delete',
            token: $('#token').val()
        }, function (res) {
            $('#todo_' + id).hide(600).animate(
                { marginLeft: "500px" },
                {
                    duration: 400,
                    queue: false
                }
            );
            setTimeout(function () {
                $('#todo_' + id).remove();
            }, 600);
        });
    });
    'use strict';

    $('#new_todo_form').on('submit', function () {
        let title = $("#new_todo").val();

        $.post('_ajax.php', {
            title: title,
            mode: 'create',
            token: $('#token').val()
        }, function (res) {
            let $li = $('#todo_template').clone();
            $li
                .attr('id', 'todo_' + res.id)
                .data('id', res.id)
                .find('.card-text').text(title);
            $($li).prependTo('#todos').hide().slideDown();
            $('#new_todo').val('').focus();

            let todoList = $("li.todo:not('#todo_template')");
            let count = todoList.length;
            console.log(count);

            if (count > 5) {
                $("li.todo:not('#todo_template')").filter(":last").slideUp().queue(function () {
                    $(this).remove();
                });
            }
        });
        return false;
    });



});