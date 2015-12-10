<?php
defined('SYSPATH') or die('No direct script access.');

set_include_path(get_include_path().
	PATH_SEPARATOR.
	APPPATH);
//echo (get_include_path());
require_once('phpqrcode/classes/qrlib.php');

class Qr {
   private $ad;
   private $id;
   private $dir;
   private $user;
   private $name;
   private $email;

   public function __construct($id) {
        $this->id = $id;
        $this->ad=          new Model_Ad($id);

	$this->dir = QR_DIR.$id."/";
	$this->user = ORM::factory('user');
	$user_id = $this->ad->id_user;
	$this->user =$this->user->where('id_user','=',$user_id)->find();
	$this->email = $this->user->email;
	$this->name = $this->user->name;
    //	echo($this->ad->id_user.":".$this->email.":".$this->name);
   }
  
  public function reset() {
     if (is_dir($this->dir)) {
       array_map('unlink', glob($this->dir."*"));
        } else {
	   mkdir($this->dir);
       }
  }   


   public function website() {
      $site = trim($this->ad->website);
      if (!$site) {
	   $this->log("No website, will not create URL QR.");
           return false;
      }
      if (strpos("http://", $site) != 0) {
         $site = "http://".$site; 
      }
      return $this->doTheNeedful('website',$site);
   }

   private function log($s) {
  	  Kohana::$log->add(Log::INFO, "Ad $this->id: ".$s);
   }

   
   public function calendar() {
       $cus_cols = $this->ad->custom_columns();
       if (!$cus_cols) {
          $this->log("No start or end info, will not create Calendar QR.");
	  return false;
       }
       $start = NULL;
       $end = NULL;
//       var_dump($cus_cols);
       foreach ($cus_cols as $key=>$value) {
          if ($key == "cf_starts") {
	      $start = $cus_cols[$key]['value'];
	  } else if ($key == "cf_ends") {
	      $end = $cus_cols[$key]['value'];
	  } 
       }

       if (!$start || !$end) {
          $this->log("No start or end info, will not create Calendar QR.");
	  return false;
      }
      $start= str_replace("-","",$start);
      $start= str_replace(":","",$start);
      $start= str_replace(" ","T",$start);

      $end= str_replace("-","",$end);
      $end= str_replace(":","",$end);
      $end= str_replace(" ","T",$end);

      $phone = trim($this->ad->phone);
      $address = trim($this->ad->address);
      $title = trim($this->ad->title);
      $desc = trim($this->ad->description);
      $email = $this->email;
      $name= $this->name;
      $data = "BEGIN:VEVENT\n";
      $data .= "DTSTART:$start\n";
      $data .= "DTEND:$end\n";
      $data .= "SUMMARY:$title\n";
      if ($address) {
         $data .= "LOCATION:$address\n";
      }
      $data .= "DESCRIPTION:$desc\n";
      $data .= "END:VEVENT";
      echo($data);
      $retval = $this->doTheNeedful('calendar',$data);
      echo($retval);
      return $retval;
   }

   public function contact() {
          // we building raw data 
	 $phone = trim($this->ad->phone);
	 $address = trim($this->ad->address);
	 $email = $this->email;
	 $name= $this->name;

	 if (!$phone && !$address && !$email) {
	   $this->log("No phone, email or address, will not create contact QR.");
	 }

	 $name_split = explode(" ",$name);
	 $last_name = array_pop($name_split);
	 array_unshift($name_split, $last_name);
	 $sortName = implode(";", $name_split);

        $codeContents  = 'BEGIN:VCARD'."\n"; 
        $codeContents .= 'VERSION:2.1'."\n"; 
        $codeContents .= 'N:'.$sortName."\n"; 
        $codeContents .= 'FN:'.$name."\n"; 
	// $codeContents .= 'ORG:'.$orgName."\n"; 
        if ($phone) {
           $codeContents .= 'TEL;TYPE=cell:'.$phone."\n"; 
        }
        
        if ($address) {
          $codeContents .= 'ADR;TYPE=work;'. 
         'LABEL="'.
	 $name.
	 '":'.
	 $address.
	 "\n"; 
        }
	if ($email) {
	        $codeContents .= 'EMAIL:'.$email."\n"; 
		}

      $codeContents .= 'END:VCARD'; 
      return $this->doTheNeedful('contact',$codeContents);
   }

   private function doTheNeedful($type, $payload) {
      $qr_path = $this->dir.$this->id."_".$type.".png";
      $this->log("Writing to $qr_path...");
      $f = QRcode::png($payload, $qr_path, QR_ECLEVEL_H, 4);      
      return $qr_path;
}       
   
   public function qr() {
     $retval = array();
     $retval[] = $this->website();
     $retval[] = $this->contact();
     return $retval;
   }
}
?>