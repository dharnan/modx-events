<div id="eventsDetail">
	<dl>
		<dt>{$event.title|capitalize}</dt>
		<dd class="datetime">{$event.date|date_format:"l, F d, Y"} {$event.time|date_format:"h:m A"}</dd>
		<dd class="description">{$event.description}</dd>
	</dl>
</div>
<div id="back">
	<a href="{$backHref}">&laquo; Back to the Events List</a>
</div>
