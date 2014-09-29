<?php
namespace SimpleMvC\plugins;

/**
 * @todo figure out y the class wont just psr4 autoload 'using' the correct NS
 */

use SimpleMvC\plugins\libs\PHPmailer;

function send_mail(array $params)
{

  							// Setup vars
  // --------------------------------------------------------------------------	
  
	  $ToEmail = $params['TO'];
	  $FromEmail = $params['FROM'];
	  $MessageHTML = $params['MESSAGE'];
	  $MessageTEXT = "Message Cannot be displayed.";
	  $MessageSubject = $params['SUBJECT'];
	  
  // --------------------------------------------------------------------------
  
  $Mail = new \SimpleMvC\plugins\libs\PHPmailer\phpmailer;
  $Mail->PluginDir = core_directory.'/plugins/libs/PHPmailer/';
  $Mail->IsSMTP(); // Use SMTP
  $Mail->Host        = "smtp.gmail.com"; // Sets SMTP server
  //$Mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
  $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
  $Mail->SMTPSecure  = "tls"; //Secure conection
  $Mail->Port        = 465; // set the SMTP port
  $Mail->Username    = 'king.xanda@gmail.com'; // SMTP account username
  $Mail->Password    = 'y2324me4u'; // SMTP account password
  $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
  $Mail->CharSet     = 'UTF-8';
  $Mail->Encoding    = '8bit';
  $Mail->Subject     = $MessageSubject;
  $Mail->ContentType = 'text/html; charset=utf-8\r\n';
  $Mail->From        = $FromEmail;
  $Mail->FromName    = $FromEmail;
  $Mail->WordWrap    = 400; // RFC 2822 Compliant for Max 998 characters per line

  $Mail->AddAddress( $ToEmail ); // To:
  $Mail->isHTML( TRUE );
  $Mail->Body    = $MessageHTML;
  $Mail->AltBody = $MessageTEXT;
  $Mail->Send();
  $Mail->SmtpClose();

  if ( $Mail->IsError() ) // ADDED - This error checking was missing
  {
  	error_log($Mail->ErrorInfo);
    return FALSE;
  }
  else 
  {
    return TRUE;
  }

}

?>
