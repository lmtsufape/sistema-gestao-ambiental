<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CnaeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ANEXO UNICO
        \App\Models\Cnae::create(['nome' => 'Usina de concreto e de asfalto, inclusive produção de concreto betuminoso a quente e a frio', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Usina móvel de concreto e de asfalto, inclusive produção de concreto betuminoso a quente e a frio', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Preservação de peixes, crustáceos e moluscos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de conservas de frutas', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de conservas de legumes e outros vegetais', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de sucos, doces e polpas de frutas, hortaliças e legumes', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Beneficiamento de arroz e fabricação de produtos do arroz', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Moagem de trigo e fabricação de derivados', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de farinha de mandioca e derivados', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de farinha de milho e derivados, exceto óleos de milho', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Torrefação e moagem de café', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos à base de café', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de biscoitos e bolachas', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de especiarias, molhos, temperos e condimentos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de alimentos e pratos prontos', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de vinagre', 'setor_id' => '1', 'potencial_poluidor' => '1']);


        \App\Models\Cnae::create(['nome' => 'Fabricação de pós alimentícios', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de gelo comum, utilizando gás refrigerante amônia', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de gelo comum, utilizando outros gases refrigerantes', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos para infusão (chá, mate, etc.)', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de adoçantes naturais e artificiais', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de alimentos dietéticos e complementos alimentares', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos do fumo', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos têxteis para uso doméstico', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de tapeçaria', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de cordoaria', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de tecidos especiais, inclusive artefatos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Confecção de roupas íntimas, sem lavagem, tingimento e outros acabamentos', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Facção de roupas íntimas', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Confecção de peças do vestuário, exceto roupas íntimas, sem lavagem, tingimento e outros acabamentos', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Facção de peças do vestuário, exceto roupas íntimas', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Confecção de roupas profissionais, sem lavagem, tingimento e outros acabamentos', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Facção de roupas profissionais', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de acessórios do vestuário, exceto para segurança e proteção', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de meias', 'setor_id' => '1', 'potencial_poluidor' => '1']);


        \App\Models\Cnae::create(['nome' => 'Fabricação de artigos do vestuário, produzidos em malharias e tricotagens, exceto meias', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de calçados de couro', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de tênis de qualquer material', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de calçados de material sintético', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de calçados de materiais não especificados anteriormente', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de partes para calçados, de qualquer material', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de madeira laminada e de chapas de madeira compensada, prensada e aglomerada', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de esquadrias de madeira e de peças de madeira para instalações industriais e comerciais', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de outros artigos de carpintaria para construção', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de madeira, palha, cortiça, vime e material trançado não especificados anteriormente, exceto móveis', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de embalagens de papel', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de fraldas descartáveis', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de absorventes higiênicos', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de pólvoras, explosivos e detonantes', 'setor_id' => '1', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artigos pirotécnicos', 'setor_id' => '1', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de fósforos de segurança', 'setor_id' => '1', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de sabões e detergentes sintéticos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos de limpeza e polimento', 'setor_id' => '1', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Fabricação de cosméticos, produtos de perfumaria e de higiene pessoal', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de preparações farmacêuticas (manipulação)', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Reforma de pneumáticos usados', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de borracha, exceto pneumáticos e câmaras de ar', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de laminados planos e tubulares de material plástico', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de embalagens de material plástico', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de tubos e acessórios de material plástico para uso na construção', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de material plástico não especificados anteriormente', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de estruturas pré-moldadas de concreto armado, em série e sob encomenda', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de cimento para uso na construção', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de fibrocimento para uso na construção', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de casas pré-moldadas de concreto', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Preparação de massa de concreto e argamassa para construção', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de outros artefatos e produtos de concreto, cimento, fibrocimento, gesso, e materiais semelhantes', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Britamento de pedras, exceto associado à extração', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Aparelhamento de pedras para construção, exceto associado à extração', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Aparelhamento de placas e execução de trabalhos em mármore, granito, ardósia e outras pedras', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de estruturas metálicas sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Fabricação de esquadrias de metal sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de tanques, reservatórios metálicos e caldeiras para aquecimento central', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de caldeiras geradoras de vapor, exceto para aquecimento central e para veículos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Produção de artefatos estampados de metal, sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artigos de cutelaria, sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artigos de serralheria, exceto esquadrias', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de ferramentas, sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de embalagens metálicas', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos de trefilados de metal padronizados', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos de trefilados de metal, exceto padronizados', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artigos de metal para uso doméstico e pessoal', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de produtos de metal não especificados anteriormente', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Serviços de confecção de armações metálicas para construção', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Serviço de corte e dobra de metais', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de outros produtos de metal não especificados anteriormente', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de componentes eletrônicos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de equipamentos de informática', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricáçgo de periféricos para equipamentos de informática', 'setor_id' => '1', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Fabricação de equipamentos transmissores de comunicação', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos telefônicos e de outros equipamentos de comunicação', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos de recepção, reprodução, gravação e amplificação de áudio e vídeo', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos e equipamentos de medida, teste e controle', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de cronômetros e relógios', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos eletromédicos e eletroterapêuticos e equipamentos de irradiação', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de equipamentos e instrumentos ópticos, peças e acessórios', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos fotográficos e cinematográficos, peças e acessórios', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de mídias virgens, magnéticas e ópticas', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de luminárias e outros equipamentos de iluminação', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de eletrodos, contatos e outros artigos de carvão e grafita para uso elétrico, eletroímãs e isoladores', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de equipamentos para sinalização e alarme', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de válvulas, registros e dispositivos semelhantes', 'setor_id' => '1', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de móveis com predominância de madeira, sem pintura e/ou verniz', 'setor_id' => '1', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de móveis com predominância de metal, sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de móveis de outros materiais, exceto madeira e metal', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Lapidação de gemas', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos de joalheria e ourivesaria', 'setor_id' => '1', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Cunhagem de moedas e medalhas', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de bijuterias e artefatos semelhantes (sem tratamento químico)', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de instrumentos musicais sem tratamento químico superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artefatos para caça, pesca e esporte', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de brinquedos e jogos recreativos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de instrumentos não-eletrônicos e utensílios para uso médico, cirúrgico, odontológico e de laboratório, sem tratamento superficial', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de mobiliário para uso médico, cirúrgico, odontológico e de laboratório', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos e utensílios para correção de defeitos físicos e aparelhos ortopédicos em geral, sem tratamento superficial, sob encomenda', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aparelhos e utensílios para correção de defeitos físicos e aparelhos ortopédicos em geral, sem tratamento superficial, exceto sob encomenda', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de materiais para medicina e odontologia', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Serviços de prótese dentária', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de artigos ópticos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Serviços de laboratórios ópticos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de escovas, pincéis e vassouras', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de equipamentos e acessórios para segurança e proteção pessoal e profissional', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de roupas de proteção e segurança e resistentes a fogo', 'setor_id' => '1', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Fabricação de guarda-chuvas e similares', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de canetas, lápis e outros artigos para escritório', 'setor_id' => '1', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de letras, letreiros e placas de qualquer material, exceto luminosos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de painéis e letreiros luminosos', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de aviamentos para costura sem tratamento químico', 'setor_id' => '1', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Fabricação de velas, inclusive decorativas', 'setor_id' => '1', 'potencial_poluidor' => '2']);

        \App\Models\Cnae::create(['nome' => 'Extração de areia, argila, cascalho e saibro, exceto extraídos de corpos hídricos', 'setor_id' => '2', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Extração de granito', 'setor_id' => '2', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Extração de mármore', 'setor_id' => '2', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Extração de feldspato', 'setor_id' => '2', 'potencial_poluidor' => '3']);

        \App\Models\Cnae::create(['nome' => 'Usina de compostagem', 'setor_id' => '3', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Reciclagem de materiais metálicos e triagem de materiais recicláveis (que inclua pelo menos uma etapa do processo de industrialização)', 'setor_id' => '3', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Reciclagem de materiais plásticos (que inclua pelo menos uma etapa do processo de industrialização)', 'setor_id' => '3', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Reciclagem de vidros (que inclua pelo menos uma etapa do processo de industrialização)', 'setor_id' => '3', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Reciclagem de papel e papelão (que inclua pelo menos uma etapa do processo de industrialização)', 'setor_id' => '3', 'potencial_poluidor' => '3']);


        \App\Models\Cnae::create(['nome' => 'Transportadoras de resíduos — Transporte (desde que a coleta, o transporte e a destinação final se limitem ao território do município)', 'setor_id' => '3', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Transportadoras de resíduos — Base operacional', 'setor_id' => '3', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Autoclave para resíduos de serviços de saúde e outros processos de inertização', 'setor_id' => '3', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Crematório e serviço de cremação', 'setor_id' => '3', 'potencial_poluidor' => '2']);

        \App\Models\Cnae::create(['nome' => 'Construção ou ampliação de redes de coleta, interceptores e emissários de esgotos domésticos (sem ETE)', 'setor_id' => '4', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Estações de tratamento de esgoto sanitário', 'setor_id' => '4', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Limpadoras de tanques sépticos (limpa fossas) — Transporte (desde que a coleta, o transporte e a destinação final se limitem ao território do município)', 'setor_id' => '4', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Limpadoras de tanques sépticos (limpa fossas) — Base operacional', 'setor_id' => '4', 'potencial_poluidor' => '3']);

        \App\Models\Cnae::create(['nome' => 'Edificações uni ou plurifamiliares', 'setor_id' => '5', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Conjuntos habitacionais', 'setor_id' => '5', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Loteamentos, desmembramentos e remembramentos', 'setor_id' => '5', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Equipamentos religiosos ou similares', 'setor_id' => '5', 'potencial_poluidor' => '1']);

        \App\Models\Cnae::create(['nome' => 'Depósitos de materiais recicláveis', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Postos de revenda ou abastecimento de combustíveis líquidos, GNV e GNC', 'setor_id' => '6', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Clínica veterinária com procedimentos cirúrgicos', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Clínica veterinária sem procedimentos cirúrgicos', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Posto de saúde', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Laboratório de análise clínica', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Clínica médica com procedimentos cirúrgicos e clínica odontológica', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Clínica médica e similares, sem procedimentos cirúrgicos.', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Serviços de radiologia', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Lavanderias não industriais sem tingimento', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Lavanderias não industriais com tingimento', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Galerias comerciais', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Shopping', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Escolas, creches e centro de ensino', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Universidades', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Faculdades e/ou escolas técnicas', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Centros de pesquisa e tecnologia sem manipulação de produtos químicos, biológicos e similares perigosos', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Centros de pesquisa e tecnologia com manipulação de produtos químicos, biológicos e similares perigosos.', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Hotéis, pousadas, hospedarias, flats e similares (exceto resorts)', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Camping,', 'setor_id' => '6', 'potencial_poluidor' => '1']);


        \App\Models\Cnae::create(['nome' => 'Armazenamento e revenda de recipientes transportáveis de gás liquefeito de petróleo GLP', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Serviços de pré-impressão e acabamentos gráficos', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Comércio de veículos automotores', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Manutenção e reparação de veículos automotores', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Manutenção e reparação de máquinas e equipamentos', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Lavagem de veículos', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de alimentos para animais e insumos agropecuários', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de leite e laticínios', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de carnes, aves, produtos da carne e pescados', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de hortifrutigranjeiros', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de produtos alimentícios em geral, inclusive com fracionamento/acondicionamento', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Comércio de produtos de higiene, limpeza e conservação domiciliar', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de madeira, pedras e material de construção', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de carvão, inclusive com fracionamento / acondicionamento', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Comércio de defensivos agrícolas, adubos, fertilizantes e corretivos do solo', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Comércio Atacadista de produtos químicos e petroquímicos', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Comércio de resíduos e sucatas metálicas', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Comércio de mercadorias em geral com predominância de produtos alimentícios (minimercados, mercearias, supermercados, hipermercados e armazéns)', 'setor_id' => '6', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Comércio de produtos farmacêuticos e artigos médicos', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Transporte de cargas em geral (exceto produtos perigosos) — Transporte (desde que a coleta e o transporte se limitem ao território do município)', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Transporte de cargas em geral (exceto produtos perigosos) — base operacional', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Transporte coletivo de passageiros (desde que o transporte se limite ao território do município)', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Transporte coletivo de passageiros (desde que o transporte se limite ao território do município) — base operacional', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Restaurante e similares com emissões atmosféricas', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Lanchonetes, casa de chá, de sucos e similares com emissões atmosféricas', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Serviços de catering, bufê e outros serviços de comida preparada', 'setor_id' => '6', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Laboratórios de análises físico-química e/ou biológica', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Laboratórios fotográficos com geração de efluentes químicos', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Locação de sanitário químico', 'setor_id' => '6', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Imunização e controle de pragas urbanas com atividades executadas nos limites do território do Município', 'setor_id' => '6', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Tinturaria', 'setor_id' => '6', 'potencial_poluidor' => '3']);

        \App\Models\Cnae::create(['nome' => 'Pontes e viadutos', 'setor_id' => '7', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Acessos', 'setor_id' => '7', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Implantação e pavimentação de ruas', 'setor_id' => '7', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Piscicultura convencional (viveiro escavado)', 'setor_id' => '8', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Piscicultura em tanque-rede (água doce)', 'setor_id' => '8', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Carcinicultura (água doce)', 'setor_id' => '8', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Produção de formas jovens', 'setor_id' => '8', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Avicultura', 'setor_id' => '8', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Caprinovinocultura (em sistema intensivo)', 'setor_id' => '8', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Ranicultura', 'setor_id' => '8', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Herpetocultura', 'setor_id' => '8', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Piscicultura ornamental', 'setor_id' => '8', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Central de embalagem e expedição de produtos agrícolas', 'setor_id' => '8', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Atividades agrícolas sem irrigação e/ou drenagem', 'setor_id' => '8', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Pecuária extensiva', 'setor_id' => '8', 'potencial_poluidor' => '3']);

        \App\Models\Cnae::create(['nome' => 'Armazenamento de produtos químicos e/ou substâncias perigosas', 'setor_id' => '9', 'potencial_poluidor' => '3']);

        \App\Models\Cnae::create(['nome' => 'Canteiros de obra', 'setor_id' => '10', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => "Planos e projetos urbanísticos. (Quando houver intervenção em curso d'água que necessitem de outorga, esta intervenção será licenciada pela CPRH).", 'setor_id' => '10', 'potencial_poluidor' => '3']);


        \App\Models\Cnae::create(['nome' => 'Revitalizações/requalificação de espaços públicos', 'setor_id' => '10', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Terraplenagem', 'setor_id' => '10', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Muro de contenção de barreiras ou encostas', 'setor_id' => '10', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Remediação de áreas degradadas (exceto de lixões)', 'setor_id' => '10', 'potencial_poluidor' => '1']);

        \App\Models\Cnae::create(['nome' => 'Sistemas de distribuição de água (mediante licença de captação expedida pela CPRH)', 'setor_id' => '11', 'potencial_poluidor' => '2']);

        \App\Models\Cnae::create(['nome' => 'Subestações de energia elétrica', 'setor_id' => '12', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Estações rádio base (ERBs) e equipamentos de telefonia sem fio', 'setor_id' => '12', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Redes de transmissão de sistemas de telefonia', 'setor_id' => '12', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Sistemas de geração de energia elétrica de origem eólica', 'setor_id' => '12', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Sistemas de geração de energia elétrica de origem fotovoltaica e heliotérmica', 'setor_id' => '12', 'potencial_poluidor' => '1']);

        \App\Models\Cnae::create(['nome' => 'Cemitérios e similares', 'setor_id' => '13', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Hospitais', 'setor_id' => '13', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Terminal de passageiros', 'setor_id' => '13', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Aeródromos (pista de pouso e decolagem)', 'setor_id' => '13', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Heliponto e heliporto', 'setor_id' => '13', 'potencial_poluidor' => '1']);


        \App\Models\Cnae::create(['nome' => 'Polos, condomínios, distritos e parques industriais', 'setor_id' => '14', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Ginásios, quadras e similares', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Estádios de futebol', 'setor_id' => '14', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Complexo esportivos e vilas olímpicas', 'setor_id' => '14', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Autódromo', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Trilhas ecológicas', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Casa de shows e similares', 'setor_id' => '14', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Centro de convenções', 'setor_id' => '14', 'potencial_poluidor' => '2']);
        \App\Models\Cnae::create(['nome' => 'Teatros e cinemas', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Clubes', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Praças', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Parques urbanos e metropolitanos, parques de exposição e similares', 'setor_id' => '14', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Jardins botânicos', 'setor_id' => '14', 'potencial_poluidor' => '1']);

        \App\Models\Cnae::create(['nome' => 'Viveiro florestal', 'setor_id' => '15', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Exploração de produtos vegetais: uso não madeireiro (óleos essenciais, resinas, gomas, frutos, folhas, ramos, raízes, sementes e produtos voltados para a produção de fármacos, cosméticos e outras finalidades)', 'setor_id' => '15', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Supressão de indivíduos isolados de espécies nativas', 'setor_id' => '15', 'potencial_poluidor' => '2']);


        \App\Models\Cnae::create(['nome' => 'Supressão da vegetação nativa para uso alternativo do solo', 'setor_id' => '15', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Intervenção e supressão em área de preservação permanente', 'setor_id' => '15', 'potencial_poluidor' => '3']);
        \App\Models\Cnae::create(['nome' => 'Transplante de árvores', 'setor_id' => '15', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Poda de árvores', 'setor_id' => '15', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Implantação ou enriquecimento de florestas plantadas com espécies nativas', 'setor_id' => '15', 'potencial_poluidor' => '1']);
        \App\Models\Cnae::create(['nome' => 'Implantação de florestas com espécies exóticas', 'setor_id' => '15', 'potencial_poluidor' => '1']);

    }
}
