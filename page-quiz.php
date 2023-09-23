<?php
/**
 * Template Name: Quiz Page
 */

// Display the quiz form
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <form id="quiz-form">
            <label for="name">Name: </label>
            <input type="text" name="name" required>
            <!-- Other form fields go here -->
            <input type="submit" value="Submit">
        </form>
    </main>
</div>

<script>
document.getElementById('quiz-form').addEventListener('submit', function (event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    fetch('/wp-json/quiz/v1/submit', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
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
