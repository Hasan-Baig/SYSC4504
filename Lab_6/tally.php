<?php
session_start();

if(!isset($_SESSION['yesCount'])){
    $_SESSION['yesCount']=0;
    $_SESSION['noCount']=0;
}

if($_POST['answer'] == "yes") {
    $_SESSION['yesCount']++;
} 

if ($_POST['answer'] == "no") {
    $_SESSION['noCount']++;
} 
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>QuickPoll Tally</title>
    </head>
    <body>
        <header>
            <h1>QuickPoll Tally</h1>
        </header>
        <main>
            <p>
                Your answer has been registered. The current totals are: <br>
                Yes: <?php echo $_SESSION['yesCount'] ?><br>
                No: <?php echo $_SESSION['noCount'] ?><br>
                <a href="vote.php">Vote again</a><br>
                <a href='deletevote.php'>Register a new question</a>
            </p>
        </main>
    </body>
</html>