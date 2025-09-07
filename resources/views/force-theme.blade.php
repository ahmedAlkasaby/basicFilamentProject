@if(auth()->check())
    <script>
        localStorage.setItem('theme', '{{ $forcedTheme ?? 'light' }}');
    </script>
@endif
