<?php
function handle_quiz_submission(WP_REST_Request $request) {
    // Extract the form data from the request object
    $name = sanitize_text_field($request->get_param('name'));
    $answers = $request->get_param('answers');
    
    // Initialize the score
    $score = 0;
    // TODO: Process answers and update $score
    
    // Retrieve existing quiz answers from the options table
    $existing_answers = get_option('quiz_answers', []);
    
    // Append the new set of answers
    $existing_answers[] = [
        'name' => $name,
        'answers' => $answers,
        'score' => $score
    ];
    
    // Update the option with the modified array
    update_option('quiz_answers', $existing_answers);
    
    // Return a response
    return new WP_REST_Response(['success' => true, 'score' => $score], 200);
}

add_action('rest_api_init', function () {
    register_rest_route('quiz/v1', '/submit', [
        'methods' => 'POST',
        'callback' => 'handle_quiz_submission',
    ]);
});

function my_delete_function() {
    // Verify Nonce
    if (
        !isset($_POST['delete_quiz_answers_nonce']) ||
        !wp_verify_nonce($_POST['delete_quiz_answers_nonce'], 'delete_quiz_answers_action')
    ) {
        wp_die('Nonce verification failed!');
    }
    
    if (isset($_POST['delete']) && is_array($_POST['delete'])) {
        
        // Get the existing answers
        $existing_answers = get_option('quiz_answers', []);
        
        // Loop through the keys to delete and remove them from the array
        foreach ($_POST['delete'] as $key) {
            if (isset($existing_answers[$key])) {
                unset($existing_answers[$key]);
            }
        }
        
        // Re-index the array to maintain the numeric index continuity
        $existing_answers = array_values($existing_answers);
        
        // Update the modified array back as the option
        update_option('quiz_answers', $existing_answers);
    }
    
    // Redirect back to the referring page
    wp_redirect(wp_get_referer());
    exit;
}

add_action('admin_post_my_delete_handler', 'my_delete_function');
