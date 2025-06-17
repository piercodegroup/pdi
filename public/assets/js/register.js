import { showPassword } from "../utils/showPassword.js";

// Executa showPassword assim que o script é carregado
showPassword();

// Seleciona o botão de envio para dados de registro
const buttonSubmitData = document.querySelector(".button-submit-data-register");
buttonSubmitData.addEventListener("click", submitData);

// Seleciona as seções das etapas
var step1 = document.querySelector(".step-1");
var step2 = document.querySelector(".step-2");

// Preenche o formulário com dados do localStorage, se existentes
function populateForm() {
  const savedData = JSON.parse(localStorage.getItem("userData"));
  if (savedData) {
    document.getElementById("name").value = savedData.name || "";
    document.getElementById("email").value = savedData.email || "";
    document.getElementById("password").value = savedData.password || "";
    document.getElementById("confirm-password").value = savedData.confirmPassword || "";
    document.getElementById("cpf").value = savedData.cpf || "";
  }
}

// Função para submeter os dados da etapa inicial
async function submitData(e) {
  e.preventDefault();

  const data = {
    name: document.getElementById("name").value,
    email: document.getElementById("email").value,
    password: document.getElementById("password").value,
    confirmPassword: document.getElementById("confirm-password").value,
  };

  let currentDataStorage = JSON.parse(localStorage.getItem("userData")) || {};

  // Atualiza dados no localStorage com os novos valores e mantém o CPF se já existir
  let newDataStorage = { ...data };
  newDataStorage.cpf = currentDataStorage?.cpf ?? "";
  localStorage.setItem("userData", JSON.stringify(newDataStorage));

  populateForm();
  
  checkResponse(await fetchRegister(data));
}

// Adiciona o evento ao botão de CPF para a próxima etapa
const buttonSubmitCpf = document.querySelector(".button-submit-data-cpf");
buttonSubmitCpf.addEventListener("click", (e) => submitCpf(JSON.parse(localStorage.getItem("userData")), e));

// Função para submeter os dados do CPF na segunda etapa
async function submitCpf(data, e) {
  e.preventDefault();
  data.cpf = document.getElementById("cpf").value;
  localStorage.setItem("userData", JSON.stringify(data));

  checkResponse(await fetchRegister(data));
  console.log('criado 1')
}

// Função para enviar dados ao servidor
async function fetchRegister(data) {
  const url = "controllers/clienteController.php";
  data.operation = "create";

  const req = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
    },
    body: JSON.stringify(data)
  });

  const result = await req.json();
  console.log('criado 2')
  return result;
}

// Função para processar e exibir respostas do servidor
async function checkResponse(result) {
  console.log(result);

  if (result.status === "error") {
    document.querySelectorAll(".message-error").forEach(message => message.remove());
    document.querySelectorAll(".input-container").forEach(input => input.classList.remove("border"));

    if (result.invalid_fields) {
      result.invalid_fields.forEach((field) => {
        let inputContainer = document.getElementById(field.field).parentElement;
        let messageError = document.createElement("span");

        messageError.textContent = field.error;
        messageError.classList.add("message-error", "text-[12px]", "mt-1", "text-red-500");

        inputContainer.classList.add("border", "border-red-500");
        inputContainer.insertAdjacentElement("afterend", messageError);
      });
    }

    if (!step1.classList.contains("hidden")) {
      if (result.invalid_fields && result.invalid_fields.length === 1 && result.invalid_fields[0].field === "cpf") {
        document.querySelectorAll(".message-error").forEach(message => message.remove());
        document.querySelectorAll(".input-container").forEach(input => input.classList.remove("border"));
        nextStep();
      }
    }
    return;
  }

  localStorage.removeItem("userData"); // Limpa dados se o registro for bem-sucedido
}

// Avança para a próxima etapa do formulário
function nextStep() {
  step1.classList.add("hidden");
  step2.classList.remove("hidden");
  populateForm();
}

// Controle de navegação entre etapas
(function controlStep() {
  const buttonPrevStep1 = document.querySelector(".button-prev-step-1");
  buttonPrevStep1.addEventListener("click", function () {
    let currentValue = document.getElementById("cpf").value;
    let data = JSON.parse(localStorage.getItem('userData')) || {};
    data.cpf = currentValue;
    localStorage.setItem("userData", JSON.stringify(data));

    step2.classList.add("hidden");
    step1.classList.remove("hidden");
  });
})();

// Função para aplicar máscara no CPF
(function maskCpf() {
  document.getElementById('cpf').addEventListener('input', function (event) {
    let value = event.target.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    value = value.replace(/^(\d{3})(\d)/, '$1.$2');    // Adiciona o primeiro ponto
    value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3'); // Adiciona o segundo ponto
    value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4'); // Adiciona o traço
    event.target.value = value.slice(0, 14); // Limita ao tamanho máximo do CPF
  });
})();

// Remove dados ao carregar a página
document.addEventListener('DOMContentLoaded', () => localStorage.removeItem("userData"));
