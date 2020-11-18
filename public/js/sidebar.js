$(document).ready(function() {
    $("#nav-item-users a").click(function() {
      $("#arrow-users").toggleClass('flip');
      $("#nav-treeview-users").toggle();
    });

    $("#nav-item-biblioteca a").click(function() {
      $("#arrow-biblioteca").toggleClass('flip');
      $("#nav-treeview-biblioteca").toggle();
    });

    $("#nav-item-libro a").click(function() {
      $("#arrow-libro").toggleClass('flip');
      $("#nav-treeview-libro").toggle();
    });
  });
  