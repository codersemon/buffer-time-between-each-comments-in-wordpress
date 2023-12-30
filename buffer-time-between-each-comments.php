<?php 
/**
 * Add Buffer time between each comments
 * WordPress Codesinppets by EMON KHAN
 * https://devswizard.com
 * https://emonkhan.me
 * 
 */

 function devswizard_snippets_comment_buffer_time( $commentdata ) {
    // Check if the user is an administrator or editor, in which case, no buffer time is applied.
    if ( current_user_can( 'activate_plugins' ) ) {
        return $commentdata;
    }

    // Check if the user has commented before
    $last_comment_time = get_user_meta( $commentdata['user_id'], 'last_comment_time', true );

    // If it's the first comment or more than 1 hour has passed since the last comment, allow the comment
    // If you want to increase or decrease time just change "3600" to your desired seconds.
    if ( empty( $last_comment_time ) || ( time() - $last_comment_time ) > 3600 ) {
        // Update the last comment time
        update_user_meta( $commentdata['user_id'], 'last_comment_time', time() );

        return $commentdata;
    } else {
        // Display an error message with a "Go to Home Page" button
        $error_message = 'You can only submit one comment per hour. Please wait before submitting another comment.';
        $error_message .= '<br><a href="' . home_url() . '" class="button">Go to Home Page</a>';
        wp_die( $error_message );
    }
}
add_filter( 'preprocess_comment', 'devswizard_snippets_comment_buffer_time' );
