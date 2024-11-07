<?php
include '../db/DB.php';

$mysqli = new DB();

if (isset($_POST['action']) && $_POST['action'] == 'getAllGroups') {
    $result = $mysqli->query("SELECT * FROM groups");
    $groups = $result->fetch_all(MYSQLI_ASSOC);
    
    foreach ($groups as &$group) {
        $groupId = $group['id'];
        $productResult = $mysqli->query("SELECT product_id FROM groups_products WHERE group_id = $groupId");
        $productIds = [];
        while ($product = $productResult->fetch_assoc()) {
            $productIds[] = $product['product_id'];
        }
        $group['products'] = $productIds;
    }

    echo json_encode($groups);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'getGroup') {
    $groupId = $_POST['id'];
    $result = $mysqli->query("SELECT * FROM groups WHERE id = $groupId");
    $group = $result->fetch_assoc();

    $productResult = $mysqli->query("SELECT product_id FROM groups_products WHERE group_id = $groupId");
    $productIds = [];
    while ($product = $productResult->fetch_assoc()) {
        $productIds[] = $product['product_id'];
    }

    $group['products'] = $productIds;
    echo json_encode($group);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'createGroup') {
    $name = $_POST['name'];
    $products = $_POST['products'];
    $mysqli->query("INSERT INTO groups (name) VALUES ('$name')");
    $groupId = $mysqli->getInsertId();

    foreach ($products as $productId) {
        $mysqli->query("INSERT INTO groups_products (group_id, product_id) VALUES ($groupId, $productId)");
    }
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'updateGroup') {
    $groupId = $_POST['id'];
    $name = $_POST['name'];
    $products = $_POST['products'];
    $mysqli->query("UPDATE groups SET name = '$name' WHERE id = $groupId");

    $mysqli->query("DELETE FROM groups_products WHERE group_id = $groupId");

    foreach ($products as $productId) {
        $mysqli->query("INSERT INTO groups_products (group_id, product_id) VALUES ($groupId, $productId)");
    }
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'deleteGroup') {
    $groupId = $_POST['id'];
    $mysqli->query("DELETE FROM groups_products WHERE group_id = $groupId");
    $mysqli->query("DELETE FROM groups WHERE id = $groupId");
    exit;
}
