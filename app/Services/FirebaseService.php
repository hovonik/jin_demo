<?php

namespace App\Services;

class FirebaseService
{
    public static function sendOrderNotification($data)
    {
        $headers = [
            'Authorization: key=' . getenv('FIREBASE_SERVER_KEY'),
            'Content-Type: application/json',
        ];
        $data = json_encode($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            return false;
        }

        // Close connection
        curl_close($ch);
        return true;
    }
}
