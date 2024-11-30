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
function generateQuiz($settings) {
    // Set Level - Min/Max Value
    $min = 1; // Default Minimum Value
    $max = 10; // Default Maximum Value

    if ($settings['level'] === '1') {
        $min = 1;
        $max = 10;
    } elseif ($settings['level'] === '2') {
        $min = 11;
        $max = 100;
    } elseif ($settings['level'] === 'custom') {
        $min = $settings['custom_min'] ?? 1;
        $max = $settings['custom_max'] ?? 10;
    }

    // Generate Random Number (Operands) 
    $num1 = rand($min, $max);
    $num2 = rand($min, $max);

    // Set Operator & Answer
    $operator = $settings['operator'] ?? 'add';
    $answer = 0; // Initialize Variable
    switch ($operator) {
        case 'add':
            $answer = $num1 + $num2;
            $operatorSymbol = '+';
            break;
        case 'sub':
            $answer = $num1 - $num2;
            $operatorSymbol = '-';
            break;
        case 'mul':
            $answer = $num1 * $num2;
            $operatorSymbol = '*';
            break;
        default:
            $operatorSymbol = '+';
            $answer = $num1 + $num2;
    }

    // Generate UNIQUE Choices
    $choices = [$answer];
    $max_diff = $settings['max_diff'] ?? 10;
    while (count($choices) < 4) {
        $choice = rand($answer - $max_diff, $answer + $max_diff);
        if (!in_array($choice, $choices)) {
            $choices[] = $choice;
        }
    }
    shuffle($choices); // For Randomness

    return [
        'question' => "$num1 $operatorSymbol $num2 = ?",
        'correct_index' => array_search($answer, $choices),
        'choices' => $choices,
    ];
}

// REQUEST POST
    // Save Settings
    // Start Quiz
    // Submit Answer
?>