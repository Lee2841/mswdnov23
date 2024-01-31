<?php
var_dump($_POST);

$email = '';
$comments = '';
$maxSize = ini_get('upload_max_filesize');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $comments = $_POST['comments'];

    if (empty($comments)) {
        // Comment is empty, display an error message or take appropriate action
        echo '<p style="color: red;">Please enter a comment</p>';
    } else {
        // Comment is not empty, proceed with further processing
        printf('<p>Received email: %s and comments %s</p>', $email, $comments);
    }


    if (isset($_POST['reason']) > 0) {
        echo '<p>Reasons for contacting us:</p>';
        echo '<ul>';
        foreach ($_POST['reason'] as $reason) {
            echo "<li>$reason</li>";
        }
        echo '</ul>';
    }
}

//printf('<p>We can contact you by %s</p>', join(', ', $_POST['contact_method']));
//printf('You %s want to subscribe to our newsletter', $_POST['newsletter'] === 'yes' ? '' : 'do not');

if (isset($_FILES['uploadedFile']) && is_uploaded_file($_FILES['uploadedFile']['tmp_name'])) {
    $uploadedFile = $_FILES['uploadedFile']['tmp_name'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $uploadedFile);
    $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
    if (!in_array($mimeType, $allowedTypes)) {
        die('Invalid file format!');
    }
    $uploadFolder = 'uploads/';
    $uniqueId = time() . uniqid(rand());
    $origName = pathinfo($_FILES['uploadedFile']['name'])['filename'];
    $ext = pathinfo($_FILES['uploadedFile']['name'])['extension'];
    $destFile = $uploadFolder . $origName . "_$uniqueId." . $ext;
    if (move_uploaded_file($uploadedFile, $destFile)) {
        echo "<p>File uploaded successfully.</p>";
    } else {
        echo "<p>There was an error uploading the file.</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Using Forms</title>
</head>

<body>
    <h3>Contact Us</h3>
    <form enctype="multipart/form-data" name="contact_form" method="POST" action="index.php">
        <label for="email" style="display: inline-block; width: 100px;">Email</label>
        <input type="email" id="email" name="email" value="<?= $email ?>"><br><br>
        <label for="reason" style="display: inline-block; width: 100px;">Query Type</label>
        <select name="reason[]" multiple>
            <option name="tech_support">Technical Support</option>
            <option name="sales">Sales</option>
            <option name="bug">Bug Report</option>
            <option name="general">General</option>
        </select><br><br>
        <label for="contact_method" style="display: inline-block; width: 100px;">Contact me by</label>
        <input type="checkbox" name="contact_method[]" value="email">Email
        <input type="checkbox" name="contact_method[]" value="phone">Phone
        <input type="checkbox" name="contact_method[]" value="sms">SMS
        <input type="checkbox" name="contact_method[]" value="whatsapp">WhatsApp
        <br><br>
        <label for="newsletter" style="display: inline-block; width: 100px">Subscribe to Newsletter</label>
        <input type="radio" name="newsletter" value="yes">Yes
        <input type="radio" name="newsletter" value="No" checked>No
        <br><br>
        <label for="comments" style="display: inline-block; width: 100px;">Comments</label>
        <textarea id="comments" name="comments"><?= $comments ?></textarea><br>
        <input type="file" name="uploadedFile" accept="image/png, image/jpeg, image/gif"> (Max Size:
        <?= $maxSize ?>)
        <br><br>
        <label style="display: inline-block; width: 100px;"></label>
        <input type="submit" value="Send">
    </form>
</body>

</html>

//  1:55 Lesson 10