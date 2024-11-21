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


function countAllSubjects() {
    try {
        // Get the database connection
        $conn = getConnection();

        // SQL query to count all subjects
        $sql = "SELECT COUNT(*) AS total_subjects FROM subjects";
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the count
        return $result['total_subjects'];
    } catch (PDOException $e) {
        // Handle any errors
        return "Error: " . $e->getMessage();
    }
}


function addSubject($subject_code, $subject_name) {
    $validateSubjectData = validateSubjectData($subject_code, $subject_name);


    // Get database connection
    $conn = getConnection();

    try {
        // Prepare SQL query to insert subject into the database
        $sql = "INSERT INTO subjects (subject_code, subject_name) VALUES (:subject_code, :subject_name)";
        $stmt = $conn->prepare($sql);

        // Bind parameters to the SQL query
        $stmt->bindParam(':subject_code', $subject_code);
        $stmt->bindParam(':subject_name', $subject_name);

        // Execute the query
        if ($stmt->execute()) {
            return true; // Subject successfully added
        } else {
            return "Failed to add subject."; // Query execution failed
        }
    } catch (PDOException $e) {
        // Return error message if the query fails
        return "Error: " . $e->getMessage();
    }
}

function validateSubjectData($subject_code, $subject_name ) {
    $errors = [];

    // Check if subject_code is empty
    if (empty($subject_code)) {
        $errors[] = "Subject code is required.";
    }

    // Check if subject_name is empty
    if (empty($subject_name)) {
        $errors[] = "Subject name is required.";
    }

    return $errors;
}

function fetchSub() {
    // Get the database connection
    $conn = getConnection();

    try {
        // Prepare SQL query to fetch all subjects
        $sql = "SELECT * FROM subjects";
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch all subjects as an associative array
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the list of subjects
        return $subjects;
    } catch (PDOException $e) {
        // Return an empty array in case of error
        return [];
    }
}















?>