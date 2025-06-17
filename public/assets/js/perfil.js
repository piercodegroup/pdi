document.addEventListener("DOMContentLoaded", () => {
    carregarPerfil();
    carregarPedidos();
    carregarEnderecos();

    const atualizarPerfilBtn = document.getElementById("atualizar-perfil");
    if (atualizarPerfilBtn) {
        atualizarPerfilBtn.addEventListener("click", atualizarPerfil);
    }

    const recuperarSenhaBtn = document.getElementById("recuperar-senha");
    if (recuperarSenhaBtn) {
        recuperarSenhaBtn.addEventListener("click", abrirModalSenha);
    }

    const fecharModalBtn = document.getElementById("fechar-modal");
    if (fecharModalBtn) {
        fecharModalBtn.addEventListener("click", fecharModalSenha);
    }

    const fecharModalEnderecosBtn = document.getElementById("fechar-modal-enderecos");
    if (fecharModalEnderecosBtn) {
        fecharModalEnderecosBtn.addEventListener("click", fecharModalEnderecos);
    }

    document.getElementById("pedidos-container")?.addEventListener("click", (event) => {
        if (event.target.classList.contains("cancelar-pedido")) {
            const pedidoId = event.target.dataset.pedidoId;
            cancelarPedido(pedidoId);
        }
    });

    const adicionarEnderecoBtn = document.getElementById("adicionar-endereco");
    if (adicionarEnderecoBtn) {
        adicionarEnderecoBtn.addEventListener("click", abrirModalAdicionarEndereco);
    }

});

function criarUrl(action, params = {}) {
    let url = `../../controllers/perfilController.php?action=${action}`;
    for (const key in params) {
        url += `&${key}=${encodeURIComponent(params[key])}`;
    }
    return url;
}

function handleError(err, mensagem = "Ocorreu um erro. Tente novamente mais tarde.") {
    Swal.fire({
        title: "Erro!",
        text: mensagem,
        icon: "error",
        confirmButtonText: "OK",
        confirmButtonColor: "#583C2B",
    });
}

function carregarPerfil() {
    fetch(criarUrl("getPerfil"))
        .then(res => res.json())
        .then(data => {
            document.getElementById("nome").value = data.nome || "";
            document.getElementById("email").value = data.email || "";
            const cpfInput = document.getElementById("cpf");
            if (cpfInput) {
                cpfInput.value = data.cpf || "";
                $("#cpf").mask("000.000.000-00"); // Adicionando máscara ao CPF
            }
        })
        .catch(err => handleError(err, "Erro ao carregar perfil."));
}

function atualizarPerfil() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const cpf = document.getElementById("cpf").value;

    if (!nome || !email || !cpf) {
        showNotification("Erro", "Todos os campos são obrigatórios.", "error");
        return;
    }

    fetch(criarUrl("updatePerfil"), {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nome, email, cpf }),
    })
        .then(res => res.json())
        .then(data => showNotification("Sucesso", data.message, "success"))
        .catch(err => showNotification("Erro", "Erro ao atualizar perfil.", "error"));

}

function carregarPedidos() {
    fetch(criarUrl("getPedidos"))
        .then(res => res.json())
        .then(data => {
            const pedidosContainer = document.getElementById("pedidos-container");
            if (pedidosContainer) {
                pedidosContainer.innerHTML = "";
                data.forEach(pedido => {
                    pedidosContainer.innerHTML += `
                        <div class="border p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-gray-800">Pedido #${pedido.codigo_pedido}</p>
                                <p class="text-gray-600 text-sm">Status: <span class="text-blue-600">${pedido.status}</span></p>
                                <p class="text-gray-600 text-sm">Total: R$ ${pedido.preco_total}</p>
                            </div>
                            <button data-pedido-id="${pedido.codigo_pedido}" class="cancelar-pedido bg-color-secondary text-white py-2 px-4 rounded-lg hover:bg-color-primary">
                                Cancelar Pedido
                            </button>
                        </div>
                    `;
                });
            }
        })
        .catch(err => handleError(err, "Erro ao carregar pedidos."));
}

function cancelarPedido(pedidoId) {
    showConfirmation("Cancelar Pedido", "Deseja realmente cancelar este pedido?", () => {
        fetch(criarUrl("cancelarPedido", { id: pedidoId }), {
            method: "POST",
        })
            .then(res => res.json())
            .then(data => {
                showNotification("Sucesso", data.message, "success");
                carregarPedidos();
            })
            .catch(err => showNotification("Erro", "Erro ao cancelar pedido.", "error"));
    });
}

function abrirModalSenha() {
    const modal = document.getElementById("modal-senha");
    modal.classList.remove("hidden");
}

function fecharModalSenha() {
    const modal = document.getElementById("modal-senha");
    modal.classList.add("hidden");
}

function alterarSenha() {
    const novaSenha = document.getElementById("nova-senha").value;
    const confirmarSenha = document.getElementById("confirmar-senha").value;

    if (novaSenha !== confirmarSenha) {
        showNotification("Erro", "As senhas não coincidem.", "error");
        return;
    }

    fetch("../../controllers/perfilController.php?action=alterarSenha", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ novaSenha }),
    })
        .then(res => res.json())
        .then(data => {
            showNotification("Sucesso", data.message, "success");
            fecharModalSenha();
        })
        .catch(err => showNotification("Erro", "Erro ao alterar senha.", "error"));
}

function abrirModalEnderecos() {
    const modal = document.getElementById("modal-enderecos");
    modal.classList.remove("hidden");
}

function fecharModalEnderecos() {
    const modal = document.getElementById("modal-enderecos");
    modal.classList.add("hidden");
}

function carregarEnderecos() {
    fetch(criarUrl("getEnderecos"))
        .then(res => res.json())
        .then(data => {
            const enderecosList = document.getElementById("enderecos-list");
            if (enderecosList) {
                enderecosList.innerHTML = "";
                data.forEach(endereco => {
                    enderecosList.innerHTML += `
                        <div class="border p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-gray-800">${endereco.logradouro}, ${endereco.numero} - ${endereco.bairro}</p>
                                <p class="text-gray-600 text-sm">${endereco.cidade} - ${endereco.estado}</p>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="abrirModalEditarEndereco(${endereco.codigo_endereco})" class="border text-gray-300 py-2 px-4 pt-3 rounded-xl hover:bg-color-secondary hover:text-white"><i class='bx bxs-edit'></i></button>
                                <button onclick="excluirEndereco(${endereco.codigo_endereco})" class="border text-gray-300 py-2 px-4 pt-3 rounded-xl hover:bg-red-600 hover:text-white"><i class='bx bxs-trash' ></i></button>
                            </div>
                        </div>
                    `;
                });
            }
        })
        .catch(err => handleError(err, "Erro ao carregar endereços."));
}


function excluirEndereco(id) {
    showConfirmation("Excluir Endereço", "Deseja realmente excluir este endereço?", () => {
        fetch(`../../controllers/perfilController.php?action=excluirEndereco&id=${id}`, {
            method: "POST",
        })
            .then(res => res.json())
            .then(data => {
                showNotification("Sucesso", data.message, "success");
                carregarEnderecos();
            })
            .catch(err => showNotification("Erro", "Erro ao excluir endereço.", "error"));
    });
}




// Função para abrir o modal de adicionar endereço
function abrirModalAdicionarEndereco() {
    document.getElementById("modal-adicionar-endereco").classList.remove("hidden");
    document.getElementById("form-adicionar-endereco").reset();
}

// Função para fechar o modal de adicionar endereço
function fecharModalAdicionarEndereco() {
    document.getElementById("modal-adicionar-endereco").classList.add("hidden");
}

function confirmarAdicionarEndereco() {
    const endereco = {
        tipo: "Residencial", // Certifique-se de enviar esse campo, caso aplicável.
        logradouro: document.getElementById("logradouro-adicionar").value.trim(),
        numero: document.getElementById("numero-adicionar").value.trim(),
        complemento: null,
        bairro: document.getElementById("bairro-adicionar").value.trim(),
        cidade: document.getElementById("cidade-adicionar").value.trim(),
        estado: document.getElementById("estado-adicionar").value.trim(),
        pais: "Brasil",
        cep: document.getElementById("cep-adicionar").value.trim(),
    };

    fetch(criarUrl("adicionarEndereco"), {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ endereco }),
    })
        .then(res => {
            if (!res.ok) throw new Error("Erro no backend.");
            return res.json();
        })
        .then(data => {
            Swal.fire({
                title: "Sucesso!",
                text: "Endereço adicionado com sucesso!",
                icon: "success",
                confirmButtonText: "OK",
                confirmButtonColor: "#583C2B",
            });
            carregarEnderecos();
            fecharModalAdicionarEndereco();
        })
        .catch(err => handleError(err, "Erro ao adicionar endereço."))
        .finally(() => {
            fecharModalAdicionarEndereco();
        });
}






function abrirModalEditarEndereco(codigo_endereco) {
    const url = criarUrl("getEnderecos", { codigo_endereco });

    fetch(criarUrl("getEnderecos"))
    .then(res => res.json())
    .then(data => {
        const endereco = data.find(end => end.codigo_endereco === codigo_endereco);
        if (!endereco) {
            Swal.fire({
                title: "Atenção!",
                text: "Endereço não encontrado!",
                icon: "warning",
                confirmButtonText: "OK",
                confirmButtonColor: "#583C2B",
            });
            return;
        }
        document.getElementById("cep-editar").value = endereco.cep;
        document.getElementById("logradouro-editar").value = endereco.logradouro;
        document.getElementById("numero-editar").value = endereco.numero;
        document.getElementById("bairro-editar").value = endereco.bairro;
        document.getElementById("cidade-editar").value = endereco.cidade;
        document.getElementById("estado-editar").value = endereco.estado;

        document.getElementById("modal-editar-endereco").dataset.enderecoId = codigo_endereco;
        document.getElementById("modal-editar-endereco").classList.remove("hidden");
    })
    .catch(err => handleError(err, "Erro ao carregar endereço."));

}

// Função para fechar o modal de editar endereço
function fecharModalEditarEndereco() {
    document.getElementById("modal-editar-endereco").classList.add("hidden");
}

// Função para confirmar a edição de um endereço
function confirmarEditarEndereco() {
    const id = document.getElementById("modal-editar-endereco").dataset.enderecoId;
    const cep = document.getElementById("cep-editar").value;
    const logradouro = document.getElementById("logradouro-editar").value;
    const numero = document.getElementById("numero-editar").value;
    const bairro = document.getElementById("bairro-editar").value;
    const cidade = document.getElementById("cidade-editar").value;
    const estado = document.getElementById("estado-editar").value;

    if (!cep || !numero) {
        Swal.fire({
            title: "Atenção!",
            text: "CEP e Número são obrigatórios.",
            icon: "warning",
            confirmButtonText: "OK",
            confirmButtonColor: "#583C2B",
        });
        return;
    }

    const enderecoAtualizado = { cep, logradouro, numero, bairro, cidade, estado };
    const url = criarUrl("editarEndereco", { id });

    fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ endereco: enderecoAtualizado })
    })
        .then(res => res.json())
        .then(data => {
            carregarEnderecos();
            fecharModalEditarEndereco();
        })
        .catch(err => handleError(err, "Erro ao editar endereço."));
}









function buscarEnderecoPorCEP(cepInputId, campos) {
    const cep = document.getElementById(cepInputId).value.replace(/\D/g, "");

    if (cep.length !== 8) {
        showNotification("Erro", "CEP inválido. Insira um CEP válido com 8 dígitos.", "error");
        return;
    }

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(res => res.json())
        .then(data => {
            if (data.erro) {
                showNotification("Erro", "CEP não encontrado.", "error");
                return;
            }

            // Preenche os campos com os dados retornados
            document.getElementById(campos.logradouro).value = data.logradouro || "";
            document.getElementById(campos.bairro).value = data.bairro || "";
            document.getElementById(campos.cidade).value = data.localidade || "";
            document.getElementById(campos.estado).value = data.uf || "";
        })
        .catch(err => showNotification("Erro", "Erro ao buscar endereço pelo CEP.", "error"));
}






function showNotification(title, text, icon = "info") {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: "OK",
        confirmButtonColor: "#583C2B",
    });
}

function showConfirmation(title, text, confirmCallback) {
    Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#583C2B",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
    }).then((result) => {
        if (result.isConfirmed) {
            confirmCallback();
        }
    });
}