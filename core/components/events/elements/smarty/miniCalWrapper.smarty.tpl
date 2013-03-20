<div id="miniCalWrapper">
	<div id="miniCalHeader">
		{html_options name=monthYear id=monthYear options=$monthOptions selected=$currMonth}
		<input type="hidden" id="eventsResourceId" value="{$eventsResourceId}"/>
	</div>
	<div id="miniCalTableWrapper">
		<div class="loading-indicator" style="display:none;">Loading Month Data...</div>
		{$miniCalTableHtml}
	</div>
	<div id="miniCalFooter"></div>
</div>
