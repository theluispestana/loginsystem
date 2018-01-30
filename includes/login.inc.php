<?php

session_start();

if (isset($_POST['submit'])) {
    include 'dbh.inc.php';

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    // Error handlers
    // Check if imputs are empty

    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    } else {
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
        // $result = mysqli_query($conn, $sql);
        // $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=error");
            exit();
        } else {
          if ($row = mysqli_fetch_assoc($result)) {
            // De-hashing the password_get_info()
            $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
            if ($hashedPwdCheck == false) {
              header("Location: ../index.php?login=error");
              exit();
            } elseif ($hashedPwdCheck == true) {
              // Log in the user here
              $_SESSION['u_id'] = $row['user_id'];
              $_SESSION['u_first'] = $row['user_first'];
              $_SESSION['u_last'] = $row['user_last'];
              $_SESSION['u_email'] = $row['user_email'];
              $_SESSION['u_uid'] = $row['user_uid'];
              header("Location: ../index.php?login=success");
              exit();
            }
          }
        }
    }
} else {
    header("Location: ../index.php?login=error");
    exit();
}
