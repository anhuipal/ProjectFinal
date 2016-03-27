<?php

function getUsers(){
    include "db.php";
    $results = $db->query("select * from users");
    $resultsArray = $results->fetchAll(PDO::FETCH_ASSOC);
    return $resultsArray;
}

function isAdmin($user_id){
    try{
        include 'db.php';
        $results = $db->query("select user_type from users WHERE user_id=$user_id");
        $row = $results->fetchColumn();
        if($row==1){
            return 'admin';
        }
        else if($row==2){
            return 'professor';
        }
        else{
            return 'user';
        }
    }catch(PDOException $e){
        echo $e;
    }
}

function getFname($user_id){
    try {
        include "db.php";
        $results = $db->query("select fName from users WHERE user_id=$user_id");
        $row = $results->fetchColumn();
        return $row;
    }
    catch(PDOException $e){
        echo $e;
    }
}

function fillMajors(){
    try {
        include "db.php";
        $results = $db->query("select major_id,major_desc from majors");
        $resultsArray = $results->fetchAll(PDO::FETCH_ASSOC);
        return $resultsArray;
    }catch(PDOException $e){
        echo $e;
    }
}


function registerUser($id, $fName, $lName, $birth_year, $password,$email)
{
    include "db.php";
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(array(":id" => $id));
        $count = $stmt->rowCount();

        if ($count == 0) {
            $results = $db->prepare("INSERT INTO users (user_id,fName, lName, birt_year, password,email) VALUES (?,?,?,?,?,?)");
            $results->bindValue(1, $id);
            $results->bindValue(2, $fName);
            $results->bindValue(3, $lName);
            $results->bindValue(4, $birth_year);
            $results->bindValue(5, $password);
            $results->bindValue(6, $email);

            $results->execute();

            if ($results->execute()) {
                echo "registered";
            } else {
                echo "Query could not execute !";
            }

        } else {

            echo "1"; //  not available
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


function searchCourse($code){
    include "db.php";
    try{
       // $results = $db->prepare("select * from courses");
       // $results->bindValue(1,$code);
       // $results->execute();
        $results = $db->query("select * from courses");
        $resultsArray = $results->fetchAll(PDO::FETCH_ASSOC);
        return $resultsArray;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}


function checkbrute($user_id, $mysqli) {
    include "db.php";
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param(1, $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

?>