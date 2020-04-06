<?php

use App\Channel;
use App\Template;
use Illuminate\Database\Seeder;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channel_email = Channel::where('code','email')->first();
        Template::updateOrCreate([
            'channel_id'    => $channel_email->id,
            'code'          => 'simple_reset_password'
        ], [
            'name'          => 'Reset Password',
            'description'   => 'Template untuk merubah katasandi',
            'template'      => ('<p>Hai [name],</p> <p>Sistem kami mendeteksi permintaan perubahan kata sandi untuk email <strong>[email]</strong>.</p> <p>Silahkan klik tombol dibawah ini untuk melanjutkan permintaan Anda. <a href="http://login.com">Login</a> <br><br>Terima kasih,</p>')
        ]);
        Template::updateOrCreate([
            'channel_id'    => $channel_email->id,
            'code'          => 'success_reset_password'
        ], [
            'name'          => 'Berhasil merubah password',
            'description'   => 'Template password berhasil diubah',
            'template'      => ('<p>Hai [name],</p> <p>Katasandi untuk <strong>[email]</strong> telah berhasil diubah.</p> <p>Terima kasih,</p>')
        ]);

        Template::updateOrCreate([
            'channel_id'    => $channel_email->id,
            'code'          => 'tes_mail'
        ], [
            'name'          => 'Testing Email Template',
            'description'   => 'Template testing email',
            'template'      => ('<p>Hai [email],</p>
            <p>Ini adalah email testing dari Alter Notification.</p>
            <p><a href="https://alterindonesia.com">Klik Tombol</a></p>
            <p><img src="https://alterindonesia.com/front/images/logo.png" width="200" alt="Ini adalah deskripsi gambar"></p>
            ')
        ]);
    }
}
