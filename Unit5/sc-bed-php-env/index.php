<?php
var_dump($_POST);

$email = '';
$comments = '';
$maxSize = ini_get('upload_max_filesize');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST)['email'] && $_POST['email'] !== '') {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        }  else {
            $errors[] = "Email address is invalid.";
        }

    } else {
        $errors[] = "Email address is missing";
    }

    $comments = $_POST['comments'];
    // Validate Comments
    if (empty($comments)) {
        // Comment is empty, display an error message or take appropriate action
        echo '<p style="color: red;">Please enter a comment</p>';
    } else {
        // Comment is not empty, proceed with further processing
        printf('<p>Received email: %s and comments %s</p>', $email, $comments);
    }

    if (count($errors) === 0) {
        printf('<p>Received email %s ad comments %s </p>', $email, $comments)
        if (isset($_POST['reason']) > 0) {
            echo '<p>Reasons for contacting us:</p>';
            echo '<ul>';
            foreach ($_POST['reason'] as $reason) {
                echo "<li>$reason</li>";
            }
            echo '</ul>';
        }
    }
    
    printf('<p>We can contact you by %s</p>', join(', ', $_POST['contact_method']));
    printf('You %s want to subscribe to our newsletter', $_POST['newsletter'] === 'yes' ? '' : 'do not');
    
    }


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
<?php if (count($errors) > 0) { ?>     
    <div id="error_alert" style="display: block; background-color: #e3767d; border-radius: 5px; max-width: 400px; padding: 5px;">         
    <?php             
    foreach($errors as $error) {                 
        echo "<li>$error</li>";             
        }         
        ?>     
        </div>     
        <?php } ?>

        <style>         
        .validation_message {             
            font-size: small;            
            font-style: italic;             
            color: red;             
            margin: 0;             
            display: none;         
            }         
            .validation_invalid {             
                outline: 1px solid red;         
            }     
        </style>

    <h3>Contact Us</h3>
    <form id = "contactForm" enctype="multipart/form-data" name="contact_form" method="POST" action="index.php">
        <label for="email" style="display: inline-block; width: 100px;">Email</label>
        <input type="email" id="email" name="email" value="<?= $email ?>"><br><br>
        <p class="validation_message">Please enter a valid email address.</p> 
        <label for="reason" style="display: inline-block; width: 100px;">Query Type</label>
        <select name="reason[]" multiple>
            <option name="tech_support">Technical Support</option>
            <option name="sales">Sales</option>
            <option name="bug">Bug Report</option>
            <option name="general">General</option>
        </select>
        <p class="validation_message">Please choose one or more reasons for your query.</p> 
        <br><br>
        <label for="contact_method" style="display: inline-block; width: 100px;">Contact me by</label>
        <input type="checkbox" name="contact_method[]" value="email">Email
        <input type="checkbox" name="contact_method[]" value="phone">Phone
        <input type="checkbox" name="contact_method[]" value="sms">SMS
        <input type="checkbox" name="contact_method[]" value="whatsapp">WhatsApp
        <p class="validation_message">Please tell us how you'd like us to get back to you.</p> 
        <br><br>
        <label for="newsletter" style="display: inline-block; width: 100px">Subscribe to Newsletter</label>
        <input type="radio" name="newsletter" value="yes">Yes
        <input type="radio" name="newsletter" value="No" checked>No
        <p class="validation_message">Please enter your query.</p> 
        <br><br>
        <label for="comments" style="display: inline-block; width: 100px;">Comments</label>
        <textarea id="comments" name="comments"><?= $comments ?></textarea><br>
        <input type="file" name="uploadedFile" accept="image/png, image/jpeg, image/gif"> (Max Size:
        <?= $maxSize ?>)
        <br><br>
        <label style="display: inline-block; width: 100px;"></label>
        <input type="submit" value="Send">
    </form>
    <script>
    document.getElementById('contactForm').addEventListener('submit', validateForm); 
    
    function validateForm(evt) {
        let contains_errors = false;         
        // Reset validation         
        messages = document.getElementsByClassName('validation_message');         
        Array.from(messages).forEach((el) => {             
            el.style.display = 'none';         
        });         
        invalid = document.getElementsByClassName('validation_invalid');         
        Array.from(invalid).forEach((el) => {             
            el.classList.remove('validation_invalid');         
        });         
        // Email         
        const re = GET_FROM_GIST;         
        const email = document.getElementById('email');         
        if (email.value === '' || !re.test(email.value.toLowerCase())) {             
            contains_errors = true;             
            email.classList.add('validation_invalid');             
            getNextSibling(email, '.validation_message').style.display = 'block';         
        }         
        
        // Query Type         
        const selected = document.querySelectorAll('#reason option:checked');        
        const values = Array.from(selected).map(el => el.value);         
        if (values.length === 0) {             
            contains_errors = true;             
            const reason = document.getElementById('reason');             
            reason.classList.add('validation_invalid');             
            getNextSibling(reason, '.validation_message').style.display = 'block';         
        }         
        // Contact Method         
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');         
        const checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);         
        if (!checkedOne) {             
            contains_errors = true;             
            for (checkbox of checkboxes) {                
                checkbox.classList.add('validation_invalid');             
            }             
            getNextSibling(checkboxes[0], '.validation_message').style.display = 'block';

            // Comments         
            const comments = document.getElementById('comments');         
            if (comments.value === '') {             
                contains_errors = true;             
                comments.classList.add('validation_invalid');             
                getNextSibling(comments, '.validation_message').style.display = 'block';         
            }         if (contains_errors) {             
                evt.preventDefault();         
            }     
        }    
        const getNextSibling = function (elem, selector) {         
            // Get the next sibling element         
            var sibling = elem.nextElementSibling;         
            // If there's no selector, return the first sibling         
            if (!selector) return sibling;         
            // If the sibling matches our selector, use it         
            // If not, jump to the next sibling and continue the loop         
            while (sibling) {             
                if (sibling.matches(selector)) return sibling;                 
                    sibling = sibling.nextElementSibling             
            }            
        }; 
    }


    </script>
</body>

</html>