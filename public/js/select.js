//DROPDOWN SELECT
var biblioteca = $("[name=libro] option").detach()
$("[name=biblioteca]").change(function() {
var val = $(this).val()
$("[name=libro] option").detach()
biblioteca.filter("." + val).clone().appendTo("[name=libro]")
}).change()