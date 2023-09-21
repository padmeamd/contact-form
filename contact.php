<?php

$name = htmlspecialchars($_POST["name"]);
$email = htmlspecialchars($_POST["email"]);
$message = htmlspecialchars($_POST["message"]);

$recipient_email = "dashaday.web@gmail.com";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (mb_strlen($name) >= 1) {
        if (mb_strlen($message) >= 1) {
            $data = array(
                'secret' => "0x57Cc5Ff92c8DFE66F5675CE2234C84725025c85B",
                'response' => $_POST['h-captcha-response']
            );
         
            $verify = curl_init();
             curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
             curl_setopt($verify, CURLOPT_POST, true);
             curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
             curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
             $response = curl_exec($verify);
         
             /*var_dump($response);*/
         
             $responseData = json_decode($response);
         
             if ($responseData->success) {
                 if (mail($recipient_email, "New contact form sent.", "Name: ".$name.".\nEmail: ".$email."\nMessage: ".$message.".") ) {
                    echo "<p>Your message was sent successfully!:)</p>";
                     echo '<br><p><a href="/">Get back to the website</a></p>';
                 } else {
                     echo "<p>Your email cannot be send. Please, try again later.</p>";
                     echo '<br><p><a href="/contact.html">Get back</a></p>';
                 }
             } else {
                 echo "<p>Please, fill the anti-bot checkbox.</p>";
                 echo '<br><p><a href="/contact.html">Get back</a></p>';
             }
        } else {
            echo "<p>Please, enter your message.</p>";
            echo '<br><p><a href="/contact.html">Get back</a></p>';
        }
    } else {
        echo "<p>Please, enter your name.</p>";
        echo '<br><p><a href="/contact.html">Get back</a></p>';
    }
} else {
    echo "<p>Please, enter valid email.</p>";
    echo '<br><p><a href="/contact.html">Get back</a></p>';
}
?>