{include file="header.tpl" h1="Импорт товаров"}

<p>
<h3>Загрузка файла импорта</h3>
<form method="post" action="/import/upload" class="form f400p" enctype="multipart/form-data">
    <div class="form-group">
        <label for="">Файл импорта:</label>
        <input class="form-control" multiple type="file" name="import_file">
    </div>
    <div class="form-element">
        <button class="btn btn-default">{$submit_name|default:'Импортировать'}</button>
    </div>
</form>
</p>

{include file="bottom.tpl"}