<?php

if (isset($_POST['submit'])) {
    include_once 'dbh.inc.php';

    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    // Error handlers
    // Check for empty fields
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) {
        header("Location: ../signup.php?signup=empty");
        exit();
    } else {
        // Check if input characters are valid
        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
            header("Location: ../signup.php?signup=invalidname");
            exit();
        } else {
            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../signup.php?signup=email");
                exit();
            } else {
                //Creating prepared statement
                $sql = "SELECT * FROM users WHERE user_uid=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                  echo "SQL statement failed";
                } else {
                  //bind parameters to the placeholder
                  mysqli_stmt_bind_param($stmt, "s", $uid);
                  //run parameters inside database
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                }
                $resultCheck = mysqli_stmt_num_rows($result);

                if ($resultCheck > 0) {
                    header("Location: ../signup.php?signup=usertaken");
                    exit();
                } else {
                    // Hashing the Password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    // Insert the user into the database
                    // $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd');";
                    // Using prepared statement to insert sql code
                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES (?, ?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                      echo "SQL statement failed";
                    } else {
                      //bind parameters to the placeholder
                      mysqli_stmt_bind_param($stmt, "sssss", $first, $last, $email, $uid, $hashedPwd);
                      //run parameters inside database
                      mysqli_stmt_execute($stmt);
                      // $result = mysqli_stmt_get_result($stmt);
                    }

                    // line with mysqli_query can be written with or without a variable
                    mysqli_query($conn, $sql);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../signup.php");
    exit();
}
