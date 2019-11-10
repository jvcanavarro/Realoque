function lista(bairro){

    $.ajax({

    url : `http://localhost:5000/bairro/${bairro}`,
    crossDomain: true,
    type: 'get',

    erro : (xhr, status, error) => console.log(error),

    success : (result) => {

        for(let imovel of result){

            console.log(JSON.parse(imovel));
            

        }
        
        
    }

})}