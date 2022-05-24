@guest
<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div style="color: var(--primaria); font-size: 35px; font-weight: bolder;">
                    Legislação
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="padding-left: 30px; padding-right: 30px; text-align: justify;">
                    <div class="card-body">
                        <div class="row justify-content-start">
                            <div class="col-md-12 list-ordenada">
                                <ol class="nested-counter-list">
                                    <li class="scope">LEGISLAÇÃO MUNICIPAL
                                        <ol class="pl-3">
                                            <li>Lei nº 4619/2019 – Dispõe sobre o licenciamento ambiental no Município de Garanhuns e dá outras providências;</li>
                                            <li>Lei nº 4224/2015 – Institui a política ambiental e o sistema municipal de meio ambiente e desenvolvimento sustentável para a proteção, controle e licenciamento ambiental no município de Garanhuns, e dá outras providências;</li>
                                            <li>Lei nº 4692/2020 – Obriga os novos prédios residenciais e comerciais a incluírem vegetação em seus telhados, com o intuito de reduzir as ilhas de calor e preservar a biodiversidade;</li>
                                            <li>Lei nº 3620/2008 – Institui o plano diretor participativo do município de Garanhuns, instrumento da política urbana e ambiental, e dá outras providências;</li>
                                            <li>Lei 3444/2006 – Institui o Fundo Municipal do Meio Ambiente – FMMA, e dá outras providências;</li>
                                            <li>Lei Orgânica Municipal de Garanhuns;</li>
                                            <li>Lei 2857/1997 – Altera a lei 1439/69, em seu capítulo XII, no que diz respeito a veiculação de anúncios e cartazes: dispõe sobre o ordenamento de publicidade no espaço urbano do Município de Garanhuns e dá outras providências;</li>
                                            <li>Lei 1439/1969 – Institui o Código de Postura do Município e dá outras providências;</li>
                                        </ol>
                                    </li>
                                    <li class="scope">LEGISLAÇÃO ESTADUAL
                                        <ol class="pl-3">
                                            <li>Lei nº 14.236/2010 – Dispõe sobre a Política Estadual de Resíduos Sólidos, e dá outras providências;</li>
                                            <li>Lei nº 14.249/2010 (alterada pela lei 14.549, de 21 de dezembro de 2011) – Dispõe sobre licenciamento ambiental, infrações e sanções administrativas ao meio ambiente, e dá outras providências;</li>
                                        </ol>
                                    </li>
                                    <li class="scope">LEGISLAÇÃO FEDERAL
                                        <ol class="pl-3">
                                            <li>Lei nº 12.305/2010 – Institui a Política Nacional de Resíduos Sólidos; altera a Lei nº 9.605, de 2 de fevereiro de 1988; e dá outras providências;</li>
                                            <li>Lei nº 6.938/1981 – Dispõe sobre a Política Nacional do Meio Ambiente, seus fins e mecanismos de formulação e aplicação, e dá outras providências;</li>
                                            <li>Lei nº 12.651/2012 – Dispõe sobre a proteção da vegetação nativa e dá outras providências (Código Florestal);</li>
                                            <li>Lei Complementar 140 de 2011 – Fixa normas para a cooperação entre a União, os Estados, o Distrito Federal e os Municípios nas ações administrativas decorrentes do exercício da competência comum relativas à proteção das paisagens naturais notáveis, à proteção do meio ambiente, ao combate à poluição em qualquer de suas formas e à preservação das florestas, da fauna e da flora; e altera a Lei nº 6.938/81;</li>
                                            <li>Lei 9605/1998 – Dispõe sobre as sanções penais e administrativas derivadas de condutas atividades lesivas ao meio ambiente, e dá outras providências;</li>
                                            <li>Lei 6.514/2008 – Dispõe sobre as infrações e sanções administrativas ao meio ambiente, estabelece o processo administrativo federal para apuração destas infrações, e dá outras providências.</li>
                                        </ol>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @component('layouts.footer')@endcomponent
</x-guest-layout>
@else
<x-app-layout>
    @section('content')
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div style="color: var(--primaria); font-size: 35px; font-weight: bolder;">
                    Legislação
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="padding-left: 30px; padding-right: 30px; text-align: justify;">
                    <div class="card-body">
                        <div class="row justify-content-start">
                            <div class="col-md-12 list-ordenada">
                                <ol class="nested-counter-list">
                                    <li class="scope">LEGISLAÇÃO MUNICIPAL
                                        <ol class="pl-3">
                                            <li>Lei nº 4619/2019 – Dispõe sobre o licenciamento ambiental no Município de Garanhuns e dá outras providências;</li>
                                            <li>Lei nº 4224/2015 – Institui a política ambiental e o sistema municipal de meio ambiente e desenvolvimento sustentável para a proteção, controle e licenciamento ambiental no município de Garanhuns, e dá outras providências;</li>
                                            <li>Lei nº 4692/2020 – Obriga os novos prédios residenciais e comerciais a incluírem vegetação em seus telhados, com o intuito de reduzir as ilhas de calor e preservar a biodiversidade;</li>
                                            <li>Lei nº 3620/2008 – Institui o plano diretor participativo do município de Garanhuns, instrumento da política urbana e ambiental, e dá outras providências;</li>
                                            <li>Lei 3444/2006 – Institui o Fundo Municipal do Meio Ambiente – FMMA, e dá outras providências;</li>
                                            <li>Lei Orgânica Municipal de Garanhuns;</li>
                                            <li>Lei 2857/1997 – Altera a lei 1439/69, em seu capítulo XII, no que diz respeito a veiculação de anúncios e cartazes: dispõe sobre o ordenamento de publicidade no espaço urbano do Município de Garanhuns e dá outras providências;</li>
                                            <li>Lei 1439/1969 – Institui o Código de Postura do Município e dá outras providências;</li>
                                        </ol>
                                    </li>
                                    <li class="scope">LEGISLAÇÃO ESTADUAL
                                        <ol class="pl-3">
                                            <li>Lei nº 14.236/2010 – Dispõe sobre a Política Estadual de Resíduos Sólidos, e dá outras providências;</li>
                                            <li>Lei nº 14.249/2010 (alterada pela lei 14.549, de 21 de dezembro de 2011) – Dispõe sobre licenciamento ambiental, infrações e sanções administrativas ao meio ambiente, e dá outras providências;</li>
                                        </ol>
                                    </li>
                                    <li class="scope">LEGISLAÇÃO FEDERAL
                                        <ol class="pl-3">
                                            <li>Lei nº 12.305/2010 – Institui a Política Nacional de Resíduos Sólidos; altera a Lei nº 9.605, de 2 de fevereiro de 1988; e dá outras providências;</li>
                                            <li>Lei nº 6.938/1981 – Dispõe sobre a Política Nacional do Meio Ambiente, seus fins e mecanismos de formulação e aplicação, e dá outras providências;</li>
                                            <li>Lei nº 12.651/2012 – Dispõe sobre a proteção da vegetação nativa e dá outras providências (Código Florestal);</li>
                                            <li>Lei Complementar 140 de 2011 – Fixa normas para a cooperação entre a União, os Estados, o Distrito Federal e os Municípios nas ações administrativas decorrentes do exercício da competência comum relativas à proteção das paisagens naturais notáveis, à proteção do meio ambiente, ao combate à poluição em qualquer de suas formas e à preservação das florestas, da fauna e da flora; e altera a Lei nº 6.938/81;</li>
                                            <li>Lei 9605/1998 – Dispõe sobre as sanções penais e administrativas derivadas de condutas atividades lesivas ao meio ambiente, e dá outras providências;</li>
                                            <li>Lei 6.514/2008 – Dispõe sobre as infrações e sanções administrativas ao meio ambiente, estabelece o processo administrativo federal para apuração destas infrações, e dá outras providências.</li>
                                        </ol>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
</x-app-layout>
@endguest
