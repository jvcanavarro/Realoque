let listaContainer = document.getElementById("lista")
var imoveis = []


function render(ims){

    listaContainer.innerHTML = ''

    for(let imovel of ims){

        let itemContainer = document.createElement('div')
        itemContainer.className = 'imovel'

        itemContainer.onclick = (event) => window.location.href = base + 'sample/' + imovel.index

        let log = document.createElement('i')
        log.className ="far fa-building casinha"

        let tit = document.createElement('h2')
        tit.innerHTML = imovel.bairro

        let end = document.createElement('h3')
        end.innerHTML = imovel.endereco

        let blocks = [log, tit, end]

        for(i of blocks) itemContainer.appendChild(i)

        listaContainer.appendChild(itemContainer)

    }        

}



function lista(){
    

    $.ajax({

    url : `http://localhost:5000/valor/4`,
    crossDomain: true,
    type: 'get',

    erro : (xhr, status, error) => console.log(error),

    success : (result) => {

        result.sort((a, b) => a.normal_value_construcao - b.normal_value_construcao)

        for (let i = 0; i < 7; i++) {
            imoveis.push(result[i])
            
        }
        
        render(imoveis)
        
        
    }

})}

lista()