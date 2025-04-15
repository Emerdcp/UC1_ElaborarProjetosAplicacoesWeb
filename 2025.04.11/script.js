document.getElementById('form-contato').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Mensagem enviada com sucesso! Em breve entraremos em contato.');
    this.reset();
  });


  // Modal para cards

  document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".card");
    const modal = document.getElementById("modal");
    const modalTitle = document.getElementById("modal-title");
    const modalTexto = document.getElementById("modal-texto");
    const closeModal = document.querySelector(".close");
  
    const conteudoModal = {
      auto: {
        titulo: "Seguro Auto",
        texto: `
        <br>
        <p>Nada melhor do que dirigir com tranquilidade, sabendo que seu veículo está protegido. Isso acontece quando você conta com um seguro de automóvel que considera seu perfil e oferece coberturas opcionais para você escolher de acordo com suas necessidades.</p>
        <p>E como isso acontece?</p>
        <p>Pense no seu perfil de motorista na hora de solicitar uma cotação - qual é sua idade? Qual o seu gênero - masculino ou feminino? Depois, procure um produto que tenha mais a ver com você, que considere essas características e avalie as coberturas que ele oferece.</p>
        <p>As coberturas básicas geralmente incluem:</p>
        <ul>
          <li>Colisão, incêndio e roubo/furto;</li>
          <li>Danos a terceiros;</li>
          <li>Proteção a passageiros.</li>
        </ul>
        
        `
      },
      previdencia: {
        titulo: "Previdência",
        texto: "Aqui estão mais informações sobre a Previdência."
      },
      residencial: {
        titulo: "Seguro Residencial",
        texto: "Aqui estão mais informações sobre o Seguro Residencial."
      },
      condominio: {
        titulo: "Seguro para Condomínio",
        texto: "Aqui estão mais informações sobre o Seguro Residencial."
      },
      empresariais: {
        titulo: "Seguro Empresariais",
        texto: "Aqui estão mais informações sobre o Seguro Residencial."
      }
    };
  
    cards.forEach(card => {
      card.addEventListener("click", () => {
        const produto = card.getAttribute("data-produto");
        const conteudo = conteudoModal[produto];
  
        if (conteudo) {
          modalTitle.textContent = conteudo.titulo;
          modalTexto.innerHTML = conteudo.texto;
          modal.style.display = "block";
        }
      });
    });
  
    closeModal.addEventListener("click", () => {
      modal.style.display = "none";
    });
  
    window.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  });
  

  // Modal para Assistência 24hs


  const btnAssistencia = document.getElementById("btn-assistencia");
  const modalAssistencia = document.getElementById("modal-assistencia");
  const fecharAssistencia = document.getElementById("fechar-assistencia");

  btnAssistencia.addEventListener("click", (e) => {
    e.preventDefault();
    modalAssistencia.style.display = "block";
  });

  fecharAssistencia.addEventListener("click", () => {
    modalAssistencia.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target === modalAssistencia) {
      modalAssistencia.style.display = "none";
    }
  });


  //limpar campo no formulário

  function limparFormulario() {
    document.getElementById("form-contato").reset();
  }





//Padronização para telefone

const telefoneInput = document.getElementById("telefone");

  telefoneInput.addEventListener("input", function (e) {
    let valor = e.target.value.replace(/\D/g, ""); // Remove tudo que não for número

    if (valor.length > 11) valor = valor.slice(0, 11); // Limita a 11 dígitos

    // Aplica máscara (XX) XXXXX-XXXX
    if (valor.length > 6) {
      valor = valor.replace(/(\d{2})(\d{5})(\d{0,4})/, "($1) $2-$3");
    } else if (valor.length > 2) {
      valor = valor.replace(/(\d{2})(\d{0,5})/, "($1) $2");
    } else {
      valor = valor.replace(/(\d*)/, "($1");
    }

    e.target.value = valor;
  });


  //envio e configuração e-mail


  function validarEmail() {
    const email = document.getElementById("email").value;
    
    // Expressão regular para validar email
    const regex = /^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/;

    if (!regex.test(email)) {
      alert("❌ E-mail inválido! Use o formato: exemplo@dominio.com");
      return false; // Impede o envio do formulário
    }

    // Se estiver tudo certo
    return true;
  }