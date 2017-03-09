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
      <div>
        <h1>Votez pour votre œuvre favorite !</h1>
        <h2>Musée des beaux arts de bordeaux</h2>
        <time>Session de vote ouverte du {{$fromDate}} au {{$toDate}}</time>
      </div>
      <p>{{$sessionDescription}}</p>
    </header>
    
    <div class="gallery">
      @foreach ($artworks as $a)<a href="#artwork{{$a['id']}}" style="background-image: url({{$a['image']}});">
        <span>
          <strong class="name"  >{{$a['name']}}  </strong> 
          <span   class="author">{{$a['author']}}</span>
        </span>
      </a>@endforeach
    </div>
    
    @foreach ($artworks as $a)
    <div class="artwork" id="artwork{{$a['id']}}">
      <a class="background" href="#n"></a>
      <div>
        <img alt="photographie de l'œuvre {{$a['name']}}" src="{{$a['image']}}" />
        <div class="side">
          <div class="info">
            <h4 class="name">{{$a['name']}}</h4>
            <div><span class="author">{{$a['author']}}</span> <time>{{$a['date']}}</time></div>
            <p class="description">{{$a['description']}}</p>
          </div>
          <button>voter pour cette œuvre</button>
          <a class="close" href="#n">retour à la gallerie</a>
        </div>
      </div>
    </div>
    @endforeach      
    
  </body>
</html>
