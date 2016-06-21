<?php
/**
 * Created by PhpStorm.
 * User: pumi
 * Date: 6/21/2016
 * Time: 10:41 AM
 */
class Utility {

    public static function addMailLog($from_email, $from_name, $to_email, $to_name, $subject, $message, $entry, $type){

        $mailLog = new MailLog();

        $mailLog->from_email = $from_email;
        $mailLog->from_name = $from_name;
        $mailLog->to_email = $to_email;
        $mailLog->to_name = $to_name;
        $mailLog->subject = $subject;
        $mailLog->message = $message;
        $mailLog->entry_date = date('Y-m-d h:i:s');
        $mailLog->entry = $entry;
        $mailLog->type = $type;

        if ($mailLog->save()) {

            return true;

        } else {

            print_r($mailLog->getErrors());
            return false;
        }
    }
}