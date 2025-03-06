

<iframe id="miIframe" src="https://docs.google.com/spreadsheets/d/1tuEloeP8T71eAj054O6xwYaao1S6pUTkZWD6QogfJdE/edit?rm=minimal" style="width: 100%; height: 100%"></iframe>


<script>
    document.getElementById("miIframe").addEventListener("load", function() {
        console.log("El usuario ha cargado la hoja.");
    });

    document.getElementById("miIframe").addEventListener("focus", function() {
        console.log("El usuario está interactuando con la hoja.");
    });

    document.getElementById("miIframe").addEventListener("blur", function() {
        console.log("El usuario dejó de interactuar con la hoja.");
    });
</script>