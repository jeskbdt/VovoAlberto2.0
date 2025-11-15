const selSabor = document.querySelector('#qtdSabores');
const divSabores = document.querySelector('#campoSabores');
const divErro = document.querySelector('.error');

const URL_BASE = document.querySelector("#confUrlBase").dataset.urlBase;

function criaSelectSabor() {
    const qtdSabores = selSabor.value;
    const url = URL_BASE + "/api/carrega_sabores.php";

    let valoresAntigos = {};
    document.querySelectorAll('#campoSabores select').forEach((select, index) => {
        valoresAntigos[index] = select.value;
    });

    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", url);

    xhttp.onload = function() {
        var sabores = JSON.parse(xhttp.responseText);

        divSabores.innerHTML = "";

        for (let i = 0; i < qtdSabores; i++) {

            const label = document.createElement('label');
            label.textContent = (i + 1) + "° Sabor: ";
            label.htmlFor = "sabor" + (i + 1);

            const selectSabor = document.createElement('select');
            selectSabor.id = "sabor" + (i + 1);

            sabores.forEach(s => {
                adicionarOptionSabor(s, selectSabor);
            });

            if (valoresAntigos[i] !== undefined) {
                selectSabor.value = valoresAntigos[i];
            }

            divSabores.appendChild(label);
            divSabores.appendChild(selectSabor);
            divSabores.appendChild(document.createElement('br'));
        }
    };

    xhttp.send();
}

function adicionarOptionSabor(sabor, select) {
    const option = document.createElement("option");
    option.value = sabor.id;
    option.textContent = sabor.nome;
    
    select.appendChild(option);
}

function salvarPedido() {

    const dados = new FormData();

    const selectsSabores = divSabores.querySelectorAll('select');

    selectsSabores.forEach((select, index) => {
        const numero = index + 1;
        dados.append('sabor' + numero, select.value);
    });

    const inputId = document.querySelector('#id');
    if (inputId) {
        dados.append('id', inputId.value);
    }

    const tamanho = document.querySelector('#tamanho')?.value || "";
    const endereco = document.querySelector('#endereco')?.value || "";
    const telefoneCliente = document.querySelector('#telefoneCliente')?.value || "";
    const metodoPagamento = document.querySelector('#metodoPagamento')?.value || "";
    const atendente = document.querySelector('#atendente')?.value || "";
    const entregador = document.querySelector('#entregador')?.value || "";

    dados.append('tamanho', tamanho);
    dados.append('endereco', endereco);
    dados.append('telefoneCliente', telefoneCliente);
    dados.append('metodoPagamento', metodoPagamento);
    dados.append('atendente', atendente);
    dados.append('entregador', entregador);


    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", URL_BASE + "/api/pedido_salvar.php");

    xhttp.onload = function() {

        let json = JSON.parse(xhttp.responseText);
        
        if (!json.success) {
            divErro.innerHTML = "";
            json.errors.forEach(err => {
                divErro.innerHTML += `<p>${err}</p>`;
            });
            divErro.style.display = "block";
            window.scrollTo(0, 0);
            return;
        }

        window.location = "listarPedidos.php";
    };

    xhttp.send(dados);
}



const handlePhone = (event) => {
    let input = event.target
    input.value = phoneMask(input.value)
}
const phoneMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g,'')
    value = value.replace(/(\d{2})(\d)/,"($1) $2")
    value = value.replace(/(\d)(\d{4})$/,"$1-$2")
    return value
}
