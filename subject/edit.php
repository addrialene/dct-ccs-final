<?php
// Include shared functions and header
include '../functions.php';
include '../admin/partials/header.php';

// Define paths for navigation
$paths = [
    'logout' => '../admin/logout.php',
    'dashboard' => '../admin/dashboard.php',
    'studentRegister' => '../admin/student/register.php',
    'addSubject' => './admin/add.php',
];
include '../admin/partials/side-bar.php';

// Fetch subject data by subject_code from GET parameter
$subject_data = getSubjectByCode($_GET['subject_code']);

?>

<div class="col-md-9 col-lg-10">
    <!-- Page Heading -->
    <h3 class="text-left mb-5 mt-5">Edit Subject</h3>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $paths['dashboard']; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>

    <!-- Process Form Submission -->
    <?php
    if (isPost()) {
        $subject_code = $subject_data['subject_code']; // Current subject code
        $subject_name = postData('subject_name');     // New subject name

        // Update subject and provide feedback
        if (updateSubject($subject_code, $subject_name, $paths['addSubject'])) {
            echo '<div class="alert alert-success">Subject updated successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to update the subject. Please try again.</div>';
        }
    }
    ?>

    <!-- Edit Subject Form -->
    <div class="card p-4 mb-5">
        <form method="POST">
            <!-- Subject Code (disabled) -->
            <div class="mb-3">
                <label for="subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code" 
                       value="<?= htmlspecialchars($subject_data['subject_code']); ?>" disabled>
            </div>

            <!-- Subject Name -->
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" 
                       value="<?= htmlspecialchars($subject_data['subject_name']); ?>">
            </div>

            <!-- Update Subject Button -->
            <button type="submit" class="btn btn-primary btn-sm w-100">Update Subject</button>
        </form>
    </div>
</div>

<?php
// Include footer
include '../admin/partials/footer.php';
?>
