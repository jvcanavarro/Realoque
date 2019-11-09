let cidades = []

fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados/35/municipios')
.then((response) => {

    response.json().then(
        (json) => cidades = json
    )
    

})


let selectInput = 