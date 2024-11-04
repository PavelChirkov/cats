<?php
include_once 'Cats.php';

$catManager = new Cats();
$id = (isset($_POST['id']))?$_POST['id']:0;
if(!isset($_GET['action'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($_POST['action']) {
            case 'add':
                $name = $_POST['name'];
                $gender = $_POST['gender'];
                $age = $_POST['age'];
                $catManager->addCat($name, $gender, $age);
                break;
            case 'update':
                $name = $_POST['name'];
                $gender = $_POST['gender'];
                $age = $_POST['age'];
                $catManager->updateCat($id, 'update', $name, $gender, $age);
                break;
            case 'updateMother':
                $name = $_POST['mother'];
                $catManager->updateCat($id, 'updateMother', $name);
                break;
            case 'updateFather':
                $id = $_POST['id'];
                $name = $_POST['father'];
                $catManager->updateCat($id, 'updateFather', $name);
                break;
        }
    }
}elseif ($_GET['action'] === 'deletefather'){
    $id = (isset($_GET['id']))?$_GET['id']:0;
    $idF = (isset($_GET['delete_father']))?$_GET['delete_father']:0;
    $catManager->updateCat($id, 'deleteFather', $idF);
}elseif ($_GET['action'] === 'deleteMother'){
    $id = (isset($_GET['id']))?$_GET['id']:0;
    $catManager->updateCat($id, 'deleteMother');
}elseif ($_GET['action'] === 'delete'){
    $id = (isset($_GET['id']))?$_GET['id']:0;
    $catManager->updateCat($id, 'delete');
}

header('Location: index.php');
exit;