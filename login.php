<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mirada Verde</title>
    <link rel="shortcut icon" href="/Img/icon-back.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
   

<header data-bs-theme="dark">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="/index.php">Mirada Verde</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" aria-current="page" href="/login.php">Iniciar Sesión</a>
        
        </div>
      </div>
    </div>
  </nav>  
</header>

<main>
  <div class="album py-5 bg-body-tertiary">
    <div class="container">

      <div class="row row-cols-1 ">
        
      <form action="/Controller/validation.php" method="POST">
        <center>
        <img class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100" src="Img/icon-back.png"/>
          <h1 class="text-body-emphasis">Mirada Verde</h1>
          <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="nombre@example.com" name="email" >
            <label for="floatingInput">Correo</label>
          </div>
          <br>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña" name="password" >
            <label for="floatingPassword">Contraseña</label>
          </div>

          <div class="form-check text-start my-3">
            
          </div>
          <button class="btn btn-primary w-100 py-2" type="submit">Iniciar Sesión</button>
       
        </center>
  </form>

        
      </div>
    </div>
  </div>

</main>

<footer class="text-body-secondary py-5">
  <div class="container">
    <p class="mb-1">TheSmoke10 &copy;2,024 </p>
    
  </div>
</footer>
  </body>
</html>