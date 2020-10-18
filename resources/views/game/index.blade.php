<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <style>
        h2 {
            color: red;
        }
    </style>
</head>
<body>

<div>
    @if($gameOver)
        <h2>GAME OVER</h2>
    @else
        <p>NOMBRE PERSONNAGES: {{$personnagesCount}}</p>
        @foreach($personnages as $personnage)
            <ul>
                <li>NOM: {{$personnage->name}}</li>
                <li>PV: {{$personnage->lp}}</li>
                <li>EMPOISONNE {{($personnage->poisoned)?'Oui':'Non'}}</li>
                <li>TYPE PERSONNAGE: {{$personnage->typePersonnage->name}}</li>
            </ul>
        @endforeach
        <a href="{{route('game.turn')}}">JOUER</a>
        <a href="{{route('game.reset')}}">RESET</a>
    @endif
</div>

</body>
</html>
