<?php 

defined('SYSPATH') or die('No direct script access.');

define('ROOT', realpath(APPPATH.'..')."/");

set_include_path(get_include_path().
	PATH_SEPARATOR.
	APPPATH);
//echo (get_include_path());
require_once('phpqrcode/classes/qrlib.php');

define('QR_DIR', ROOT.'qrs/');

class Controller_Qrtest extends Controller
{
	
	/**
	 * 
	 * NEW ADVERTISEMENT 
	 * 
	 */
	public function action_index() {
	

	  
    // here our data 
    $name         = 'John Doe'; 
    $sortName     = 'Doe;John'; 
    $phone        = '(049)012-345-678'; 
    $phonePrivate = '(049)012-345-987'; 
    $phoneCell    = '(049)888-123-123'; 
    $orgName      = 'My Company Inc.'; 

    $email        = 'john.doe@example.com'; 

    // if not used - leave blank! 
    $addressLabel     = 'Our Office'; 
    $addressPobox     = ''; 
    $addressExt       = 'Suite 123'; 
    $addressStreet    = '7th Avenue'; 
    $addressTown      = 'New York'; 
    $addressRegion    = 'NY'; 
    $addressPostCode  = '91921-1234'; 
    $addressCountry   = 'USA'; 

    // we building raw data 
    $codeContents  = 'BEGIN:VCARD'."\n"; 
    $codeContents .= 'VERSION:2.1'."\n"; 
    $codeContents .= 'N:'.$sortName."\n"; 
    $codeContents .= 'FN:'.$name."\n"; 
    $codeContents .= 'ORG:'.$orgName."\n"; 

    $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n"; 
    $codeContents .= 'TEL;HOME;VOICE:'.$phonePrivate."\n"; 
    $codeContents .= 'TEL;TYPE=cell:'.$phoneCell."\n"; 

    $codeContents .= 'ADR;TYPE=work;'. 
        'LABEL="'.$addressLabel.'":' 
        .$addressPobox.';' 
        .$addressExt.';' 
        .$addressStreet.';' 
        .$addressTown.';' 
        .$addressPostCode.';' 
        .$addressCountry 
    ."\n"; 

    $codeContents .= 'EMAIL:'.$email."\n"; 

    $codeContents .= 'END:VCARD'; 
    
    // generating 
    $fname = '1';
    $qr_path=    QR_DIR.$fname.'.png';
    echo("Writing to $qr_path...");

    $f=  QRcode::png($codeContents, $qr_path, QR_ECLEVEL_L, 3);      
    	   echo("[".$f."]");
	   die();
 	}

}
