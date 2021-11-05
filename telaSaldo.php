<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Controle de despesas</title>
</head>
<body background="./imagem/imagem1.jpg">
<h2>Bem Vindo(a) <?php session_start();
    echo $_SESSION['login'];

?></h2>

<div class="container">
    <h4>Saldo atual</h4>

    <h1 id="balance" class="balance">R$ 0.00 </h1>

    <h1 id="valor2" style="display: none" ><?php
        echo $_SESSION['fixed_salary'];
        ?></h1>

    <div class="inc-exp-container">
        <div>
            <h4>Renda</h4>
            <p id="money-plus" class="money plus">+ R$0.00</p>
        </div>

        <div>
            <h4>Despesas</h4>
            <p id="money-minus" class="money minus">- R$0.00</p>
        </div>
    </div>

    <h3>Transações</h3>

    <ul id="transactions" class="transactions">

    </ul>

    <h3>Adicionar transação</h3>

    <form method="POST" id="form">
        <div class="form-control">
            <label for="transaction-type">Tipo de Transação</label>
            <br/>
            <select id="transaction-type" name="transaction-type"required>
                <option>Selecione</option>
                <option value="1">Debito</option>
                <option value="2">Credito</option>
            </select>
            <br/>

            <label for="text">Nome</label>
            <input autofocus type="text" id="text" placeholder="Nome da transação" />
        </div>

        <div class="form-control">
            <label for="amount">Valor <br />
                <small>(Despesas acrescentar o valor de negativo antes.)</small>
            </label>
            <input type="number" id="amount" placeholder="Valor da transação" />
        </div>

        <button onclick="verificaTransacao()" class="btn">Adicionar</button>


    </form>
</div>


<script src="script.js"></script>

</body>
</html>


