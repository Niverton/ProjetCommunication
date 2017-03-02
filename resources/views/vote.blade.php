<!doctype html>
<html lang="fr">
  
  <head>
    <meta charset="utf-8">
    <title>Votez pour votre œuvre favorite - Musée des beaux arts de bordeaux</title>
    <link rel="stylesheet" href="/static/vote.css">
    <script src="script.js"></script>
  </head>
  
  <body>
    
    <header>
      <h1>Votez pour votre œuvre favorite !</h1>
      <h2>Musée des beaux arts de bordeaux</h2>
      
      <p>{{$sessionDescription}}</p>
    </header>
    
    <div class="gallery">
      @foreach ($artworks as $a)
      <a href="#artwork{{$a['id']}}" style="background-image: url({{$a['image']}});">
        <span>
          <strong>{{$a['name']}}</strong> 
          <span>{{$a['author']}}</span>
        </span>
      </a>
      @endforeach
    </div>
    
    @foreach ($artworks as $a)
    <div class="artwork" id="artwork{{$a['id']}}">
      <img alt="photographie de l'œuvre {{$a['name']}}" src="{{$a['image']}}" />
      <div class="info">
        <h4 class="name">{{$a['name']}}</h4>
        <time>{{$a['date']}}</time>
        <span class="author">{{$a['author']}}</span>
        <p class="description">{{$a['description']}}</p>
      </div>
    </div>
    @endforeach      
    
  </body>
</html>
