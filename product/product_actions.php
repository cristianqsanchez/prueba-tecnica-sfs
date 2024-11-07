<?php
include './Product.php';
$product = new Product();

if (isset($_POST['action']) && $_POST['action'] == 'create') {
    $product->create($_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock']);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'read') {
    $result = $product->read();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'getProduct') {
    $id = $_POST['id'];
    $result = $product->read();
    $productDetails = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['id'] == $id) {
            $productDetails = $row;
            break;
        }
    }
    echo json_encode($productDetails);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $product->update($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock']);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $product->delete($_POST['id']);
    exit;
}
