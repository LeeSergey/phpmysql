{include file="header.tpl" h1="Список товаров"}
        <p><a href='/products/add'>Добавить</a></p>
        <nav>
            <ul class="pagination">
                {section loop=$pages_count name=pagination}
                    <li class="page-item {if $smarty.get.p == $smarty.section.pagination.iteration}active{/if}"><a href="{$smarty.server.PATH_INFO}?p={$smarty.section.pagination.iteration}" class="page-link">{$smarty.section.pagination.iteration}</a></li>
                {/section}
            </ul>
        </nav>
        <p>
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
                            {if $product.images}
                                <br>
                                {foreach from=$product.images item=image}
                                    <img width="40" src="{$image.path}" alt="{$image.name}">
                                {/foreach}
                            {/if}
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
        </p>
{include file="bottom.tpl"}