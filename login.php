<?php
include("header.php");
$err_msg = "";
if (isset($_POST['submit']) && $_POST['submit'] == 'Login') {
    $email = get_safe_value($conn, $_POST['email']);
    $password = get_safe_value($conn, $_POST['password']);

    if (empty($email) || empty($password)) {
        $err_msg = "Please fill in all fields";
    } else {


        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPasswordFromDB = $row['password'];

                if (password_verify($password, $hashedPasswordFromDB)) {
                    if ($row['verification_status'] == 1) {

                        $_SESSION['user'] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'email' => $row['email'],

                        );
                        $_SESSION['LOGIN'] = 'yes';







                        echo "<script>window.location.href='index.php'</script>";

                    } else {
                        $err_msg = "your are not verified yet";


                    }
                } else {
                    $err_msg = "Invalid password";

                }
            } else {
                $err_msg = "Invalid email";

            }
        } else {
            $err_msg = "Database error: ";
        }

        $stmt->close();

    }




}
?>
<style>
    /* Login Form Container */
    .login-form-container {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        place-self: center;
        margin: 10%;
    }


    /* Headings */
    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    /* Form Elements */
    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    input {
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    input:focus {
        outline: none;
        border-color: #3494E6;
        box-shadow: 0 0 5px rgba(52, 148, 230, 0.2);
    }

    /* Button */
    .login-button {
        background: linear-gradient(to right, #3494E6, #EC6EAD);
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
        transition: background 0.3s ease;
    }

    .login-button:hover {
        background: #3494E6;
    }

    /* Links */
    a {
        text-decoration: none;
        color: #3494E6;
        font-size: 14px;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Register Link */
    .register-link {
        text-align: right;
        margin-bottom: 20px;
    }

    /* Forgot Password Link */
    .forgot-link {
        text-align: center;
        margin-top: 15px;
    }

    /* Error Message */
    .msg {
        color: red;
        margin-top: 10px;
        font-size: 14px;
        text-align: center;
    }

    /* Terms of Use */
    h5 {
        font-size: 12px;
        color: #555;
        margin-top: 10px;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    h5 a {
        font-weight: bold;
    }
</style>
<main>
    <div class="login-form-container">
        <div class="register-link">
            <a href="register.php">Register/Sign Up</a>
        </div>
        <h2>Login</h2>
        <form id="login-form" method="post">
            <label for="email">User Id:</label>
            <input type="text" id="email" class="username" name="email" placeholder="Enter Your Email" value="" />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Your Password" />

            <h5>
                By continuing, you agree to our <a href="">Terms of Use</a> and
                <a href="privacy.php">Prvacy Policy.</a>
            </h5>

            <input type="submit" class="login-button" name="submit" value="Login">

            <p class="msg"></p>

            <div class="forgot-link">
                <a href="forgot_password.php">Forgot password?</a>
            </div>
        </form>
        <p style="justify-self: center;
    color: red;"><?php echo $err_msg; ?></p>
    </div>

</main>
<?php
include("footer.php");

?>