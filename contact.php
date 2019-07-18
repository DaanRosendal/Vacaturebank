<?php $page='contact'; include_once('header.html');?>

<body>
    <div class="container col-centered">
        <div class="page-header text-center unselectable">
            <h1 class="unselectable mt-2 display-4">Contactformulier</h1>
            <p class="text-muted">U krijgt binnen 3 werkdagen een reactie</p>
            <hr>
        </div>
    </div>
    <div class="container text-center unselectable">
        <form class="mt" name="contact" method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <input required type="text"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="naam" placeholder="Naam" />
            </div>
            <div class="form-group">
                <input required type="email"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="email" placeholder="E-mail" />
                <small id="emailHelp" class="form-text text-muted">We delen uw e-mail nooit met derden</small>
            </div>
            <div class="form-group">
                <textarea required style="height: 300px"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="bericht" placeholder="Bericht" /></textarea>
            </div>
            <input type="submit"
                class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0"
                name="submit" value="Verzenden" /><br>
    </div>
    </form>

    </div>
</body>