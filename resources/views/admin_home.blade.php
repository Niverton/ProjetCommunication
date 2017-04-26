<!doctype html>
<html lang="fr">
    
    <head>
        <meta charset="utf-8">
        <title>Votez pour vos œuvres favorites - Musée des beaux-arts de Bordeaux</title>
        <link rel="stylesheet" href="/static/style.css">
    </head>
    
    <body class="admin home">

        <header>
            <div>
                <h1>Votez pour vos œuvres favorites !</h1>
                <h2>Musée des beaux-arts de Bordeaux</h2>
                <h3>Accueil</h3>
            </div>
        </header>

        <div>
            <a class="cancel button" href="/vote">Page de vote</a>
            @if ($active === null)
                <a class="ok button" href="/admin/create">Créer un nouvelle session de vote</a>
            @endif


            @if ($active !== null)
                <h3>Session active</h3>
                <div class="active">
                    <a class="ok button" href="/admin/results/{{$active['id']}}">{{$active['fromDate']}} → {{$active['toDate']}}</a>
                    <a class="cancel button" href="/admin/close">Fermer le vote</a>
                </div>
            @endif
            
            <h3>Historique</h3>
            <ul class="history">
                @foreach ($history as $session)
                    <li>
                        <a class="ok button" href="/admin/results/{{$session['id']}}">{{$session['fromDate']}} → {{$session['toDate']}}</a>
                    </li>
                @endforeach
            </ul>
        </div>  
          
    </body>

</html>
