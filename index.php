<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>CRUD</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
<style type="text/css">
    .bs-example{
        margin: 20px;
    }
</style>
</head>

<body>
<div class="bs-example">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="float-left">Products</h2>
                    <a href="#" class="btn btn-primary float-right add-model"> Add Product </a>
                </div>
                <table id="productsListTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <div class="page-header clearfix">
                <h2 class="float-left">Line Chart</h2>
                </div>
                <div class="chart-container pie-chart">
                    <canvas id="bar_chart" height="100"> </canvas>
                </div>
            </div>
        </div>        
    </div>
</div>
</body>

<!-- Update Form Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="prodCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="update-form" name="update-form" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" class="form-control" id="mode" name="mode" value="update">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="descr" name="descr" placeholder="Enter Description" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="Enter Quantity" value="" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Form Modal-->
<div class="modal fade" id="add-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="prodCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="add-form" name="add-form" class="form-horizontal">
                    <input type="hidden" class="form-control" id="mode" name="mode" value="add">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="descr" name="descr" placeholder="Enter Description" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="Enter Quantity" value="" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Add product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var table = $('#productsListTable').DataTable({
        dom: 'Pfrtip',
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": "fetch.php",
        "drawCallback" : function(settings){
            var products_name = []; 
            var price = []; 

            for(var count = 0; count < settings.aoData.length; count++){
                products_name.push(settings.aoData[count]._aData[1]);
                price.push(parseFloat(settings.aoData[count]._aData[3]));
            }

            var chart_data = {
                labels: products_name,
                datasets: [
                    {
                        label: 'Price',
                        backgroundColor: 'rgba(0, 153, 255)',
                        color: '#fff', 
                        data: price
                    }
                ]
            };

            var chart = $('#bar_chart');
            var price_chart = new Chart(chart, {
                type: 'line', 
                data: chart_data
            });
        }
        });
});


$('.add-model').click(function () {
    $('#add-modal').modal('show');
});


$('#add-form').submit(function(e){
    e.preventDefault();


    $.ajax({
        url:"actions.php",
        type: "POST",
        data: $(this).serialize(), 
        success: function(){
        var oTable = $('#productsListTable').dataTable(); 
        oTable.fnDraw(false);
        $('#add-modal').modal('hide');
        $('#add-form').trigger("reset");
        }
    });
});


$('body').on('click', '.btn-edit', function () {
    var id = $(this).data('id');
    $.ajax({
        url:"actions.php",
        type: "POST",
        data: {
        id: id,
        mode: 'edit' 
        },
        dataType : 'json',
        success: function(result){
            $('#id').val(result.prod_ID);
            $('#name').val(result.name);
            $('#descr').val(result.descr);
            $('#price').val(result.price);
            $('#qty').val(result.quantity);
            $('#edit-modal').modal('show');
        }
    });
});


$('#update-form').submit(function(e){
    e.preventDefault();

    $.ajax({
        url:"actions.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(){
            var oTable = $('#productsListTable').dataTable(); 
            oTable.fnDraw(false);
            $('#edit-modal').modal('hide');
            $('#update-form').trigger("reset");
        }
    });
}); 


$('body').on('click', '.btn-delete', function () {
    var id = $(this).data('id');
    if (confirm("Please confirm that you want to delete this product.")) {
    $.ajax({
        url:"actions.php",
        type: "POST",
        data: {
            id: id,
            mode: 'delete' 
        },
        dataType : 'json',
        success: function(result){
            var oTable = $('#productsListTable').dataTable(); 
            oTable.fnDraw(false);
        }
    });
    } 
    return false;
});
</script>

</html>