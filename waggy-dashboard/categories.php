<?php
session_start();
include("includes/header.php");
require_once 'model/Category.php';

$categoryModel = new Category();
$categories = $categoryModel->getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Category Dashboard</h1>

        <div class="row">
            <div>
                <button type="button" style="background:#000;" class="button1" onclick="openAddModal()">
                    <span class="button__text">Add Category</span>
                    <span class="button__icon" style="background:#000;"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round"
                            stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                            <line y2="19" y1="5" x2="12" x1="12"></line>
                            <line y2="12" y1="12" x2="19" x1="5"></line>
                        </svg></span>
                </button>
            </div>
            <div class="pt-5 pb-3">
                <h2>Category Table</h2>
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Category Description</th>
                            <th>Category Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td data-label="Category Id"><?= htmlspecialchars($category['category_id']) ?></td>
                            <td data-label="Category Name"><?= htmlspecialchars($category['category_name']) ?></td>
                            <td data-label="Description"><?= htmlspecialchars($category['category_description']) ?></td>
                            <td data-label="Picture">
                                <img src="../category_img/<?php echo $category['category_picture']; ?>"
                                    alt="Category Image" width="50">

                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn"
                                        onclick="document.getElementById('editModal<?= $category['category_id'] ?>').style.display='flex'">Edit</button>
                                    <form action="process_category.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="category_id"
                                            value="<?= htmlspecialchars($category['category_id']); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="button" class="delete-btn"
                                            onclick="confirmDelete(this)">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for each category -->
                        <div id="editModal<?= $category['category_id'] ?>" class="modal"
                            style="display: none; justify-content: center; align-items: center; height: 100vh;">
                            <div class="modal-content" style="width: 50%; text-align: center;">
                                <button class="close-btn delete-btn" style="background:#db4f4f;"
                                    onclick="document.getElementById('editModal<?= $category['category_id'] ?>').style.display='none'">X</button>
                                <h2>Edit Category</h2>
                                <form id="editForm" enctype="multipart/form-data" method="POST"
                                    action="process_category.php">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">


                                    <div class="form-group">
                                        <label for="categoryName">Category Name:</label>
                                        <input type="text" name="newCategoryName"
                                            value="<?= htmlspecialchars($category['category_name']) ?>"
                                            required><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="categoryDescription">Category Description:</label>
                                        <input type="text" name="newCategoryDescription"
                                            value="<?= htmlspecialchars($category['category_description']) ?>"
                                            required><br><br>
                                    </div>

                                    <div class="form-group">
                                        <label for="categoryPicture">Current Category Picture:</label><br>
                                        <input type="hidden" name="oldImage"
                                            value="<?= htmlspecialchars($category['category_picture']); ?>">
                                        <img src="../category_img/<?= htmlspecialchars($category['category_picture']) ?>"
                                            alt="Current Category Picture"
                                            style="max-width: 70px; margin-bottom: 10px; border-radius:10%;">
                                    </div>
                                    <div class="form-group">
                                        <label for="newCategoryImage">New Category Picture:</label><br>
                                        <input type="file" name="newCategoryImage" accept="image/*"><br><br>
                                    </div>

                                    <button class="save-btn edit-btn" type="submit"
                                        style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px;">Save</button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Add Modal -->
                <div id="addModal" class="modal"
                    style="display: none; justify-content: center; align-items: center; height: 100vh;">
                    <div class="modal-content" style="width: 50%; text-align: center;">
                        <button class="close-btn delete-btn" style="background:#db4f4f;"
                            onclick="closeAddModal()">X</button>
                        <h2>Add Category</h2>
                        <form id="addForm" enctype="multipart/form-data" method="POST" action="process_category.php">
                            <input type="hidden" name="action" value="create">
                            <div class="form-group">
                                <label for="newCategoryName">Category Name:</label>
                                <input type="text" id="newCategoryName" name="newCategoryName" required><br><br>
                            </div>
                            <div class="form-group">
                                <label for="newCategoryDescription">Category Description:</label>
                                <input type="text" id="newCategoryDescription" name="newCategoryDescription"
                                    required><br><br>
                            </div>
                            <div class="form-group">
                                <label for="newCategoryImage">Category Picture:</label>
                                <input type="file" id="newCategoryImage" name="newCategoryImage" accept="image/*"
                                    required><br><br>
                            </div>
                            <button class="save-btn edit-btn" type="submit"
                                style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px; font-size: 14px;">Add
                                Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/sb-admin-2.min.js"></script>
        <script src="js/modal.js"></script>
        <script>
        function confirmDelete(button) {
            event.preventDefault(); // Prevent form submission
            const form = button.closest("form");
            Swal.fire({
                title: 'Are you sure?',
                text: "This category will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#db4f4f',
                cancelButtonColor: '#000',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        }
        </script>
    </div>
</body>

</html>