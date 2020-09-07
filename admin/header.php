<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="loginA.php">後台管理</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="shopManage.php">商品管理</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="userManage.php">使用者管理</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="chart.php">報表</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link disabled" href="../index.php" tabindex="-1" aria-disabled="true">前往顧客頁面</a>
            </li>
          </ul>
          <span class="navbar-text" style="margin-right: 10px;">
            hello <?=$userName?>
          </span>
          <a href=<?= ($status)?"loginA.php?logout=1":"loginA.php"?>><button class="btn btn-outline-info my-2 my-sm-0"><?=($status)? "Logout" :"Login"?></button></a>
          <!-- <form class="form-inline my-2 my-lg-0">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Login</button>
          </form> -->
        </div>
      </nav>