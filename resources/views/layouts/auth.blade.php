<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sign In') | Uddan Educational Foundation</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            red: '#E51E25',
                            'red-hover': '#CC1219',
                            orange: '#F37021',
                            amber: '#F8971D',
                            dark: '#1E232A',
                            charcoal: '#13171F',
                            50: '#fff1f1',
                            100: '#ffe1e1',
                            200: '#ffc7c8',
                            300: '#ffa0a2',
                            400: '#ff6669',
                            500: '#E51E25',
                            600: '#cc1219',
                            700: '#aa0c12',
                            800: '#8c0d12',
                            900: '#751115',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        .brand-gradient {
            background: linear-gradient(135deg, #E51E25 0%, #F37021 50%, #F8971D 100%);
        }
        .brand-gradient-text {
            background: linear-gradient(135deg, #E51E25 0%, #F37021 60%, #F8971D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased">
    @yield('content')
</body>
</html>
