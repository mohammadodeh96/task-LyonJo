<?php

require 'dbcon.php';

if(isset($_POST['save_user']))
{
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    if (!empty($_FILES)) {
                        
        $file_ext = substr(
                $_FILES['profile_picture']['type'], 
                strpos($_FILES['profile_picture']['type'], '/') + 1 
        );
        $file_name = "pf-$id.$file_ext";
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], "./assets/$file_name");
        $_POST['profile_picture'] = $file_name;
}
    $profile_picture = mysqli_real_escape_string($con, $file_name);

    if($name == NULL || $email == NULL || $password == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO users (name,email,password,profile_picture) VALUES ('$name','$email','$password','$profile_picture')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'user Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'user Not Created'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['update_user']))
{
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $profile_picture = mysqli_real_escape_string($con, $_POST['profile_picture']);

    if($name == NULL || $email == NULL || $password == NULL || $profile_picture == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE users SET name='$name', email='$email', password='$password', profile_picture='$profile_picture' 
                WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'user Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'user Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['user_id']))
{
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);

    $query = "SELECT * FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $user = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'user Fetch Successfully by id',
            'data' => $user
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'user Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['delete_user']))
{
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    $query = "DELETE FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'user Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'user Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>