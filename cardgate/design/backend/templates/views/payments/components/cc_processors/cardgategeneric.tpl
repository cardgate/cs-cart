
<div class="control-group">
	<label class="control-label" for="shopid">Site Id:</label>
	<div class="controls">
	<input type="text" name="payment_data[processor_params][shopid]" id="shopid" value="{$processor_params.shopid}"  size="40" />
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="hashkey">Hash Key:</label>
	<div class="controls">
	<input type="text" name="payment_data[processor_params][hashkey]" id="hashkey" value="{$processor_params.hashkey}"  size="40" />
	</div>
</div><div class="control-group">
	<label class="control-label" for="merchantid">Merchant Id:</label>
	<div class="controls">
	<input type="text" name="payment_data[processor_params][merchantid]" id="merchantid" value="{$processor_params.merchantid}" size="20" />
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="merchantkey">Merchant API Key:</label>
	<div class="controls">
	<input type="text" name="payment_data[processor_params][merchantkey]" id="merchantkey" value="{$processor_params.merchantkey}"  size="60" />
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="testmode">Testmode:</label>
	<div class="controls">
	<select name="payment_data[processor_params][testmode]" id="testmode">
		<option value="off" {if $processor_params.testmode == "off"}selected="selected"{/if}>{__("live")}</option>
		<option value="on" {if $processor_params.testmode == "on"}selected="selected"{/if}>{__("test")}</option>
	</select>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="statussuccess">Status Success:</label>
	<div class="controls">
	{cardgatestatus state="statussuccess" current=$processor_params.statussuccess}
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="statusfailed">Status GEEN Success:</label>
	<div class="controls">
	{cardgatestatus state="statusfailed" current=$processor_params.statusfailed}
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="statuspending">Status In behandeling:</label>
	<div class="controls">
	{cardgatestatus state="statuspending" current=$processor_params.statuspending}
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="statuscanceled">Status Annuleren:</label>
	<div class="controls">
	{cardgatestatus state="statuscanceled" current=$processor_params.statuscanceled}
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="currency">{__("currency")}:</label>
	<div class="controls">
	<select name="payment_data[processor_params][currency]" id="currency">
		<option value="EUR" {if $processor_params.currency == "EUR"}selected="selected"{/if}>{__("currency_code_eur")}</option>
	</select>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Omschrijving:</label>
	<div class="controls">
	<input type="text" name="payment_data[processor_params][description]" id="description" value="{$processor_params.description}" size="60" />
	</div>
</div>