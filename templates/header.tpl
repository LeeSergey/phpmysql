<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container site-wrapper">
    <header>
        <div class="row">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/products/" class="nav-link">Товары</a></li>
                <li class="nav-item"><a href="/categories/" class="nav-link">Категории</a></li>
                <li class="nav-item"><a href="/import/index" class="nav-link">Импорт товаров</a></li>
                <li class="nav-item"><a href="/queue/list" class="nav-link">Список задач</a></li>
            </ul>
        </div>
    </header>
    

    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column nav-pills">
                {foreach from=$categories_shared item=category}
                    <a href="/categories/view?id={$category.id}" class="nav-link {if $current_category.id == $category.id} active{/if}">{$category.name}</a>
                {/foreach}
            </nav>
        </div>
        <div class="col-md-9">
            {if $h1}<h1>{$h1}</h1>{/if}