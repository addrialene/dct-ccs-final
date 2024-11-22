<?php
// Include required files for shared functions and reusable page components
include '../functions.php'; // Contains functions like addSubject and fetchSubjects
include '../admin/partials/header.php'; // Header section with styles and scripts

// Define navigation paths
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../admin/student/register.php';
include '../admin/partials/side-bar.php'; // Sidebar navigation
?>

<!-- Content Area -->
<div class="col-md-9 col-lg-10">
    <h3 class="text-left mb-5 mt-5">Add A New Subject</h3> <!-- Page title -->
    
    <!-- Breadcrumb Navigation -->
    <!-- Helps the user know their current page and navigate back -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>

    <?php
    // Handle form submission for adding a new subject
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form inputs and sanitize them
        $subject_code = htmlspecialchars(trim(postData("subject_code")));
        $subject_name = htmlspecialchars(trim(postData("subject_name")));
        
        // Check if the input fields are not empty
        if (!empty($subject_code) && !empty($subject_name)) {
            // Call the function to add the subject to the database
            addSubject($subject_code, $subject_name);
        } else {
            // Show a warning message if fields are empty
            echo '<div class="alert alert-warning">Please fill in all fields.</div>';
        }
    }
    ?>

    <!-- Form for adding a new subject -->
    <!-- Users can input the subject code and name here -->
    <div class="card p-4 mb-5">
        <form method="POST">
            <div class="mb-3">
                <label for="subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code" required> <!-- Input field for subject code -->
            </div>
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" required> <!-- Input field for subject name -->
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">Add Subject</button> <!-- Submit button -->
        </form>
    </div>

    <!-- Table displaying the list of subjects -->
    <div class="card p-4">
        <h3 class="card-title text-center">Subject List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Options</th> <!-- Edit and Delete actions -->
                </tr>
            </thead>
            <tbody>
                <?php 
                // Fetch all subjects from the database
                $subjects = fetchSub();
                if (!empty($subjects)): 
                    // Loop through the subjects and display each one in a row
                    foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?= htmlspecialchars($subject['subject_code']) ?></td> <!-- Display subject code -->
                            <td><?= htmlspecialchars($subject['subject_name']) ?></td> <!-- Display subject name -->
                            <td>
                                <!-- Edit button links to the edit page with the subject code as a parameter -->
                                <a href="edit.php?subject_code=<?= urlencode($subject['subject_code']) ?>" class="btn btn-primary btn-sm">Edit</a>

                                <!-- Delete button links to the delete page with the subject code as a parameter -->
                                <a href="delete.php?subject_code=<?= urlencode($subject['subject_code']) ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; 
                else: ?>
                    <!-- Show a message if no subjects are found -->
                    <tr>
                        <td colspan="3" class="text-center">No subjects found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Include the footer section
include '../admin/partials/footer.php';
?>
