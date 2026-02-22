<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "laundryaa"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $mobile = trim($_POST["mobile"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Input validation
    $errors = [];

    if (strlen($name) < 3) {
        $errors[] = "Full Name must be at least 3 characters.";
    }

    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors[] = "Enter a valid 10-digit mobile number.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $errors[] = "Email is already registered.";
    }
    $stmt->close();

    // If no errors, proceed with inserting into the database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, mobile, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $mobile, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Sign up successful! Redirecting to login.'); window.location.href='home.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}

$conn->close();
?>
<?php
$conn = new mysqli("localhost", "root", "", "laundryaa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validation
    if ($password !== $confirm) {
        echo "Passwords do not match";
        exit;
    }

    // Check existing email
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Email already registered";
        exit;
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users(name,mobile,email,password) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $name, $mobile, $email, $hashed);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful'); window.location='signin.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

}
?>