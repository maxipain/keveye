<nav class="navbar navbar-inverse">
    <div class="container-fluid">

        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
       
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php

                    $where_librarian = array('username'=>$_SESSION['librarian_account']);
                    $fetch = $obj->fetch_records('staff_accounts',$where_librarian);
                    foreach($fetch as $row)
                    {
                        echo $row['names'];
                    }

                    ?>
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="changepassword.php"><i class="fa fa-lock fa-fw"></i>Change password</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>