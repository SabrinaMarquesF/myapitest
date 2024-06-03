<?php 
header("Content-Type: application/json");
include 'db.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET['id'])) {
            $id = intval($_GET["id"]);
            getUser($id);
        } else {
            getUsers();
        }
        break;
        case 'POST':
            createUser();
            break;
        case 'PUT':
            $id = intval($_GET["id"]);
            updateUser($id);
            break;
        case 'DELETE':
            $id = intval($_GET["id"]);
            deleteUser($id);
            break;
        default:
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
    
    function getUsers()
    {
        global $pdo;
        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    }
    
    function getUser($id)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user);
    }
    
    function createUser()
    {
        global $pdo;
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data["name"];
        $email = $data["email"];
        $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            $response = array('status' => 1, 'status_message' => 'User Added Successfully.');
        } else {
            $response = array('status' => 0, 'status_message' => 'User Addition Failed.');
        }
        echo json_encode($response);
    }
    
    function updateUser($id)
    {
        global $pdo;
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data["name"];
        $email = $data["email"];
        $query = "UPDATE users SET name=:name, email=:email WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $response = array('status' => 1, 'status_message' => 'User Updated Successfully.');
        } else {
            $response = array('status' => 0, 'status_message' => 'User Updation Failed.');
        }
        echo json_encode($response);
    }
    
    function deleteUser($id)
    {
        global $pdo;
        $query = "DELETE FROM users WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $response = array('status' => 1, 'status_message' => 'User Deleted Successfully.');
        } else {
            $response = array('status' => 0, 'status_message' => 'User Deletion Failed.');
        }
        echo json_encode($response);
    }
    ?>