jQuery(document).ready(function ($) {
    var mailchimpForm = $('form');
    mailchimpForm.on('submit', function (e) {
        e.preventDefault();
        var buttonText = $(this).find('button').text();
        // Change Text
        $(this).find('button').text($(this).find('button').data('loading'));
        $.ajax({
            url: premiumblog_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mailchimp_subscribe',
                fields: $(this).serialize(),
                apiKey: mailchimpForm.data('api-key'),
                listId: mailchimpForm.data('list-id')
            },
            success: function (data) {
                mailchimpForm.find('button').text( buttonText );
                if ( 'subscribed' === data.status ) {
                        mailchimpForm.find( '.pbw-mailchimp-success-message' ).show();
                } else {
                        mailchimpForm.find( '.pbw-mailchimp-error-message' ).show();
                    }
                    
                    mailchimpForm.find( '.pbw-mailchimp-message' ).fadeIn();
            }
        });

    });
});