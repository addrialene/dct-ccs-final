<?php
// Include necessary functions and header files
include '../functions.php'; // Contains helper functions for data handling
include '../admin/partials/header.php'; // Header partial for the admin panel

// Define paths for navigation links
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../student/register.php';
$subjectPage = './subject/add.php';

// Include sidebar for navigation
include '../admin/partials/side-bar.php';

// If the form is submitted via POST request, process the data
?>

<div class="col-md-9 col-lg-10">

    <!-- Page Title -->
    <h3 class="text-left mb-5 mt-5">Edit Student</h3>

    <!-- Breadcrumb Navigation for easy navigation between pages -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="../admin/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
        </ol>
    </nav>

    <?php
    // Fetch student data based on the provided student_id from the GET request
    $student_data = getStudentById($_GET['student_id']);

    // Check if the form is submitted via POST method
    if (isPost()) {
        // Fetch the student ID and new first and last name from the POST request
        $student_id = $student_data['student_id'];
        $firstname = postData("first_name");
        $lastname = postData("last_name");

        // Call function to update the student record in the database
        updateStudent($student_id, $firstname, $lastname, 'register.php');
    }
    ?>
    

    <!-- Edit Student Form -->
    <div class="card p-4 mb-5">
        <form method="POST">
            <!-- Student ID (disabled input field as it cannot be edited) -->
            <div class="mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?= htmlspecialchars($student_data['student_id']) ?>" disabled>
            </div>

            <!-- First Name Input Field -->
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($student_data['first_name']) ?>">
            </div>

            <!-- Last Name Input Field -->
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($student_data['last_name']) ?>">
            </div>

            <!-- Update Button -->
            <button type="submit" class="btn btn-primary btn-sm w-100">Update Student</button>
        </form>
    </div>

</div>

<?php
// Include footer partial for the admin panel
include '../admin/partials/footer.php';
?>
