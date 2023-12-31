<?php
/**
 * Template Name: Quiz Page
 */

// Define the correct answers.
$correct_answers = [
    'q1' => 'b', // <link> is used to link a CSS file
    'q2' => 'd', // href="" attribute defines the url
    'q3' => 'c', // font-size controls the text size in CSS
    'q4' => 'd', // JavaScript is primarily used to add interactivity to a web page
    'q5' => 'a', // Padding is used to add space inside an element
    'q6' => 'c', // <script> is used to embed JavaScript in a web page
    'q7' => 'c', // onclick is the JavaScript event fired when a user clicks on an HTML element
    'q8' => 'a', // .class is used to select elements with a specific class in CSS
    'q9' => 'c', // p.help selects a paragraph with the class help
    'q10' => 'b' // style is the HTML attribute used to specify inline styles
];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('POST request received');
    
    // Decode the received JSON data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        error_log('Failed to decode JSON data');
        error_log('JSON Error: ' . json_last_error_msg());
    }
    
    error_log('Received Data: ' . print_r($data, true));
    
    // Initialize the score
    $score = 0;

    // Compare received answers with correct ones and calculate the score
    foreach ($correct_answers as $question => $correct_answer) {
        if (isset($data['answers'][$question]) && $data['answers'][$question] == $correct_answer) {
            $score++;
        }
    }
    
    error_log('Calculated Score: ' . $score);

    // Store the results (name, answers, and score) in the database
    $existing_answers = get_option('quiz_answers', []);
    $existing_answers[] = [
        'name' => sanitize_text_field($data['name']),
        'answers' => $data['answers'],
        'score' => $score,
    ];
    update_option('quiz_answers', $existing_answers);
    
     // Initialize an array to hold the incorrect answers
     $incorrect_answers = [];
    
     // Compare received answers with correct ones and calculate the score
     foreach ($correct_answers as $question => $correct_answer) {
         if (!isset($data['answers'][$question]) || $data['answers'][$question] != $correct_answer) {
             $incorrect_answers[$question] = $correct_answer;
         } else {
             $score++;
         }
     }
     
    // Return the score, incorrect answers, and whether the quiz submission was successful as a JSON response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'score' => $score,
    'incorrect_answers' => $incorrect_answers,
    'total_questions' => count($correct_answers) // Sending total number of questions
]);


     exit;
 
}

// Display the quiz form
get_header();

?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <form id="quiz-form">
            <label for="name">Name: </label>
            <input type="text" name="name" required>

            <fieldset>
                <legend>1. Which HTML element is used to link a CSS file?</legend>
                <label><input type="radio" name="q1" value="a">&lt;a&gt;</label>
                <label><input type="radio" name="q1" value="b">&lt;link&gt;</label>
                <label><input type="radio" name="q1" value="c">&lt;script&gt;</label>
                <label><input type="radio" name="q1" value="d">&lt;style&gt;</label>
            </fieldset>

            <fieldset>
                <legend>2. Which attribute in a link tag specifies the URL?</legend>
                <label><input type="radio" name="q2" value="a">link=""</label>
                <label><input type="radio" name="q2" value="b">src=""</label>
                <label><input type="radio" name="q2" value="c">anchor=""</label>
                <label><input type="radio" name="q2" value="d">href=""</label>
            </fieldset>

            <fieldset>
                <legend>3. Which CSS property controls the text size?</legend>
                <label><input type="radio" name="q3" value="a">font-style</label>
                <label><input type="radio" name="q3" value="b">text-size</label>
                <label><input type="radio" name="q3" value="c">font-size</label>
                <label><input type="radio" name="q3" value="d">text-style</label>
            </fieldset>

        <fieldset>
            <legend>4. Which of the following is primarily used to add interactivity to a web page?</legend>
            <label><input type="radio" name="q4" value="a" required> HTML</label>
            <label><input type="radio" name="q4" value="b"> CSS</label>
            <label><input type="radio" name="q4" value="c"> HTTP</label>
            <label><input type="radio" name="q4" value="d"> JavaScript</label>
        </fieldset>

        <fieldset>
            <legend>5. Which CSS property is used to add space inside an element?</legend>
            <label><input type="radio" name="q5" value="a" required> Padding</label>
            <label><input type="radio" name="q5" value="b"> Margin</label>
            <label><input type="radio" name="q5" value="c"> Border</label>
            <label><input type="radio" name="q5" value="d"> Width</label>
        </fieldset>

        <fieldset>
    <legend>6. Which HTML tag is used to embed JavaScript in a web page?</legend>
    <label><input type="radio" name="q6" value="a" required> &lt;java&gt;</label>
    <label><input type="radio" name="q6" value="b"> &lt;js&gt;</label>
    <label><input type="radio" name="q6" value="c"> &lt;script&gt;</label>
    <label><input type="radio" name="q6" value="d"> &lt;javascript&gt;</label>
</fieldset>

        <fieldset>
    <legend>7. Which JavaScript event is fired when the user clicks on an HTML element?</legend>
    <label><input type="radio" name="q7" value="a" required> onload</label>
    <label><input type="radio" name="q7" value="b"> onchange</label>
    <label><input type="radio" name="q7" value="c"> onclick</label>
    <label><input type="radio" name="q7" value="d"> onmouseover</label>
</fieldset>


        <fieldset>
            <legend>8. Which of the following selectors is used to select elements with a specific class?</legend>
            <label><input type="radio" name="q8" value="a" required> .class</label>
            <label><input type="radio" name="q8" value="b"> #class</label>
            <label><input type="radio" name="q8" value="c"> class</label>
            <label><input type="radio" name="q8" value="d"> *class</label>
        </fieldset>

        <fieldset>
            <legend>9. Which of the following CSS selectors selects a paragraph with the class help?</legend>
            <label><input type="radio" name="q9" value="a" required>paragraph .help</label>
            <label><input type="radio" name="q9" value="b"> p#help</label>
            <label><input type="radio" name="q9" value="c"> p.help</label>
            <label><input type="radio" name="q9" value="d"> #help>p</label>
        </fieldset>

            <fieldset>
                <legend>10. Which HTML attribute is used to specify inline styles?</legend>
                <label><input type="radio" name="q10" value="a">class</label>
                <label><input type="radio" name="q10" value="b">style</label>
                <label><input type="radio" name="q10" value="c">styles</label>
                <label><input type="radio" name="q10" value="d">inline-style</label>
            </fieldset>

            <input type="submit" value="Submit">
        </form>
    </main>
</div>

<script>
document.getElementById('quiz-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

// Construct an object containing form data
const data = {
    name: formData.get('name'),
    answers: {
        q1: formData.get('q1'), // This will be 'a', 'b', 'c', or 'd' depending on the user's choice
        q2: formData.get('q2'),
        q3: formData.get('q3'),
        q4: formData.get('q4'),
        q5: formData.get('q5'),
        q6: formData.get('q6'),
        q7: formData.get('q7'),
        q8: formData.get('q8'),
        q9: formData.get('q9'),
        q10: formData.get('q10')
    }
};


    console.log('Sending Data:', data);

    fetch('/quiz/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => {
        console.log('Received Response:', response);
        return response.json();
    })
    .then(data => {
        // Handle the response from the server
        console.log('Received Data:', data);
        
        let feedbackMessage = `Quiz submitted successfully! Your score is: ${data.score} out of ${data.total_questions}.\n`;
        
        if (Object.keys(data.incorrect_answers).length > 0) {
            feedbackMessage += 'The following answers are incorrect:\n';
            for (const [question, correctAnswer] of Object.entries(data.incorrect_answers)) {
                feedbackMessage += `Question ${question.replace('q', '')}: Correct answer is ${correctAnswer}\n`;
            }
        }
        
        alert(feedbackMessage);
    })

    .catch(error => {
        console.error('Error during fetch operation: ', error);
        alert('There was an error submitting the quiz.');
    });
});

</script>

<?php
if (current_user_can('administrator')) {
    $quiz_answers = get_option('quiz_answers', []);
    if (!empty($quiz_answers)) {

        if (!empty($quiz_answers)) {
            // Initialize an array to hold the count of wrong answers for each question.
            $wrong_answers_count = [];
            
            foreach ($quiz_answers as $answer) {
                foreach ($correct_answers as $question => $correct_answer) {
                    if (!isset($answer['answers'][$question]) || $answer['answers'][$question] != $correct_answer) {
                        // Increment the count of wrong answers for the question.
                        if (!isset($wrong_answers_count[$question])) {
                            $wrong_answers_count[$question] = 0;
                        }
                        $wrong_answers_count[$question]++;
                    }
                }
            }
            
            // Display the table with counts of wrong answers.
            echo '<table>';
            echo '<tr><th>Question</th><th>Wrong Answers Count</th></tr>';
            foreach ($wrong_answers_count as $question => $count) {
                echo '<tr>';
                echo '<td>' . esc_html($question) . '</td>';
                echo '<td>' . esc_html($count) . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            echo '<style>';
            echo 'table { width: 100%; border-collapse: collapse; }';
            echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
            echo 'th { background-color: #4CAF50; color: white; }';
            echo 'ul { list-style-type: none; padding: 0; }';
            echo '.question { font-weight: bold; color: #333; }';
            echo '.value { color: #666; }';
            echo '</style>';
            
            echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
            echo '<input type="hidden" name="action" value="my_delete_handler" />';
            echo wp_nonce_field('delete_quiz_answers_action', 'delete_quiz_answers_nonce');

            echo '<table>';
            echo '<tr><th>Select</th><th>Name</th><th>Answers</th><th>Score</th></tr>'; // Added 'Select' column header
            foreach ($quiz_answers as $key => $answer) { // Assuming $quiz_answers is an associative array and $key is a unique identifier for each row.
                echo '<tr>';
                echo '<td><input type="checkbox" name="delete[]" value="' . esc_attr($key) . '"></td>'; // Checkbox for each row
                echo '<td>' . esc_html($answer['name']) . '</td>';
                
                echo '<td>';
                echo '<ul>';
                foreach ($answer['answers'] as $question => $selected_answer) {
                    echo '<li><span class="question">' . esc_html($question) . ':</span> <span class="value">' . esc_html($selected_answer) . '</span></li>';
                }
                echo '</ul>';
                echo '</td>';
                
                echo '<td>' . esc_html($answer['score']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<input type="submit" value="Delete Selected">'; // Delete button
            echo '</form>';
            
    } else {
        echo '<p>No quiz results found.</p>';
    }
}
}



get_footer();
