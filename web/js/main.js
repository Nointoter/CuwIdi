$(function () {
    $('#modalButtonAddIdea').click(function () {
        $('#modalAddIdea').modal('show')
            .find('#modalContentAddIdea')
            .load($(this).attr('value'));
    });

    $('#modalButtonChangePassword').click(function () {
        $('#modalChangePassword').modal('show')
            .find('#modalContentChangePassword')
            .load($(this).attr('value'));
    });

    $('.modalButtonDeleteUserUsersIndex').click(function () {
        event.preventDefault();
        $('#modalDeleteUserUsersIndex').modal('show')
            .find('#modalContentDeleteUserUsersIndex')
            .load($(this).attr('value'));
    });

    $('#modalButtonDeleteProfile').click(function () {
        event.preventDefault();
        $('#modalDeleteProfile').modal('show')
            .find('#modalContentDeleteProfile')
            .load($(this).attr('value'));
    });

    $('#modalButtonDeleteUserSieSearch').click(function () {
        event.preventDefault();
        $('#modalDeleteUserSieSearch').modal('show')
            .find('#modalContentDeleteUserSieSearch')
            .load($(this).attr('value'));
    });

    $('body').on('click', '.pjax-delete-link', function (e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('delete-url');
        var pjaxContainer = $(this).attr('pjax-container');
        var result = confirm($(this).attr('pjax-confirm'));
        if (result) {
            $.ajax({
                url: deleteUrl,
                type: 'post',
                error: function (xhr, status, error) {
                    alert('Ошибка удаления.' + xhr.responseText);
                }
            }).done(function (data) {
                $.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 3000});
            });
        }
    });
});
