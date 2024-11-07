<?php
include '../db/DB.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function create($name, $description, $price, $stock) {
        $name = $this->db->escape_string($name);
        $description = $this->db->escape_string($description);
        $price = $this->db->escape_string($price);
        $stock = $this->db->escape_string($stock);
        $sql = "INSERT INTO products (name, description, price, stock) VALUES ('$name', '$description', '$price', '$stock')";
        return $this->db->query($sql);
    }

    public function read() {
        $sql = "SELECT * FROM products";
        return $this->db->query($sql);
    }

    public function update($id, $name, $description, $price, $stock) {
        $id = $this->db->escape_string($id);
        $name = $this->db->escape_string($name);
        $description = $this->db->escape_string($description);
        $price = $this->db->escape_string($price);
        $stock = $this->db->escape_string($stock);
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', stock='$stock' WHERE id=$id";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $id = $this->db->escape_string($id);
        $sql = "DELETE FROM products WHERE id=$id";
        return $this->db->query($sql);
    }
}
