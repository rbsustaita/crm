{{-- <div>
    {{ $getChildComponentContainer() }}
</div> --}}
<style>
    div {
        font-size: 18px;
        line-height: 1.5;
        text-align: justify;
    }
</style>

<div>
    {{ $getRecord()->contract_type }}
    DE ETIQUETADO DE ACUERDO A LAS NORMAS OFICIALES MEXICANAS VIGENTES PUBLICADAS EN EL DIARIO OFICIAL 
    DE LA FEDERACION EL QUE CELEBRAN POR UNA PARTE 
    <b>"{{ $getRecord()->client->name }}"</b>,
    QUE EN LO SUCESIVO SE LE DENOMINARA <b>“EL CLIENTE”</b>, REPRESENTADO POR
    <b>{{ strtoupper($getRecord()->person->fullname) }}</b>,
    EN SU CARÁCTER DE <b>“REPRESENTANTE LEGAL”</b>,
    Y POR LA OTRA <b>"SIIVCE"</b> REPRESENTADA POR <b>RICARDO BARRERA SUSTAITA</b>, EN SU CARÁCTER DE
    <b>“DIRECTOR GENERAL”</b>, QUE EN LO SUCESIVO SE LE DEMONINARA “LA UNIDAD DE INSPECCIÓN”.
</div>

<div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
    <b>"DECLARACIONES"</b>
</div>

<div style="text-align: left; margin-top: 30px; margin-bottom: 30px;">
    <b>1. "LA UNIDAD DE INSPECCIÓN DECLARA"</b>
</div>

<style>
    ol li::marker {
        content: counter(list-item, upper-alpha) ")    ";
        /* Cambia números a letras en mayúsculos */
    }
</style>

{{-- <ol style="list-style-type: none; margin-left: 50px; margin-right: 50px;">
    @foreach ($getRecord()->ui_statements as $statement)
        <li style="margin-bottom: 20px;">{!! $statement['statement'] !!}</li>
    @endforeach
</ol> --}}
{{-- {{ var_dump($getRecord()->ui_statements) }} --}}

<div style="text-align: left; margin-top: 30px; margin-bottom: 30px;">
    <b>2. "EL CLIENTE DECLARA"</b>
</div>

<ol style="list-style-type: none; margin-left: 50px; margin-right: 50px;">
    @foreach ($getRecord()->client_statements as $statement)
        <li style="margin-bottom: 20px;">{!! $statement['statement'] !!}</li>
    @endforeach
</ol>

<div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
    <b>"CLÁUSULAS"</b>
</div>

<div style="text-align: left; margin-top: 30px; margin-bottom: 30px;">
    <b>PRIMERA: “SIIVCE” PRESTARÁ LOS SIGUIENTES SERVICIOS:</b>
</div>

<ol style="list-style-type: none; margin-left: 50px; margin-right: 50px;">
    @foreach ($getRecord()->clauses as $clause)
        <li style="margin-bottom: 20px;">{!! $clause['clauses'] !!}</li>
    @endforeach
</ol>

<div style="text-align: left; margin-top: 30px; margin-bottom: 30px;">
    <b>"NORMAS"</b>
</div>

