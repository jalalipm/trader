<?php

return [
    'android' => [
        "download_url" => "android",
        "version_name" => "1.0.0",
        "version_code" => 1,
        "min_version_code" => 1,
        "invite_message" => "از بازار ، اپلیکیشن سپارش رو نصب کن و باهاش خرید کن . اینم لینکش : https://cafebazaar.ir/app/com.separesh.app.trader",
        "changelog" => "بهبود رابط کاربری##افزودن درگاه بانک ملت##رفع برخی باگ های جزئی",
        // "view_type" => 4
    ],
    'ios' => [
        "download_url" => "ios",
        "version_name" => "1.0.0",
        "version_code" => 1,
        "min_version_code" => 0,
        "invite_message" => "",
        "changelog" => "بهبود رابط کاربری##افزودن درگاه بانک ملت##رفع برخی باگ های جزئی"

    ],
    'general' => [
        "firebase_topics_name" => "trade",
        "firebase_url" => "https://fcm.googleapis.com/fcm/send",
        "firebase_authorization_web" => "Authorization: key=AAAA3QMp_DM:APA91bGgjXMuVK3FhOHy5LWoOHoe7SD6w7F90M6LcFMEiGw_dk44hPMYidZEMGjReTUclaLKLriHVUuPaWZT8QjYcXmZGTsQYM4YqQSKkdwiIbIaVNmf283RBHdH6Q8VgN1oCJULZ4Hy",
        "firebase_authorization_app" => "Authorization: key=AAAABZqJadg:APA91bGg7ZsEjwQc_DPTs6z2NX69AjzAQYRjtLyElsG99UafcNbQbikES4uMIZtBdkBfBFLrT0G_xgfmkKrDpCZmv5nk83kqWlSC5w5n4MwSNCQYZl1TK8-h8_PTMfluq1JB5ZOGzH0F"
    ],
    'public' => [
        'call_number' => "02175239000",
        'separesh_url' => "https://trade.separesh.shop/about.html",
        'about_url' => "https://trade.separesh.shop/about.html",
        "firebase_topic" => "trade",
        "payment_url" => "https://trade.shop/payment/beefkaa/getway.php",
        "condition_terms_url" => "http://www.3paresh.com/TermCondition.html",
        "min_group_count" => 5
    ],
];
