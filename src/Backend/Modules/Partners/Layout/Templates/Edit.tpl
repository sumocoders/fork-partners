{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
    <h2>{$lblPartner|ucfirst}: {$lblEdit}</h2>
</div>

{form:edit}
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

<div class="box">
    <div class="heading">
        <h3>
            {$lblPartners}
        </h3>
    </div>
    {option:dgPartners}
    <div class="optionsRTE">
        <div class="dataGridHolder">{$dgPartners}</div>
    </div>
    {/option:dgPartners}
    {option:!dgPartners}
    <div class="options">
        <a href="{$var|geturl:'add_partner'}&amp;id={$item.id}" class="button inputButton icon iconAdd">
            <span>{$lblAddPartner|ucfirst}</span>
        </a>
    </div>
    <div class="options">
        {option:!dgPartners}<p>{$msgNoPartners}</p>{/option:!dgPartners}
    </div>
    {/option:!dgPartners}
</div>

<div class="fullwidthOptions">
    <a href="{$var|geturl:'delete'}&amp;id={$item.id}" data-message-id="confirmDelete" class="askConfirmation button linkButton icon iconDelete">
        <span>{$lblDelete|ucfirst}</span>
    </a>

    <div id="confirmDelete" title="{$lblDelete|ucfirst}?" style="display: none;">
        <p>
            {$msgConfirmDelete|sprintf:{$item.name}}
        </p>
    </div>
    <div class="buttonHolderRight">
        <input id="editButton" class="inputButton button mainButton" type="submit" name="edit" value="{$lblSave|ucfirst}" />
    </div>
</div>
{/form:edit}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
