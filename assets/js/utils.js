function isCpf(cpf) {
    var soma;
    var resto;
    var i;

    if ( (cpf.length != 11) ||
        (cpf == "00000000000") || (cpf == "11111111111") ||
        (cpf == "22222222222") || (cpf == "33333333333") ||
        (cpf == "44444444444") || (cpf == "55555555555") ||
        (cpf == "66666666666") || (cpf == "77777777777") ||
        (cpf == "88888888888") || (cpf == "99999999999") ) {
        return false;
    }

    soma = 0;

    for (i = 1; i <= 9; i++) {
        soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
    }

    resto = 11 - (soma - (Math.floor(soma / 11) * 11));

    if ( (resto == 10) || (resto == 11) ) {
        resto = 0;
    }

    if ( resto != Math.floor(cpf.charAt(9)) ) {
        return false;
    }

    soma = 0;

    for (i = 1; i<=10; i++) {
        soma += cpf.charAt(i-1) * (12 - i);
    }

    resto = 11 - (soma - (Math.floor(soma / 11) * 11));

    if ( (resto == 10) || (resto == 11) ) {
        resto = 0;
    }

    if (resto != Math.floor(cpf.charAt(10)) ) {
        return false;
    }

    return true;
}
function isCnpj(cnpj){

//    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    var tamanho = cnpj.length - 2;
    var numeros = cnpj.substring(0,tamanho);
    var digitos = cnpj.substring(tamanho);
    var soma = 0;
    var pos = tamanho - 7;
    for (var i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

}
function isCpfCnpj(valor) {
    var retorno = false;
    var numero  = valor.replace(/[^\d]+/g,'');;

    if (numero.length > 11){
        if (isCnpj(numero)) {
            retorno = true;
        }
    } else {
        if (isCpf(numero)) {
            retorno = true;
        }
    }

    return retorno;
}