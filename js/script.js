const form = document.querySelector('#Adicionar_Form')
const paciente = document.querySelector('#marca')
const medico = document.querySelector('#modelo')
const data = document.querySelector('#anoFabricacao')
const horario = document.querySelector('#preco')
const tableBody = document.querySelector('#Tabela_adiciona tbody')

const URL = 'http://localhost:8080/CRUD.php'

function carregarCarros() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        mode: 'cors'
    })
        .then(response => response.json())
        .then(adiciona => {
            tableBody.innerHTML = ''

            adiciona.forEach(AutoMax => {
                const tr = document.createElement('tr')
                tr.innerHTML = `
            <td>${AutoMax.modelo}</td>
            <td>${AutoMax.marca}</td>
            <td>${AutoMax.anoFrabricacao}</td>
            <td>${AutoMax.preco}</td>
            <td>
            <button data-id="${adiciona.id}" onclick="atualizarCarros(${adiciona.id})">Editar</button>
            <button onclick="excluirCarros(${adiciona.id})">Excluir</button>
            </td>
            `
                tableBody.appendChild(tr)
            })
        })
}

function adicionarCarros(event) {

    event.preventDefault()

    const marcaValor = marca.value
    const modeloValor = modelo.value
    const anoFabricacaoValor = anoFabricacao.value
    const precoValor = preco.value

    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `paciente=${encodeURIComponent(marcaValor)}&medico=${encodeURIComponent(modeloValor)}&data=${encodeURIComponent(anoFabricacaoValor)}&horario=${encodeURIComponent(precoValor)}`
    })
        .then(response => {
            if (response.ok) {
                carregarCarros()
                marcaValor.value = ''
                modeloValor.value = ''
                anoFabricacaoValor.value = ''
                precoValor.value = ''
            } else {
                console.error('Erro ao adicionar carro')
                alert('Erro ao adicionar carro')
            }
        })
}

//excluir carro

function excluirCarros(id){
    if(confirm('Deseja excluir esse carro?')){
        fetch(`${URL}?id=${id}`, {
            method:'DELETE'
        })
            .then(response => {
                if (response.ok){
                    carregarCarros()
                } else {
                    console.error('Erro ao excluir carro')
                    alert('Erro ao excluir carro')
                }
            })
    }
}


function atualizarCarro(id){
    const marca = prompt('Digite a nova marca: ')
    const modelo = prompt('Digite o novo modelo: ')
    const anoFabricacao = prompt('Digite o novo ano de fabricação: ')
    const preco = prompt('Digite o novo preço: ')

    if(marca && modelo && anoFabricacao && preco){
        fetch(`${URL}?id=${id}`,{
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `marca=${encodeURIComponent(marca)}&modelo=${encodeURIComponent(modelo)}&anoFabricacao=${encodeURIComponent(anoFabricacao)}&preco=${encodeURIComponent(preco)}`
        })
            .then(response => {
                if(response.ok){
                    carregarCarros()
                }else{
                    console.error('Erro ao editar o carro')
                }
            })
    }

}

form.addEventListener('submit', adicionarCarros())
carregarCarros()
