document.addEventListener('DOMContentLoaded', function() {
    // Função para finalizar o pedido
    document.getElementById('finalize-btn').addEventListener('click', function() {
        if (confirm('Deseja finalizar o pedido?')) {
            // Enviar uma requisição POST para finalizar o pedido
            fetch('carrinho.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'finalize_order': true
                })
            }).then(response => response.text())
              .then(data => {
                  // Redirecionar para a página de confirmação
                  window.location.href = '../pedidos/confirmacao.php';
              });
        }
    });
});
