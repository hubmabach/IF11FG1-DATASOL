<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="#">
        <img src="./assets/logo.png" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php if ($isLoggedIn): ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Reporting</a>
            </li>
            <?php if ($isAdmin): ?>
            <li class="nav-item active dropdown">
                <a class="nav-link" href="#">Stammdaten <span class="sr-only">(current)</span></a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Neubeschaffung</a>
            </li>
            <?php endif; ?>
        </ul>
        <form class="form-inline">
            <button class="btn btn-outline-danger my-2 my-sm-0" name="logout" type="submit">Abmelden</button>
        </form>
    <?php endif; ?>
    </div>
</nav>