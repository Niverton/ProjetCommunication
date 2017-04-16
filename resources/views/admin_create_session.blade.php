<!doctype html>
<html lang="fr">
  
  <head>
    <meta charset="utf-8">
    <title>Votez pour vos œuvres favorites - Musée des beaux-arts de Bordeaux</title>
    <link rel="stylesheet" href="/static/style.css">
  </head>
  
  <body>

    <div class="vsplit">
    
      <header>
        <div>
          <h1>Votez pour vos œuvres favorites !</h1>
          <h2>Musée des beaux-arts de Bordeaux</h2>

          <time>
            Session de vote ouverte

            @if (empty($fromDate))
               <a href="#form">cliquez ici pour choisir les dates</a>
            @else
               du <a href="#form">{{$fromDate}} au {{$toDate}}</a>
            @endif

          </time>
        </div>
        
        <p><a href="#form">
            @if (empty($sessionDescription))
               Cliquez ici pour personaliser la description de la session de vote.
            @else
               {{$sessionDescription}}
            @endif
        </a></p>

        <a class="validate" href="/admin/create/validate">Valider et créer la session de vote</a>
        
      </header>
      
      <div class="hsplit">
        
        <div class="gallery">
          @foreach ($artworks as $a)<a href="#n" style="background-image: url({{$a['image']}});" onclick="addToCart(this, {{$a['id']}});">
            <span>
              <strong class="name">{{$a['name']}}</strong> 
              <span class="author">{{$a['author']}}</span>
            </span>
          </a>@endforeach
        </div>
        
        <div id="cart" class="gallery">
          @foreach ($cartArtworks as $a)<a href="#n" style="background-image: url({{$a['image']}});" onclick="removeFromCart(this, {{$a['id']}});">
            <span>
              <strong class="name">{{$a['name']}}</strong> 
              <span class="author">{{$a['author']}}</span>
            </span>
          </a>@endforeach
        </div>
        
      </div>
      
    </div>

    <div class="modal error" id="invalid-dates">
      <div class="background"></div>
      <div class="content">
          <strong>Dates invalides. Merci de les corriger.</strong>
          <div class="buttons"><a href="#form">Ok</a></div>
      </div>
    </div>

    <div class="modal error" id="empty-cart">
        <div class="background"></div>
        <div class="content">
            <strong>Votre sélection d'œuvres est vide. Merci d'ajouter quelques œuvres.</strong>
            <div class="buttons"><a href="#n">Ok</a></div>
        </div>
    </div>
    
    <form class="modal" id="form" action="/admin/create/submit" method="post">
      <div class="background"></div>
      <div class="content">
        <label for="fromDate">Session de vote ouverte du :</label> <br />
        <input type="date" id="fromDate" name="fromDate" value="{{$fromDate}}" />
        <label for="toDate"> au </label>
        <input type="date" id="toDate" name="toDate" value="{{$toDate}}" />

        <br />
        
        <label for="description">Description de la session de vote :</label> <br />
        <textarea name="description" id="description">{{$sessionDescription}}</textarea>

        <br />

        <div class="buttons">
          <button type="reset" onclick="cancelForm()">Annuler</button>
          <button type="submit">Valider</button>
        </div>
      </div>
    </form>

    <script src="/static/ajax.js"></script>
    <script src="/static/admin_create_session.js"></script>
    <script>init();</script>
  </body>

</html>
