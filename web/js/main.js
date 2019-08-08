$(function(){
    $('#modalButtonAddIdea').click(function(){
        $('#modalAddIdea').modal('show')
            .find('#modalContentAddIdea')
            .load($(this).attr('value'));
    });

    $('#modalButtonChangePassword').click(function(){
        $('#modalChangePassword').modal('show')
            .find('#modalContentChangePassword')
            .load($(this).attr('value'));
    });

    $('.modalButtonDeleteUserUsersIndex').click(function(){
        event.preventDefault();

        console.log("Ура! Мы здесь.");
        console.log("Вывод значения атрибута:");
        console.log($(this).attr('value'));

        $('#modalDeleteUserUsersIndex').modal('show')
            .find('#modalContentDeleteUserUsersIndex')
            .load($(this).attr('value'));
    });

    $('#modalButtonDeleteProfile').click(function(){
        event.preventDefault();
        $('#modalDeleteProfile').modal('show')
            .find('#modalContentDeleteProfile')
            .load($(this).attr('value'));
    });

    $('#modalButtonDeleteUserSieSearch').click(function(){
        event.preventDefault();
        $('#modalDeleteUserSieSearch').modal('show')
            .find('#modalContentDeleteUserSieSearch')
            .load($(this).attr('value'));
    });
});