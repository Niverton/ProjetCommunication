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
          @foreach ($cartArtworks as $a)<a href="#n" style="background-image: url({{$a['image']}});" onclick="addToCart({{$a['id']}});">
            <span>
              <strong class="name">{{$a['name']}}</strong> 
              <span class="author">{{$a['author']}}</span>
            </span>
          </a>@endforeach
        </div>
        
      </div>
      
    </div>

    <form class="modal" id="form" onsubmit="submitForm(); return false;">
      <div class="background"></div>
      <div class="content">
        <label for="fromDate">Session de vote ouverte du :</label> <br />
        <input type="date" id="fromDate" name="fromDate" />
        <label for="toDate"> au </label>
        <input type="date" id="toDate" name="toDate" />

        <br />
        
        <label for="description">Description de la session de vote :</label> <br />
        <textarea name="description" id="description">
        </textarea>

        <br />

        <div>
          <button type="reset" onclick="cancelForm()">Annuler</button>
          <button type="submit">Valider</button>
        </div>
      </div>
    </form>
    
    <script src="/static/admin_create_session.js"></script>
    <script>init();</script>
  </body>

</html>
