<?php
session_start();
include "config.php"; // <-- must provide $con (mysqli)

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

/*
 Delete handler
 Using prepared statement for safety and storing a flash message in session
*/
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = $con->prepare("DELETE FROM contact_messages WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $_SESSION['msg_success'] = "Message #{$id} deleted successfully.";
            } else {
                $_SESSION['msg_error'] = "Delete failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['msg_error'] = "Prepare failed: " . $con->error;
        }
    } else {
        $_SESSION['msg_error'] = "Invalid message id.";
    }
    header("Location: contact_messages.php");
    exit;
}

// Fetch messages
$messages_q = "SELECT * FROM contact_messages ORDER BY id DESC";
$messages = mysqli_query($con, $messages_q);
if (!$messages) {
    die("SQL Error fetching messages: " . mysqli_error($con) . " - Query: " . $messages_q);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Messages - Admin | TerraNew</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
/* Define a green color palette for TerraNew */
:root {
    --tn-primary-green: #006400; /* Dark Green - Sidebar BG */
    --tn-light-green: #38a832; /* Medium Green - Hover/Accent */
    --tn-bg-color: #f7f9fc; /* Light background */
    --tn-card-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

body { 
    background: var(--tn-bg-color); 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* --- Sidebar Styling --- */
.sidebar { 
    position: fixed; 
    left: 0; 
    top: 0; 
    height: 100%; 
    width: 240px; /* Unified width */
    background: var(--tn-primary-green); 
    color: #fff; 
    padding-top: 20px; 
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.sidebar h3 {
    font-weight: 700;
    margin-bottom: 30px !important;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.sidebar a { 
    display: block; 
    padding: 12px 25px; 
    color: #fff; 
    text-decoration: none; 
    font-size: 1.05rem;
    transition: background 0.3s, padding-left 0.3s;
}

.sidebar a:hover { 
    background: var(--tn-light-green); 
    padding-left: 30px; 
}

.sidebar a i {
    margin-right: 10px;
    width: 20px;
}
/* Highlight active link */
.sidebar a[href="contact_messages.php"] {
    background: var(--tn-light-green); 
}

/* --- Content Styling --- */
.content { 
    margin-left: 240px; /* Unified margin */
    padding: 30px; 
}

h2 {
    color: var(--tn-primary-green);
    font-weight: 600;
    margin-bottom: 20px;
}

/* --- Table Styling (Card effect + Green Header) --- */
.table-card-container { /* New wrapper for card effect */
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: var(--tn-card-shadow);
}

.table thead th { 
    background-color: var(--tn-primary-green); /* Dark Green Header */
    color: white; 
    font-size: 0.95rem;
    font-weight: 600;
    vertical-align: middle;
    text-align: center;
}

.table tbody tr:hover {
    background-color: #e9ecef;
}

.table td {
    vertical-align: middle;
    /* Adjust text alignment for readability where possible */
    text-align: center; 
}

.table-responsive {
    overflow-x: auto;
}

.truncate { 
    max-width: 300px; /* Increased max-width for message content */
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
    text-align: left; /* Left align truncated text for better reading */
}

.btn-sm {
    font-size: 0.8rem;
    padding: 5px 8px;
    min-width: 80px;
}
</style>
</head>
<body>
<div class="sidebar">
  <h3 class="text-center mb-4"><i class="fa-solid fa-recycle"></i> TerraNew</h3> 
  <a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a href="customers.php"><i class="fa fa-users"></i> Customers</a>
  <a href="products.php"><i class="fa fa-box"></i> Products</a>
  <a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a>
  <a href="contact_messages.php"><i class="fa fa-envelope"></i> Messages</a>
  <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a> </div>

<div class="content">
  <h2><i class="fa fa-envelope"></i> Contact Messages</h2>

  <?php if (!empty($_SESSION['msg_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo htmlspecialchars($_SESSION['msg_success']); unset($_SESSION['msg_success']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['msg_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo htmlspecialchars($_SESSION['msg_error']); unset($_SESSION['msg_error']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="table-card-container"> <div class="table-responsive">
    <table class="table table-striped table-hover mt-3 align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Date</th>
          <th style="width:160px;">Action</th> </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($messages) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($messages)): ?>
            <tr>
              <td><?php echo (int)$row['id']; ?></td>
              <td class="text-start"><?php echo htmlspecialchars($row['first_name']); ?></td>
              <td class="text-start"><?php echo htmlspecialchars($row['last_name']); ?></td>
              <td class="text-start"><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td class="truncate" title="<?php echo htmlspecialchars($row['message']); ?>">
                <?php echo htmlspecialchars(mb_strimwidth($row['message'], 0, 80, "...")); ?>
              </td>
              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              <td>
                <div class="d-grid gap-1">
                  <button
                    class="btn btn-sm btn-primary view-btn"
                    data-id="<?php echo (int)$row['id']; ?>"
                    data-first="<?php echo htmlspecialchars($row['first_name']); ?>"
                    data-last="<?php echo htmlspecialchars($row['last_name']); ?>"
                    data-email="<?php echo htmlspecialchars($row['email']); ?>"
                    data-phone="<?php echo htmlspecialchars($row['phone']); ?>"
                    data-message="<?php echo htmlspecialchars($row['message']); ?>"
                    data-date="<?php echo htmlspecialchars($row['created_at']); ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#viewModal"
                  >
                    <i class="fa fa-eye"></i> View
                  </button>

                  <a href="?delete=<?php echo (int)$row['id']; ?>"
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Are you sure you want to delete message #<?php echo (int)$row['id']; ?>?')">
                     <i class="fa fa-trash"></i> Delete
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center text-muted">No messages found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Message Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <dl class="row">
          <dt class="col-sm-3">ID</dt>
          <dd class="col-sm-9" id="vm-id"></dd>

          <dt class="col-sm-3">Name</dt>
          <dd class="col-sm-9" id="vm-name"></dd>

          <dt class="col-sm-3">Email</dt>
          <dd class="col-sm-9" id="vm-email"></dd>

          <dt class="col-sm-3">Phone</dt>
          <dd class="col-sm-9" id="vm-phone"></dd>

          <dt class="col-sm-3">Date</dt>
          <dd class="col-sm-9" id="vm-date"></dd>

          <dt class="col-sm-3">Message</dt>
          <dd class="col-sm-9" id="vm-message" style="white-space:pre-wrap;"></dd>
        </dl>
      </div>
      <div class="modal-footer">
        <a href="#" id="vm-delete-link" class="btn btn-danger" onclick="return confirm('Delete this message?')"><i class="fa fa-trash"></i> Delete</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Fill modal when view button clicked
  document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('vm-id').textContent = this.dataset.id || '';
      document.getElementById('vm-name').textContent = (this.dataset.first || '') + ' ' + (this.dataset.last || '');
      document.getElementById('vm-email').textContent = this.dataset.email || '';
      document.getElementById('vm-phone').textContent = this.dataset.phone || '';
      document.getElementById('vm-date').textContent = this.dataset.date || '';
      document.getElementById('vm-message').textContent = this.dataset.message || '';
      // update delete link in modal
      document.getElementById('vm-delete-link').setAttribute('href', '?delete=' + (this.dataset.id || ''));
    });
  });
</script>
</body>
</html>