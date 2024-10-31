<?php
session_start();
include("includes/header.php")
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Orders dashboard</h1>

  <div class="row">
      <div class="pt-5 pb-3">
          <h2>Orders Table</h2>
    </div>
    <table class="responsive-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Order Date</th>
                <th>Order Price</th>
                <th>Order Status</th>
                <th>Discount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Order ID">123456</td>
                <td data-label="User Name">John Doe</td>
                <td data-label="Order Date">2024-10-15</td>
                <td data-label="Order Price">$150.00</td>
                <td data-label="Order Status">Delivered</td>
                <td data-label="Discount">10%</td>
                <td data-label="Actions">
                    <div class="action-buttons">
                        <button class="edit-btn" onclick="openOrderModal(this)">View order</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td data-label="Order ID">123457</td>
                <td data-label="User Name">Jane Smith</td>
                <td data-label="Order Date">2024-10-16</td>
                <td data-label="Order Price">$75.00</td>
                <td data-label="Order Status">Pending</td>
                <td data-label="Discount">5%</td>
                <td data-label="Actions">
                    <div class="action-buttons">
                        <button class="edit-btn"onclick="openOrderModal(this)">View order</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td data-label="Order ID">123458</td>
                <td data-label="User Name">Mike Brown</td>
                <td data-label="Order Date">2024-10-17</td>
                <td data-label="Order Price">$200.00</td>
                <td data-label="Order Status">Cancelled</td>
                <td data-label="Discount">0%</td>
                <td data-label="Actions">
                    <div class="action-buttons">
                        <button class="edit-btn" onclick="openOrderModal(this)">View order</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>    
</div>
<!-- View Modal -->
<div class="modal" id="viewModal"  style="display: none; justify-content: center; align-items: center; height: 100vh;">
    <div class="modal-content" style="width: 50%; text-align: center;">
        <button class="close-btn" style="background:#db4f4f;" onclick="closeEditModal()">X</button>
        <h3>Order Details</h3>
        <form id="editForm">
            <div class="form-group">
                <label for="orderId">Order ID:</label>
                <input type="text" id="orderId" name="orderId" readonly>
            </div>
            <div class="form-group">
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName">
            </div>
            <div class="form-group">
                <label for="orderDate">Order Date:</label>
                <input type="date" id="orderDate" name="orderDate">
            </div>
            <div class="form-group">
                <label for="orderPrice">Order Price:</label>
                <input type="text" id="orderPrice" name="orderPrice">
            </div>
            <div class="form-group">
                <label for="orderStatus">Order Status:</label>
                <select id="orderStatus" name="orderStatus">
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="text" id="discount" name="discount">
            </div>
            <button class="save-btn" type="submit"
                    style="background-color: #000; color: white; padding: 10px; border: none; cursor: pointer; width: 100px; margin-top: 20px;">Save
                    Changes</button>
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
        
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        
            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        
            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>
            <script src="js/modal.js"></script>
            <script>
                function closeEditModal() {
                     document.getElementById('viewModal').style.display = "none";
                                            }

// Add this function to open the modal with order details
                function openOrderModal(orderId, userName, orderDate, orderPrice, orderStatus, discount) {
                    document.getElementById('orderId').value = orderId;
                    document.getElementById('userName').value = userName;
                    document.getElementById('orderDate').value = orderDate;
                    document.getElementById('orderPrice').value = orderPrice;
                    document.getElementById('orderStatus').value = orderStatus;
                    document.getElementById('discount').value = discount;
                    document.getElementById('viewModal').style.display = "block";
                }
            </script>
        
        </body>
        
        </html>                   