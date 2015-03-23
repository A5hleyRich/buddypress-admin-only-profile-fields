( function( $ ) {

	$( document ).ready( function() {

		var $visibilityInput = $( 'input[name=default-visibility]' );
		var $allowedInput    = $( '#allow-custom-visibility-allowed' )
		var $disabledInput   = $( '#allow-custom-visibility-disabled' );
		var $enforceBox      = $allowedInput.closest( '.postbox' );

		if ( 'hidden' === $visibilityInput.filter( ':checked' ).val() ) {
			$enforceBox.hide();
			$disabledInput.attr( 'checked', true );
		}

		$visibilityInput.on( 'change', function() {
			if ( 'hidden' === $( this ).val() ) {
				$enforceBox.hide();
				$disabledInput.attr( 'checked', true );
			}
			else {
				$enforceBox.show();
				$allowedInput.attr( 'checked', true );
			}
		} );

	} );

} )( jQuery );