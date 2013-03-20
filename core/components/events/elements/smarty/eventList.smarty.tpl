<div id="eventsList">
	{$pagination}
	{foreach $events as $event}
	<dl>
		<dt><a href="{$event.href}" title="Click for details...">{$event.title|capitalize|truncate:90}</a></dt>
		<dd class="datetime">{$event.date|date_format:"l, F d, Y"} {$event.time|date_format:"h:m A"}</dd>
		<dd class="description">{$event.description|strip_tags|truncate:100}</dd>
	</dl>
	{foreachelse}
	<dl>
		<dt>There are no events to show.</dt>
	</dl>
	{/foreach}
	{$pagination}
</div>
