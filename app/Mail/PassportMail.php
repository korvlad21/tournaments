<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PassportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $image;
    protected $filename;
    protected $passport;
    protected $username;
    protected $slug;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($image, $filename, $passport, $username, $slug)
    {
        $this->image = $image;
        $this->filename = $filename;
        $this->passport = $passport;
        $this->username = $username;
        $this->slug = $slug;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.passport')->with([
            'passport'=> $this->passport,
            'username' => $this->username,
            'slug' => $this->slug,
        ])->subject('Подтверждение пользователя!!!')->attach($this->image, [
            'as' => $this->filename,
        ]);
    }
}
