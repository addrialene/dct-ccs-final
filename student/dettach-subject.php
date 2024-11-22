<?php
// Include necessary functions and header files
include '../functions.php'; // Contains helper functions
include '../admin/partials/header.php'; // Header partial for admin panel

// Define paths for navigation
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '.register.php';
$subjectPage = './subject/add.php';

// Include sidebar for navigation
include '../admin/partials/side-bar.php';

// If the form is submitted via POST request
if (isPost()) {
    // Dettach the selected subject from the student using the provided student_id and subject_id
    dettachSubject(GETdata('student_id'), GETdata('subject_id'), 'attach-subject.php?student_id=' . GETdata('student_id'));
}
?>

<div class="col-md-9 col-lg-10">

    <!-- Page Title -->
    <h3 class="text-left mb-5 mt-5">Delete a Student</h3>

    <!-- Breadcrumb Navigation for easy navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>

    <!-- Confirmation Message Section -->
    <div class="border p-5">
        <!-- Asking user to confirm dettachment of subject from the student record -->
        <p class="text-left">Are you sure you want to dettach this subject from this student record?</p>
        
        <!-- Display student and subject details for confirmation -->
        <ul class="text-left">
            <li><strong>Student ID:</strong> <?= GETdata("student_id") // Display the student ID ?></li>
            <li><strong>First Name:</strong> <?= GETdata("firstname") // Display the student's first name ?></li>
            <li><strong>Last Name:</strong> <?= GETdata("lastname") // Display the student's last name ?></li>
            <li><strong>Subject Code:</strong> <?= GETdata("subject_id") // Display the subject code ?></li>
            <li><strong>Subject Name:</strong> <?= GETdata("subject_name") // Display the subject name ?></li>
        </ul>

        <!-- Form to confirm dettachment -->
        <form method="POST" class="text-left">
            <!-- Button to cancel dettachment and return to the subject attachment page -->
            <a href="attach-subject.php?student_id=<?= GETdata('student_id') ?>" class="btn btn-secondary">Cancel</a>
            <!-- Submit button to confirm dettachment of the subject from the student -->
            <button type="submit" class="btn btn-primary">Delete Subject from Student</button>
        </form>
    </div>

</div>

<?php
// Include the footer partial for admin panel
include '../admin/partials/footer.php';
?>
