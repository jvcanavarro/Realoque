
var selectInput = document.getElementById('bairros')

$.ajax({

    url : 'http://localhost:5000/bairros',
    crossDomain: true,
    type: 'get',

    erro : (xhr, status, error) => console.log(error),

    success : (result) => {

        for(let bairro of  result){

            let option = document.createElement('option')
            option.value = bairro
            option.innerHTML = bairro
        
            selectInput.appendChild(option)
        
        }
        
    }

})


function lista(){

    window.location.href = base + 'lista/' + selectInput.value
    

}





