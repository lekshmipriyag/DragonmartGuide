<style>
.sidebar-nav, .navbar-collapse {
	padding: 0px;
	margin: 0px;
}
.navbar-nav, .nav-list {
	width: 100% !important;
}
.navbar-nav li a {
	width: 100% !important;
}
.navbar-nav li {
	width: 100% !important;
}
.caret {
	margin-top: 10px;
}
.rrcheckbox div {
	padding: 0px;
}
</style>

<div class="sidebar-nav">
  <div class="navbar navbar-default" role="navigation" style="border-color:#ccc !important; background-color:#fff;">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <span class="visible-xs navbar-brand">Sidebar menu</span> </div>
    <div class="navbar-collapse">
      <ul class="nav navbar-nav" id="sidenav01">
        <li> <a href="#" data-toggle="collapse" data-target="#toggleDemo0" data-parent="#sidenav01" class="collapsed">
          <h4> Dashboard <span class="caret pull-right"></span> </h4>
          </a>
          <div class="collapse" id="toggleDemo0" style="height: 0px;">
            <ul class="nav nav-list">
              <li><a href="#">SubMenu1</a></li>
              <li><a href="#">SubMenu2</a></li>
              <li><a href="#">SubMenu3</a></li>
            </ul>
          </div>
        </li>
        <li class="active"> <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed"> <span class="glyphicon glyphicon-cloud"></span> Company List <span class="caret pull-right"></span> </a>
          <div class="collapse" id="toggleDemo" style="height: 0px;">
            <ul class="nav nav-list">
              <li><a href="#">Create Company</a></li>
              <li><a href="#">Edit Company</a></li>
              <li><a href="#">Splited List</a></li>
              <li><a href="#">?????</a></li>
            </ul>
          </div>
        </li>
        <li> <a href="#" data-toggle="collapse" data-target="#toggleDemo2" data-parent="#sidenav01" class="collapsed"> <span class="glyphicon glyphicon-inbox"></span> Offer &amp; Deals <span class="caret pull-right"></span> </a>
          <div class="collapse" id="toggleDemo2" style="height: 0px;">
            <ul class="nav nav-list">
              <li><a href="#">Create New Offer</a></li>
              <li><a href="#">Current Offer</a></li>
              <li><a href="#">Beneficiary List</a></li>
              <li><a href="#">Beneficiary Review</a></li>
            </ul>
          </div>
        </li>
        <li data-toggle="modal" data-target=".bs-example-modal-lg"><a href="#"><span class="glyphicon glyphicon-lock"></span> Gallery</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-calendar"></span> WithBadges <span class="badge pull-right">42</span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-cog"></span> PreferencesMenu</a></li>
      </ul>
    </div>
  </div>
</div>
