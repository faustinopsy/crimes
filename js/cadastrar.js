
function cadcrime() {
    const cep = document.getElementById("cep")
    const rua = document.getElementById("endereco")
    const lng = document.getElementById("utmy")
    const lat = document.getElementById("utmx")
    const bairro = document.getElementById("bairro")
    const tipoRoubo = document.getElementById("roubo");
    const tipoFurto = document.getElementById("furto");
    const cidade = document.getElementById("cidade")
    const uf = document.getElementById("uf")
    const cepvalue = cep.value;
    const lngvalue = lng.value;
    const latvalue = lat.value;
    const bairrovalue = bairro.value;
    const ruavale = rua.value;
    let tipovale;
 
    if(tipoRoubo.checked){
        tipovale = tipoRoubo.value;
    }else{
        tipovale = tipoFurto.value;
    }
    const cidadevalue = cidade.value;
    const ufvalue = uf.value;

    if (bairrovalue =="" || cepvalue=="") {
        const messageText = document.getElementById("message-text");
        messageText.innerText = 'campos cep ou bairro vazios';
        showMessage();
        return;
    }

    $.ajax({
        type: "POST",
        url: "cadcrime.php",
        data: {
            cep: cepvalue,
            bairro: bairrovalue,
            lat:lngvalue,
            lng:latvalue,
            rua:ruavale,
            tipo:tipovale
        },
        success: (data, status, jqXHR) => {
            if(status=='success'){
                cep.value = ""
                lng.value = ""
                lat.value = ""
                bairro.value = ""
                rua.value = ""
                tipoFurto.value = ""
                tipoRoubo.value = ""
                cidade.value = ""
                uf.value = ""
                const messageText = document.getElementById("message-text");
                messageText.innerText = 'Cadastrado com sucesso';
                showMessage();
                carregapontos();
                location.reload();
            }
        },
    })
}
function carregapontos(){
 
    var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
   // if (this.readyState == 4 && this.status == 200) {
   //   document.getElementById("demo").innerHTML = '';
   // }
 };
 xhttp.open("GET", "../estatistica/pontos.php", true);
 xhttp.send();
   }

  