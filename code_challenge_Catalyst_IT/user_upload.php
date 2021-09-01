<?php

function db_conn(){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "users_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function create_table(){
   
    $conn = db_conn();
    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS users (
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE KEY
    );";

    if ($conn->query($sql) === TRUE) {
        echo "Users table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
}


function reformat_str($input){
    //reformat to all lowercase
    $str = str_replace("'", "\'", $input);
    $output = strtolower($str);    
    return $output;
}

function validate_email($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}

function insert_data(){

    $conn = db_conn();
    // read data from csv file
    $CSVfp = fopen("users.csv", "r");
    if($CSVfp !== FALSE) {
    print "<PRE>";
    $row = 0;
    $stdout = fopen('error.log', 'wb');
    while(! feof($CSVfp)) {
        $data = fgetcsv($CSVfp, 1000, ",");
        $row++;
        if($row==1) continue;
        //insert data
        if(validate_email($data[2]))
        {
            $sql = "INSERT INTO users (`name`, `surname`, `email`) VALUES ('" . ucfirst(reformat_str($data[0])) . "', '" . ucfirst(reformat_str($data[1])) . "', '" . reformat_str($data[2]) . "');";

            if ($conn->query($sql) === TRUE) {
                echo $sql."\r\n\n";
            } else {            
                echo "Error inserting data: " . $conn->error;
            }
        }else{                                  
            fwrite($stdout,  reformat_str($data[2]) . PHP_EOL);            
        }
    }
    }
    fclose($stdout);   
    fclose($CSVfp);
}

create_table();
insert_data();

?>