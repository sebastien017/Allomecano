function affiche_bloc() {
    if (document.getElementById("formGarage").checked)
    {
        document.getElementById("container-formGarage").style.display = "block";
    }
    else
    {
        document.getElementById("container-formGarage").style.display = "none";
    }
}