<?php    
    // All project functions should be placed here

session_start();    
function postData($key) {
    return isset($_POST[$key]) ? $_POST[$key] : null;
}


 
function getConnection() {
    // Database configuration
    $host = 'localhost'; // Replace with your host
    $dbName = 'dct-ccs-finals'; // Replace with your database name
    $username = 'root'; // Replace with your username
    $password = ''; // Replace with your password
    $charset = 'utf8mb4'; // Recommended for UTF-8 support
    
    try {
        $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function login($email, $password) {
    $validateLogin = validateLoginCredentials($email, $password);

    if(count($validateLogin) > 0){
        echo displayErrors($validateLogin);
        return;
    }


    // Get database connection
    $conn = getConnection();

    // Convert the input password to MD5
    $hashedPassword = md5($password);

    // SQL query to check if the email and hashed password match
    $query = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    
    $stmt->execute();
    
    // Fetch the user data if found
    $user = $stmt->fetch();

    if ($user) {
        // Login successful
        // return $user;
        $_SESSION['email'] = $user['email'];
        header("Location: admin/dashboard.php");
    } else {
        // Login failed
        echo displayErrors(["Invalid email or password"]);
    }
}



function validateLoginCredentials($email, $password) {
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    
    return $errors;
}



function displayErrors($errors) {
    if (empty($errors)) return "";

    $errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>System Alerts</strong><ul>';

    // Make sure each error is a string
    foreach ($errors as $error) {
        // Check if $error is an array or not
        if (is_array($error)) {
            // If it's an array, convert it to a string (you could adjust this to fit your needs)
            $errorHtml .= '<li>' . implode(", ", $error) . '</li>';
        } else {
            $errorHtml .= '<li>' . htmlspecialchars($error) . '</li>';
        }
    }

    $errorHtml .= '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

    return $errorHtml;
}

// Function to count all subjects in the database
function countAllSubjects() {
    try {
        // Get the database connection
        $conn = getConnection();

        // SQL query to count all subjects
        $sql = "SELECT COUNT(*) AS total_subjects FROM subjects";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the result as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total count of subjects
        return $result['total_subjects'];
    } catch (PDOException $e) {
        // Return error message if there is an exception
        return "Error: " . $e->getMessage();
    }
}

// Function to count all students in the database
function countAllStudents() {
    try {
        // Get the database connection
        $conn = getConnection();

        // SQL query to count all students
        $sql = "SELECT COUNT(*) AS total_students FROM students";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the result as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total count of students
        return $result['total_students'];
    } catch (PDOException $e) {
        // Return error message if there is an exception
        return "Error: " . $e->getMessage();
    }
}

// Function to calculate the total number of passed and failed students
function calculateTotalPassedAndFailedStudents() {
    try {
        // Get the database connection
        $conn = getConnection();

        // SQL query to calculate the total grades and subjects for each student
        $sql = "SELECT student_id, 
                       SUM(grade) AS total_grades, 
                       COUNT(subject_id) AS total_subjects 
                FROM students_subjects 
                GROUP BY student_id";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch all the results as an associative array
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Initialize counters for passed and failed students
        $passed = 0;
        $failed = 0;

        // Loop through each student's data
        foreach ($students as $student) {
            // Calculate the average grade for the student
            $average_grade = $student['total_grades'] / $student['total_subjects'];

            // Increment the passed or failed counter based on the grade
            if ($average_grade >= 75) {
                $passed++; // Increment passed count if the average grade is 75 or higher
            } else {
                $failed++; // Increment failed count if the average grade is below 75
            }
        }

        // Return an associative array with the counts of passed and failed students
        return [
            'passed' => $passed,
            'failed' => $failed
        ];
    } catch (PDOException $e) {
        // Return error message if there is an exception
        return "Error: " . $e->getMessage();
    }
}


?>