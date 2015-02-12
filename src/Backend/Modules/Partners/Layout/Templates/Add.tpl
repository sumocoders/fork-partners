{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
    <h2>{$lblPartnerWidget|ucfirst}: {$lblAdd}</h2>
</div>

{form:add}
<div class="box">
    <div class="heading">
        <h3>
            <label for="name">{$lblName|ucfirst}<abbr title="{$lblRequiredField}">*</abbr></label>
        </h3>
    </div>
    <div class="options">
        {$txtName} {$txtNameError}
    </div>
</div>

<div class="fullwidthOptions">
    <div class="buttonHolderRight">
        <input id="addButton" class="inputButton button mainButton" type="submit" name="add" value="{$lblNext|ucfirst}" />
    </div>
</div>
{/form:add}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
