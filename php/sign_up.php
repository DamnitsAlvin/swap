<?php
    //database info
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "swap_information";

    //etsablish connection with database
    $conn = new mysqli($servername, $username, $password, $database);

    //code functionality starts here
    //data from signin.html are stored in variables
    $lastname = $_POST["lname"];
    $firstname = $_POST["fname"];
    $gender = $_POST["gender"];
    $username = $_POST["uname"];
    $address = $_POST["add"];
    $contact = $_POST["con-no"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["con-pas"];
    $id_pic = $_POST["val"];

    //function to check if the username or email is already taken, if it is already taken then the user cannot register with it.
    function validationCheck()
    {
        global $username;
        global $email;
        global $conn;

        //check if the username already exist in the database
        $sql = "SELECT Username FROM user_information WHERE Username = '$username'";
        $result = $conn->query($sql);
        $no_error = TRUE;

        if($result)
        {
            if(mysqli_num_rows($result) >= 1)
            {
                echo "The username is already taken!<br>";
                $no_error = FALSE;
            }
        }

        //check if the email already exist in the database
        $sql = "SELECT Email FROM user_information WHERE Email = '$email'";
        $result = $conn->query($sql);

        if($result)
        {
            if(mysqli_num_rows($result) >= 1)
            {
                echo "The email is already registered to another account!<br>";
                $no_error = FALSE;
            }
        }

        return $no_error;
    }

    //use the validationCheck function to check the credentials, if there are no problem(s) with the credentials that the user entered the data will be recorded or else they are not recorded
    if(validationCheck())
    {
        //check if the password matched the confirm password, if matched then the data will be registered else they are not recorded.
        if(strcmp($password, $confirm_password) == 0)
        {
            $sql = "INSERT INTO user_information (First_name, Last_name, Email, Username, Contact, Address, gender, password) VALUES ('$firstname', '$lastname', '$email', '$username', $contact, '$address', '$gender', '$password')";

            if($conn->query($sql) === TRUE)
            {
                //redirect to homepage after recording the data
                echo "Account registered!";
            }
            else
            {
                echo "Error: " . $conn->error;
            }
        }
        else
        {
            echo "password does not match!<br>";
        }
    }
    else
    {
        echo "not recorded!<br>";
    }

?>