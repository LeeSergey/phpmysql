{include file="header.tpl" h1=$current_category.name}
        {*<p><a href='/products/add'>Добавить</a></p>*}

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название товара</th>
                    <th>Категория</th>
                    <th>Артикул</th>
                    <th>Цена</th>
                    <th>Количество на складе</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$products item=product}
                <tr>
                    <td>{$product.id}</td>
                    <td width="200">
                        <strong>{$product.name}</strong>
                    </td>
                    <td>{$product.category_name}</td>
                    <td>{$product.article}</td>
                    <td>{$product.price}</td>
                    <td>{$product.amount}</td>
                    
                    <td>
                        <a href="/products/edit?id={$product.id}" class="btn btn-primary">Ред</a>
                        !
                        <form action="/products/delete" method="POST" style="display: inline;"><input type="hidden" name="id" value="{$product.id}"><input type="submit" value="Уд" class="btn btn-danger"></form>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
{include file="bottom.tpl"}