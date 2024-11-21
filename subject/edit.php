<?php
// Include necessary shared functions file and header partial
include '../functions.php'; // Include shared functions for database and form handling
include '../admin/partials/header.php'; // Include the header of the admin panel

// Define file paths for navigation links
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../admin/student/register.php';
$subjectPage = './admin/add.php';
include '../admin/partials/side-bar.php'; // Include sidebar for navigation

// Fetch the subject data based on the subject code passed in the URL
$subject_data = getSubjectByCode($_GET['subject_code']);

?>

<div class="col-md-9 col-lg-10">

<!-- Page Heading -->
<h3 class="text-left mb-5 mt-5">Edit Subject</h3>

<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <!-- Link to Dashboard -->
        <li class="breadcrumb-item" aria-current="page"><a href="../admin/dashboard.php">Dashboard</a></li>
        <!-- Link to Add Subject Page -->
        <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
        <!-- Active link for Edit Subject Page -->
        <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
    </ol>
</nav>

<!-- Check if the form has been submitted using the POST method -->
<?php
    // If form is submitted
    if(isPost()){
        // Get the subject code and the new subject name from the form
        $subject_code = $subject_data['subject_code'];
        $subject_name = postData('subject_name');
        
        // Call the function to update the subject
        updateSubject($subject_code, $subject_name, "./add.php");
    }
?>

<!-- Edit Subject Form -->
<div class="card p-4 mb-5">
    <!-- Form to update the subject -->
    <form method="POST">
        <!-- Subject Code (readonly field, cannot be edited) -->
        <div class="mb-3">
            <label for="subject_code" class="form-label">Subject Code</label>
            <input type="text" class="form-control" id="subject_code" name="subject_code" 
                   value="<?= htmlspecialchars($subject_data['subject_code']) ?>" disabled>
        </div>

        <!-- Subject Name (editable field) -->
        <div class="mb-3">
            <label for="subject_name" class="form-label">Subject Name</label>
            <input type="text" class="form-control" id="subject_name" name="subject_name" 
                   value="<?= htmlspecialchars($subject_data['subject_name']) ?>">
        </div>

        <!-- Button to submit the form and update the subject -->
        <button type="submit" class="btn btn-primary btn-sm w-100">Update Subject</button>
    </form>
</div>

</div>

<?php
// Include the footer section of the admin panel
include '../admin/partials/footer.php';
?>
