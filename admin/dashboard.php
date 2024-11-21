<?php
include '../functions.php';

$logoutPage = 'logout.php';
$subjectPage = '../admin/subject/add.php';
$studentPage = '../admin/student/register.php';
require './partials/header.php';
require './partials/side-bar.php';

// Fetch the data
$total_subjects = countAllSubjects();
$total_students = countAllStudents();
$failedAndPassed = calculateTotalPassedAndFailedStudents();

?>

<!-- Template Files here -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <h1 class="h2">Dashboard</h1>        
    
    <div class="row mt-5">
        <div class="col-12 col-xl-3">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white border-primary">Number of Subjects:</div>
                <div class="card-body text-primary">
                    <!-- Display total subjects count dynamically -->
                    <h5 class="card-title"><?= $total_subjects ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white border-primary">Number of Students:</div>
                <div class="card-body text-success">
                    <!-- Display total students count dynamically -->
                    <h5 class="card-title"><?= $total_students ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-danger mb-3">
                <div class="card-header bg-danger text-white border-danger">Number of Failed Students:</div>
                <div class="card-body text-danger">
                    <!-- Display failed students count dynamically -->
                    <h5 class="card-title"><?= $failedAndPassed['failed'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white border-success">Number of Passed Students:</div>
                <div class="card-body text-success">
                    <!-- Display passed students count dynamically -->
                    <h5 class="card-title"><?= $failedAndPassed['passed'] ?></h5>
                </div>
            </div>
        </div>
    </div>    
</main>
<!-- Template Files here -->
