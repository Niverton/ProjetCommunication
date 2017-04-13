<!doctype html>
<html lang="fr">
  
  <head>
    <meta charset="utf-8">
    <title>Votez pour vos œuvres favorites - Musée des beaux-arts de Bordeaux</title>
    <link rel="stylesheet" href="/static/style.css">
    <script src="script.js"></script>
  </head>
  
  <body>
    
    <header>
      <div>
        <h1>Votez pour vos œuvres favorites !</h1>
        <h2>Musée des beaux-arts de Bordeaux</h2>
        <time>Session de vote ouverte du {{$fromDate}} au {{$toDate}}</time>
      </div>
      <p>{{$sessionDescription}}</p>
    </header>
    
    <div class="gallery">
      @foreach ($artworks as $a)<a href="#artwork{{$a['id']}}" style="background-image: url({{$a['image']}});">
        <span>
          <strong class="name"  >{{$a['name']}}</strong> 
          <span class="author">{{$a['author']}}</span>
        </span>
      </a>@endforeach
    </div>
    
    @foreach ($artworks as $a)
    <div class="modal artwork" id="artwork{{$a['id']}}">
      <a class="background" href="#n"></a>
      <div class="content">
        <img alt="Photographie de l'œuvre {{$a['name']}}" src="{{$a['image']}}" />
        <div class="side">
          <div class="info">
            <h4 class="name">{{$a['name']}}</h4>
            <div><span class="author">{{$a['author']}}</span> <time>{{$a['date']}}</time></div>
            <p class="description">{{$a['description']}}</p>
          </div>
          <button id="button{{$a['id']}}" onclick="voteCounter(this.id)">Voter pour cette œuvre</button>
          <div id="votes"></div>
          <a class="close" href="#n">Retour à la galerie</a>
        </div>
      </div>
    </div>
    @endforeach  
    <script type="text/javascript" src="/static/vote.js"></script>
    
  </body>

</html>
