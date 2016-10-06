jQuery( document ).on( 'click', '.pt-love-it', function() {
	var $this 	= jQuery(this),
		post_id = $this.find('.love-button').attr('data-id'),
		nonce 	= $this.find('#_wpnonce').val();

		// wp_love_it_ids = jQuery.cookie('wp_love_it_ids') ? jQuery.cookie('wp_love_it_ids').split(',') : [];
		wp_love_it_ids = Cookies.get('wp_love_it_ids') ? Cookies.get('wp_love_it_ids').split(',') : [];

	if ( $this.hasClass( 'has_rated' ) ) {
        return false;
    }

    var count = $this.find('.love-count').text();

    jQuery( '#love-count-'+post_id ).text( parseFloat(count) + 1 );
    jQuery( '#pt-love-it-'+post_id ).addClass( 'has_rated' );
	jQuery( '#pt-love-it-'+post_id ).find('.love-button').text( loveit.lovedText ).removeAttr( 'href' );
	
	jQuery.ajax({
		url : loveit.ajax_url,
		type : 'POST',
		dataType: 'json',
		data : {
			action : 'pt_love_it',
			post_id : post_id,
			_wpnonce : nonce
		},
		success : function( data ) {		
			if ( data.status ) {
				wp_love_it_ids.push( post_id );
				// jQuery.cookie('wp_love_it_ids', wp_love_it_ids, {expires: 3});
				Cookies.set('wp_love_it_ids', wp_love_it_ids.toString(), { expires: 3, path: '' });
			} else {
				jQuery( '#pt-love-it-'+post_id ).removeClass( 'has_rated' );
				jQuery( '#pt-love-it-'+post_id ).find('.love-button').text( loveit.loveText );
				jQuery( '#love-count-'+post_id ).text( count );
			}
		},
		error: function() {
			jQuery( '#pt-love-it-'+post_id ).removeClass( 'has_rated' );
			jQuery( '#pt-love-it-'+post_id ).find('.love-button').text( loveit.loveText );
			jQuery( '#love-count-'+post_id ).text( count );
      	}
	});
	 
	return false;
})