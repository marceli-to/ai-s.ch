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

    // Site-Name; …_stacked steht mit Zeilenumbrüchen im mobilen Header.
    'site_name' => 'Archiv Innenarchitektur Schweiz ai-s',
    'site_name_stacked' => 'Archiv<br>Innenarchitektur<br>Schweiz ai-s',
    'homepage' => 'Homepage',

    // Menü-Fuss (im Template, nicht im CP pflegbar).
    'become_member' => 'Mitglied werden',
    'legal_notice' => 'Impressum',
    'legal_notice_url' => '/impressum',
    'privacy_policy' => 'Datenschutz',
    'privacy_policy_url' => '/datenschutzerklaerung',
    'choose_language' => 'Sprache wählen',

    // Untermenü auf der Bestände-Detailseite.
    'biography' => 'Werdegang',
    'work' => 'Werk',

    // Titel und URL der Bestände-Übersicht dieser Site.
    'inventory_title' => 'Einblicke Bestände',
    'inventory_url' => '/einblicke-bestaende',

    // Slug bzw. URL der Veranstaltungs-Seiten dieser Site.
    'upcoming_events_slug' => 'kommende-veranstaltungen',
    'upcoming_events_url' => '/veranstaltungen/kommende-veranstaltungen',
    'past_events_slug' => 'vergangene-veranstaltungen',

];
