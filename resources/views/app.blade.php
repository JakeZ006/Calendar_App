<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('favicon.svg') }}">

        <script>
        /*
            (() => {
                try {
                    const stored = localStorage.getItem("theme");
                    const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

                    document.documentElement.classList.toggle(
                        "dark",
                        stored === "dark" || (stored !== "light" && systemDark),
                    );
                } catch {
                    // Storage unavailable; keep the light theme.
                }
            })();*/
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
