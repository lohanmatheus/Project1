<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Controle de despesas</title>
</head>
<body background="./imagem/imagem1.jpg">
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">


            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <form class="d-flex">
                            <input class="form-control me-2" id="userName" type="search"
                                   placeholder="Faça sua Busca" aria-label="Search">
                            <button class="btn btn-outline-success" type="button"
                                    onclick="verificaSearch()">Buscar
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div id="area-menu2" style="display: none" class="table-responsive">
                            <table class="table">
                                <thead class="text-uppercase bg-primary text-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Options </th>
                                </tr>
                                </thead>
                                <tbody id="result-list">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="telaSaldo.php" > <button   type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button> </a>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>