<?php
/**
 * Template Name: Quiz Page
 */

// Define the correct answers.
$correct_answers = [
    'q1' => 'b', // <link> is used to link a CSS file
    'q2' => 'c', // function myFunction() is how you create a function in JavaScript
    'q3' => 'c', // font-size controls the text size in CSS
    'q4' => 'd', // JavaScript is primarily used to add interactivity to a web page
    'q5' => 'a', // Padding is used to add space inside an element
    'q6' => 'c', // <script> is used to embed JavaScript in a web page
    'q7' => 'c', // onclick is the JavaScript event fired when a user clicks on an HTML element
    'q8' => 'a', // .class is used to select elements with a specific class in CSS
    'q9' => 'd', // margin: 0 auto; is used to center an element horizontally in CSS
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
    
    // Return the score as a JSON response and exit
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'score' => $score]);
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
                <legend>2. How do you create a function in JavaScript?</legend>
                <label><input type="radio" name="q2" value="a">function:myFunction()</label>
                <label><input type="radio" name="q2" value="b">function = myFunction()</label>
                <label><input type="radio" name="q2" value="c">function myFunction()</label>
                <label><input type="radio" name="q2" value="d">myFunction():function</label>
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
            <legend>9. Which of the following CSS rules centers an element horizontally?</legend>
            <label><input type="radio" name="q9" value="a" required> text-align: center;</label>
            <label><input type="radio" name="q9" value="b"> align: center;</label>
            <label><input type="radio" name="q9" value="c"> horizontal-align: center;</label>
            <label><input type="radio" name="q9" value="d"> margin: 0 auto;</label>
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
        if (data.success) {
            alert('Quiz submitted successfully! Your score is: ' + data.score);
        } else {
            alert('There was an error submitting the quiz.');
        }
    })
    .catch(error => {
        console.error('Error during fetch operation: ', error);
        alert('There was an error submitting the quiz.');
    });
});

</script>

<?php
get_footer();
