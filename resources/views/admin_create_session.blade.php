<!doctype html>
<html lang="fr">
    
    <head>
        <meta charset="utf-8">
        <title>Votez pour vos œuvres favorites - Musée des beaux-arts de Bordeaux</title>
        <link rel="stylesheet" href="/static/style.css">
    </head>
    
    <body class="admin create">

        <div class="vsplit">
            
            <header>
                <div>
                    <h1>Votez pour vos œuvres favorites !</h1>
                    <h2>Musée des beaux-arts de Bordeaux</h2>

                    <h3>Nouvelle session</h3>
                    
                    <div class="time">
                        Session ouverte

                        @if (empty($fromDate))
                            <a href="#form">Cliquez ici pour choisir les dates.</a>
                        @else
                            du <a href="#form">{{$fromDate}} au {{$toDate}}.</a>
                        @endif

                    </div>
                </div>
                
                <p><a href="#form">
                    @if (empty($sessionDescription))
                        Cliquez ici pour personnaliser la description de la session de vote.
                    @else
                        {{$sessionDescription}}
                    @endif
                </a></p>
                
                <span class="menu">
                    <a class="ok button" href="/admin/create/validate">Valider et créer la session de vote</a>
                    <a class="cancel button" href="/admin">Retour à l'accueil</a>
                </span>
                
            </header>
            
            <div class="hsplit">

                <div>
                    <h4>Toutes les œuvres</h4>
                    <h5>Cliquez sur les œuvres à ajouter à la sélection.</h5>
                    <div class="small scroll gallery">
                        @foreach ($artworks as $a)<a href="#n" style="background-image: url({{$a['image']}});" onclick="addToCart(this, {{$a['id']}});">
                            <span>
                                <strong class="name">{{$a['name']}}</strong> 
                                <span class="author">{{$a['author']}}</span>
                            </span>
                            </a>@endforeach
                    </div>
                </div>

                <div>
                    <h4>Sélection</h4>
                    <h5>Cliquez sur une œuvre pour la retirer.</h5>
                    <div id="cart" class="small scroll gallery">
                        @foreach ($cartArtworks as $a)<a href="#n" style="background-image: url({{$a['image']}});" onclick="removeFromCart(this, {{$a['id']}});">
                            <span>
                                <strong class="name">{{$a['name']}}</strong> 
                                <span class="author">{{$a['author']}}</span>
                            </span>
                            </a>@endforeach
                    </div>
                </div>
                
            </div>
            
        </div>

        <div class="modal error" id="invalid-dates">
            <div class="background"></div>
            <div class="content">
                <strong>Dates invalides. Merci de les corriger.</strong>
                <div class="buttons"><a class="ok button" href="#form">Ok</a></div>
            </div>
        </div>

        <div class="modal error" id="empty-cart">
            <div class="background"></div>
            <div class="content">
                <strong>Votre sélection d'œuvres est vide. Merci d'ajouter quelques œuvres.</strong>
                <div class="buttons"><a class="ok button" href="#n">Ok</a></div>
            </div>
        </div>
        
        <form class="modal" id="form" action="/admin/create/submit" method="post">
            <div class="background"></div>
            <div class="content">
                <label for="fromDate">Session de vote ouverte du :</label> <br />
                <input type="date" id="fromDate" name="fromDate" value="{{$fromDateRfc}}" placeholder="aaaa-mm-jj" />
                <label for="toDate"> au </label>
                <input type="date" id="toDate" name="toDate" value="{{$toDateRfc}}" placeholder="aaaa-mm-jj" />

                <br />
                <br />
                
                <label for="description">Description de la session de vote :</label> <br />
                <textarea name="description" id="description">{{$sessionDescription}}</textarea>

                <br />

                <div class="buttons">
                    <button class="cancel button" type="reset" onclick="cancelForm()">Annuler</button>
                    <button class="ok button" type="submit">Valider</button>
                </div>
            </div>
        </form>

        <script src="/static/ajax.js"></script>
        <script src="/static/admin_create_session.js"></script>
        <script>init();</script>

    </body>

</html>
