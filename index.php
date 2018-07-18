<?php
use Sabre\VObject;

include 'vendor/autoload.php';

$url ="https://meinsack.click/v1/70193/H%C3%B6lderlinplatz/";


data_to_cal($url);


function data_to_cal($url) {

    $reminder = '-PT12H';

    $cal = new VObject\Component\VCalendar();
    $cal->add('X-WR-CALNAME','Abholtermine Gelber Sack');
    $cal->add('X-APPLE-CALENDAR-COLOR', '#FFFF00');

    $content = file_get_contents($url);
    $result = json_decode($content);

    foreach($result->dates as $k => $v)
    {

        // Add Event -> Starttime is 06:00
        $cal->add('VEVENT', [
            'SUMMARY' => 'Gelber Sack',
            'DTSTART' => (new \DateTime($v))->add(new DateInterval('PT4H')),
            'DTEND' => (new \DateTime($v))->add(new DateInterval('PT5H')),
            'VALARM' => [
                'TRIGGER' => $reminder,
                'DESCRIPTION' => 'Sack rausstellen',
                'ACTION' => 'DISPLAY'
            ]
        ]);
    }
 

    echo $cal->serialize();
}



?>