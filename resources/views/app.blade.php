<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="author" content="Bruno Andrade - Projeto Midia Ciência" />
        <meta name="description" content="Site PICTEC - Programa de Iniciação Científica e Tecnológica de Mato Grosso do Sul" />
        <link rel="canonical" href="" />
        <meta property="og:locale" content="pt_BR" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="PICTEC" />
        <meta property="og:description" content="Site PICTEC - Programa de Iniciação Científica e Tecnológica de Mato Grosso do Sul" />
        <meta property="og:url" content="" />
        <meta property="og:site_name" content="PICTEC" />

        <meta name="keywords" content="PICTEC, iniciação científica, tecnologia, ciência, MS" />
        <meta name="robots" content="index, follow" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="/favicon.ico">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class=" antialiased leading-normal tracking-normal bg-white">
        @inertia
    </body>
</html>
