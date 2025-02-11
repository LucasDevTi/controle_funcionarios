
function showLoading() {
    document.getElementById('loading-overlay').style.display = 'flex';
}

function hideLoading() {
    document.getElementById('loading-overlay').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const cpfInput = document.querySelector('.cpf');
    const cpfError = document.getElementById('cpf-error');
    const formCadastroFuncionario = document.getElementById('formCadastroFuncionario');
    const formEdicaoFuncionario = document.getElementById('formEdicaoFuncionario');
    const formCadastroEmpresa = document.getElementById('formCadastroEmpresa');


    // Máscara CPF
    if (cpfInput) {
        cpfInput.addEventListener('input', function () {
            let cpf = cpfInput.value.replace(/\D/g, '');

            if (cpf.length > 11) cpf = cpf.substring(0, 11);

            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            cpfInput.value = cpf;
        });
    }

    function validarCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');
        if (cpf.length !== 11) return false;

        // Impede CPFs números iguais (ex: 111.111.111-11)
        if (/^(\d)\1{10}$/.test(cpf)) return false;

        let soma = 0;
        let resto;

        // Validação do 1º dígito verificador
        for (let i = 1; i <= 9; i++) {
            soma += parseInt(cpf.charAt(i - 1)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;

        soma = 0;
        // Validação do 2º dígito verificador
        for (let i = 1; i <= 10; i++) {
            soma += parseInt(cpf.charAt(i - 1)) * (12 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    if (formCadastroFuncionario) {

        document.getElementById('formCadastroFuncionario').addEventListener('submit', function (event) {
            const cpfValue = cpfInput.value;
            event.preventDefault();

            saveFuncionario();

            if (!validarCPF(cpfValue)) {
                cpfError.textContent = "CPF inválido!";
            } else {
                cpfError.textContent = "";
            }
        });
    }

    if (formEdicaoFuncionario) {
        document.getElementById('formEdicaoFuncionario').addEventListener('submit', function (event) {
            const cpfValue = cpfInput.value;
            event.preventDefault();
            updateFuncionario();

            if (!validarCPF(cpfValue)) {
                cpfError.textContent = "CPF inválido!";
            } else {
                cpfError.textContent = "";
            }
        });
    }

    if (formCadastroEmpresa) {
        document.getElementById('formCadastroEmpresa').addEventListener('submit', function (event) {
            event.preventDefault();
            insertEmpresa();
        });
    }
});

function alertMsg(element, remove, add, msg) {

    element.textContent = '';
    element.textContent = msg;

    element.style.display = 'block';
    element.style.opacity = 1;
    element.classList.remove(remove);
    element.classList.add(add);
}

function saveFuncionario() {

    var nome = document.getElementById('nome').value;
    var email = document.getElementById('email').value;
    var cpf = document.getElementById('cpf').value;
    const select = document.getElementById('empresa');
    var id_empresa = select.value;
    let infoReturn = document.querySelector('.info-return');

    if (nome == "" || cpf == "" || email == "" || id_empresa == "") {
        alertMsg(infoReturn, 'red', 'green', "Todos os dados precisam ser preenchidos");
        return;
    }
    showLoading();
    $.ajax({
        url: '/controle_funcionarios/public/funcionarios/salvar',
        type: 'POST',
        async: true,
        method: 'POST',
        dataType: 'json',
        data: {
            nome_cad: nome,
            cpf_cad: cpf,
            email_cad: email,
            empresa_cad: id_empresa
        },
        success: function (response) {
            console.log(response.success)
            if (response.success) {
                alertMsg(infoReturn, 'red', 'green', response.message);
                hideLoading();
            } else {
                console.log(response);
                alertMsg(infoReturn, 'green', 'red', response.message);
                hideLoading();
            }
        }, error: function () {
            alertMsg(infoReturn, 'green', 'red', "Houve um erro inesperado! Por favor tente novamente.");
            hideLoading();
        }
    });

}

function updateFuncionario() {

    var nome = document.getElementById('nome_edit').value;
    var email = document.getElementById('email_edit').value;
    var cpf = document.getElementById('cpf_edit').value;
    const select = document.getElementById('empresa_edit');
    var id_empresa = select.value;
    let infoReturnEdit = document.querySelector('#info-return-edit');
    let id_funcionario = document.getElementById('id_funcionario').value;

    if (nome == "" || cpf == "" || email == "" || id_empresa == "") {
        alertMsg(infoReturnEdit, 'red', 'green', "Todos os dados precisam ser preenchidos");
        return;
    }
    showLoading();
    $.ajax({
        url: '/controle_funcionarios/public/funcionarios/update',
        type: 'POST',
        async: true,
        method: 'POST',
        dataType: 'json',
        data: {
            nome_edit: nome,
            cpf_edit: cpf,
            email_edit: email,
            empresa_edit: id_empresa,
            id: id_funcionario
        },
        success: function (response) {
            if (response.success) {
                alertMsg(infoReturnEdit, 'red', 'green', response.message);
                hideLoading();
            } else {
                alertMsg(infoReturnEdit, 'green', 'red', response.message);
                hideLoading();
            }
        }, error: function () {
            alertMsg(infoReturnEdit, 'green', 'red', "Houve um erro inesperado! Por favor tente novamente.");
            hideLoading();
        }
    });

}

function excluir(event, id) {

    event.preventDefault();

    let infoReturnFuncionario = document.querySelector('#info-return-funcionarios');

    if (id == "") {
        alertMsg(infoReturnFuncionario, 'red', 'green', "Houve um erro inesperado, por favor recarregue a página e tente novamente!");
        return;
    }

    if (confirm("Tem certeza que deseja excluir esse funcionário?")) {
        showLoading();
        $.ajax({
            url: '/controle_funcionarios/public/funcionarios/excluir',
            type: 'POST',
            async: true,
            method: 'POST',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function (response) {
                console.log(response.success)
                if (response.success) {
                    alertMsg(infoReturnFuncionario, 'red', 'green', response.message);
                    hideLoading();
                    alert("Funcionário excluido com sucesso");
                    location.reload();
                } else {
                    console.log(response);
                    alertMsg(infoReturnFuncionario, 'green', 'red', response.message);
                    hideLoading();
                }
            }, error: function () {
                alertMsg(infoReturnFuncionario, 'green', 'red', "Houve um erro inesperado! Por favor tente novamente.");
                hideLoading();
            }
        });
    }
}

function insertEmpresa() {

    var nome = document.getElementById('nome_empresa').value;
    let infoReturnEmpresa = document.querySelector('#info-return-empresa');

    if (nome == "") {
        alertMsg(infoReturn, 'red', 'green', "Por favor preencha o nome da empresa");
        return;
    }
    showLoading();
    $.ajax({
        url: '/controle_funcionarios/public/empresas/insert',
        type: 'POST',
        async: true,
        method: 'POST',
        dataType: 'json',
        data: {
            nome: nome,
        },
        success: function (response) {
            console.log(response.success)
            if (response.success) {
                alertMsg(infoReturnEmpresa, 'red', 'green', response.message);
                hideLoading();
            } else {
                console.log(response);
                alertMsg(infoReturnEmpresa, 'green', 'red', response.message);
                hideLoading();
            }
        }, error: function () {
            alertMsg(infoReturnEmpresa, 'green', 'red', "Houve um erro inesperado! Por favor tente novamente.");
            hideLoading();
        }
    });

}

function exportarPdf() {
    let infoReturnFuncionario = document.querySelector('#info-return-funcionarios');

    showLoading();
    $.ajax({
        url: '/controle_funcionarios/public/funcionarios/exportarpdf',
        async: true,
        method: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data, status, xhr) {
            var blob = data;
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'funcionarios.pdf';  
            link.click();  /* Inicia o download automaticamente */
            hideLoading();

        }, error: function (xhr, status, error) {
            console.log(error);
            alertMsg(infoReturnFuncionario, 'green', 'red', "Houve um erro inesperado! Por favor tente novamente.");
            hideLoading();
        }
    });

}


