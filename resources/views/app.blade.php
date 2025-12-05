@php
use function App\Http\Helpers\getSetting;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{getSetting('fav_icon')}}" type="image/x-icon">  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <!-- Google tag (gtag.js) --> 
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-2VZ4M543WM"></script> 
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-2VZ4M543WM');</script>
        <style>
            .whatsapp-float {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                cursor: pointer;
                background-color: #25D366;
                padding: 10px;
                border-radius: 50%;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            }
            .whatsapp-float img {
                width: 40px;
                height: 40px;
            }
        </style>
    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3GMZMGG" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager(noscript)-->
        @inertia

        <!-- Comment  getSetting('chat_script') -->
        
        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/+8801670263465?text=Hello%20B.T.%20Tex%20Access%2C%20Anyone%20there%3F"
            class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
            <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp Chat" />
        </a>
    </body>
</html>
