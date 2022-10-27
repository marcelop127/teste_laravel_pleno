@component('mail::message')
 
Seu produto foi salvo com sucesso!
 
@component('mail::table')
| Campos          | Valor              |
| --------------- |:------------------:|
| Nome do produto | {{$nome_produto}}  |
| Valor           | {{$valor_produto}} |
| Ativo?          | {{$ativo_produto}} |
@endcomponent
 
Atensiosamente,<br>
{{ config('app.name') }}
@endcomponent