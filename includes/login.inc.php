<?php

if (isset($_POST['submit'])) {
    include 'dbh.inc.php';

    $uid = mysqli_real_escape_string($conn, $__POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $__POST['pwd']);

    // Error handlers
    // Check if imputs are empty

    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_uid='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=error");
            exit();
        }
    }
} else {
    header("Location: ../index.php?login=error");
    exit();
}
