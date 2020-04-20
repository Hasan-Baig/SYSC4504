<?php
session_start();
if (isset($_POST['question'])) {
    $_SESSION['question']=$_POST['question'];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>QuickPoll Vote</title>
    </head>
    <body>
        <header>
            <h1>QuickPoll Vote</h1>
        </header>
        <main>
            <form method="post" action="tally.php">
                <p>
                    <?php echo $_SESSION['question'] ?>?<br>
                    <input type="radio" name="answer" value="yes">Yes<br>
                    <input type="radio" name="answer" value="no">No<br>
                    <button type="submit">Register my vote</button>
                </p>
            </form>
        </main>
    </body>
</html>