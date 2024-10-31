<?php
session_start();
include("includes/header.php");
require_once 'model/Product.php';
require_once 'model/Category.php';

$productModel = new Product();
$products = $productModel->getAllProducts();





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Product dashboard</h1>

        <div class="row">
            <div>
                <button type="button" style="background:#000;" class="button1" onclick="openAddModal()">
                    <span class="button__text">Add Product</span>
                    <span class="button__icon" style="background:#000;"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round"
                            stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                            <line y2="19" y1="5" x2="12" x1="12"></line>
                            <line y2="12" y1="12" x2="19" x1="5"></line>
                        </svg></span>
                </button>
            </div>
            <div class="pt-5 pb-3">
                <h2>Product Table</h2>
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Product Description</th>
                            <th>Product Image</th>
                            <th>Product Category</th>
                            <th>Product Quantity</th>
                            <th>Product Price</th>
                            <th>Product State</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td data-label="Product Id"><?= htmlspecialchars($product['product_id']) ?></td>
                            <td data-label="Product Name"><?= htmlspecialchars($product['product_name']) ?></td>
                            <td data-label="Description"><?= htmlspecialchars($product['product_description']) ?></td>
                            <td data-label="Image"><img src="../inserted_img/<?= $product['product_img'] ?>"
                                    alt="Product Image" width="50" style="border-radius:10%;"></td>
                            <td data-label="Category"><?= htmlspecialchars($product['category_name']) ?></td>
                            <td data-label="Quantity"><?= htmlspecialchars($product['product_quantity']) ?></td>
                            <td data-label="Price"><?= htmlspecialchars($product['product_price']) ?></td>
                            <td data-label="Status"><?= $product['state'] == 1 ? 'In Stock' : 'Out of Stock' ?></td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn"
                                        onclick="document.getElementById('editModal<?= $product['product_id'] ?>').style.display='flex'">Edit</button>
                                    <form action="process_product.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="product_id"
                                            value="<?= htmlspecialchars($product['product_id']); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="button" class="delete-btn"
                                            onclick="confirmDelete(this)">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for each product -->
                        <div id="editModal<?= $product['product_id'] ?>" class="modal"
                            style="display: none; justify-content: center; align-items: center; height: 100vh;">
                            <div class="modal-content" style="width: 50%; text-align: center;">
                                <button class="close-btn delete-btn" style="background:#db4f4f;"
                                    onclick="document.getElementById('editModal<?= $product['product_id'] ?>').style.display='none'">X</button>
                                <h2>Edit Product</h2>
                                <form id="editForm" enctype="multipart/form-data" method="POST"
                                    action="process_product.php">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <input type="hidden" name="oldImage" value="<?= $product['product_img'] ?>">

                                    <div class="form-group">
                                        <label for="productName">Product Name:</label>
                                        <input type="text" name="newProductName"
                                            value="<?= htmlspecialchars($product['product_name']) ?>" required><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="productDescription">Product Description:</label>
                                        <input type="text" name="newProductDescription"
                                            value="<?= htmlspecialchars($product['product_description']) ?>"
                                            required><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="productImage">Old Product Image:</label><br>
                                        <img src="../inserted_img/<?= $product['product_img'] ?>"
                                            alt="Old Product Image"
                                            style="max-width: 70px; margin-bottom: 10px;border-radius:10%;">
                                    </div>
                                    <div class="form-group">
                                        <label for="productImage">New Product Image:</label><br>
                                        <input type="file" name="newProductImage" accept="image/*"><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="productCategory">Product Category:</label>
                                        <select name="newProductCategory" required>
                                            <?php
                        $categoryModel = new Category();
                        $categories = $categoryModel->getAllCategories();
                        foreach ($categories as $category) {
                            $selected = ($category['category_id'] == $product['category_id']) ? 'selected' : '';
                            echo "<option value=\"{$category['category_id']}\" $selected>{$category['category_name']}</option>";
                        }
                        ?>
                                        </select><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="productQuantity">Product Quantity:</label>
                                        <input type="number" name="newProductQuantity"
                                            value="<?= htmlspecialchars($product['product_quantity']) ?>"
                                            required><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="productPrice">Product Price:</label>
                                        <input type="number" name="newProductPrice"
                                            value="<?= htmlspecialchars($product['product_price']) ?>" step="0.01"
                                            required><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="productStatus">Product Status:</label>
                                        <select name="newProductStatus" required>
                                            <option value="1" <?= ($product['state'] == 1) ? 'selected' : ''; ?>>In
                                                Stock
                                            </option>
                                            <option value="0" <?= ($product['state'] == 0) ? 'selected' : ''; ?>>Out of
                                                Stock</option>
                                        </select><br><br>
                                    </div>

                                    <button class="save-btn edit-btn" type="submit"
                                        style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px;">Save</button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>

                   







                    <!-- Add Modal -->
                    <div id="addModal" class="modal"
                        style="display: none; justify-content: center; align-items: center; height: 100vh;">
                        <div class="modal-content" style="width: 50%; text-align: center;">
                            <button class="close-btn delete-btn" style="background:#db4f4f;"
                                onclick="closeAddModal()">X</button>
                            <h2>Add Product</h2>
                            <form id="addForm" enctype="multipart/form-data" method="POST" action="process_product.php">
                                <input type="hidden" name="action" value="create"> <!-- Hidden input for action -->
                                <div class="form-group">
                                    <label for="newProductName">Product Name:</label>
                                    <input type="text" id="newProductName" name="newProductName" required><br><br>
                                </div>
                                <div class="form-group">
                                    <label for="newProductDescription">Product Description:</label>
                                    <input type="text" id="newProductDescription" name="newProductDescription"
                                        required><br><br>
                                </div>
                                <div class="form-group">
                                    <label for="newProductImage">Product Image:</label>
                                    <input type="file" id="newProductImage" name="newProductImage" accept="image/*"
                                        required><br><br>
                                </div>
                                <div class="form-group">
                                    <label for="newProductCategory">Product Category:</label>
                                    <select id="newProductCategory" name="newProductCategory" required>
                                        <?php
                    // Fetch categories from the database
                    $categoryModel = new Category();
                    $categories = $categoryModel->getAllCategories();

                    foreach ($categories as $category) {
                        echo "<option value=\"{$category['category_id']}\">{$category['category_name']}</option>";
                    }
                    ?>
                                    </select><br><br>
                                </div>
                                <div class="form-group">
                                    <label for="newProductQuantity">Product Quantity:</label>
                                    <input type="number" id="newProductQuantity" name="newProductQuantity"
                                        required><br><br>
                                </div>
                                <div class="form-group">
                                    <label for="newProductPrice">Product Price:</label>
                                    <input type="number" id="newProductPrice" name="newProductPrice" step="0.01"
                                        required><br><br>
                                </div>
                                <div class="form-group">
                                    <label for="newProductStatus">Product Status:</label>
                                    <select id="newProductStatus" name="newProductStatus" required>
                                        <option value="1">In Stock</option>
                                        <option value="0">Out of Stock</option>
                                    </select><br><br>
                                </div>
                                <button class="save-btn edit-btn" type="submit"
                                    style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px; font-size: 14px;">Add
                                    Product</button>
                            </form>
                        </div>
                    </div>






            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
// Display SweetAlert if there is a message in the session
if (isset($_SESSION['sweetalert'])): ?>
        <script>
        Swal.fire({
            icon: '<?= $_SESSION['sweetalert']['type']; ?>',
            title: '<?= $_SESSION['sweetalert']['type'] === 'success' ? 'Success' : 'Error'; ?>',
            text: '<?= $_SESSION['sweetalert']['message']; ?>',
            confirmButtonColor: '#000',
            iconColor: '<?= $_SESSION['sweetalert']['type'] === 'success' ? '#000' : '#000'; ?>'
        });
        </script>
        <?php
    unset($_SESSION['sweetalert']);
endif;
?>


        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
        <script src="js/modal.js"></script>
        <script>
        function confirmDelete(button) {
            const form = button.closest('form'); // Get the closest form element
            const productId = form.querySelector('input[name="product_id"]').value; // Get the product ID

            Swal.fire({
                title: 'Are you sure to delete this product?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#db4f4f',
                cancelButtonColor: '#000',
                confirmButtonText: 'Delete!',
                cancelButtonText: 'cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        }
        </script>


</body>

</html>
<!-- Begin Page Content -->