<h2>Cadastrar Funcionário</h2>

<p class="info-return"></p>

<form id="formCadastroFuncionario" action="/controle_funcionarios/public/funcionarios/salvar" method="POST">
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome_cad" required>
    </div>
    <div class="form-group">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control" id="cpf" name="cpf_cad" maxlength="14" required>
        <br>
        <span id="cpf-error" class="error-message"></span>

    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email_cad" required>
    </div>
    <div class="form-group">
        <label for="empresa">Empresa</label>
        <select class="form-control" id="empresa" name="empresa_cad" required>
            <option value="0">Selecione a empresa</option>
            <?php if (!empty($empresas)) : ?>
                <?php foreach ($empresas as $empresa) : ?>
                    <option value="<?php echo htmlspecialchars($empresa['id_empresa']); ?>"><?php echo htmlspecialchars($empresa['nome']); ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>

</form>

<div id="mensagem" class="alert mt-3 d-none"></div>