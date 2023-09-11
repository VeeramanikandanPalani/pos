<header>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light top-header-bg-color">
            <a class="navbar-brand text-white font-weight-bold" href="#">Beta</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav ml-auto top-header-nav-ul">
                <li class="nav-item">
                  <a class="nav-link text-white" href="showInwardForm">Inward<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="showOutwardForm">Outward</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="master" id="master_sub_items" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
                    <div class="dropdown-menu" aria-labelledby="master_sub_items">
                      <a class="dropdown-item" href="stockList">Stock List</a>
                      <a class="dropdown-item" href="showInwardReportForm">Inward Report</a>
                      <a class="dropdown-item" href="showOutwardReportForm">Outward Report</a>
                      <a class="dropdown-item" href="supplierForm">Supplier List</a>
                      <a class="dropdown-item" href="addUserForm">Users List</a>
                      <a class="dropdown-item" href="showItemList">Items List</a>
                      <a class="dropdown-item" href="showChatForum">Chat</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link text-white dropdown-toggle" href="master" id="master_sub_items" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Master's</a>
                  <div class="dropdown-menu" aria-labelledby="master_sub_items">
                    <a class="dropdown-item" href="addItems">Items Master</a>
                    <a class="dropdown-item" href="supplierForm">Suppliers Master</a>
                    <a class="dropdown-item" href="customerForm">Customer's Master</a>
                    <a class="dropdown-item" href="addUserForm">Users Master</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{auth()->user()->email}}
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Dashboard</a>
                    <a class="dropdown-item" href="logout">Signout</a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>

</div>
</header>
