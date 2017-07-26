<?php
if (!isset($_POST['Submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
    exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
} else {
    $exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
    $profanity = "/(beastial|bestial|blowjob|clit|cock|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
    $spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
    $bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";

    if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
        exit("<p>Known spam bots are not allowed.</p>");
    }
    foreach ($_POST as $key => $value) {
        $value = trim($value);

        if (empty($value)) {
            exit("<p>Empty fields are not allowed. Please go back and fill in the form properly.</p>");
        } elseif (preg_match($exploits, $value)) {
            exit("<p>Exploits/malicious scripting attributes aren't allowed.</p>");
        } elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
            exit("<p>That kind of language is not allowed through our form.</p>");
        }

        $_POST[$key] = stripslashes(strip_tags($value));
    }

    if (!ereg("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,6})$",strtolower($_POST['email']))) {
        exit("<p>That e-mail address is not valid, please use another.</p>");
    }

    $recipient = "info@gageinternational.org";
    $subject = "Message from gageinternational.org";

    $message = "You've received an e-mail through your website mail form: \n";
    $message .= "Name: {$_POST['name']} \n";
    $message .= "E-mail: {$_POST['email']} \n";
	$message .= "Company: {$_POST['company']} \n";
    $message .= "Tel: {$_POST['tel']} \n";
    $message .= "Message: {$_POST['message']} \n";

    $headers = "From: gageinternational.org <$recipient> \n";
    $headers .= "Reply-To: <{$_POST['email']}>";

    if (mail($recipient,$subject,$message,$headers)) {
       // echo "<p>Thank you! Your mail was successfully sent. Thank you for your time.</p>";
		header("location:http://www.inviziononline.com/shadypines/site/contactSuccess.html");

    } else {
        //echo "<p>Sorry, there was an error and your mail was not sent. Please find an alternative method of contacting the webmaster.</p>";
          header("location:http://www.inviziononline.com/shadypines/site/contactError.html");

	}
}
?>
