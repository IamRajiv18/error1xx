<?php
include("header.php");



if (isset($_POST['submit'])) {
    // Validate inputs
    $name = get_safe_value($conn, $_POST['firstName']);
    $email = get_safe_value($conn, $_POST['email']);
    $phonenumber = get_safe_value($conn, $_POST['phonenumber']);
    $gender = get_safe_value($conn, $_POST['gender']);
    $age = intval(get_safe_value($conn, $_POST['age'])); // Ensure age is an integer
    $occupation = get_safe_value($conn, $_POST['occupation']);

    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email ID or Phone Number is already registered'); window.history.back();</script>";
        exit;
    }

    // Generate verification ID
    $verification_id = 1;

    // Insert user data securely
    $insertQuery = "INSERT INTO user (name, email, password, profession, gender, age, verification_status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param('ssssiii', $name, $email, $hashedPassword, $occupation, $gender, $age, $verification_id);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful! Redirecting to login...'); window.location.href='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>

<style>
    form {
        background-color: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        place-self: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    input,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }

    input:focus,
    select:focus {
        outline: none;
        border-color: #3494E6;
        box-shadow: 0 0 5px rgba(52, 148, 230, 0.2);
    }

    button {
        background: linear-gradient(to right, #3494E6, #EC6EAD);
        color: white;
        padding: 12px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }

    button:hover {
        background: #3494E6;
    }

    .required:after {
        content: " *";
        color: #EC6EAD;
    }

    .terms {
        font-size: 12px;
        color: #555;
        margin-top: 10px;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .terms a {
        font-weight: bold;
        text-decoration: none;
        color: #3494E6;
    }

    .terms a:hover {
        text-decoration: underline;
    }

    h2 {
        place-self: anchor-center;
    }
</style>

<main>
    <h2>Registration Form</h2>
    <form method="post">
        <div class="form-group">
            <label for="firstName" class="required">First Name</label>
            <input type="text" id="firstName" name="firstName" required>
        </div>

        <div class="form-group">
            <label for="email" class="required">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phonenumber" class="required">Phone Number</label>
            <input type="text" id="phonenumber" name="phonenumber" required>
        </div>

        <div class="form-group">
            <label for="password" class="required">Password</label>
            <input type="password" id="password" name="password" required minlength="8">
        </div>

        <div class="form-group">
            <label for="confirmPassword" class="required">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8">
        </div>

        <div class="form-group">
            <label for="gender" class="required">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
                <option value="prefer-not">Prefer not to say</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ageCategory" class="required">Age</label>
            <input type="number" id="ageCategory" name="age" required>
        </div>

        <div class="form-group">
            <label for="occupation" class="required">Occupation</label>
            <select id="occupation" name="occupation" required>
                <option value="">Select</option>
                <option value="government">Government Employee</option>
                <option value="business">Business</option>
                <option value="student">Student</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="terms">
            By creating an account, you agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.
        </div>

        <div class="form-group">
            <button type="submit" name="submit">Register</button>
        </div>
    </form>
</main>

<?php include("footer.php"); ?>