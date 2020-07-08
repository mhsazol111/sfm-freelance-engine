<?php
if( ! defined( 'ABSPATH' ) ) die( 'No direct access please!' );

if( ! class_exists('sfmInvitation') ) {
	/**
	 * Class sfmInvitations
	 */
    class sfmInvitations{
	    /**
	     * sfmInvitations constructor.
	     */
    	public function __construct() {
		    add_action( 'fre_new_invite', array($this, 'store_invitation'), 12, 3 );
	    }

	    /**
	     * @param int $invited      ID of the User who will get the invitation.
	     * @param int $send_invite  User id of invitation sender.
	     * @param int $value        ID of the Project where the user is invited.
	     *
	     * @return void
	     */
	    public function store_invitation( $invited, $send_invite, $value ) {

    		$previous_invitations = (array) get_post_meta( $value, '_sfm_invited_users', true );

    		if( !empty( $previous_invitations ) && is_array( $previous_invitations )  ) {

				if( !in_array($invited, $previous_invitations ) ) {
					$previous_invitations[] = $invited;
				}

		    } else {

			    $previous_invitations = array();
			    $previous_invitations[] = $invited;

		     }

    		update_post_meta( $value, '_sfm_invited_users', $previous_invitations );

	    }

	    /**
	     * Get the invitations by project id.
	     *
	     * @param int $project_id
	     *
	     * @return array
	     */
	    public static function getInvitations( $project_id ){
		    $inv_meta = get_post_meta( $project_id, '_sfm_invited_users', true );
		    if ( ! empty( $inv_meta ) && is_array( $inv_meta ) ) {
			    return array_filter( $inv_meta, function ( $inv ) {
				    return ! empty( $inv );
			    } );
		    }
		    return [];
	    }
    }

    new sfmInvitations();
}