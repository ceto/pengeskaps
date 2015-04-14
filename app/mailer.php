<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = strip_tags(trim($_POST["form__name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        
        $email = filter_var(trim($_POST["form__email"]), FILTER_SANITIZE_EMAIL);

        $tel = strip_tags(trim($_POST["form__tel"]));
        $tel = str_replace(array("\r","\n"),array(" "," "),$tel);

        $message = trim($_POST["form__message"]);

        // Check that data was sent to the mailer.

        if ( empty($name) OR empty($email) ) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! Name and email are required!";
            exit;
        }

        if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! Email is invalid.";
            exit;
        }

        // Set the recipient email address.
        $recipient = "cff@eiendomsmegler1.no";

        // Set the email subject.
        $subject = "Pengeskapsfabrikken contact from $name";
        
        $subject2 = "Takk for din henvendelse.";
        $email_content2="Du er nå registrert som interessent i boligprosjektet Pengeskapsfabrikken.\nVi jobber nå med utarbeidelse av hjemmeside og prospekt.\nSom registrert interessent holder vi deg fortløpende orientert om fremdriften.";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Tel: $tel\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";
        
        $email_headers2  = "From: Christian Fr. Foss <$recipient>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Takk for din henvendelse.";

            $txt = "emails/data.txt"; 
            $fh = fopen($txt, 'a'); 
            $txt=date("F j, Y, g:i a").' | '.$name.' | '.$email.' | '.$tel.' | '.str_replace(array("\r","\n"),array(" "," "),$message).PHP_EOL; 
            fwrite($fh,$txt);
            fclose($fh);

            //confirmation email
            mail($email, $subject2, $email_content2, $email_headers2);




        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
