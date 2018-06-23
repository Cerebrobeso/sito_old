<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="bower_components/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
</head>
<body>
    <?php
    if(isset($_POST['email'])) {

        // EDIT THE 2 LINES BELOW AS REQUIRED
        $email_to = "stefanosilvestro@gmail.com";
        $email_subject = "Your email subject line";

        function died($error) {
            // your error code can go here
            echo "We are very sorry, but there were error(s) found with the form you submitted. ";
            echo "These errors appear below.<br /><br />";
            echo $error."<br /><br />";
            echo "Please go back and fix these errors.<br /><br />";
            die();
        }


        // validation expected data exists
        if(!isset($_POST['name']) ||
            !isset($_POST['email']) ||
            !isset($_POST['comments'])) {
            died('We are sorry, but there appears to be a problem with the form you submitted.');       
        }



        $first_name = $_POST['name']; // required
        $email_from = $_POST['email']; // required
        $comments = $_POST['comments']; // required

        $error_message = "";
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
        }

        $string_exp = "/^[A-Za-z .'-]+$/";

        if(!preg_match($string_exp,$first_name)) {
        $error_message .= 'The First Name you entered does not appear to be valid.<br />';
        }



        if(strlen($comments) < 2) {
        $error_message .= 'The Comments you entered do not appear to be valid.<br />';
        }

        if(strlen($error_message) > 0) {
        died($error_message);
        }

        $email_message = "Form details below.\n\n";


    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }



    $email_message = "Nome: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Testo: ".clean_string($comments)."\n";

    // create email headers
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);  


    if (@mail == true){ ?>
        <script language="javascript" type="text/javascript">
            swal({
                title: 'success',
                text: 'thank you',
                type: 'success'
            })
            window.location = '../site-it/contact-it.html';
        </script>
    <?php } else { ?>
        <script language="javascript" type="text/javascript">
            swal({
                title: "Error!",
                text: "Message not sent. Please, notify the site administrator admin@admin.com",
                type: "error"
            });
            window.location = '../site-it/contact-it.html';
        </script>
    <?php

        }
    }
    ?>
</body>
</html>