<?php
// Include required functions and header files
include '../functions.php'; // Contains necessary helper functions
include '../admin/partials/header.php'; // Header partial for the admin panel

// Define paths for navigation
$logoutPage = '../logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../student/register.php';
$subjectPage = './subject/add.php';

// Include sidebar for navigation
include '../admin/partials/side-bar.php';

// Handle the POST request for updating the student's grade
if (isPost()) {
    // Call the function to update the subject grade and redirect
    updateSubjectGrade(
        GETdata('student_id'), // Retrieve the student ID from GET request
        GETdata('subject_id'), // Retrieve the subject ID from GET request
        postData('grade'), // Retrieve the grade from POST data
        'register.php?student_id=' . GETdata('student_id') // Redirect URL after update
    );
}
?>

<div class="col-md-9 col-lg-10">

    <!-- Page Title -->
    <h3 class="text-left mb-5 mt-5">Assign Grade to Subject</h3>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <!-- Links to other pages for navigation -->
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assign Grade</li>
        </ol>
    </nav>

    <div class="border p-5">
        <!-- Display selected student and subject information -->
        <p class="text-left fs-4">Selected Student and Subject Information</p>
        <ul class="text-left">
            <!-- Student ID -->
            <li><strong>Student ID:</strong> <?= GETdata('student_id') ?></li>
            <!-- Full Name -->
            <li><strong>Name:</strong> <?= GETdata('firstname') . ' ' . GETdata('lastname') ?></li>
            <!-- Subject Code -->
            <li><strong>Subject Code:</strong> <?= GETdata('subject_id') ?></li>
            <!-- Subject Name -->
            <li><strong>Subject Name:</strong> <?= GETdata('subject_name') ?></li>
        </ul>
        <hr>

        <!-- Form for assigning grade to the subject -->
        <form method="POST" class="text-left">
            <!-- Grade input field -->
            <div class="mb-3 p-3 border rounded">
                <label for="gradeInput" class="form-label">Grade</label>
                <input type="number" class="form-control border-0" id="gradeInput" name="grade" placeholder="Enter grade">
            </div>

            <!-- Cancel button redirects to attach-subject page -->
            <a href="attach-subject.php?student_id=<?= GETdata('student_id') ?>" class="btn btn-secondary">Cancel</a>
            <!-- Submit button to assign grade -->
            <button type="submit" class="btn btn-primary">Assign Grade to Subject</button>
        </form>
    </div>

</div>

<?php
// Include footer partial for the admin panel
include '../admin/partials/footer.php';
?>
