<?php 

$dbDetails = array( 
'host' => 'localhost', 
'user' => 'root', 
'pass' => '', 
'db'   => 'products'
); 

$table = 'products'; 

$primaryKey = 'prod_ID'; 

$columns = array( 
array( 'db' => 'name', 'dt' => 1 ), 
array( 'db' => 'descr',  'dt' => 2 ), 
array( 'db' => 'price', 'dt'  => 3 ), 
array( 'db' => 'quantity', 'dt'  => 4 ),
array( 'db' => 'prod_ID','dt' => 0, 
'formatter' => function( $d, $row ) { 
return '<button class="btn btn-primary btn-edit" data-id="'.$row['prod_ID'].'"> Edit </button> <a href="#" class="btn btn-danger btn-delete ml-2" data-id="'.$row['prod_ID'].'"> Delete </a>'; 
} 
) 
); 

//SQL query processing class 
require 'ssp.class.php'; 

echo json_encode( 
SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ));