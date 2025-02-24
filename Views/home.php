<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones Tipo Instagram</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }
        .post, .recommendation {
            width: 300px;
            background: white;
            margin: 15px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .post img, .recommendation img {
            width: 100%;
            height: auto;
        }
        .content {
            padding: 10px;
        }
        .like-btn {
            background: none;
            border: none;
            color: red;
            font-size: 20px;
            cursor: pointer;
        }
        .recommendations {
            width: 300px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Publicaciones</h2>
<div id="posts">
    <div class="post" data-category="nature">
        <img src="https://i.imgur.com/o3LOmOf.jpg" alt="Naturaleza">
        <div class="content">
            <p>Hermoso paisaje natural 🌿</p>
            <button class="like-btn" onclick="likePost(this, 'nature')">❤️</button>
        </div>
    </div>

    <div class="post" data-category="food">
        <img src="https://i.imgur.com/Lk1N8kT.jpg" alt="Comida">
        <div class="content">
            <p>Delicioso platillo 🍕</p>
            <button class="like-btn" onclick="likePost(this, 'food')">❤️</button>
        </div>
    </div>

    <div class="post" data-category="travel">
        <img src="https://i.imgur.com/Dok6Ktx.jpg" alt="Viajes">
        <div class="content">
            <p>Explorando el mundo ✈️</p>
            <button class="like-btn" onclick="likePost(this, 'travel')">❤️</button>
        </div>
    </div>
</div>

<h2>Recomendaciones</h2>
<div id="recommendations" class="recommendations"></div>

<script>
    const recommendations = {
        nature: [
            { img: "https://i.imgur.com/JpH0Ci1.jpg", desc: "Bosque encantador 🌳" },
            { img: "https://i.imgur.com/Q5vx3UJ.jpg", desc: "Montañas majestuosas 🏔" }
        ],
        food: [
            { img: "https://i.imgur.com/dBtrLGl.jpg", desc: "Una hamburguesa deliciosa 🍔" },
            { img: "https://i.imgur.com/wdCWA3L.jpg", desc: "Postre irresistible 🍰" }
        ],
        travel: [
            { img: "https://i.imgur.com/FeWhhRv.jpg", desc: "Relax en la playa 🏖" },
            { img: "https://i.imgur.com/Y6b7Gpx.jpg", desc: "Descubriendo nuevas ciudades 🌆" }
        ]
    };

    function likePost(button, category) {
        button.style.color = button.style.color === "red" ? "black" : "red";

        const recContainer = document.getElementById("recommendations");
        recContainer.innerHTML = "";

        recommendations[category].forEach(item => {
            const recDiv = document.createElement("div");
            recDiv.classList.add("recommendation");
            recDiv.innerHTML = `
                    <img src="${item.img}" alt="Recomendación">
                    <div class="content">
                        <p>${item.desc}</p>
                    </div>
                `;
            recContainer.appendChild(recDiv);
        });
    }
</script>

</body>
</html>
