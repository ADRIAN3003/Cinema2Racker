<x-layout title="React">
    <x-slot:head>
        @viteReactRefresh
    </x-slot:head>

    <div id="react-root"></div>

    <x-slot:scripts>
        @vite('resources/js/react/main.jsx')
    </x-slot:scripts>
</x-layout>
