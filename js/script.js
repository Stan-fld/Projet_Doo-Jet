$(function() {
    $('form.ajax').submit(function(event){
        event.preventDefault();
        var data = new FormData(jQuery(this).get(0));
        jQuery.ajax({
            url:            'traitForm.php',     // $form.attr('action'),
            type:           'POST',              // $form.attr('method'),
            contentType:    false,               // obligatoire pour de l'upload
            processData:    false,               // obligatoire pour de l'upload
            dataType:       'html',              // 'json', // selon le retour attendu
            // ON LIE LES INFOS DU FORMULAIRE DANS LA REQUETE AJAX
            data:           data,
            // FONCTION A ACTIVER QUAND LE NAVIGATEUR RECOIT LA REPONSE DU SERVEUR
            success:        SITE.feedbackAjax
        });
    });
});
