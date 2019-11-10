let sample = {

    municipio : 'Abaetetuba',
    endereco : 'Rio Guajará',
    cep : '68440-000',
    desc : 'Maginal de Rio'

}


let sampleCOntainer = document.getElementsByClassName('sample')[0]

let tit = document.createElement('h2')
tit.innerHTML = 'Imóvel em '+sample.municipio

let end = document.createElement('h3')
end.innerHTML = '<i class="fas fa-map-marker-alt"></i> '+sample.endereco

let cep = document.createElement('span')
cep.className = 'caracteristica cep'
cep.innerHTML = 'CEP '+ sample.cep

let des = document.createElement('span')
des.className = 'caracteristica des'
des.innerHTML = sample.desc



let blocks = [tit, end, cep, des]

for (let i of blocks) sampleCOntainer.appendChild(i)