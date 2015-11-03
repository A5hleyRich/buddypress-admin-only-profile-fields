( function( $ ) {

	$( document ).ready( function() {

		var $visibilityInput = $( 'select[name=default-visibility]' );
		var $allowedInput    = $( '#allow-custom-visibility-allowed' )
		var $disabledInput   = $( '#allow-custom-visibility-disabled' );
		var $adminVisibilities = ['hidden', 'admin-owner', 'admin-all'];

		if ( $.inArray( $visibilityInput.val(), $adminVisibilities ) !== -1 ) {
			$disabledInput.attr( 'checked', true );
		}

		$visibilityInput.on( 'change', function() {
			if ( $.inArray( $( this ).val(), $adminVisibilities ) !== -1 ) {
				$disabledInput.attr( 'checked', true );
			} else {
				$allowedInput.attr( 'checked', true );
			}
		} );

	} );

} )( jQuery );