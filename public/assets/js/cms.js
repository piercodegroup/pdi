document.addEventListener("DOMContentLoaded", () => {
  const navbarLinks = document.querySelectorAll(".navbar-link");
  const contentSection = document.querySelector(".content");
  
  // Conteúdo da página dinamicamente
  async function loadPageContent(page, e) {
    try {
      // Realiza a requisição para carregar a página solicitada
      const response = await fetch(`./views/administrador/${page}.html`);
      if (!response.ok) {
        throw new Error(`Erro ao carregar a página: ${response.status} ${response.statusText}`);
      }

      // Insere o conteúdo HTML carregado na seção .content
      const html = await response.text();
      contentSection.innerHTML = html;

      // Reexecuta scripts carregados na página
      executeInlineScripts(contentSection);

      if (page === "cardapio/listar-produtos") {
        const buttonAddProduct = document.querySelector(".button-go-page-create-product");
        if (buttonAddProduct) {
          buttonAddProduct.addEventListener("click", () => {
            loadPageContent("cardapio/criar-produto");
          });
        }

        const buttonLinkListCategory = document.querySelector(".link-page-category");
        if (buttonLinkListCategory) {
          buttonLinkListCategory.addEventListener("click", () => {
            loadPageContent("categoria/listar-categorias");
          });
        }
      }

      if (page === "cardapio/criar-produto") {
        const buttonBackPage = document.querySelector(".button-back-page");
        if (buttonBackPage) {
          buttonBackPage.addEventListener("click", () => {
            loadPageContent("cardapio/listar-produtos");
          });
        }

        document.getElementById("input-file-upload").addEventListener("change", captureImage);
      }

      if (page === "categoria/listar-categorias") {
        const buttonLinkListProduct = document.querySelector(".link-page-product");
        if (buttonLinkListProduct) {
          buttonLinkListProduct.addEventListener("click", () => {
            loadPageContent("cardapio/listar-produtos");
          });
        }

        const buttonAddCategory = document.querySelector(".button-go-page-create-category");
        if (buttonAddCategory) {
          buttonAddCategory.addEventListener("click", () => {
            loadPageContent("categoria/criar-categoria");
          });
        }

        const result = await fetchCategory({ operation: "list" });
        listCategory(result.data);
      }

      if (page === "categoria/criar-categoria") {
        const buttonBackPage = document.querySelector(".button-back-page");
        if (buttonBackPage) {
          buttonBackPage.addEventListener("click", () => {
            loadPageContent("categoria/listar-categorias");
          });
        }

        document.querySelector(".input-file-upload").addEventListener("change", captureImage);

        const buttonCreateCategory = document.querySelector(".button-create-category");
        buttonCreateCategory.addEventListener("click", (e) => submitCategoryForm("create", e));

        document.querySelectorAll(".input-container").forEach(input => {
          input.children[0].addEventListener("focus", () => {
            if (input.nextElementSibling) {
              input.nextElementSibling.remove();
              input.classList.remove("border-red-500")
            }
          })
        });
      }

      if (page == "categoria/editar-categoria") {
        const buttonBackPage = document.querySelector(".button-back-page");

        // Recuperar o ID da categoria
        const idCategoria = e.closest("tr").dataset.id;

        if (buttonBackPage) {
          buttonBackPage.addEventListener("click", () => {
            loadPageContent("categoria/listar-categorias");
          });
        }

        loadCategoyDataEdit(idCategoria);

        async function loadCategoyDataEdit(id) {
          try {
            const res = await fetchCategory({ operation: "list", id });
            const data = res.data;

            const form = document.querySelector(".form-edit-category");
            if (!form) {
              console.error("Formulário não encontrado.");
              return;
            }

            // Preencher os campos do formulário
            form.querySelector("#name").value = data.nome;
            form.querySelector("#description").value = data.descricao;

            // Exibir o nome da imagem
            const imagePathParts = data.imagem.split("_");
            const imagePath = imagePathParts[1] || data.imagem;
            form.querySelector(".message-status-upload-image").textContent = imagePath;

            // Exibir a imagem existente
            const captureImageArea = document.querySelector(".capture-image-area");
            captureImageArea.innerHTML = `
              <img src="${data.imagem.replace(".", "")}" alt="${data.nome}" class="object-cover w-full rounded-md" />
            `;

            // Configurar o campo de upload de arquivo
            const inputFileUpload = document.querySelector(".input-file-upload");
            if (inputFileUpload) {
              inputFileUpload.addEventListener("change", (event) => {
                captureImage(event);
              });
            }

            // Configurar botão de edição de categoria
            const buttonEditCategory = document.querySelector(".button-edit-category");
            if (buttonEditCategory) {
              buttonEditCategory.addEventListener("click", (e) => {
                submitCategoryForm("edit", e, id);
              });
            }

            // Lógica para remover mensagens de erro nos inputs
            document.querySelectorAll(".input-container").forEach((inputContainer) => {
              const input = inputContainer.children[0];
              if (input) {
                input.addEventListener("focus", () => {
                  const errorElement = inputContainer.nextElementSibling;
                  if (errorElement) {
                    errorElement.remove();
                    inputContainer.classList.remove("border-red-500");
                  }
                });
              }
            });
          } catch (error) {
            console.error("Erro ao carregar dados da categoria:", error);
          }
        }
      }
    } catch (error) {
      console.error(error);
      contentSection.innerHTML = `
        <div class="text-red-500 font-semibold">
          Não foi possível carregar a página <strong>${page}</strong>.
        </div>
      `;
    }
  }

  // Links para as páginas
  navbarLinks.forEach(link => {
    link.addEventListener("click", async (event) => {
      event.preventDefault(); // Previne comportamento padrão do link

      // Obtenha o nome da página a partir do atributo data-page
      const page = link.getAttribute("data-page");

      if (page) {
        loadPageContent(page);
      }
    });
  });

  // Features: CATEGORIA
  async function submitCategoryForm(op, e, id) {
    e.preventDefault();

    // Captura os valores dos campos do formulário
    const categoryName = document.getElementById("name").value.trim();
    const categoryDescription = document.getElementById("description").value.trim();
    const inputFile = document.getElementById("image");
    const imageFile = inputFile.files[0]; // Captura o arquivo enviado (se houver)

    const formData = new FormData();
    formData.append("operation", op);
    if (op === "edit") formData.append("id", id);
    formData.append("name", categoryName);
    formData.append("description", categoryDescription);

    // Verifica se a imagem foi alterada
    if (imageFile) {
      formData.append("image", imageFile);
    }

    // Enviar o formulário com base na operação (create ou edit)
    if (op === "create") {
      try {
        const result = await fetchCategoryCreate(formData);
        handleResponse(result);
      } catch (error) {
        displayError("Ocorreu um erro ao criar a categoria.");
        console.log(error);
      }
    } else if (op === "edit") {
      try {
        const result = await fetchCategoryEdit(formData);
        handleResponse(result);
      } catch (error) {
        displayError("Ocorreu um erro ao editar a categoria.");
        console.log(error);
      }
    }
  }

  async function fetchCategoryCreate(data) {
    const url = "./controllers/categoriaController.php";

    const response = await fetch(url, {
      method: "POST",
      body: data
    });

    return await response.json();
  }

  async function fetchCategoryEdit(data) {
    const url = "./controllers/categoriaController.php";

    const response = await fetch(url, {
      method: "POST",
      body: data
    });

    return await response.json();
  }

  async function fetchCategory(data) {
    const url = "./controllers/categoriaController.php";

    const response = await fetch(url, {
      method: "POST",
      body: data,
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
      },
      body: JSON.stringify(data)
    });

    return await response.json();
  }

  function showImageCategory(e) {
    // Certifique-se de pegar o botão correto independentemente do elemento clicado
    const button = e.target.closest(".button-show-image-category");

    if (!button) return; // Se o clique não foi em algo dentro do botão, ignorar

    const rowData = button.closest("tr"); // Pega a linha associada
    const showImageContainer = document.querySelector(".show-image-container");

    // Aplique a transição para exibir o modal
    showImageContainer.style.transition = "all 0.5s ease-in-out";  // Garantir transição suave
    showImageContainer.classList.remove("hidden");
    showImageContainer.classList.add("flex");

    const categoryName = showImageContainer.querySelector(".category-name-modal");
    const categoryImage = showImageContainer.querySelector(".category-image-modal");

    categoryName.textContent = rowData.dataset.name;
    categoryImage.src = rowData.dataset.image.replace(".", "");

    const buttonCloseShowImageContainer = document.querySelector(".button-close-show-image-container");

    document.addEventListener("keydown", (e) => {
      if (e.keyCode == 27) {
        // Aplicando a transição para fechar
        showImageContainer.style.transition = "all 0.5s ease-in-out";
        showImageContainer.classList.remove("flex");
        showImageContainer.classList.add("hidden");
      }
    });

    buttonCloseShowImageContainer.addEventListener("click", () => {
      // Aplicando a transição para fechar
      showImageContainer.style.transition = "all 0.5s ease-in-out";
      showImageContainer.classList.remove("flex");
      showImageContainer.classList.add("hidden");
    });
  }

  function showDropdownMenu(e) {
    const button = e.target.closest(".button-show-dropdown-menu");

    if (!button) return;

    // Localiza o elemento pai mais próximo e, dentro dele, o menu dropdown
    const parentTd = button.closest("td");
    const dropDownContainer = parentTd.querySelector(".dropdown-menu");


    const buttonDeleteCategory = dropDownContainer.querySelector(".button-delete-category");
    buttonDeleteCategory.addEventListener("click", deleteCategory);

    const buttonEditCategory = dropDownContainer.querySelector(".button-edit-category");
    buttonEditCategory.addEventListener("click", () => loadPageContent("categoria/editar-categoria", buttonEditCategory));

    // Fecha todos os outros dropdowns
    document.querySelectorAll(".dropdown-menu.flex").forEach((dropdown) => {
      if (dropdown !== dropDownContainer) {
        dropdown.classList.replace("flex", "hidden");
      }
    });

    // Alterna o estado do dropdown atual
    if (dropDownContainer.classList.contains("hidden")) {
      dropDownContainer.classList.replace("hidden", "flex");
    } else {
      dropDownContainer.classList.replace("flex", "hidden");
    }

    // Fecha o dropdown ao pressionar a tecla Esc
    document.addEventListener(
      "keydown",
      (e) => {
        if (e.keyCode == 27) {
          dropDownContainer.classList.replace("flex", "hidden");
        }
      },
      { once: true } // Garante que o evento seja executado apenas uma vez
    );

    // Fecha o dropdown ao clicar fora
    document.addEventListener(
      "click",
      (event) => {
        if (!parentTd.contains(event.target)) {
          dropDownContainer.classList.replace("flex", "hidden");
        }
      },
      { once: true } // Adiciona o evento apenas uma vez
    );
  }

  function showDescriptionCategory(e) {
    // Certifique-se de pegar o botão correto independentemente do elemento clicado
    const button = e.target.closest(".button-show-description-category");

    if (!button) return; // Se o clique não foi em algo dentro do botão, ignorar

    const rowData = button.closest("tr"); // Pega a linha associada
    const showDescriptionContainer = document.querySelector(".show-description-container");

    // Aplique a transição para exibir o modal
    showDescriptionContainer.style.transition = "all 0.5s ease-in-out";  // Garantir transição suave
    showDescriptionContainer.classList.remove("hidden");
    showDescriptionContainer.classList.add("flex");

    const categoryName = showDescriptionContainer.querySelector(".category-name-modal");
    const categoryImage = showDescriptionContainer.querySelector(".category-image-modal");
    const categoryDescription = showDescriptionContainer.querySelector(".category-description-modal");

    categoryName.textContent = rowData.dataset.name;
    categoryImage.src = rowData.dataset.image.replace(".", "");
    categoryDescription.textContent = rowData.dataset.description;

    console.log(rowData.dataset.description);

    const buttonCloseShowDescriptionContainer = document.querySelector(".button-close-show-description-container");

    document.addEventListener("keydown", (e) => {
      if (e.keyCode == 27) {
        // Aplicando a transição para fechar
        showDescriptionContainer.style.transition = "all 0.5s ease-in-out";
        showDescriptionContainer.classList.remove("flex");
        showDescriptionContainer.classList.add("hidden");
      }
    });

    buttonCloseShowDescriptionContainer.addEventListener("click", () => {
      // Aplicando a transição para fechar
      showDescriptionContainer.style.transition = "all 0.5s ease-in-out";
      showDescriptionContainer.classList.remove("flex");
      showDescriptionContainer.classList.add("hidden");
    });
  }

  function deleteCategory(e) {
    const categoryID = e.target.closest("tr").dataset.id;

    const modalConfirmDelete = document.querySelector(".show-confirme-delete-category-container");
    modalConfirmDelete.classList.replace("hidden", "flex");

    const buttonCloseModal = modalConfirmDelete.querySelector(".button-close-show-image-container");
    buttonCloseModal.addEventListener("click", () => modalConfirmDelete.classList.replace("flex", "hidden"));

    const buttonCancel = modalConfirmDelete.querySelector(".button-cancel-delete-category");
    buttonCancel.addEventListener("click", () => modalConfirmDelete.classList.replace("flex", "hidden"));

    const buttonConfirm = modalConfirmDelete.querySelector(".button-confirm-delete-category");
    buttonConfirm.addEventListener("click", async () => {
      const res = await fetchCategory({ operation: "delete", id: categoryID });
      modalConfirmDelete.classList.replace("flex", "hidden");
      if (res.status == "success") {
        location.reload();
      }
    });
  }

  let currentPage = 1;
  const recordsPerPage = 5;
  async function listCategory(data) {
    const container = document.querySelector(".tbody-content");
    const totalRecords = data.length;
    const totalPages = Math.ceil(totalRecords / recordsPerPage);

    // Função para exibir os registros de acordo com a página atual
    async function displayPage(page) {
      container.innerHTML = ''; // Limpa os registros anteriores
      const startIndex = (page - 1) * recordsPerPage;
      const endIndex = Math.min(startIndex + recordsPerPage, totalRecords);

      // Exibe os registros da página atual
      const pageData = data.slice(startIndex, endIndex);

      if (pageData.length == 0) {
        container.innerHTML += `<tr class="bg-color-light h-max text-color-secondary overflow-hidden">
          <td colspan="5" class="py-4 px-8 rounded-l-x">Nenhuma categoria foi registrada</td>
        </tr>`;
        return;
      }

      for (const categoria of pageData) {
        const result = await fetchCategory({ operation: "listProducts", category: categoria.nome });
        container.innerHTML += `<tr class="bg-color-light h-max text-color-secondary overflow-hidden" data-id="${categoria.codigo_categoria}" data-image="${categoria.imagem}" data-description="${categoria.descricao}" data-name="${categoria.nome}">
          <td class="py-4 px-4 pl-8 rounded-l-xl">${categoria.codigo_categoria}</td>
          <td class="py-4 px-4 text-left">${categoria.nome}</td>
          <td class="py-4 px-4">${result.data ? result.data.quantidade_produtos : "0"}</td>
          <td class="py-4 px-4 font-medium">
            <button class="button-show-image-category flex items-center gap-1 cursor-pointer hover:opacity-80">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-images">
                <path d="M18 22H4a2 2 0 0 1-2-2V6" />
                <path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18" />
                <circle cx="12" cy="8" r="2" />
                <rect width="16" height="16" x="6" y="2" rx="2" />
              </svg>
              Abrir
            </button>
          </td>
          <td class="py-4 px-4 font-medium">
            <span class="button-show-description-category flex items-center gap-1 cursor-pointer hover:opacity-80">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-text">
                <path d="M17 6.1H3" />
                <path d="M21 12.1H3" />
                <path d="M15.1 18H3" />
              </svg>
              Ver
            </span>
          </td>
          <td class="py-4 pr-8 px-4 rounded-r-xl relative">
          <!-- Botão para abrir o menu -->
          <button class="button-show-dropdown-menu cursor-pointer flex items-center gap-1 hover:opacity-80">
            <!-- Ícone do botão -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-ellipsis">
              <circle cx="12" cy="12" r="1" />
              <circle cx="19" cy="12" r="1" />
              <circle cx="5" cy="12" r="1" />
            </svg>
          </button>
          
          <!-- Menu dropdown -->
          <div
            class="dropdown-menu hidden absolute left-0 top-full border border-zinc-200 w-32 bg-color-light rounded-xl shadow-lg z-20 text-sm py-2">
            <ul class="menu flex flex-col gap-2 text-color-secondary w-full">
              <li class="button-edit-category flex gap-2 p-2 cursor-pointer hover:bg-gray-100 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-pencil-line w-5 h-5">
                  <path d="M12 20h9" />
                  <path
                    d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z" />
                  <path d="m15 5 3 3" />
                </svg>
                Editar
              </li>
              <hr class="h-[2px] bg-gray-200 w-full">
              <li class="button-delete-category flex gap-2 p-2 cursor-pointer hover:bg-gray-100 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-trash-2 w-5 h-5">
                  <path d="M3 6h18" />
                  <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                  <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                  <line x1="10" x2="10" y1="11" y2="17" />
                  <line x1="14" x2="14" y1="11" y2="17" />
                </svg>
                Excluir
              </li>
            </ul>
          </div>
        </td>
        
        </tr>`;
      }

      const buttonShowImageCategory = document.querySelectorAll(".button-show-image-category");
      buttonShowImageCategory.forEach(button => button.addEventListener("click", showImageCategory));

      const buttonShowDescriptionCategoey = document.querySelectorAll(".button-show-description-category");
      buttonShowDescriptionCategoey.forEach(button => button.addEventListener("click", showDescriptionCategory));

      const buttonShowDropdown = document.querySelectorAll(".button-show-dropdown-menu");
      buttonShowDropdown.forEach(button => button.addEventListener("click", showDropdownMenu));

      // Atualiza a quantidade de registros exibidos
      document.querySelector(".quantity-show").textContent = pageData.length;
      document.querySelector(".quantity-register").textContent = totalRecords;
    }

    // Função para atualizar a navegação
    function updateNavigation() {
      const totalPages = Math.ceil(totalRecords / recordsPerPage);
      const dots = document.querySelector(".dots-pages");
      dots.innerHTML = ''; // Limpa as páginas anteriores

      for (let i = 1; i <= totalPages; i++) {
        const pageDot = document.createElement('div');
        pageDot.classList.add('dot', 'bg-color-light', 'cursor-pointer', 'hover:opacity-80', 'text-color-secondary', 'font-semibold', 'flex', 'w-5', 'h-5', 'items-center', 'justify-center', 'p-4', 'rounded-lg');
        pageDot.innerHTML = `<span class="page-number">${i}</span>`;

        // Verifica se é a página atual e adiciona a classe ativa
        if (i === currentPage) {
          pageDot.classList.add('bg-color-secondary', 'text-white'); // Página ativa
        } else {
          pageDot.classList.add('bg-color-light', 'text-color-secondary'); // Página inativa
        }

        pageDot.addEventListener('click', () => {
          currentPage = i;
          displayPage(i);
          updateNavigation(); // Atualiza a navegação
        });
        dots.appendChild(pageDot);
      }

      // Atualiza os botões de navegação
      const prevButton = document.querySelector(".button-prev-page");
      const nextButton = document.querySelector(".button-next-page");

      prevButton.disabled = currentPage === 1;
      nextButton.disabled = currentPage === totalPages;

      prevButton.addEventListener('click', () => {
        if (currentPage > 1) {
          currentPage--;
          displayPage(currentPage);
          updateNavigation();
        }
      });

      nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
          currentPage++;
          displayPage(currentPage);
          updateNavigation();
        }
      });
    }

    // Exibe a primeira página ao carregar
    displayPage(currentPage);
    updateNavigation();
  }

  // Features: CATEGORIA



  // UTILS
  function handleResponse(result) {
    document.querySelectorAll(".message-error").forEach(msg => msg.remove());
    document.querySelectorAll(".input-container").forEach(input => input.classList.remove("border-red-500"));

    if (result.status === "success") {
      location.reload();
    } else if (result.status === "error") {
      if (result.invalid_fields) {
        result.invalid_fields.forEach((field) => {
          const inputContainer = document.getElementById(field.field).parentElement;
          const messageError = document.createElement("span");

          messageError.textContent = field.error;
          messageError.classList.add("message-error", "text-[12px]", "mt-1", "text-red-500");

          if (field.field == "image") {
            displayError(messageError.textContent)
          } else {
            inputContainer.classList.add("border", "border-red-500");
            inputContainer.insertAdjacentElement("afterend", messageError);
          }
        });
      } else {
        displayError(result.message);
      }
    }
  }

  function displayError(message) {
    const errorContainer = document.querySelector(".message-status-upload-image");
    errorContainer.textContent = message;
    errorContainer.classList.add("text-red-500");
  }

  function executeInlineScripts(container) {
    const scripts = container.querySelectorAll("script");
    scripts.forEach(script => {
      const newScript = document.createElement("script");

      if (script.src) {
        // Se o script tiver um src, carregue-o novamente
        newScript.src = script.src;
      } else {
        // Caso contrário, copie o conteúdo do script inline
        newScript.textContent = script.textContent;
      }

      // Adiciona o novo script ao DOM para executá-lo
      document.body.appendChild(newScript);

      // Remove o script adicionado após a execução para evitar duplicação
      document.body.removeChild(newScript);
    });
  }

  function captureImage(event) {
    const file = event.target.files[0];
    const captureImageArea = document.querySelector(".capture-image-area");
    const messageStatus = document.querySelector(".message-status-upload-image");

    if (file) {
      // Atualizar mensagem com o nome do arquivo
      messageStatus.textContent = file.name;

      // Criar uma URL temporária para exibir a imagem selecionada
      const imageUrl = URL.createObjectURL(file);

      // Atualizar o conteúdo do local onde a imagem deve ser exibida
      captureImageArea.innerHTML = `<img src="${imageUrl}" alt="${file.name}" class="object-cover w-full rounded-md" />`;
    } else {
      // Caso nenhum arquivo seja selecionado
      messageStatus.textContent = "Nenhuma imagem foi selecionada";
      captureImageArea.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8"
          stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-plus w-24 h-24">
          <path d="M16 5h6" />
          <path d="M19 2v6" />
          <path d="M21 11.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5" />
          <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
          <circle cx="9" cy="9" r="2" />
        </svg>
        <p class="text-sm">Arraste e solte sua imagem aqui</p>
        <span class="font-bold text-sm">(até 5MB)</span>
      `;
    }
  }
});


