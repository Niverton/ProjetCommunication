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
        </div>
        <form method="post" action="" onsubmit="return submitForm(this);">
          {{$sessionDescription}}
        </form>
      </header>
      
      <div class="hsplit">
        
        <div class="gallery">
          @foreach ($artworks as $a)<a href="#n" style="background-image: url({{$a['image']}});" onclick="addToCart({{$a['id']}});">
            <span>
              <strong class="name"  >{{$a['name']}}</strong> 
              <span class="author">{{$a['author']}}</span>
            </span>
          </a>@endforeach
        </div>

        <div id="cart" class="gallery">
        </div>
        
      </div>
      
    </div>
    
    <script src="/static/admin_create_session.js"></script>
  </body>

</html>
