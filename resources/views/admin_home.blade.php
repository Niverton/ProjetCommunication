<!doctype html>
<html lang="fr">
    
    <head>
        <meta charset="utf-8">
        <title>Votez pour vos œuvres favorites - Musée des beaux-arts de Bordeaux</title>
        <link rel="stylesheet" href="/static/style.css">
    </head>
    
    <body class="admin home">

        <div class="vsplit">
            
            <header>
                <div>
                    <h1>Votez pour vos œuvres favorites !</h1>
                    <h2>Musée des beaux-arts de Bordeaux</h2>
                </div>
            </header>

            <div class="vsplit">
                @if ($active === null)
                    <div class="buttons">
                        <a href="/admin/create">Créer un nouvelle session de vote</a>
                    </div>
                @endif
                <ul>
                    @if ($active !== null)
                        <li class="active">
                            <a href="/admin/results/{{$active['id']}}"><time>{{$active['fromDate']}} → {{$active['toDate']}}</time></a>
                            <a class="close" href="/admin/close">Fermer le vote</a>
                        </li>
                    @endif
                    @foreach ($history as $session)
                        <li>
                            <a href="/admin/results/{{$session['id']}}"><time>{{$session['fromDate']}} → {{$session['toDate']}}</time></a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </body>

</html>
