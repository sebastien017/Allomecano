function affiche_bloc() {
    if (document.getElementById("formGarage").checked)
    {
        document.getElementById("container-formGarage").style.display = "block";
    }
    else
    {
        document.getElementById("container-formGarage").style.display = "none";
    }

    if (document.getElementById("garage_mobility").checked)
    {
        document.getElementById("form-distance").style.display = "block";
    }
    else
    {
        document.getElementById("form-distance").style.display = "none";
    }
}