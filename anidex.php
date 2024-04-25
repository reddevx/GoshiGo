<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: login.php");
    exit();
}

include('conexão.php');

$usuario_id = $_SESSION['usuario_id'];
$html_content = ""; // Variável para armazenar o HTML dos animais

// Verifica se foi submetido um nome de animal para pesquisa
if (isset($_GET['nome_animal'])) {
    $search_name = $_GET['nome_animal'];

    // Consulta SQL com filtro pelo nome do animal
    $sql = "SELECT * FROM bestiario_animais WHERE usuario_id = $usuario_id AND nome_animal LIKE '%$search_name%'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Criação do HTML para os animais encontrados pela pesquisa
        while ($row = $result->fetch_assoc()) {
            // Código HTML dos animais, similar ao que você já possui
            $html_content .= "<div class='animal-card p-5'> <br>";
            $html_content .= "<h2 class='animal-name'>" . $row['nome_animal'] . "</h2>";
            $html_content .= "<img src='" . $row['foto'] . "' alt='" . $row['nome_animal'] . "' class='animal-img'><br>";
            $html_content .= "<div class='animal-info img-fluid'>";
            $html_content .= "<strong>Espécie:</strong> " . $row['especie'] . "<br>";
            $html_content .= "<strong>Descrição:</strong> " . $row['descricao'] . "<br>";
            $html_content .= "<strong>Localização:</strong> " . $row['localizacao'] . "<br>";

            // Adicionar o botão de exclusão apenas se existir a chave 'id' no array $row
            if (isset($row['id'])) {
                $html_content .= "<div class='animal-actions'>";
                $html_content .= "<a href='excluir_animal.php?id=" . $row['id'] . "' class='btn btn-danger'>Excluir</a>";
                $html_content .= "</div><br>";
            }

            $html_content .= "</div>";
            $html_content .= "</div>";
        }
    } else {
        $html_content = "Nenhum animal encontrado com esse nome.";
    }

} else {
    // Consulta SQL para obter os animais do usuário logado
    $sql = "SELECT * FROM bestiario_animais WHERE usuario_id = $usuario_id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Criando o conteúdo HTML para cada animal
            $html_content .= "<div class='animal-card'>";
            $html_content .= "<h2 class='animal-name'>" . $row['nome_animal'] . "</h2>";
            $html_content .= "<img src='" . $row['foto'] . "' alt='" . $row['nome_animal'] . "' class='animal-img'><br>";
            $html_content .= "<div class='animal-info img-fluid'>";
            $html_content .= "<strong>Espécie:</strong> " . $row['especie'] . "<br>";
            $html_content .= "<strong>Descrição:</strong> " . $row['descricao'] . "<br>";
            $html_content .= "<strong>Localização:</strong> " . $row['localizacao'] . "<br>";

            // Adicionar o botão de exclusão apenas se existir a chave 'id' no array $row
            if (isset($row['id'])) {
                $html_content .= "<div class='animal-actions'>";
                $html_content .= "<a href='excluir_animal.php?id=" . $row['id'] . "' class='btn btn-danger k' >Excluir</a>";
                $html_content .= "</div><br><br><br><br>";
            }

            $html_content .= "</div>";
            $html_content .= "</div>";
        }
    } else {
        $html_content = "Nenhum animal cadastrado para este usuário.";
    }
}
$count_query = "SELECT COUNT(*) AS total_animais FROM bestiario_animais WHERE usuario_id = $usuario_id";
$count_result = $mysqli->query($count_query);
if ($count_result) {
    $row_count = $count_result->fetch_assoc();
    $total_animais = $row_count['total_animais'];
} else {
    $total_animais = 0;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['selecionados'])) {
        $animais_selecionados = $_POST['selecionados'];
        $selected_animals_query = "SELECT * FROM bestiario_animais WHERE id IN (" . implode(',', $animais_selecionados) . ")";
        $selected_animals_result = $mysqli->query($selected_animals_query);

        if ($selected_animals_result->num_rows > 0) {
            echo "<h2 class='text-primary'>Animais selecionados:</h2>";
            while ($selected_animal = $selected_animals_result->fetch_assoc()) {
                // Exibindo os animais selecionados
                echo "<section class='card'";
                echo "<div class='animal-card'>";
                echo "<h2 class='animal-name'>" . $selected_animal['nome_animal'] . "</h2>";
                echo "<img src='" . $selected_animal['foto'] . "' alt='" . $selected_animal['nome_animal'] . "' class='animal-img'><br>";
                echo "<div class='animal-info img-fluid'>";
                echo "<strong>Espécie:</strong> " . $selected_animal['especie'] . "<br>";
                echo "<strong>Descrição:</strong> " . $selected_animal['descricao'] . "<br>";
                echo "<strong>Localização:</strong> " . $selected_animal['localizacao'] . "<br>";
                echo "</div>";
                echo "</div>";
                echo "</section>";
            }
        } else {
            echo "Nenhum animal foi selecionado.";
        }
    }
}
$mysqli->close();
?>
<!DOCTYPE html> 
<html>
<head>
    <title>Goshi Go | Ver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap" rel="stylesheet">
    <style>
        /* Estilos CSS personalizados */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

* {
    font-family: 'Montserrat', sans-serif;
}


        body {
            color: #fff;
            margin: 0;
        }

        .animal-card {
            background-color: #2c2f3f;
            max-width: 400px;
            height: 500px;
            border-radius: 10px;
            padding: 10px;
        }

        .animal-name {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .animal-img {
            width: 100%;
            height: 250px;
            margin-bottom: 10px;
            border-radius: 8px;
            object-fit: cover;
        }

        .animal-info {
            font-size: 18px;
            padding: 10px;
        }

        .animal-actions {
            margin-top: 10px;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            width: 70%;
            margin: 0 auto;
        }

::-webkit-scrollbar {
    width: 12px;
    /* largura da scrollbar */
}

::-webkit-scrollbar-track {
    background: #3498db;
}

::-webkit-scrollbar-thumb {
    background: #ff6b81;
    border-radius: 6px;
    /* bordas arredondadas */
}

::-webkit-scrollbar-thumb:hover {
    background-color: #f9ca24;
}

#header {
    background-color: #2c2f3f;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    background-color: #1b1E23;
    overflow-y: auto;
    width: 300px;
    transition: all ease-in-out 0.5s;
    padding: 0 15px;
    z-index: 9997px;
}

#header .profile img {
    margin: 15px auto;
    display: block;
    width: 120px;
    border: 8px solid #2c2f3f;
    border-radius: 50%;
}

#header .profile h1 {
    font-size: 24px;
    margin: 0;
    padding: 0;
    font-weight: 600;
    -moz-text-align-last: center;
    text-align-last: center;
    color: rgb(255, 255, 255);
}

#header .profile h1:hover {
    font-size: 24px;
    margin: 0;
    padding: 0;
    font-weight: 600;
    -moz-text-align-last: center;
    text-align-last: center;
    color: rgb(0, 89, 255);
}

#header .profile .social-links a {
    font-size: 1rem;
    background-color: #212431;
    color: #fff;
    padding: 0.6rem;
    margin-right: 1rem;
    border-radius: 50%;
    transition: 0.3s;
    text-decoration: none;
}

#header .profile .social-links a:hover {
    background: rgb(52, 95, 238);
}

.nav-menu {
    padding: 1.5rem;
}

.nav-menu a,
.nav-menu a:focus {
    display: flex;
    align-items: center;
    color: #a8a9b4;
    transition: 0.3s;
    font-size: 15px;
}


.nav-menu a i,
.nav-menu a:focus i {
    font-size: 24px;
    padding-right: 0.8rem;
    color: #6f707a;
}


.nav-menu a:hover,
.nav-menu .active,
.nav-menu .active:focus,
.nav-menu li:hover>a {
    text-decoration: none;
    color: #fff;
}

.nav-menu a:hover i,
.nav-menu .active i,
.nav-menu .active:focus i,
.nav-menu li:hover>a i {
    text-decoration: none;
    color: #4a37f8;
}

#main {
    margin-left: 300px;
}

section#inicio {
    background-image: url("./img/Design\ sem\ nome\ \(2\).png");
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    width: 100%;
    height: 100vh;
}

section#inicio h2 {
    font-size: 6rem;
}

section#inicio span#subtitle {
    margin-right: 8rem;
    font-size: 1.5rem;
}


.text-shadow {
    text-shadow: 4px 4px 10px #0000;
}

section#inicio div#arraste a {
    width: 9rem;
}

section#inicio div#arraste a {
    text-decoration: none;
    color: white;
}

i.menu-mobile {
    position: fixed;
    color: #fff;
    background-color: #252c90;
    right: 1rem;
    top: 1rem;
    font-size: 1.5rem;
    border-radius: 4rem;
    cursor: pointer;
    z-index: 10;
    width: 45px;
    height: 45px;
    display: none;
    justify-content: center;
    align-items: center;
}

.menu-nav-active {
    overflow: hidden;
}

.menu-nav-active #header {
    left: 0;
}

@media (max-width: 1024px) {
    #header {
        left: -300px;
    }

    i.menu-mobile {
        display: flex;
    }

    section#inicio h2 {
        font-size: 3.5rem;
    }

    section#inicio span#subtitle {
        margin-right: 0;
        font-size: 1rem;
    }

    #main {
        margin-left: 0;
    }
}   
</style>
</head>
<body>


<i class="bi bi-list menu-mobile"></i>
    <aside id="header">
        <section class="profile">
            <img src="/imagem/logo.png" alt="Desenvolvedor DevJuanK" />
            <h1>Goshi Go</h1>

            <div class="social-links mt-4 text-center">
                <a target="_blank" href="https://github.com/DevJuanzok4?tab=repositories">
                    <i class="bi bi-github"></i>
                </a>
                <a target="_blank" href="https://www.linkedin.com/in/juan-coutinho-288625243/">
                    <i class="bi bi-discord"></i>
                </a>
            </div>
        </section>

        <nav id="navbar" class="nav-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="home.html"><i class="bi bi-house"
                            aria-hidden="true"></i>
                        Inicio</a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link" href="cadastrar_animal.html"><i class="bi bi-backpack2" aria-hidden="true"></i>
                        Cadastrar animais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="anidex.php"><i class="bi bi-binoculars" aria-hidden="true"></i>
                        Ver Animais</a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link" href="/contato.html"><i class="bi bi-envelope" aria-hidden="true"></i> Contato</a>
                </li>
            </ul>
        </nav>
    </aside>
<script>
const menuMobile = document.querySelector('.menu-mobile')
const body = document.querySelector('body')

menuMobile.addEventListener('click', () => {
    menuMobile.classList.contains("bi-list")
        ? menuMobile.classList.replace("bi-list", "bi-x")
        : menuMobile.classList.replace("bi-x", "bi-list");
    body.classList.toggle("menu-nav-active")
});

const navItem = document.querySelectorAll('.nav-item')

navItem.forEach(item => {
    item.addEventListener("click", () => {
        if (body.classList.contains("menu-nav-active")) {
            body.classList.remove("menu-nav-active")
            menuMobile.classList.replace("bi-x", "bi-list");
        }
    })

})
</script>


<body>
    <main class="container">
      <br>
      <h1 class="text-primary text-center p-2">Meus Animais Catalogados (<?php echo $total_animais; ?>)</h1>
        <!-- Campo de pesquisa por nome de animal -->
        <div class="search-container p-1">
            <form method="GET" class="form-inline">
                <div class="form-group mx-auto">
                    <input type="text" class="form-control" name="nome_animal" placeholder="Pesquisar por nome do animal">
                    <br>
                </div>
            </form>
        </div>

        <!-- Área para exibir os animais filtrados pela pesquisa -->
        <div id="card" class="card-deck row justify-content-center" style="padding: 10px;">
        <?php echo $html_content; ?><br><p>
        </div>
    </main>
</body>
</html>
