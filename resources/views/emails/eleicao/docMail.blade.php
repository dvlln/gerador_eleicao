<x-mail::message>
# RESULTADO DA APROVAÇÃO DOS DOCUMENTOS PARA INSCRIÇÃO

@if($resposta === 'aprovado')
    Parabéns!!! seus documentos foram aprovados.
    Agora só resta esperar a eleição começar para darmos andamento na eleição.

    Data inicial da eleição: {{ $inicioData }}
    Data final da eleição: {{ $fimData }}
@else
    Infelizmente seus documentos foram recusados, segue abaixo o motivo e o periodo para reenvio

    "{{ $motivo }}"

    Data inicial da depuracao: {{ $inicioData }}
    Data final da depuracao: {{ $fimData }}
@endif

Atenciosamente,
Administrador 😎
</x-mail::message>
