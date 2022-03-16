<?php

$userFile = __DIR__ . '/user-data.json';
include __DIR__ . '/db-connection.php';

function synchronizeData()
{
    // get data from file
    $fileContent = getAllUsers();
    // get online content from the DB
    $conn = connectToDB("crud_app");
    $sql_query = "SELECT * FROM user_info";
    $result = mysqli_query($conn, $sql_query);
    $DBcontent = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // if they do not match, then synchroinize DB content with file content
    if ($fileContent !== $DBcontent) {
        // delete everything from DB and insert new data from file.
        // not efficient but is the easiest method and works
        $sql = "DELETE FROM user_info";

        if (mysqli_query($conn, $sql)) {
            echo "<script>console.log('Everything deleted')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        foreach ($fileContent as $user) {
            $sql = "INSERT INTO user_info (id, name, username, email, phone, website) 
                        VALUES  ('$user[id]', '$user[name]', '$user[username]', '$user[email]', '$user[phone]', '$user[website]')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>console.log('New record created')</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
    mysqli_close($conn);
}

// write json to file 
function writeToFile($jsonData)
{
    file_put_contents($GLOBALS['userFile'], json_encode($jsonData, JSON_PRETTY_PRINT));
}

// get user data from file
function getAllUsers()
{
    return @json_decode(file_get_contents($GLOBALS['userFile']), true);
}

// return only one user by id
function getUserById($userID)
{
    foreach (getAllUsers() as $user) {
        if ($user['id'] == $userID) return $user;
    }
}

// delete one user by id
function deleteUser($userID)
{
    // get json data from file 
    $jsonData = getAllUsers();
    // iterate to find user with id
    foreach ($jsonData as $key => $value) {
        if ($value['id'] == $userID) {
            array_splice($jsonData, $key, 1);
        }
    }
    // save modified json
    writeToFile($jsonData);
    header("Location: index.php");
}

// update user by id
function updateUser($updatedUser, $user)
{
    //read file
    $jsonData = getAllUsers();
    // $updatedUser doesn't have id so get it from $user and append it
    $reversedArray = array_reverse($updatedUser, true);
    $reversedArray['id'] = $user['id']; // key gets added to the end by default, that's why array_reverse
    $updatedUser = array_reverse($reversedArray, true);
    // overwrite user data where id matches 
    foreach ($jsonData as $key => $value) {
        if ($value['id'] == $user['id']) {
            $jsonData[$key] = $updatedUser;
        }
    }
    // write it to file
    writeToFile($jsonData);
    // back to index.php
    header("Location: index.php");
}

// create new user
function createUser($newUser)
{
    // declare default id
    $lastElementId = 0;
    // read file
    $jsonData = getAllUsers();
    // get the id of last elemnt
    if ($jsonData) {
        $lastElementId = $jsonData[count($jsonData) - 1]['id']; // get id of last element
    }
    // add id as the first element, and increment it
    $reversedArray = array_reverse($newUser, true);
    $reversedArray['id'] = $lastElementId + 1; // key gets added to the end by default, that's why array_reverse
    $newUser = array_reverse($reversedArray, true);
    // add it to json
    $jsonData[] = $newUser;
    // write it to file
    writeToFile($jsonData);
    // back to index.php
    header("Location: index.php");
}

// save an image
function saveImage($fileData, $user)
{
    // no-cache so that updated images refresh immidiatelly
    header("Cache-control: no-cache");
    //get extension
    $fileExtension = explode(".", $fileData['image']['name'])[1];
    $filePath = __DIR__ . "/images/" . $user['username']  . "." . $fileExtension;
    // save file with the name of the user and the uploaded extension
    move_uploaded_file($_FILES['image']['tmp_name'], $filePath);
}
