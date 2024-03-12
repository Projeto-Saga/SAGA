function mask(seletor, tipo)
{
	setTimeout(function()
	{
        if (tipo == 'fone') {format(seletor, '(00) 00000-0000');}
        if (tipo == 'cpf_') {format(seletor, '000.000.000-00' );}
	}, 20);
}
function format(field, mask)
{
    var campoSoNumeros = field.value.replace(/\D/g, '');
    var posicaoCampo = 0;
    var NovoValorCampo = '';

    for (var i = 0; i < mask.length; i++)
    {
        if (mask.charAt(i) === '0')
        {
            NovoValorCampo += campoSoNumeros.charAt(posicaoCampo) || '';
            posicaoCampo++;
        }
        else if (mask.charAt(i) === '-' || mask.charAt(i) === '.' || mask.charAt(i) === '(' || mask.charAt(i) === ')' || mask.charAt(i) === ' ')
        {
            if (campoSoNumeros.charAt(posicaoCampo) !== '')
            {
                NovoValorCampo += mask.charAt(i);
            }
        }
        else
        {
            if (field.value.charAt(i) === mask.charAt(i))
            {
                NovoValorCampo += mask.charAt(i);
            }
            else
            {
                break;
            }
        }
    }

    field.value = NovoValorCampo;
}