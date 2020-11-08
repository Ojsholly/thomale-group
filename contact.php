<?php
session_start();

$errors = [];
$errorMessage = '';

if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($phone)) {
        $errors[] = 'Phone is empty';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }

    if (empty($errors)) {
        $toEmail = 'olusolaojewunmi@gmail.com';
        $emailSubject = 'New message from '.$name;
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["Name: {$name}", "Email: {$email}", "Phone: {$phone}", "Message:", $message];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            $_SESSION['response'] = '<div class="alert alert-success">Your Message has been successfully delivered. We will be in touch with you shortly.</div>';
            echo "<script>
                    window.location.href = 'index.html#form';
                </script>";
        } else {
            $_SESSION['response'] = '<div class="alert alert-danger">Your Message was not delivered. Please try again.</div>';
            echo "<script>
                    window.location.href = 'index.html#form';
                </script>";
        }
    } else {
        $allErrors = join('<br/>', $errors);
        $_SESSION['response'] = "<p style='color: red;'>{$allErrors}</p>";
        echo "<script>
                    window.location.href = 'index.html#form';
                </script>";
    }
}

?>