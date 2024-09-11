<?php
$host='localhost';
$username='root';
$password='';
$dbname = "products";
$conn=mysqli_connect($host,$username,$password,"$dbname");

if ($_POST['mode'] === 'add') {
    $name = $_POST['name'];
    $descr = $_POST['descr'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    mysqli_query($conn, "INSERT INTO products (name,descr,price,quantity)
    VALUES ('$name', '$descr', $price, $qty)");
    echo json_encode(true);
}  
if ($_POST['mode'] === 'edit') {
    $result = mysqli_query($conn,"SELECT * FROM products WHERE prod_ID='" . $_POST['id'] . "'");
    $row= mysqli_fetch_array($result);
    echo json_encode($row);
}   

if ($_POST['mode'] === 'update') {
    $sql = "UPDATE products SET name='{$_POST['name']}', descr='{$_POST['descr']}', quantity='{$_POST['qty']}', price='{$_POST['price']}' WHERE prod_ID='{$_POST['id']}'";
    mysqli_query($conn,$sql);
    echo json_encode(true);
}

if ($_POST['mode'] === 'delete') {
    mysqli_query($conn, "DELETE FROM products WHERE prod_ID='" . $_POST["id"] . "'");
    echo json_encode(true);
}  
?>