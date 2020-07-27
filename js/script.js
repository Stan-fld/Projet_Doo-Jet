$(function() {
    $('form.ajax').submit(function(event) {
        event.preventDefault();
        var data = new FormData($(this).get(0));
        var target = $(this).attr('data-target');
        //DEBUG
        //console.log(data);
        $.ajax({
            url:            'traitForm.php',    // $form.attr('action'),
            type:           'POST',             // $form.attr('method'),
            contentType:    false,              // obligatoire pour de l'upload
            processData:    false,              // obligatoire pour de l'upload
            dataType:       'html',             // retour attendu
            data:           data,               // ON LIE LES INFOS DU FORMULAIRE DANS LA REQUETE AJAX
            success:        function(result){
                if(target != undefined) $(target).html(result);
                else $(".feedback").html(result);
            }
        });
    });
});
