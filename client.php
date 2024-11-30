<?php
session_start();

// Initiate Default Settings
$settings = $_SESSION['settings'] ?? [
    'level' => '1',
    'operator' => 'add',
    'num_items' => 5,
    'max_diff' => 10,
];

$quizActive = isset($_SESSION['quiz']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Mathematics</title>
    <style>
        .hidden { display: none; }
        .container { border: 1px solid black; padding: 15px; width: 405px; }
        fieldset { display: inline-block; }
        body { display: flex; align-items: center; justify-content: center;}
    </style>
</head>
<body>
    <div class="container">
        <h1>Simple Mathematics</h1>

        <!-- START QUIZ FORM -->
        <form method="post" action="server.php">
            <button type="submit" name="action" value="start_quiz">Start Quiz</button>
        </form>


        <!-- SETTINGS BUTTON -->
        <button onclick="toggleSettings()">Settings</button>


        <!-- RESULTS SECTION -->
        <?php if (isset($_SESSION['results'])): ?>
            <div id="results">
                <p>Correct: <?= $_SESSION['results']['correct']; ?> | Wrong: <?= $_SESSION['results']['wrong']; ?></p>
                <?php if (!isset($_SESSION['quiz'])): ?>
                    <p>Remarks: <?= $_SESSION['results']['remarks']; ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <!-- QUIZ SECTION -->
        <?php if ($quizActive): ?>
        <?php
            $currentRound = $_SESSION['current_round']; // Current Round
            $totalRounds = $_SESSION['total_items']; // Total Rounds
        ?>
        <form method="post" action="server.php">
            <h3>Round <?= $currentRound; ?>/<?= $totalRounds; ?></h3>
            <p><?= $_SESSION['quiz']['question']; ?></p>
            <?php foreach ($_SESSION['quiz']['choices'] as $key => $choice): ?>
                <label>
                    <input type="radio" name="answer" value="<?= $key; ?>" required>
                    <?= $choice; ?>
                </label><br>
            <?php endforeach; ?> <br>
            <button type="submit" name="action" value="submit_answer">Submit Answer</button>
        </form>
        <?php endif; ?>


        <!-- SETTINGS SECTION -->
        <form method="post" action="server.php" id="settings-form" class="hidden">
            <br><hr>
            <h2>Settings</h2>
            <fieldset>
                <legend>Level</legend>
                <label><input type="radio" name="level" value="1" <?= $settings['level'] === '1' ? 'checked' : '' ?>> Level 1 (1-10)</label><br>
                <label><input type="radio" name="level" value="2" <?= $settings['level'] === '2' ? 'checked' : '' ?>> Level 2 (11-100)</label><br>
                <label><input type="radio" name="level" value="custom" <?= $settings['level'] === 'custom' ? 'checked' : '' ?>> Custom</label>
                <span> (<input type="number" name="custom_min" value="<?= $settings['custom_min'] ?? 1 ?>" required style="width: 50px;;">
                - <input type="number" name="custom_max" value="<?= $settings['custom_max'] ?? 10 ?>" required style="width:50px;">) </span>       
            </fieldset>
            <fieldset>
                <legend>Operator</legend>
                <label>
                    <input type="radio" name="operator" value="add" <?= $settings['operator'] === 'add' ? 'checked' : '' ?>> Addition
                </label><br>
                <label>
                    <input type="radio" name="operator" value="sub" <?= $settings['operator'] === 'sub' ? 'checked' : '' ?>> Subtraction
                </label><br>
                <label>
                    <input type="radio" name="operator" value="mul" <?= $settings['operator'] === 'mul' ? 'checked' : '' ?>> Multiplication
                </label><br>
            </fieldset><br><br>
            <label> Number of Items: <input type="number" name="num_items" value="<?= $settings['num_items'] ?>" min="1" required> </label><br>
            <label> Max Difference: <input type="number" name="max_diff" value="<?= $settings['max_diff'] ?>" min="1" required> </label><br><br>
            <button type="submit" name="action" value="save_settings">Save Settings</button>
        </form>
    </div> <!-- Container Div -->

    <script>
        function toggleSettings() {
            const form = document.getElementById('settings-form');
            form.classList.toggle('hidden');
        }
    </script>

</body>
</html>