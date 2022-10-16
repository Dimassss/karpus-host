<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainPageController extends Controller
{
    public function render(){

        if(view()->exists('welcome-compiled')) return view('welcome-compiled')->render();

        return view('welcome');
    }

    public function sendMail(Request $req){
        $from_name = $req->name;
        $from_telephone = $req->telephone;
        $from_email = $req->email;
        $from_message = $req->message;

        $to_name = 'Александр Балюра';
        $to_email = 'admin@karpus.com.ua';
        $data = array(
            'name' => $from_name,
            'email' => $from_email,
            'telephone' => $from_telephone,
            'body' => $from_message
        );

        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $from_name, $from_email, $from_telephone, $from_message) {
            $msg = 'Name: '.$from_name.'\n Telephone: '.$from_telephone.'\n Email: '.$from_email.'\n'.$from_message;

            $message->to($to_email, $to_name)->subject('KARPUS HOST');
            $message->from($from_email, 'KARPUS HOST');
        });
    }
}
