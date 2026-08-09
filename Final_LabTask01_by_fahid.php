<?php
// Initialize variables and error messages
$name = $age = $email = $membership = $department = $phone = "";
$nameErr = $ageErr = $emailErr = $membershipErr = $departmentErr = $phoneErr = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Student Name Validation
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = trim($_POST["name"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $nameErr = "Only letters and spaces are allowed.";
        }
    }

    // 2. Student Age Validation
    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
    } else {
        $age = trim($_POST["age"]);
        if (!is_numeric($age) || $age < 18 || $age > 30) {
            $ageErr = "Age must be between 18 and 30.";
        }
    }

    // 3. University Email Validation
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format.";
        }
    }

    // 4. Membership Type Validation
    if (empty($_POST["membership"])) {
        $membershipErr = "Please select a membership type.";
    } else {
        $membership = $_POST["membership"];
    }

    // 5. Department Validation
    if (empty($_POST["department"]) || $_POST["department"] == "") {
        $departmentErr = "Please select your department.";
    } else {
        $department = $_POST["department"];
    }

    // 6. Contact Number Validation
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = trim($_POST["phone"]);
        if (!preg_match("/^[0-9]{11}$/", $phone)) {
            $phoneErr = "Phone number must contain exactly 11 digits.";
        }
    }

    // Success Check
    if (empty($nameErr) && empty($ageErr) && empty($emailErr) && empty($membershipErr) && empty($departmentErr) && empty($phoneErr)) {
        $successMsg = "Registration successful!";
        // Clear fields on successful submission
        $name = $age = $email = $membership = $department = $phone = "";
    }
}

// Function to sanitize dynamic HTML output safely
function html_escape($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Technology Club Registration</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f7f6; }
        .form-container { max-width: 500px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input[type="text"], input[type="number"], input[type="email"], select { width: 100%; padding: 8px; box-sizing: border-box; }
        .radio-group label { font-weight: normal; display: inline-block; margin-right: 15px; }
        .error { color: red; font-size: 0.88em; margin-top: 4px; display: block; }
        .success { color: green; font-size: 1.1em; font-weight: bold; margin-bottom: 15px; }
        button { background-color: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; width: 100%; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Student Technology Club Registration</h2>

    <?php if (!empty($successMsg)): ?>
        <div class="success"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo html_escape($_SERVER["PHP_SELF"]); ?>" novalidate>
        
        <!-- 1. Student Name -->
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" id="name" name="name" value="<?php echo html_escape($name); ?>">
            <span class="error"><?php echo $nameErr; ?></span>
        </div>

        <!-- 2. Student Age -->
        <div class="form-group">
            <label for="age">Student Age</label>
            <input type="number" id="age" name="age" value="<?php echo html_escape($age); ?>">
            <span class="error"><?php echo $ageErr; ?></span>
        </div>

        <!-- 3. University Email -->
        <div class="form-group">
            <label for="email">University Email</label>
            <input type="email" id="email" name="email" value="<?php echo html_escape($email); ?>">
            <span class="error"><?php echo $emailErr; ?></span>
        </div>

        <!-- 4. Membership Type -->
        <div class="form-group radio-group">
            <label>Membership Type</label>
            <label><input type="radio" name="membership" value="Regular Member" <?php if ($membership == "Regular Member") echo "checked"; ?>> Regular Member</label>
            <label><input type="radio" name="membership" value="Executive Member" <?php if ($membership == "Executive Member") echo "checked"; ?>> Executive Member</label>
            <label><input type="radio" name="membership" value="Volunteer" <?php if ($membership == "Volunteer") echo "checked"; ?>> Volunteer</label>
            <span class="error"><?php echo $membershipErr; ?></span>
        </div>

        <!-- 5. Department -->
        <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department">
                <option value="">-- Select Department --</option>
                <option value="CSE" <?php if ($department == "CSE") echo "selected"; ?>>CSE</option>
                <option value="EEE" <?php if ($department == "EEE") echo "selected"; ?>>EEE</option>
                <option value="BBA" <?php if ($department == "BBA") echo "selected"; ?>>BBA</option>
                <option value="English" <?php if ($department == "English") echo "selected"; ?>>English</option>
                <option value="Architecture" <?php if ($department == "Architecture") echo "selected"; ?>>Architecture</option>
            </select>
            <span class="error"><?php echo $departmentErr; ?></span>
        </div>

        <!-- 6. Contact Number -->
        <div class="form-group">
            <label for="phone">Contact Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo html_escape($phone); ?>">
            <span class="error"><?php echo $phoneErr; ?></span>
        </div>

        <button type="submit">Submit Registration</button>
    </form>
</div>

</body>
</html>
