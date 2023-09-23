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
