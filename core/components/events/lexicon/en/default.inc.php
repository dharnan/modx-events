<?php
/**
 * Default English Lexicon Entries for Events
 *
 * @package events
 * @subpackage lexicon
 */
$_lang['event'] = 'Events';
$_lang['events'] = 'Events';
$_lang['events.desc'] = 'Add, update and remove website events.';
$_lang['events.management'] = 'Events Management';
$_lang['events.management_desc'] = 'Manage your events here. You can edit them by right-clicking on the respective row.<br/><br/>';
$_lang['events.help_desc'] = '
    <div id="eventHelpWindow">
        <table>
            <tr>
                <th>Snippet Parameter</th>
                <th>Possible Values (default values are <b>bold</b>)</th>
            </tr>
            <tr>
                <td>filterStr</td>
                <td>(; separated modx xpdo where syntax)</td>
            </tr>
            <tr>
                <td>sortStr</td>
                <td>(; separated modx xpdo order syntax)</td>
            </tr>
            <tr>
                <td>showMiniCal</td>
                <td>(true|<b>false</b>)</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>Sample Snippet Syntax</th>
                <th>What it will show</th>
            </tr>
            <tr>
                <td>[[!Events? &filterStr=`published:=0;title:=%sample%`]]</td>
                <td>A list of events with "sample" in the title</td>
            </tr>
            <tr>
                <td>[[!Events? &sortStr=`title:ASC`]]</td>
                <td>A list of events sorted by title</td>
            </tr>
            <tr>
                <td>[[!Events? &showMiniCal=`true`]]</td>
                <td>A mini calendar of the events for this month</td>
            </tr>
        </table>
    </div>';

$_lang['events.search...'] = 'Search...';

//actions
$_lang['events.event_help'] = 'Help';
$_lang['events.event_create'] = 'Create New event';
$_lang['events.event_remove'] = 'Remove event';
$_lang['events.event_remove_confirm'] = 'Are you sure you want to remove this event?';
$_lang['events.event_update'] = 'Update event';

//err msgs
$_lang['events.event_err_ae'] = 'A event with that name already exists.';
$_lang['events.event_err_nf'] = 'Event not found.';
$_lang['events.event_err_ns'] = 'Event not specified.';
$_lang['events.event_err_ns_title'] = 'Please specify a title for the event.';
$_lang['events.event_err_ns_subtype'] = 'Please choose a sybtype for the event.';
$_lang['events.event_err_ns_date'] = 'Please select a date for this event.';
$_lang['events.event_err_ns_time'] = 'Please select a time for this event.';
$_lang['events.event_err_ns_description'] = 'Please enter a description for this event.';
$_lang['events.event_err_remove'] = 'An error occurred while trying to remove the event.';
$_lang['events.event_err_save'] = 'An error occurred while trying to save the event.';

//db
$_lang['events.id'] = 'Id';
$_lang['events.subtype'] = 'Subtype';
$_lang['events.title'] = 'Title';
$_lang['events.date'] = 'Date';
$_lang['events.time'] = 'Time';
$_lang['events.description'] = 'Description';
$_lang['events.datetime_created'] = 'Datetime Created';
$_lang['events.datetime_modified'] = 'Datetime Modified';
$_lang['events.published'] = 'Published';
