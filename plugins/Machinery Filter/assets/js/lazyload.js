//Load more posts button
jQuery( '#more-posts-button' ).click( function( e ) {

    e.preventDefault(); 

    ajax_next_posts(); 

});


//ajaxLock is just a flag to prevent double clicks and spamming
var ajaxLock = false;

if( ! ajaxLock ) {

    function ajax_next_posts() {

        ajaxLock = true;

        //How many posts there's total
        var totalPosts = parseInt( jQuery( '#total-posts-count' ).text() );
        //How many have been loaded
        var postOffset = jQuery( '.single-post' ).length;
        //How many do you want to load in single patch
        var postsPerPage = 24;

        //Hide button if all posts are loaded
        if( totalPosts < postOffset + ( 1 * postsPerPage ) ) {

            jQuery( '#more-posts-button' ).fadeOut();
        }

        //Change that to your right site url unless you've already set global ajaxURL
        var ajaxURL = 'http://www.my-site.com/wp-admin/admin-ajax.php';

        //Parameters you want to pass to query
        var ajaxData = '&post_offset=' + postOffset + '&action=ajax_next_posts';

        //Ajax call itself
        jQuery.ajax({

            type: 'get',
            url:  ajaxURL,
            data: ajaxData,
            dataType: 'json',

            //Ajax call is successful
            success: function ( response ) {

                //Add new posts
                jQuery( '#posts-container' ).append( response[0] );
                //Update the count of total posts
                jQuery( '#total-posts-count' ).text( response[1] );

                ajaxLock = false;
            },

            //Ajax call is not successful, still remove lock in order to try again
            error: function () {

                ajaxLock = false;
            }
        });
    }
}

