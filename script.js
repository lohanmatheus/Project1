const transactionsUl = document.querySelector('#transactions')
let incomeDisplay  = document.querySelector('#money-plus')
let expenseDisplay = document.querySelector('#money-minus')
let balanceDisplay = document.querySelector('#balance')
let form = document.querySelector('#form')
let inputtransactionName = document.querySelector('#text')
let inputtransactionAmount = document.querySelector('#amount')
let valorSalary = document.getElementById('valor2').innerHTML
let valorFixed = parseInt(valorSalary)

let dummyTransactions = [
    {id : 1, name : 'Renda Fixa', amount: valorFixed },

]



let removeTransaction = ID => {
    dummyTransactions = dummyTransactions
        .filter(transaction =>
            transaction.id !== ID)

    init()
}



let addTransactionIntoDOM = transaction => {
    let operator = transaction.amount < 0 ? '-' : '+'
    let CSSClass = transaction.amount < 0 ? 'minus' : 'plus'
    let amountWithOutOperator = Math.abs(transaction.amount)   /*abs = retornar o valor apenas do numero sem sinal de "+" ou "-"*/

    let li = document.createElement('li')     // create element é um metodo do document para criar um novo elemento html, tag : 'li'

    li.classList.add(CSSClass)
    li.innerHTML = `
   ${transaction.name} 
   <span> ${operator} R$ ${amountWithOutOperator}</span>
   <button class="delete-btn" onclick="removeTransaction(${transaction.id})">
   x
   </button>
   `                                      //a transação mais recente sera adicionada na LI      (PREPEND É AO CONTRARIO)
    transactionsUl.prepend(li)



}

let updateBalanceValues = () => {
    let transactionsAmounts = dummyTransactions
        .map(transaction => transaction.amount)

    let total = transactionsAmounts
        .reduce((accumulator, transaction) => accumulator + transaction, 0)
        .toFixed(2)

    let income = transactionsAmounts
        .filter(value => value > 0)
        .reduce((accumulator, value)=> accumulator + value, 0 )
        .toFixed(2)

    let expense = Math.abs( transactionsAmounts
        .filter(value => value < 0)
        .reduce((accumulator, value) => accumulator + value, 0))
        .toFixed(2)

    balanceDisplay.textContent = `R$ ${total}`
    incomeDisplay.textContent  =` R$ ${income}`
    expenseDisplay.textContent  =` R$ ${expense}`



}

let init = () => {
    transactionsUl.innerHTML = ''    //limpar para nao repetir as informações abaixo

    dummyTransactions.forEach(addTransactionIntoDOM)
    updateBalanceValues()
}

init ()


let generatorID = () =>Math.round(Math.random()*1000)           // gerar numero aleatorio de 0 a 1000

form.addEventListener('submit', event => {
    event.preventDefault()

    let transactionName   = inputtransactionName.value.trim()
    let transactionAmount = inputtransactionAmount.value.trim()

    if(transactionName === '' || transactionAmount === ''){            //trim = remover so espaços a mais antes e depois.
        alert('Preencha o valor e o nome')
        return
    }

    let transaction = {
        id:generatorID() ,
        name: transactionName,
        amount: Number(transactionAmount)               //number()=  converter a string em um numero.
    }

    dummyTransactions.push(transaction)
    init()


    inputtransactionName.value  = ''
    inputtransactionAmount.value= ''
})



function verificaTransacao() {
    let nameTransacao = document.getElementById('text').value
    let idTypeFuture = document.getElementById('transaction-type').value
    let value = document.getElementById('amount').value
    if ( nameTransacao === '') {
        alert('Preencha o nome da transação')
    }

    if ( idTypeFuture === '') {
        alert('Preencha o tipo de transacao')
    }



    if ( value === '') {
        alert('Preencha o valor da transação')
    }

    sendTransacao(nameTransacao,value,idTypeFuture)



}

function sendTransacao(nameTransacao,value,idTypeFuture) {
    const parametros = {
        data : {
            nameTransacao: nameTransacao,
            value : value,
            idTypeFuture: idTypeFuture

        },
        classe:'usuario',
        acao: 'transacao'
    }

    let parametrosRequest = {
        method:'POST',
        cache :'default',
        body  : JSON.stringify(parametros),
        headers : {
            'Content-Type': 'application/json'
        }
    }
    let myRequest = new Request('http://localhost:8000/conecta.php', parametrosRequest)
    fetch(myRequest).then(response => {
        return response.json();
    }).then(function (response) {
        if (!response.success){
            alert(response.msg)
            return false
        }
    })


}




function verificaSearch(){
    let name = document.getElementById('userName').value
    if (name === ''){
        alert('Nome nao informado')
            return false
    }
    getUser(name)



}



function getUser(name) {
    const getTR = registro => {
        return `<tr>
                    <td>${registro.id}</td>
                    <td>${registro.name}</td>
                    <td>${registro.login}</td>
                   
                    <td><button onclick="enviar()">Enviar</button></td>
                </tr>`;
    }

    const getLoaginTr = function () {
        return `<tr>
                    <td colspan="8" style="text-align: center;" ">Carregando dados. Aguarde!</td>
                </tr>`;
    }

    let bodyRequest = JSON.stringify({
        classe: 'usuario',
        acao: 'search',
     data : {name}
    })
    let configRequest = {
        method: 'POST',
        cache: 'default',
        body: bodyRequest,
        headers: {
            'Content-Type': 'application/json'
        }
    }
    let myRequest = new Request('http://localhost:8000/conecta.php', configRequest);
    document.getElementById('result-list').innerHTML = getLoaginTr();
    fetch(myRequest).then(function (response) {
        return response.json();
    }).then(response => {
        if (response.success === true) {
            document.getElementById('result-list').innerHTML = '';
            response.dados.forEach(registro => {
                document.getElementById('result-list').innerHTML += getTR(registro);
            });
            document.getElementById('area-menu2').style.display = 'block'
            return false;
        }

        document.getElementById('result-list').innerHTML = `<tr>
                        <td colspan="8">${response.msg}</td>
                    </tr>`;
        alert(response.msg);
    })
}










function enviar() {


    const parametros = {




        classe:'usuario',
        acao: 'share'
    }

    let parametrosRequest = {
        method:'POST',
        cache :'default',
        body  : JSON.stringify(parametros),
        headers : {
            'Content-Type': 'application/json'
        }
    }
    let myRequest = new Request('http://localhost:8000/conecta.php', parametrosRequest)
    fetch(myRequest).then(response => {
        return response.json();
    }).then(function (response) {
        if (!response.success){
            alert(response.msg)
            return false
        }
    })


}




window.onload = function (){
   // alert('Page loaded!')
}