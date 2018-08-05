<?php
// I know there are probably better ways to do this, but this accomplishes what I needed it to do.
// Fetch vars. In this case, they're being pulled via the URL.

// Convert times to iCalendar format. They require a block for yyyymmdd and then another block
// for the time, which is in hhiiss. Both of those blocks are separated by a "T". The Z is
// declared at the end for UTC time, but shouldn't be included in the date conversion.
// iCal date format: yyyymmddThhiissZ
// PHP equiv format: Ymd\This

// Build the ics file
$ical = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
DTEND:' . strtoupper($_GET['dateend']) . '
UID:' . md5($_GET['tile']) . '
LOCATION:' . ucwords($_GET['adress']) . '
DESCRIPTION:' . addslashes($_GET['description']) . '
SUMMARY:' . addslashes($_GET['tile']) . '
DTSTART:' . strtoupper($_GET['datestart']) . '
END:VEVENT
END:VCALENDAR';
//set correct content-type-header

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=mohawk-event.ics');
echo $ical;
