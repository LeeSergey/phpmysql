{include file="header.tpl" h1="Список категорий"}
        <p><a href='/categories/add'>Добавить</a></p>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название Категории</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$categories item=category}
                <tr>
                    <td>{$category.id}</td>
                    <td>{$category.name}</td>
                    <td>
                        <a href="/categories/edit?id={$category.id}" class="btn btn-primary">Ред</a>
                        !
                        <form action="/categories/delete" method="POST" style="display: inline;"><input type="hidden" name="id" value="{$category.id}"><input type="submit" value="Уд" class="btn btn-danger"></form>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
{include file="bottom.tpl"}