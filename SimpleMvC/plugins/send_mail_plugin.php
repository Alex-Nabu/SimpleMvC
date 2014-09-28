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
	  $MessageHTML = $params['MESSAGE'];
	  $MessageTEXT = "Message Cannot be displayed.";
	  
  // --------------------------------------------------------------------------
  
  $Mail = new \SimpleMvC\plugins\libs\PHPmailer\PHPmailer;
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
  $Mail->Subject     = 'Test Email Using Gmail';
  $Mail->ContentType = 'text/html; charset=utf-8\r\n';
  $Mail->From        = 'king.xanda@gmail.com';
  $Mail->FromName    = 'GMail Test';
  $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

  $Mail->AddAddress( $ToEmail ); // To:
  $Mail->isHTML( TRUE );
  $Mail->Body    = $MessageHTML;
  $Mail->AltBody = $MessageTEXT;
  $Mail->Send();
  $Mail->SmtpClose();

  if ( $Mail->IsError() ) // ADDED - This error checking was missing
  {
  	// var_dump($Mail->ErrorInfo);
    return FALSE;
  }
  else 
  {
    return TRUE;
  }

}

?>
