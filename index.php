<?php

session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Todo.php');

//get todos
$todoApp = new \MyApp\Todo();
$todos = $todoApp->getAll();

require 'Calendar.php';
$calendar = new \MyApp\Calendar();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My TODOs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <div class="todo-wrapper">
            <h1>TODO</h1>
            <form action="" id="new_todo_form">
                <input type="text" id="new_todo" placeholder="What needs to be done?">
            </form>
            <ul id="todos">
            <?php foreach($todos as $todo) : ?>
                <li id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
                    <input type="checkbox" class="update_todo" <?php if ($todo->state === '1') { echo 'checked'; } ?>>
                    <span class="todo_title <?php if ($todo->state === '1') { echo 'done'; } ?>"><?= h($todo->title); ?></span>
                    <div class="delete_todo">x</div>
                </li>
            <?php endforeach; ?>
            
            <!-- 追加時のテンプレ -->
            <li id="todo_template" data-id="">
                <input type="checkbox" class="update_todo">
                <span class="todo_title"></span>
                <div class="delete_todo">x</div>
            </li>

            </ul>
        </div>

        <div class="calender-wrapper">
            <table>
                <thead>
                    <tr>
                        <th><a href="/?t=<?php echo h($calendar->prev); ?>">&laquo;</a></th>
                        <th colspan="5"><?php echo h($calendar->yearMonth); ?></th>
                        <th><a href="/?t=<?php echo h($calendar->next); ?>">&raquo;</a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sun</td>
                        <td>Mon</td>
                        <td>Tue</td>
                        <td>Wed</td>
                        <td>Thu</td>
                        <td>Fri</td>
                        <td>Sat</td>
                    </tr>
                    <?php $calendar->show(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7"><a href="/">Today</a></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="todo.js"></script>
</body>
</html>