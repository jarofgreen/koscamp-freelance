<?php
    /**
    * o------------------------------------------------------------------------------o
    * | This package is licensed under the Phpguru license. A quick summary is       |
    * | that for commercial use, there is a small one-time licensing fee to pay. For |
    * | registered charities and educational institutes there is a reduced license   |
    * | fee available. You can read more  at:                                        |
    * |                                                                              |
    * |                  http://www.phpguru.org/static/license.html                  |
    * o------------------------------------------------------------------------------o
    *
    * © Copyright 2008,2009 Richard Heyes
    */

    /**
    * This example shows you how to create an email with another email attached
    */

    require_once('Rmail.php');
    
    /**
    * Create the attached email
    */
   /*
   $attachment = new Rmail();
    $attachment->setFrom('Bob <mohammad.m4jid@gmail.com>');
    $attachment->setText('This email is attached.');
    $attachment->setSubject('This email is attached.');
    $body = $attachment->getRFC822(array('mohammad.m4jid@gmail.com'));

    /**
    * Now create the email it will be attached to
    */
    $mail = new Rmail();
    //$mail->addAttachment(new StringAttachment($body, 'Attached message', 'message/rfc822', new SevenBitEncoding()));
    // this will attach documents.
	$mail->addAttachment(new FileAttachment('example.zip'));
	$mail->addAttachment(new FileAttachment('My Job.doc'));
    
	//who is send the email
	$mail->setFrom('Richard <mohammad.m4jid2@gmail.com>');
    $mail->setSubject('Test email');
    // body of the text
	$mail->setText('Sample text');
   
   	$result  = $mail->send($addresses = array('mohammad.m4jid@gmail.com'));
?>

Message has been sent to: <?php echo implode(', ', $addresses)?>