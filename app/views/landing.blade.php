<!doctype html>
<html lang="{{ Config::get('app.locale') }}" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>{{ HTML::entities('EduCal') }}</title>
  <!-- Bootstrap core CSS -->
  {{ HTML::style("css/bootstrap.min.css") }}
  @yield('header')
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta property="og:title" content="">
  <meta property="og:site_name" content="">
  <meta property="og:description" content="">
  <meta property="og:image" content="{{ asset('') }}">
  <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-touch-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-touch-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-touch-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-touch-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-touch-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-touch-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-touch-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-touch-icon-152x152.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-196x196.png') }}" sizes="196x196">
  <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-160x160.png') }}" sizes="160x160">
  <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-96x96.png') }}" sizes="96x96">
  <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-16x16.png') }}" sizes="16x16">
  <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-32x32.png') }}" sizes="32x32">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('favicons/mstile-144x144.png') }}">
  <meta name="msapplication-config" content="{{ asset('favicons/browserconfig.xml') }}">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  {{ HTML::script("js/html5shiv.js") }}
  {{ HTML::script("js/respond.min.js") }}
  <![endif]-->
  <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
  <style>
    body {
      font-size: 16px;
      font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue";
    }

    .hero {
      width: 100%;
      min-height: 40vh;
      background: #428bca;
      color: #fff;
      display: flex;
      align-items: center;
    }

    .container {
      padding: 5vh 1em;
      width: 100%;
      max-width: 40em;
      margin: 0 auto;
    }

    .hero h1 {
      font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue";
      font-size: 6em;
      font-weight: 300;
      margin: 0;
    }

    .hero p {
      font-size: 2em;
      margin: 0;
    }

    .steps {
      padding-left: 1.5em;
      font-size: 1.5em;
    }

    .steps h2 {
      font-size: 1em;
    }

    .steps p {
      font-size: .75em;
    }

    a {
      white-space: nowrap;
      font-weight: 500;
    }

    figure img {
      height: auto;
    }

    footer {
      padding: 2em 1em;
    }

    @media screen and (orientation: portrait) and (min-width: 50em) and (min-height: 50em) {
      body {
        font-size: 2vw
      }
    }

    @media screen and (orientation: landscape) and (min-width: 50em) and (min-height: 50em) {
      body {
        font-size: 2vh
      }
    }

    @media screen and (orientation: landscape) and (min-width: 50em) {
      .steps {
        padding-left: 0;
      }
      .hero-container {
        padding: 5vh 3em;
      }
    }
  </style>
</head>

<body>
  <header class="hero">
    <div class="container">
      <h1>educal</h1>
      <p>
        Mega catchy slogan
      </p>
    </div>
  </header>
  <main class="container">
    <p>
      Maak kennis met educal in 4 stappen:
    </p>
    <ol class="steps">
      <li>
        <h2>Registreer uw school</h2>
        <p>
          U beseft dat uw school klaar is voor de moderne kalender.
          <a href="#">Registreer meteen</a> of
          <a href="#">laat ons weten</a> hoe we u kunnen overtuigen.
        </p>
      </li>
      <li>
        <h2>Voeg klassen toe</h2>
        <p>
          U beheert de klassen in een gebruiksvriendelijke gebruikersomgeving.
        </p>
        <figure class="row">
          <img class="col-sm-6 img-responsive" src="http://placehold.it/500x300" alt="" />
          <img class="col-sm-6 img-responsive" src="http://placehold.it/500x300" alt="" />
        </figure>
      </li>
      <li>
        <h2>Plan activiteiten</h2>
        <p>
          Medewerkers stellen hun agenda ook op in een gebruiksvriendelijke gebruikersomgeving :-) en beheren moeiteloos herhalende activiteiten en stuff.
        </p>
      </li>
      <li>
        <h2>Deel met ouders</h2>
        <p>
          Ouders voegen de kalender toe op
          <strong>iCal</strong> of
          <strong>Google Calendar</strong>; of bekijken een interactief overzicht op de educal website.
          <br>Wij houden alles up-to-date.
        </p>
      </li>
    </ol>
  </main>
  <footer class="text-center">
    <p>
      Gesteund door <a href="http://www.digipolis.be">Digipolis</a> en <a href="http://stad.gent">Stad Gent</a>.
    </p>
    <p>
      Ontwikkeld door studenten van <a href="http://2014.summerofcode.be">open Summer of Code 2014</a> en <a href="http://2015.summerofcode.be">open Summer of Code 2015</a>, georganiseerd door <a href="http://www.okfn.be">OKFN Belgium</a>.
    </p>
  </footer>
</body>

</html>
