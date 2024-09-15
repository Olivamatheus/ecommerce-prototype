<?php
include('../conexao.php');

// Verifica se os dados foram submetidos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prod_nome'], $_POST['prod_price'], $_POST['prod_qt'])) {
    $prod_nome = $_POST['prod_nome'];
    $prod_price = $_POST['prod_price'];
    $prod_qt = $_POST['prod_qt'];

    // Verifica se um arquivo foi enviado
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];
        $pasta = "../uploads/";
        $nomeDoArquivo = $arquivo['name'];
        $novoNomeDoArquivo = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

        if ($extensao == "jpg" || $extensao == "png") {
            $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

            if (move_uploaded_file($arquivo["tmp_name"], $path)) {
                // Insere os dados do produto no banco de dados
                $sql = "INSERT INTO products (prod_name, prod_price, prod_qt, prod_img, img_path) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sdiss", $prod_nome, $prod_price, $prod_qt, $nomeDoArquivo, $path);

                if ($stmt->execute()) {
                    echo "<script>alert('Produto cadastrado com sucesso!');</script>";
                } else {
                    echo "<p>Erro ao cadastrar o produto: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>Falha ao mover o arquivo!</p>";
            }
        } else {
            echo "<p>Tipo de arquivo não aceito!</p>";
        }
    } else {
        echo "<p>Arquivo não enviado ou ocorreu um erro.</p>";
    }
}

// Consulta para listar produtos cadastrados
$sql_query_prod = $conn->query("SELECT * FROM products") or die($conn->error);

// Consulta para listar pedidos finalizados
$sql_query_pedidos = $conn->query("SELECT * FROM orders") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-cadProd">
        <h1>Admin Page</h1>
        <div class="top-box-cadProd">
            <h3>Cadastro de Produtos</h3>
            <form method="POST" enctype="multipart/form-data" action="">
                <label>Nome do Produto:</label>
                <input type="text" name="prod_nome" required>
                <label>Preço R$:</label>
                <input type="text" name="prod_price" required>
                <label>Quantidade:</label>
                <input type="number" name="prod_qt" required>
                <label>Selecione a imagem</label>
                <input type="file" name="arquivo" required>
                <button name="upload" type="submit">Cadastrar Produto</button>
            </form>
        </div>

        <div class="bott-box-cadProd">
            <h3>Lista de Produtos</h3>
            <table border="1" cellpadding="10">
                <thead>
                    <th>Nome do Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Preview</th>
                    <th>Arquivo</th>
                </thead>
                <tbody>
                <?php while ($produto = $sql_query_prod->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produto['prod_name']); ?></td>
                        <td><?php echo number_format($produto['prod_price'], 2, ',', '.'); ?></td>
                        <td><?php echo $produto['prod_qt']; ?></td>
                        <td><img height="50" src="<?php echo htmlspecialchars($produto['img_path']); ?>" alt=""></td>
                        <td><a target="_blank" href="<?php echo htmlspecialchars($produto['img_path']); ?>"><?php echo htmlspecialchars($produto['prod_img']); ?></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="bott-box-cadProd">
            <h3>Lista de Pedidos Finalizados</h3>
            <table border="1" cellpadding="10">
                <thead>
                    <th>ID do Pedido</th>
                    <th>ID do Cliente</th>
                    <th>Valor Total</th>
                    <th>Data de Criação</th>
                </thead>
                <tbody>
                <?php while ($pedido = $sql_query_pedidos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $pedido['pedido_id']; ?></td>
                        <td><?php echo $pedido['customer_id']; ?></td>
                        <td><?php echo number_format($pedido['total_value'], 2, ',', '.'); ?></td>
                        <td><?php echo $pedido['created_at']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
