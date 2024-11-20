<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wire:Click Test</title>
    @livewireStyles
</head>
<body>
<div>
    <button wire:click="console.log('Button clicked!')">Нажми меня</button>
</div>
@livewireScripts
</body>
</html>
