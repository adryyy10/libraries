$(document).ready(function() {
    $("#nav-item-users a").click(function() {
      $("#nav-treeview-users").toggle();
    });

    $("#nav-item-biblioteca a").click(function() {
      $("#nav-treeview-biblioteca").toggle();
    });

    $("#nav-item-libro a").click(function() {
      $("#nav-treeview-libro").toggle();
    });
  });
  