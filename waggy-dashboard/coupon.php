<?php
session_start();
include("includes/header.php");
require_once 'model/Coupon.php';

$couponModel = new Coupon();
$coupons = $couponModel->getAllCoupons();
$couponData = null;
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];
    $couponData = $couponModel->getCouponById($editId); // Make sure to create this method
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .valid-status {
        color: green;
        font-weight: bold;
    }

    .invalid-status {
        color: red;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Coupon dashboard</h1>

        <div class="row">
            <div>
                <button type="button" style="background:#000;" class="button1" onclick="openAddModal()">
                    <span class="button__text">Add Coupon</span>
                    <span class="button__icon" style="background:#000;"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round"
                            stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                            <line y2="19" y1="5" x2="12" x1="12"></line>
                            <line y2="12" y1="12" x2="19" x1="5"></line>
                        </svg></span>
                </button>
            </div>
            <div class="pt-5 pb-3" style="margin-right:300px">
                <h2>Coupon Table</h2>
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Coupon Id</th>
                            <th>Coupon Name</th>
                            <th>Coupon Discount</th>
                            <th>Deadline</th>
                            <th>Validity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $coupon): ?>
                        <tr>
                            <td><?= htmlspecialchars($coupon['coupon_id']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_name']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_discount']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_expiry_date']); ?></td>
                            <td
                                class="<?= $coupon['coupon_status'] === 'Valid' ? 'valid-status' : 'invalid-status'; ?>">
                                <?= htmlspecialchars($coupon['coupon_status']); ?>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="openEditModal(this)">Edit</button>
                                    <form method="POST" action="process_coupon.php" style="display:inline;">
                                        <input type="hidden" name="action" value="delete_coupon">
                                        <input type="hidden" name="coupon_id"
                                            value="<?= htmlspecialchars($coupon['coupon_id']); ?>">
                                        <button class="delete-btn" type="button"
                                            onclick="confirmDelete(this)">Delete</button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Modal, Edit Modal, Footer, and Scripts here -->
    </div> <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Edit Modal -->
    <div id="editModal" class="modal"
        style="display: none; justify-content: center; align-items: center; height: 100vh;">
        <div class="modal-content" style="width: 50%; text-align: center;">
            <button class="close-btn" style="background:#db4f4f;" onclick="closeEditModal()">X</button>
            <h2>Edit Coupon</h2>
            <form id="editForm" action="process_coupon.php" method="POST">
                <input type="hidden" name="action" value="edit_coupon">
                <input type="hidden" id="editCouponId" name="coupon_id" required>
                <div class="form-group">
                    <label for="coupon_name">Coupon Name:</label>
                    <input type="text" id="editCouponName" name="coupon_name"> <!-- Changed here -->
                </div>
                <div class="form-group">
                    <label for="editDiscount">Coupon Discount:</label>
                    <input type="text" id="editDiscount" name="coupon_discount" ><br><br>
                </div>
                <div class="form-group">
                    <label for="editExpiryDate">Deadline:</label>
                    <input type="date" id="editExpiryDate" name="coupon_expiry_date" min="<?= date('Y-m-d'); ?>">
                    <br><br>
                </div>
                <div class="form-group">
                    <label for="editStatus">Validity:</label>
                    <select id="editStatus" name="coupon_status">
                        <option value="Valid">Valid</option>
                        <option value="Invalid">Invalid</option>
                    </select><br><br>
                </div>
                <button class="save-btn" type="submit"
                    style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px;">Save</button>
            </form>
        </div>
    </div>



    <!-- Add Modal -->
    <div id="addModal" class="modal"
        style="display: none; justify-content: center; align-items: center; height: 100vh;">
        <div class="modal-content" style="width: 50%; text-align: center;">
            <button class="close-btn" style="background:#db4f4f;" onclick="closeAddModal()">X</button>
            <h2>Add Coupon</h2>
            <form id="addForm" action="process_coupon.php" method="POST">
                <input type="hidden" name="action" value="add_coupon">
                <div class="form-group">
                    <label for="coupon_name">Coupon Name:</label>
                    <input type="text" id="coupon_name" name="coupon_name"> <!-- Changed here -->
                </div>
                <div class="form-group">
                    <label for="coupon_discount">Coupon Discount:</label>
                    <input type="text" id="coupon_discount" name="coupon_discount"> <!-- Changed here -->
                </div>
                <div class="form-group">
                    <label for="coupon_expiry_date">Deadline:</label>
                    <!-- Add Modal -->
                    <input type="date" id="coupon_expiry_date" name="coupon_expiry_date" min="<?= date('Y-m-d'); ?>">
                    <!-- Changed here -->
                </div>
                <div class="form-group">
                    <label for="coupon_status">Validity:</label>
                    <select id="coupon_status" name="coupon_status">
                        <!-- Changed here -->
                        <option value="Valid">Valid</option>
                        <option value="Invalid">Invalid</option>
                    </select>
                </div>
                <button class="save-btn" type="submit"
                    style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px;">Save
                </button>
            </form>

        </div>
    </div>







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
        const form = button.closest('form'); // Get the form associated with the delete button
        const couponId = form.querySelector('input[name="coupon_id"]').value;

        Swal.fire({
            title: 'Are you sure?',
            text: "This coupon will be marked as deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#db4f4f',
            cancelButtonColor: '#000',
            confirmButtonText: 'Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form to delete the coupon
            }
        });
    }

    function openEditModal(button) {
        const row = button.closest('tr');
        const id = row.cells[0].innerText; // Assuming coupon_id is in the first column
        const name = row.cells[1].innerText; // changed by me
        const discount = row.cells[2].innerText;
        const expiryDate = row.cells[3].innerText;
        const status = row.cells[4].innerText;

        document.getElementById('editCouponId').value = id;
        document.getElementById('editCouponName').value = name; // changed by me
        document.getElementById('editDiscount').value = discount;
        document.getElementById('editExpiryDate').value = expiryDate;
        document.getElementById('editStatus').value = status;

        document.getElementById('editModal').style.display = 'flex';
    }
    </script>



</body>

</html>
</body>

</html>