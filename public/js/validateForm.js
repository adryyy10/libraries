function validateForm() {
    var titulo = document.forms["formLibro"]["titulo"].value;
    var biblioteca = document.forms["formLibro"]["biblioteca"].value;
    console.log(biblioteca);
    
    if (titulo == "") {
        errorTitulo = "El título no puede estar vacío";
        document.getElementById("errorTitulo").innerHTML = errorTitulo;
        return false;
    }

    if (biblioteca == "") {
        errorBiblioteca = "La biblioteca no puede estar vacía";
        document.getElementById("errorBiblioteca").innerHTML = errorBiblioteca;
        return false;
    }
}