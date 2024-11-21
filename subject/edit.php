<?php
// Include necessary files for shared functions and reusable page components
include '../functions.php'; // Contains functions like getSubjectByCode and updateSubject
include '../admin/partials/header.php'; // Header section with styles and scripts

// Define navigation paths for easy reference
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../admin/student/register.php';
$subjectPage = './add.php';
include '../admin/partials/side-bar.php'; // Sidebar navigation

// Initialize variables
$subject_code = isset($_GET['subject_code']) ? trim($_GET['subject_code']) : '';
$subject_data = null;

// Validate and fetch subject data
if (!empty($subject_code)) {
    // Fetch subject details using the provided subject code
    $subject_data = getSubjectByCode($subject_code);
    
    // Check if the subject exists
    if (!$subject_data) {
        // Subject not found, display an error message
        echo '<div class="alert alert-danger">Subject not found. Please check the subject code and try again.</div>';
        // Optionally, you can redirect to the subject list or add page
        exit; // Stop further execution
    }
} else {
    // No subject code provided, display an error message
    echo '<div class="alert alert-danger">No subject code provided. Please provide a valid subject code.</div>';
    // Optionally, you can redirect to the subject list or add page
    exit; // Stop further execution
}
?>

<!-- Content Area -->
<div class="col-md-9 col-lg-10">
    <h3 class="text-left mb-5 mt-5">Edit Subject</h3> <!-- Corrected the closing tag -->

    <!-- Breadcrumb Navigation -->
    <!-- Helps the user understand their current location within the application -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>

    <?php
    // Handle form submission for updating the subject
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve and sanitize form inputs
        // Note: Subject code is not editable, so we use the existing code from $subject_data
        $subject_name = isset($_POST['subject_name']) ? htmlspecialchars(trim($_POST['subject_name'])) : '';

        // Validate input: Ensure subject name is not empty
        if (!empty($subject_name)) {
            // Attempt to update the subject in the database
            $update_success = updateSubject($subject_code, $subject_name, "./add.php");

            if ($update_success) {
                // Update was successful, you can redirect or display a success message
                echo '<div class="alert alert-success">Subject updated successfully.</div>';
            } else {
                // Update failed, display an error message
                echo '<div class="alert alert-danger">Failed to update subject. Please try again.</div>';
            }
        } else {
            // Subject name is empty, display a warning message
            echo '<div class="alert alert-warning">Please provide a subject name.</div>';
        }
    }
    ?>

    <!-- Edit Subject Form -->
    <!-- Users can update the subject name here -->
    <div class="card p-4 mb-5">
        <form method="POST">
            <!-- Subject Code (displayed but not editable) -->
            <div class="mb-3">
                <label for="subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code" 
                       value="<?= htmlspecialchars($subject_data['subject_code']) ?>" disabled>
                <!-- Hidden input to retain the subject code if needed -->
                <input type="hidden" name="subject_code" value="<?= htmlspecialchars($subject_data['subject_code']) ?>">
            </div>

            <!-- Subject Name (editable) -->
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" 
                       value="<?= htmlspecialchars($subject_data['subject_name']) ?>" required>
            </div>

            <!-- Update Subject Button -->
            <button type="submit" class="btn btn-primary btn-sm w-100">Update Subject</button>
        </form>
    </div>
</div>


<?php
// Include the footer section
include '../admin/partials/footer.php';
?>
