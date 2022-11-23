<!-- testing template -->
<link type="text/css" rel="stylesheet" href="{$ROOT_PATH}/src/App/Pages/Defaults/Resources/styles/exception.css">
<div class="err-cont">
    <div class="err-header">
        <h1>{$CLASS}: {$ERROR}</h1>
        <p>Error Code: {$CODE}</p>
    </div>
    <div class="err">
        <p>At {$FILE}, line {$LINE}</p>
        <pre data-lang="php">{$FILE_CODE}</pre>
    </div>
</div>