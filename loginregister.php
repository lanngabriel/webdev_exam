<?php
session_start();
require_once 'config.php';


if (isset($_POST['register_btn'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $destination = 'uploads/';
    $newfilename = basename($_FILES['picture']['name']);
    $targetFilePath = $destination . $newfilename;
    $allowfile = array('jpg', 'jpeg', 'png', 'gif');
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $check = sqlsrv_query(
        $conn,
        "SELECT email FROM REGISTER WHERE email = '$email'"
    );

    if (!$check) die(print_r(sqlsrv_errors(), true));

    if (sqlsrv_has_rows($check)) {
        $_SESSION['alerts'][] = ['type' => 'error', 'message' => 'Email is already registered!'];
        $_SESSION['active_form'] = 'register';
    } else {

        if ($password !== $confirm_password) {
            $_SESSION['alerts'][] = ['type' => 'error', 'message' => 'Passwords do not match!'];
            $_SESSION['active_form'] = 'register';
            header("Location: index.php");
        exit();
    }

        $insert = sqlsrv_query(
            $conn,
            "INSERT INTO REGISTER (name, email, password)
             VALUES ('$name', '$email', '$password')"
        );

        $finalfolder = move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath);
        if ($finalfolder) {
            $sqlInsertFile = "INSERT INTO IMAGE (name, path, upload_date, email) VALUES ('$newfilename', '$targetFilePath', GETDATE(), '$email')";
            $sqlimg = sqlsrv_query($conn, $sqlInsertFile);
        } else {
            echo "Error uploading file.";
            exit;
        }

        if (!$insert) die(print_r(sqlsrv_errors(), true));

        $_SESSION['alerts'][] = ['type' => 'success', 'message' => 'Registration successful'];
        $_SESSION['active_form'] = 'login';
    }

    header("Location: index.php");
    exit();
}



if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = sqlsrv_query(
        $conn,
        "SELECT * FROM REGISTER WHERE email = '$email'"
    );
    $profileQuery = sqlsrv_query(
        $conn,
        "SELECT * FROM IMAGE WHERE email = '$email'"
    );
    $profile = sqlsrv_fetch_array($profileQuery);


    if (!$query) die(print_r(sqlsrv_errors(), true));

    $user = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        $_SESSION['name'] = $user['name'];
        $_SESSION['profile'] = $profile['path'];
        $_SESSION['alerts'][] = ['type' => 'success', 'message' => 'Login successful'];
    } else {
        $_SESSION['alerts'][] = ['type' => 'error', 'message' => 'Incorrect email or password!'];
        $_SESSION['profile'] = null;
        $_SESSION['active_form'] = 'login';
    }

    header("Location: index.php");
    exit();
}

?>
