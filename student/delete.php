<?php
// Include necessary function and header files
include '../functions.php'; // Contains helper functions
include '../admin/partials/header.php'; // Header partial for admin panel

// Define paths for navigation
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../student/register.php';
$subjectPage = './subject/add.php';

// Include sidebar for navigation
include '../admin/partials/side-bar.php';

// Fetch student details using student_id from the GET parameters
$student_data = getStudentById($_GET['student_id']);

// Check if form is submitted via POST request
if(isPost()){
    // Call the deleteStudent function to delete the student record
    deleteStudent($student_data['student_id'], 'register.php');
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

    <div class="border p-5">
        <!-- Confirmation Message asking user to confirm deletion -->
        <p class="text-left">Are you sure you want to delete the following student record?</p>
        <ul class="text-left">
            <!-- Display Student ID -->
            <li><strong>Student ID:</strong> <?= htmlspecialchars($student_data['student_id']) ?></li>
            <!-- Display Student First Name -->
            <li><strong>First Name:</strong> <?= htmlspecialchars($student_data['first_name']) ?></li>
            <!-- Display Student Last Name -->
            <li><strong>Last Name:</strong> <?= htmlspecialchars($student_data['last_name']) ?></li>
        </ul>

        <!-- Form to confirm deletion -->
        <form method="POST" class="text-left">
            <!-- Cancel button to go back to student registration page -->
            <a href="register.php" class="btn btn-secondary">Cancel</a>
            <!-- Button to submit the form and delete the student record -->
            <button type="submit" class="btn btn-primary">Delete Student Record</button>
        </form>
    </div>

</div>

<?php
// Include footer partial for admin panel
include '../admin/partials/footer.php';
?>
