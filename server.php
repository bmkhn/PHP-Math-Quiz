<?php
session_start();

// Initialize Default Settings (IF NOT SET)
if (!isset($_SESSION['settings'])) {
    $_SESSION['settings'] = [
        'level' => '1',
        'operator' => 'add', 
        'num_items' => 5, 
        'max_diff' => 10, 
    ];
}

// generateQuiz
    // Level - Set Minimum and Maximum Value
    // Generate Random Number (Operands) 
    // Set Operator & Answer
    // Generate Choices

// REQUEST POST
    // Save Settings
    // Start Quiz
    // Submit Answer
?>