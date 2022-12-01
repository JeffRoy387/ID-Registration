<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
        $mname = isset($_POST['mname']) ? $_POST['mname'] : '';
        $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $idnum = isset($_POST['idnum']) ? $_POST['idnum'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE users SET id = ?, fname = ?, mname = ?, lname = ? email = ?, idnum = ?, 
            course = ?, password = ?, gender = ? WHERE id = ?');
        $stmt->execute([$id, $fname, $mname, $lname, $email,$idnum, $course, $password, $gender, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$users) {
        exit('Users doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
    <h2>Register Form</h2>
    <form action="create.php" method="post">

        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">

        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="fname" placeholder="Enter your first name"><br>

        <label for="mname">Middle Initial:</label><br>
        <input type="text" id="mname" name="mname"placeholder="Enter your Middle Initial"><br>

        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="lname" placeholder="Enter your Last name"><br>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Enter your Email Address"><br>

        <label for="idnum">Enter ID Number:</label><br>
        <input type="text" id="idnum" name="idnum" maxlength="9" size="9"placeholder="Enter your ID Number"><br>

        <label for="course">Select your Course</label><br>
        <input list="course" name="course" >

        <datalist id="course">
        <option value = "BACHELOR OF SCIENCE IN ACCOUNTING INFORMATION SYSTEM">
        <option value = "BACHELOR OF SCIENCE IN ACCOUNTING TECHNOLOGY">
        <option value = "BACHELOR OF SCIENCE IN AGRICULTURAL ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN ARCHITECTURE">
        <option value = "BACHELOR OF SCIENCE IN BIOLOGY">
        <option value = "BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION">
        <option value = "BACHELOR OF SCIENCE IN CIVIL ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN TOURISM MANAGEMENT">
        <option value = "BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT">
        <option value = "BACHELOR OF ARTS IN BEHAVIORAL SCIENCE">
        <option value = "BACHELOR OF ARTS IN COMMUNICATION">
        <option value = "BACHELOR OF ARTS IN ENGLISH">
        <option value = "BACHELOR OF ARTS IN ENGLISH LANGUAGE STUDIES">
        <option value = "BACHELOR OF ARTS IN MASS COMMUNICATION">
        <option value = "BACHELOR OF ARTS IN POLITICAL SCIENCE">
        <option value = "BACHELOR OF CULTURE AND ARTS EDUCATION">
        <option value = "BACHELOR OF EARLY CHILDHOOD EDUCATION">
        <option value = "BACHELOR OF ELEMENTARY EDUCATION">
        <option value = "BACHELOR OF FINE ARTS">
        <option value = "BACHELOR OF FORENSIC SCIENCE">
        <option value = "BACHELOR OF LIBRARY AND INFORMATION SCIENCE">
        <option value = "BACHELOR OF PHYSICAL EDUCATION">
        <option value = "BACHELOR OF SCIENCE IN ACCOUNTANCY">
        <option value = "BACHELOR OF SCIENCE IN COMMERCE">
        <option value = "BACHELOR OF SCIENCE IN COMPUTER ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN COMPUTER SCIENCE">
        <option value = "BACHELOR OF SCIENCE IN CRIMINOLOGY">
        <option value = "BACHELOR OF SCIENCE IN DATA ANALYTICS">
        <option value = "BACHELOR OF SCIENCE IN ELECTRONIC AND COMMUNICATIONS ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN ELECTRONICS ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN ENTREPRENEURSHIP">
        <option value = "BACHELOR OF SCIENCE IN ENVIRONMENTAL AND SANITARY ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN ENVIRONMENTAL PLANNING">
        <option value = "BACHELOR OF SCIENCE IN EXERCISE & SPORTS SCIENCE">
        <option value = "BACHELOR OF SCIENCE IN FINANCIAL AND MANAGEMENT ACCOUNTING">
        <option value = "BACHELOR OF SCIENCE IN FORENSIC ACCOUNTING">
        <option value = "BACHELOR OF SCIENCE IN GEODETIC ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMEN">
        <option value = "BACHELOR OF SCIENCE IN INDUSTRIAL SECURITY MANAGEMENT">
        <option value = "BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY">
        <option value = "BACHELOR OF SCIENCE IN INTERNAL AUDITING">
        <option value = "BACHELOR OF SCIENCE IN LEGAL MANAGEMENT">
        <option value = "BACHELOR OF SCIENCE IN MANAGEMENT ACCOUNTING">
        <option value = "BACHELOR OF SCIENCE IN MECHANICAL ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN MECHATRONICS ENGINEERING">
        <option value = "BACHELOR OF SCIENCE IN NURSING">
        <option value = "BACHELOR OF SCIENCE IN OFFICE ADMINISTRATION">
        <option value = "BACHELOR OF SCIENCE IN PSYCHOLOGY">
        <option value = "BACHELOR OF SCIENCE IN REAL ESTATE MANAGEMENT">
        <option value = "BACHELOR OF SCIENCE IN TOURISM MANAGEMENT">
        <option value = "BACHELOR OF SECONDARY EDUCATION">
        <option value = "BACHELOR OF SPECIAL NEEDS EDUCATION-ELEMENTARY SCHOOL TEACHING">
        <option value = "DOCTOR IN INFORMATION TECHNOLOGY">
        <option value = "DOCTOR OF PHILOSOPHY IN CRIMINAL JUSTICE"> 
    </datalist><br>

        <label for="password">Enter Password:</label><br>
        <input type="text" id="password" name="password" minlength="6" size="6"placeholder="6 digit password"><br>

        <label for="gender">Select your Gender:</label><br>
        <input list="gender" name="gender" >

        <datalist id="gender">
            <option value = "Male">
            <option value = "Female">
            <option value = "Prefer not to say">
        </datalist ><br>

        <br>
        <input type="submit" value="Create">



    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>