<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SharingNotif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($foto, $str, $subjek)
    {
        $this->foto = $foto;
        $this->tindakan = $str;
        $this->subjek = $subjek;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.sharing-notif')
                    ->with([
                        'foto' => $this->foto,
                        'tindakan' => $this->tindakan,
                        'subjek' => $this->subjek,
                    ]);
    }
}
