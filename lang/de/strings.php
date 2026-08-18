<?php

return [

    /*
    | Übersetzbare Frontend-Texte. Statamic setzt die App-Locale pro Site
    | (siehe resources/sites.yaml), darum greift automatisch die passende Datei.
    */

    'next_event' => 'Nächste Veranstaltung',

    // Zeitangaben; :start / :time / :end werden im Template ersetzt.
    'time_range' => ':start–:end Uhr',
    'time_from' => 'ab :time Uhr',
    'time_until' => 'bis :time Uhr',

    // Slug bzw. URL der Veranstaltungs-Seiten dieser Site.
    'upcoming_events_slug' => 'kommende-veranstaltungen',
    'upcoming_events_url' => '/veranstaltungen/kommende-veranstaltungen',
    'past_events_slug' => 'vergangene-veranstaltungen',

];
