<?php
// Include required function and header files
include '../functions.php'; // Contains helper functions
include '../admin/partials/header.php'; // Header partial for admin panel

// Define paths for navigation
$logoutPage = '../admin/logout.php';
$dashboardPage = '../admin/dashboard.php';
$studentPage = '../student/register.php';
$subjectPage = './subject/add.php';

// Include sidebar for navigation
include '../admin/partials/side-bar.php';

// Fetch student details using student_id from GET parameters
$student_data = getStudentById($_GET['student_id']);
?>

<div class="col-md-9 col-lg-10">

    <!-- Page Title -->
    <h3 class="text-left mb-5 mt-5">Delete a Student</h3>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../admin/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>

    <?php
    // Handle form submission
    if (isPost()) {
        // Check if any subjects were selected
        if (isset($_POST['subjects']) && !empty($_POST['subjects'])) {
            $subjects = $_POST['subjects']; // Array of selected subjects

            // Assign selected subjects to the student
            assignSubjectsToStudent($student_data['student_id'], $subjects);
        } else {
            // Display error if no subjects are selected
            echo displayErrors(["No subjects selected."]);
        }
    }
    ?>

    <div class="border p-5">
        <!-- Display Selected Student Information -->
        <h4 class="text-left mb-2 mt-5">Selected Student Information</h4>
        <ul class="text-left">
            <!-- Display Student ID -->
            <li><strong>Student ID:</strong> <?= htmlspecialchars($student_data['student_id']) ?></li>
            <!-- Display Student Name -->
            <li><strong>Name:</strong> <?= htmlspecialchars($student_data['first_name']) . ' ' . htmlspecialchars($student_data['last_name']) ?></li>
        </ul>
        <hr>

        <!-- Form for attaching subjects -->
        <form method="POST" class="text-left">
            <?php
            // Generate checkboxes for all available subjects
            echo getAllSubjectsCheckboxes($student_data['student_id']);
            ?>
            <!-- Submit button to attach subjects -->
            <button type="submit" class="btn btn-primary mt-3">Attach Subjects</button>
        </form>
    </div>

    <!-- Display Assigned Subject List -->
    <div class="card p-4 mt-5 mb-5">
        <h3 class="card-title text-left">Subject List</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Grade</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Fetch assigned subjects for the student
                $assignedSubjects = fetchAssignSubjects($student_data['student_id']); 
                
                // Check if any subjects are assigned
                if (!empty($assignedSubjects)): ?>
                    <?php foreach ($assignedSubjects as $subject): ?>
                        <tr>
                            <!-- Display Subject Code -->
                            <td><?= htmlspecialchars($subject['subject_id']) ?></td>
                            <!-- Display Subject Name -->
                            <td><?= htmlspecialchars($subject['subject_name']) ?></td>
                            <!-- Display Subject Grade -->
                            <td><?= htmlspecialchars($subject['grade']) ?></td>
                            <td>
                                <!-- Dettach Subject Button -->
                                <a href="dettach-subject.php?subject_id=<?= urlencode($subject['subject_id']) ?>&subject_name=<?= urlencode($subject['subject_name']) ?>&student_id=<?= $student_data['student_id'] ?>&firstname=<?= $student_data['first_name'] ?>&lastname=<?= $student_data['last_name'] ?>" class="btn btn-danger btn-sm">Dettach Subject</a>
                                
                                <!-- Assign Grade Button -->
                                <a href="assign-grade.php?subject_id=<?= urlencode($subject['subject_id']) ?>&subject_name=<?= urlencode($subject['subject_name']) ?>&student_id=<?= $student_data['student_id'] ?>&firstname=<?= $student_data['first_name'] ?>&lastname=<?= $student_data['last_name'] ?>" class="btn btn-success btn-sm">Assign Grade</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Display message if no subjects are assigned -->
                    <tr>
                        <td colspan="4" class="text-center">No subjects found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
// Include footer partial for admin panel
include '../admin/partials/footer.php';
?>
