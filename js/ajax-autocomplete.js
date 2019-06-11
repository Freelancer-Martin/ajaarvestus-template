jQuery(document).ready(function($) {




    console.log(  $('input').val()  );


    $( '.ajax-save-html-tag' ).mouseenter(function() {//on( "mouseenter", function() {

        //console.log(  $( this ).find( '.ajax-html-tag-value' ).val() );

        var mydata = {

            action: "save_cool_options",
            html_tag: $( this ).find( '.ajax-html-tag-value' ).val(),
            month: $( this ).find( '.ajax-month-value' ).val(),
            //color: 'green'
        };
        //console.log( mydata );

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

        $.ajax({
            type: "POST",
            url: ajaxurl,

            dataType: "json",
            data: mydata,
            success: function (data, textStatus, jqXHR) {

        if(data === true)
          $('#display').fadeOut( 1000 ).html('<p>Options Saved!</p>');

            },

            error: function (errorMessage) {

                console.log(errorMessage);
            }

        });


    });

});
