<h2>Editar Funcionário</h2>

<p id="info-return-edit"></p>

<form id="formEdicaoFuncionario" method="POST">
    <input type="hidden" name="id_funcionario" id="id_funcionario" value="<?php echo htmlspecialchars($funcionario['id_funcionario']) ?>">
    <div class="form-group">
        <label for="nome_edit">Nome</label>
        <input value="<?php echo htmlspecialchars($funcionario['nome']) ?>" type="text" class="form-control" id="nome_edit" name="nome_edit" required>
    </div>
    <div class="form-group">
        <label for="cpf_edit">CPF</label>
        <input type="text" value="<?php echo htmlspecialchars($funcionario['cpf']) ?>" class="form-control cpf" id="cpf_edit" name="cpf_edit" maxlength="14" required>
        <br>
        <span id="cpf-error" class="error-message"></span>

    </div>
    <div class="form-group">
        <label for="email_edit">Email</label>
        <input type="email" value="<?php echo htmlspecialchars($funcionario['email']) ?>" class="form-control" id="email_edit" name="email_edit" required>
    </div>
    <div class="form-group">
        <label for="empresa_edit">Empresa</label>
        <select class="form-control" id="empresa_edit" name="empresa_edit" required>
            <option value="0">Selecione a empresa</option>
            <?php if (!empty($empresas)) : ?>
                <?php foreach ($empresas as $empresa) : ?>
                    <option value="<?php echo htmlspecialchars($empresa['id_empresa']); ?>" <?php echo ($empresa['id_empresa'] == $funcionario['id_empresa']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($empresa['nome']); ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Editar</button>

</form>

<div id="mensagem" class="alert mt-3 d-none"></div>