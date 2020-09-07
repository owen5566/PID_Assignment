<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">JUST BUY IT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">首頁 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="memberPage.php">使用者頁面／訂單</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                暫時
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="admin/loginA.php" tabindex="-1" aria-disabled="true">後台管理</a>
            </li>
          </ul>
          <span class="navbar-text" style="margin-right: 10px;">
            hello <?=$userName?>!
          </span>
          <a href=<?=($status)? "login.php?logout=1" :"login.php"?>><button class="btn btn-outline-info my-2 my-sm-0"><?=($status)? "Logout" :"Login"?></button></a>
          <a href="cart.php"><i class="fa fa-shopping-cart fa-fw" ></i></a>

        </div>
      </nav>