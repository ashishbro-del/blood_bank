<?php
session_start();

// Display error messages if they exist in the session
if (isset($_SESSION['error'])) {
    echo '<div class="error-message">';
    echo '<p>' . $_SESSION['error'] . '</p>';
    echo '</div>';
    // Clear the error message after displaying it
    unset($_SESSION['error']);
}

// Display success messages if they exist in the session
if (isset($_SESSION['success'])) {
    echo '<div class="success-message">';
    echo '<p>' . $_SESSION['success'] . '</p>';
    echo '</div>';
    // Clear the success message after displaying it
    unset($_SESSION['success']);
}
?>
