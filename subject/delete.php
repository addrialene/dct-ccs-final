<?php
// Include necessary files and functions
include '../functions.php'; // Import common functions
include '../admin/partials/header.php'; // Include header content

// Path definitions for navigation
$logoutUrl = '../admin/logout.php';
$dashboardUrl = '../admin/dashboard.php';
$registerStudentUrl = '../admin/student/register.php';
$subjectAddUrl = './add.php';

// Include sidebar content
include '../admin/partials/side-bar.php';

// Retrieve subject details using the subject code from the URL
$subjectDetails = getSubjectByCode($_GET['subject_code']);

// Process the request to delete the subject if the form is submitted
if (isPost()) {
    removeSubject($subjectDetails['subject_code'], './add.php');
}

?>

<div class="col-md-9 col-lg-10">

    <!-- Page Heading -->
    <h3 class="text-left mb-5 mt-5">Delete Subject</h3>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <!-- Link to the main dashboard -->
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
            <!-- Link to add a subject -->
            <li class="breadcrumb-item"><a href="add.php">Add a Subject</a></li>
            <!-- Current page indicator -->
            <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
        </ol>
    </nav>

    <!-- Confirmation Section for Deletion -->
    <div class="border p-5">
        <!-- Prompt asking for confirmation -->
        <p class="text-left">Do you really want to delete the following subject entry?</p>
        <ul class="text-left">
            <!-- Display subject code and name for review -->
            <li><strong>Subject Code:</strong> <?= htmlspecialchars($subjectDetails['subject_code']) ?></li>
            <li><strong>Subject Name:</strong> <?= htmlspecialchars($subjectDetails['subject_name']) ?></li>
        </ul>

        <!-- Confirmation form -->
        <form method="POST" class="text-left">
            <!-- Link to cancel and go back to the subject creation page -->
            <a href="add.php" class="btn btn-secondary">Cancel</a>
            <!-- Button to confirm deletion -->
            <button type="submit" class="btn btn-danger">Delete Subject Record</button>
        </form>
    </div>

</div>

<?php
// Include footer content
include '../admin/partials/footer.php';
?>
