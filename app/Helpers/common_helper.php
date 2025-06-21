<?php

function bangla_day($day)
{
    $days = [
        'Saturday' => 'শনিবার',
        'Sunday' => 'রবিবার',
        'Monday' => 'সোমবার',
        'Tuesday' => 'মঙ্গলবার',
        'Wednesday' => 'বুধবার',
        'Thursday' => 'বৃহস্পতিবার',
        'Friday' => 'শুক্রবার'
    ];

    return $days[$day] ?? $day;
}
