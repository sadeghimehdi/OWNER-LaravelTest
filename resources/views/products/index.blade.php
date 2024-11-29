<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Products</title>

        <style>
            .alert-success {
                color: green;
            }

            .alert-danger {
                color: red;
            }

        </style>
    </head>
    <body>

        <h1>Current Products</h1>

        @if(count($products) > 0)
            <ul>
                @foreach ($products as $product)
                    <li>
                        Name: {{ $product->name }} <br>
                        @if($product->description)
                            Description: {{ $product->description }}<br>
                        @endif
                        @if($product->tags->isNotEmpty())
                            Tags:
                            @foreach ($product->tags as $tag)
                                {{ $tag->name }}
                            @endforeach
                            <br>
                        @endif
                    </li>
                    <form action="/products/delete" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="@php(print $product['id'])"/>
                        <button type="submit">delete</button>
                    </form>
                @endforeach
            </ul>
        @else
            <p>There is no products availablr</p>
        @endif

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2>New product</h2>
        <form action="/products/create" method="POST">
            @csrf
            <input type="text" name="name" placeholder="name" /><br />
            <textarea name="description" placeholder="description"></textarea><br />
            <input type="text" name="tags" placeholder="tags" /><br />
            <button type="submit">Submit</button>
        </form>

    </body>
</html>
