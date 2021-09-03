<?php

namespace Database\Seeders;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pdf = PDF::loadHTML("<h1>Documento</h1>");
        $caminho_licencas = "documentos/licencas/";

        Storage::put('public/' . $caminho_licencas . "req_licenca_ambiental.pdf", $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Requerimento de licença ambiental devidamente preenchida e assinada pelo empreendedor',
            'documento_modelo' => $caminho_licencas . 'req_licenca_ambiental.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'cpf_rg_requerente.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Cópia da (s) Identidade (s) e CPF(s) do requerente',
            'documento_modelo' => $caminho_licencas . 'cpf_rg_requerente.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'procuracao_rg_cpf_procurador.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Procuração (se houver), assim como Identidade e CPF do procurador',
            'documento_modelo' => $caminho_licencas . 'procuracao_rg_cpf_procurador.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'comprovante_pag_taxa_ambiental.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Comprovante de pagamento da taxa ambiental',
            'documento_modelo' => $caminho_licencas . 'comprovante_pag_taxa_ambiental.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'autorizacao_supressao_vegetacao.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Autorização da supressão de vegetação, solicitada ao órgão ambiental competente(se houver)',
            'documento_modelo' => $caminho_licencas . 'autorizacao_supressao_vegetacao.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'escritura_terreno_contrato_aluguel.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Cópia da escritura do terreno (se imóvel próprio) ou Contrato de aluguel',
            'documento_modelo' => $caminho_licencas . 'escritura_terreno_contrato_aluguel.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'outorga_apac_cprh.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'No caso de utilização de água de corpos hídricos (superficiais ou subterrâneos), 
                anexar a Outorga da Agência Pernambucana de Águas (APAC)ou de Direito da Agência Estadual de Meio Ambiente (CPRH)',
            'documento_modelo' => $caminho_licencas . 'outorga_apac_cprh.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'mapa_croquide_localizacao_empreendimento.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Mapa ou Croquide localização do empreendimento em relação ao Município, respeitando a posição do Norte 
                verdadeiro, indicando: Vias de acessos principais e pontos de referências para chegar ao local, Ocupações vizinhas ao empreendimento, em um raio mínimo de 100 metros.',
            'documento_modelo' => $caminho_licencas . 'mapa_croquide_localizacao_empreendimento.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'comprovante_agua(Compesa).pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Comprovante de fornecimento de água (Compesa), se outro tipo, apresentar recibo de pagamento',
            'documento_modelo' => $caminho_licencas . 'comprovante_agua(Compesa).pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'dispensa_outorga_agua.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Dispensa de Outorga de água (se houver)',
            'documento_modelo' => $caminho_licencas . 'dispensa_outorga_agua.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'cronograma_execucao_obra.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Cronograma de execução da obra',
            'documento_modelo' => $caminho_licencas . 'cronograma_execucao_obra.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'identidade_profissional_tecnicos.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Cópia da Carteira de Identidade profissional do (s) responsável (eis) técnico (s)pela execução da obra de instalação',
            'documento_modelo' => $caminho_licencas . 'identidade_profissional_tecnicos.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'projeto_hidrossanitario_comprovante_art.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Projeto Hidrossanitário com Anotação de Responsabilidade Técnica (ART) e comprovante de pagamento da ART. 
                O profissional deverá ser habilitado para elaboração e execução do projeto técnico',
            'documento_modelo' => $caminho_licencas . 'projeto_hidrossanitario_comprovante_art.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'projeto_arquitetonico_memorial_descritivo.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Projeto arquitetônico com memorial descritivo',
            'documento_modelo' => $caminho_licencas . 'projeto_arquitetonico_memorial_descritivo.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'contrato_social_jucepe.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Contrato Social, registrada na Junta Comercial do Estado –JUCEPE',
            'documento_modelo' => $caminho_licencas . 'contrato_social_jucepe.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'pac.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Projeto  de  Controle  Ambiental  (PCA),  detalhando,  dimensionamento  e  tratamento  ambiental  dos 
                resíduos gerados (sólido, líquido e gasoso), de acordo a exigência na LP, quando for o caso',
            'documento_modelo' => $caminho_licencas . 'pac.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'plano_gerenciamento_residuos_solidos.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Plano  de  Gerenciamento  de  Resíduos  Sólidos  (se  houver),  com  Anotação  de  Responsabilidade Técnica –ART 
                (quitada)do  responsável  pela  elaboração  de  projeto,  em  conformidade  com  as atribuições do profissional',
            'documento_modelo' => $caminho_licencas . 'plano_gerenciamento_residuos_solidos.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'alvara_prefeitura_xerox.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Alvará da Prefeitura (Xerox)',
            'documento_modelo' => $caminho_licencas . 'alvara_prefeitura_xerox.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'atestado_regularidade_bombeiro.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Atestado de Regularidade do Corpo deBombeiro (Xerox)',
            'documento_modelo' => $caminho_licencas . 'atestado_regularidade_bombeiro.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'licenca_vigilancia_sanitaria.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Licença de funcionamento da Vigilância Sanitária (Xerox)',
            'documento_modelo' => $caminho_licencas . 'licenca_vigilancia_sanitaria.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'cnpj.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Cadastro Nacional de Pessoa Jurídica (CNPJ), se houver',
            'documento_modelo' => $caminho_licencas . 'cnpj.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'projeto_hidrossanitario_memoria_calculo_art.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Projeto  Hidrossanitário  comMemoria  de  Cálculo  maisAnotação  de  Responsabilidade  Técnica (ART) quitada 
                do profissional responsávelpela elaboração e execução do projeto técnico',
            'documento_modelo' => $caminho_licencas . 'projeto_hidrossanitario_memoria_calculo_art.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'alvara_vigilancia_sanitaria.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Alvará emitido pela Vigilância Sanitária (Xerox), quando for o caso',
            'documento_modelo' => $caminho_licencas . 'alvara_vigilancia_sanitaria.pdf'
        ]);

        Storage::put('public/' . $caminho_licencas . 'certificado_condicao_microempreendedor_individual.pdf', $pdf->stream());
        DB::table('documentos')->insert([
            'nome' => 'Certificado da Condição de Microempreendedor individual (Quando couber)',
            'documento_modelo' => $caminho_licencas . 'certificado_condicao_microempreendedor_individual.pdf'
        ]);
    }
}
