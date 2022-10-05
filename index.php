<?php
require "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST">
                <!-- For an error -->
                <?php if (isset($_GET['mess']) && ($_GET['mess']) == 'error') { ?>
                    <input type="text" 
                        name="title" 
                        placeholder="This field is required"
                        style="border-color: red;"/>
                <button type="submit">Add &nbsp;<span>&#43;</span></button>
                <?php } else { ?>
                    <input type="text" 
                       name="title" 
                       placeholder="Type your task here!">
                <button type="submit">Add &nbsp;<span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="show-todo-section">
            <!-- if todo list is empty - show a picture -->
            <?php if ($todos->rowCount() < 0) { ?>
            <div class="todo-item">
                <div class="empty">
                    <img src="img/todolist.jpg" alt="to do list photo"/>
                </div>
            </div>
            <?php } ?>
            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>" 
                        class="remove-to-do">x</span>
                    <?php if($todo['checked']) { ?>
                        <input type="checkbox"
                               class="check-box"
                               datatodoid="<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $todo['title']; ?></h2>
                        <?php } else { ?>
                            <input type="checkbox"
                               class="check-box"/>
                        <h2><?php echo $todo['title']; ?></h2>
                        <?php } ?>
                        </br>
                        <small><?php echo $todo['date_time']; ?></small>                  
                    </div>
            <?php } ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.remove-to-do').click(function() {
                const id = $(this).attr('id');
                
                $.post("app/remove.php",
                    {
                        id: id
                    },
                    (data) => {
                        if (data) {
                            $(this).parent().hide(600);
                        }
                    }
                );
            });
        $(".check-box").click(function(e) {
                const id = $(this).attr('data-todo-id');

                $.post('app/check.php',
                    {
                        id: id
                    },
                    (data) => {
                        if (data != 'error')  {
                            const h2 = $(this).next();
                            if(data === '1') {
                                h2.removeClass('checked');
                            } else {
                                h2.addClass('checked');
                            }
                        }
                    }
                );
            });
        });


    </script>
</body>
</html>