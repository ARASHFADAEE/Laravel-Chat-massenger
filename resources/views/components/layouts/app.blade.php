<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم چت</title>
    
    <!-- فونت ایران یکان -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        @font-face {
            font-family: 'IRANYekan';
            src: url('{{ asset("fonts/IRANYekanXVF.woff2") }}') format('woff2'),
                 url('{{ asset("fonts/IRANYekanXVF.woff") }}') format('woff');
            font-weight: 100 900;
            font-style: normal;
            font-display: swap;
        }
        
        * {
            font-family: 'IRANYekan', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        body {
            font-family: 'IRANYekan', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        .font-iran {
            font-family: 'IRANYekan', 'Tahoma', 'Arial', sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-iran">
    {{ $slot }}
    @livewireScripts
</body>
</html>
