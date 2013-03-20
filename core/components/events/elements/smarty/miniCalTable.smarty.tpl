<table id="miniCalTable" class="miniCalTableInner" cellspacing="0">
	<!-- weekdays -->
	<tr class="weekdays">
		{foreach $weekDays as $weekDay}
		<td>{$weekDay|capitalize}</td>
		{/foreach}
	</tr>
	<!-- cal days -->
	{foreach $calDays as $row}
	<tr class="calendardays">
		{foreach $row as $col}
		<td class="{$col.class}">
			{$col.day}
			<div class="eventToolTip" style="display:none;">
				<span class="eventDetail">
					{foreach $col.events as $event}
					<dl>
						<dt><a href="{$event.href}" class="eventTitleLink" title="Click for details...">{$event.title|strip_tags|truncate:50}</a></dt>
						<dd class="eventTime">{$event.time|date_format:"h:m A"}</dd>
					</dl>
					{/foreach}
				</span>
			</div>
		</td>
		{/foreach}
	</tr>
	{/foreach}
</table>
