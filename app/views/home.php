<h2>Lista de Funcionários</h2>
<div class="block-btn">
    <a href="/controle_funcionarios/public/funcionarios/cadastrar" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i> Cadastrar
    </a>
</div>
<table class="table table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
            <th>Email</th>
            <th>Empresa</th>
            <th>Data de cadastro</th>
            <th>Salário</th>
            <th>Bonificação</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($funcionarios)) : ?>
            <?php foreach ($funcionarios as $funcionario) :
                $dataCadastro = $funcionario['data_cadastro'];
                $dataAtual = new DateTime();
                $dataCadastroObj = new DateTime($dataCadastro);
                $diferenca = $dataCadastroObj->diff($dataAtual);
                if ($diferenca->y >= 5) {
                    $background = "#dc3545";
                } else if ($diferenca->y >= 1) {
                    $background = "#007bff";
                } else {
                    $background = "";
                }
            ?>
                <tr style="background-color: <?php echo $background ?>;">
                    <td><?php echo htmlspecialchars($funcionario['id_funcionario']); ?></td>
                    <td><?php echo htmlspecialchars($funcionario['nome']); ?></td>
                    <td><?php echo htmlspecialchars($funcionario['cpf']); ?></td>
                    <td><?php echo htmlspecialchars($funcionario['rg']); ?></td>
                    <td><?php echo htmlspecialchars($funcionario['email']); ?></td>
                    <td><?php echo htmlspecialchars($funcionario['id_empresa']); ?></td>
                    <td><?php
                        $dataCadastro = $funcionario['data_cadastro'];
                        $date = new DateTime($dataCadastro);
                        echo $date->format('d/m/Y');
                        ?>
                    </td>
                    <td>R$ <?php echo htmlspecialchars($funcionario['salario']); ?></td>
                    <td><?php echo htmlspecialchars($funcionario['bonificacao']); ?> %</td>

                    <td>
                        <a href="/controle_funcionarios/public/funcionarios/editar/<?php echo $funcionario['id_funcionario']; ?>" class="btn btn-warning btn-sm">
                            Editar
                        </a>
                    </td>
                    <td>
                        <form action="/controle_funcionarios/public/funcionarios/excluir/<?php echo $funcionario['id_funcionario']; ?>" method="POST" style="display:inline-block;">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">Nenhum funcionário encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>