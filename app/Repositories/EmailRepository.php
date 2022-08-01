<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Models\KeyValue;
use Mailgun\Mailgun;
use Exception;

class EmailRepository
{

  public function CheckMailSent($to, $failures, $mailName, $userName)
  {
    if (count($failures) > 0) {

      Log::stack(['single'])->error("[Mail ERROR] : email " . $mailName . ": There was one or more failures: ");
      foreach ($failures as $email_address) {
        Log::stack(['single'])->debug(" - " . $email_address);
      }
    } else {
      if (is_array($to)) {
        $email_list = implode(',', $to);
      } else {
        $email_list = $to;
      }
      Log::stack(['single', 'stdout'])->debug("[Mail] : email " . $mailName . " Sent Successfully to " . $email_list . ". Action made by <" . $userName . ">");
    }
  }

  public function cleanMailList($emails)
  {
    $emailsArray = explode(',', $emails);

    foreach ($emailsArray as $email) {
      Log::stack(['single', 'stdout'])->debug("ORIGIN: <" . $email . ">");
    }

    $cleanedEmails = array_map('trim', $emailsArray);

    foreach ($cleanedEmails as $email) {
      Log::stack(['single', 'stdout'])->debug("CLEANED: <" . $email . ">");
    }

    return $cleanedEmails;
  }

  public function validateEmails($emails)
  {
    foreach ($emails as $email) {

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Log::stack(['single'])->debug("L'adresse email '$email' est considérée comme invalide.");
        throw new Exception("L'adresse email '$email' est considérée comme invalide.");
        return false;
      }
    }
    return true;
  }

  /**
   * get the value of the key parameter, if not found, we will get back the key.
   */
  public function getKeyValue($key)
  {
    $keyValue = KeyValue::where('key', $key)->first();
    $value = ($keyValue != null) ? $keyValue->value : $key;
    return $value;
  }

  public function sendMailGun($data, $html)
  {
    $mg = Mailgun::create(env('MAILGUN_KEY'), env('MAILGUN_API_URL'));


    $options  = [
      "o:tracking"        => "yes",
      "o:tracking-clicks" => "yes",
      "o:tracking-opens"  => "yes",
      'html'              => $html
    ];
    $msgData = array_merge($data, $options);
    // Log::stack(['single'])->debug("[Mail] : msgdata1 " . $msgData["o:tracking"] . " - " . $msgData['subject']);

    $response      =  $mg->messages()->send(env('MAILGUN_DOMAIN'), $msgData);
    $message_id    = $response->getId();
  }

  public function GetListBccMails($applications)
  {
    $compteur = 0;
    $bcclist = "";

    foreach ($applications as $row) {
      if ($compteur < (count($applications) - 1)) {
        $bcclist .= $row->parentemail . ",";
      } else {
        $bcclist .=  $row->parentemail;
      }
      $compteur++;
    }

    return $bcclist;
  }

  public function generatePassword()
  {
    //Add password to user otherwise the user has no password until membership confirmed
    $str_result = '**$$$$####???????0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    // Shufle the $str_result and returns substring
    // of specified length
    $userPassword =  substr(str_shuffle($str_result),  0, 12);
    return $userPassword;
  }
}
