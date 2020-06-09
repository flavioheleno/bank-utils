<?php
declare(strict_types = 1);

namespace BankUtils\Common;

use InvalidArgumentException;
use RuntimeException;

/**
 * @link https://www.febraban.org.br/associados/utilitarios/Bancos.asp
 */
final class BankCode {
  private static $list = [
    '654' => [
      'name' => 'Banco A.J.Renner S.A.',
      'url'  => 'www.bancorenner.com.br'
    ],
    '246' => [
      'name' => 'Banco ABC Brasil S.A.',
      'url'  => 'www.abcbrasil.com.br'
    ],
    '075' => [
      'name' => 'Banco ABN AMRO S.A.',
      'url'  => 'www.abnamro.com'
    ],
    '121' => [
      'name' => 'Banco Agibank S.A.',
      'url'  => 'www.agibank.com.br'
    ],
    '025' => [
      'name' => 'Banco Alfa S.A.',
      'url'  => 'www.bancoalfa.com.br'
    ],
    '641' => [
      'name' => 'Banco Alvorada S.A.',
      'url'  => ''
    ],
    '065' => [
      'name' => 'Banco Andbank (Brasil) S.A.',
      'url'  => 'www.andbank-lla.com.br'
    ],
    '213' => [
      'name' => 'Banco Arbi S.A.',
      'url'  => 'www.arbi.com.br'
    ],
    '096' => [
      'name' => 'Banco B3 S.A.',
      'url'  => 'www.bmfbovespa.com.br/bancobmfbovespa/'
    ],
    '024' => [
      'name' => 'Banco BANDEPE S.A.',
      'url'  => 'www.santander.com.br'
    ],
    '330' => [
      'name' => 'Banco Bari de Investimentos e Financiamentos S/A',
      'url'  => 'www.bancobari.com.br'
    ],
    '318' => [
      'name' => 'Banco BMG S.A.',
      'url'  => 'www.bancobmg.com.br'
    ],
    '752' => [
      'name' => 'Banco BNP Paribas Brasil S.A.',
      'url'  => 'www.bnpparibas.com.br'
    ],
    '107' => [
      'name' => 'Banco BOCOM BBM S.A.',
      'url'  => 'www.bancobbm.com.br'
    ],
    '063' => [
      'name' => 'Banco Bradescard S.A.',
      'url'  => 'www.ibi.com.br'
    ],
    '036' => [
      'name' => 'Banco Bradesco BBI S.A.',
      'url'  => ''
    ],
    '122' => [
      'name' => 'Banco Bradesco BERJ S.A.',
      'url'  => ''
    ],
    '204' => [
      'name' => 'Banco Bradesco Cartões S.A.',
      'url'  => ''
    ],
    '394' => [
      'name' => 'Banco Bradesco Financiamentos S.A.',
      'url'  => ''
    ],
    '237' => [
      'name' => 'Banco Bradesco S.A.',
      'url'  => 'www.bradesco.com.br'
    ],
    '218' => [
      'name' => 'Banco BS2 S.A.',
      'url'  => 'www.bs2.com/banco/'
    ],
    '208' => [
      'name' => 'Banco BTG Pactual S.A.',
      'url'  => 'www.btgpactual.com'
    ],
    '473' => [
      'name' => 'Banco Caixa Geral - Brasil S.A.',
      'url'  => 'www.bcgbrasil.com.br'
    ],
    '412' => [
      'name' => 'Banco Capital S.A.',
      'url'  => 'www.bancocapital.com.br'
    ],
    '040' => [
      'name' => 'Banco Cargill S.A.',
      'url'  => 'www.bancocargill.com.br'
    ],
    '266' => [
      'name' => 'Banco Cédula S.A.',
      'url'  => 'www.bancocedula.com.br'
    ],
    '739' => [
      'name' => 'Banco Cetelem S.A.',
      'url'  => 'www.cetelem.com.br'
    ],
    '233' => [
      'name' => 'Banco Cifra S.A.',
      'url'  => 'www.bancocifra.com.br'
    ],
    '745' => [
      'name' => 'Banco Citibank S.A.',
      'url'  => 'www.citibank.com.br'
    ],
    '241' => [
      'name' => 'Banco Clássico S.A.',
      'url'  => 'www.bancoclassico.com.br'
    ],
    '756' => [
      'name' => 'Banco Cooperativo do Brasil S.A. - BANCOOB',
      'url'  => 'www.bancoob.com.br'
    ],
    '748' => [
      'name' => 'Banco Cooperativo Sicredi S.A.',
      'url'  => 'www.sicredi.com.br'
    ],
    '222' => [
      'name' => 'Banco Credit Agricole Brasil S.A.',
      'url'  => 'www.calyon.com.br'
    ],
    '505' => [
      'name' => 'Banco Credit Suisse (Brasil) S.A.',
      'url'  => 'www.csfb.com'
    ],
    '069' => [
      'name' => 'Banco Crefisa S.A.',
      'url'  => 'www.crefisa.com.br'
    ],
    '003' => [
      'name' => 'Banco da Amazônia S.A.',
      'url'  => 'www.bancoamazonia.com.br'
    ],
    '083' => [
      'name' => 'Banco da China Brasil S.A.',
      'url'  => 'www.boc-brazil.com'
    ],
    '707' => [
      'name' => 'Banco Daycoval S.A.',
      'url'  => 'www.daycoval.com.br'
    ],
    '51' => [
      'name' => 'Banco de Desenvolvimento do Espírito Santo S.A.',
      'url'  => ''
    ],
    '300' => [
      'name' => 'Banco de La Nacion Argentina',
      'url'  => 'www.bna.com.ar'
    ],
    '495' => [
      'name' => 'Banco de La Provincia de Buenos Aires',
      'url'  => 'www.bapro.com.ar'
    ],
    '494' => [
      'name' => 'Banco de La Republica Oriental del Uruguay',
      'url'  => 'www.bancorepublica.com.uy'
    ],
    '001' => [
      'name' => 'Banco do Brasil S.A.',
      'url'  => 'www.bb.com.br'
    ],
    '047' => [
      'name' => 'Banco do Estado de Sergipe S.A.',
      'url'  => 'www.banese.com.br'
    ],
    '037' => [
      'name' => 'Banco do Estado do Pará S.A.',
      'url'  => 'www.banpara.b.br'
    ],
    '041' => [
      'name' => 'Banco do Estado do Rio Grande do Sul S.A.',
      'url'  => 'www.banrisul.com.br'
    ],
    '004' => [
      'name' => 'Banco do Nordeste do Brasil S.A.',
      'url'  => 'www.banconordeste.gov.br'
    ],
    '265' => [
      'name' => 'Banco Fator S.A.',
      'url'  => 'www.fator.com.br'
    ],
    '224' => [
      'name' => 'Banco Fibra S.A.',
      'url'  => 'www.bancofibra.com.br'
    ],
    '626' => [
      'name' => 'Banco Ficsa S.A.',
      'url'  => 'www.ficsa.com.br'
    ],
    '094' => [
      'name' => 'Banco Finaxis S.A.',
      'url'  => 'www.bancofinaxis.com.br'
    ],
    '612' => [
      'name' => 'Banco Guanabara S.A.',
      'url'  => 'www.bancoguanabara.com.br'
    ],
    '012' => [
      'name' => 'Banco Inbursa S.A.',
      'url'  => 'www.bancoinbursa.com'
    ],
    '604' => [
      'name' => 'Banco Industrial do Brasil S.A.',
      'url'  => 'www.bancoindustrial.com.br'
    ],
    '653' => [
      'name' => 'Banco Indusval S.A.',
      'url'  => 'www.bip.b.br'
    ],
    '077' => [
      'name' => 'Banco Inter S.A.',
      'url'  => 'www.bancointer.com.br'
    ],
    '249' => [
      'name' => 'Banco Investcred Unibanco S.A.',
      'url'  => ''
    ],
    '184' => [
      'name' => 'Banco Itaú BBA S.A.',
      'url'  => 'www.itaubba.com.br'
    ],
    '029' => [
      'name' => 'Banco Itaú Consignado S.A.',
      'url'  => ''
    ],
    '479' => [
      'name' => 'Banco ItauBank S.A',
      'url'  => 'www.itaubank.com.br'
    ],
    '376' => [
      'name' => 'Banco J. P. Morgan S.A.',
      'url'  => 'www.jpmorgan.com'
    ],
    '074' => [
      'name' => 'Banco J. Safra S.A.',
      'url'  => 'www.safra.com.br'
    ],
    '217' => [
      'name' => 'Banco John Deere S.A.',
      'url'  => 'www.johndeere.com.br'
    ],
    '076' => [
      'name' => 'Banco KDB S.A.',
      'url'  => 'www.bancokdb.com.br'
    ],
    '757' => [
      'name' => 'Banco KEB HANA do Brasil S.A.',
      'url'  => 'www.bancokeb.com.br'
    ],
    '600' => [
      'name' => 'Banco Luso Brasileiro S.A.',
      'url'  => 'www.lusobrasileiro.com.br'
    ],
    '243' => [
      'name' => 'Banco Máxima S.A.',
      'url'  => 'www.bancomaxima.com.br'
    ],
    '720' => [
      'name' => 'Banco Maxinvest S.A.',
      'url'  => 'www.bancomaxinvest.com.br'
    ],
    '389' => [
      'name' => 'Banco Mercantil do Brasil S.A.',
      'url'  => 'www.mercantil.com.br'
    ],
    '370' => [
      'name' => 'Banco Mizuho do Brasil S.A.',
      'url'  => 'www.mizuhobank.com/brazil/pt/'
    ],
    '746' => [
      'name' => 'Banco Modal S.A.',
      'url'  => 'www.bancomodal.com.br'
    ],
    '066' => [
      'name' => 'Banco Morgan Stanley S.A.',
      'url'  => 'www.morganstanley.com.br'
    ],
    '456' => [
      'name' => 'Banco MUFG Brasil S.A.',
      'url'  => 'www.br.bk.mufg.jp'
    ],
    '007' => [
      'name' => 'Banco Nacional de Desenvolvimento Econômico e Social - BNDES',
      'url'  => 'www.bndes.gov.br'
    ],
    '169' => [
      'name' => 'Banco Olé Bonsucesso Consignado S.A.',
      'url'  => 'www.oleconsignado.com.br'
    ],
    '079' => [
      'name' => 'Banco Original do Agronegócio S.A.',
      'url'  => 'www.original.com.br'
    ],
    '212' => [
      'name' => 'Banco Original S.A.',
      'url'  => 'www.original.com.br'
    ],
    '712' => [
      'name' => 'Banco Ourinvest S.A.',
      'url'  => 'www.ourinvest.com.br'
    ],
    '623' => [
      'name' => 'Banco PAN S.A.',
      'url'  => 'www.bancopan.com.br'
    ],
    '611' => [
      'name' => 'Banco Paulista S.A.',
      'url'  => 'www.bancopaulista.com.br'
    ],
    '643' => [
      'name' => 'Banco Pine S.A.',
      'url'  => 'www.pine.com'
    ],
    '658' => [
      'name' => 'Banco Porto Real de Investimentos S.A.',
      'url'  => ''
    ],
    '747' => [
      'name' => 'Banco Rabobank International Brasil S.A.',
      'url'  => 'www.rabobank.com.br'
    ],
    '633' => [
      'name' => 'Banco Rendimento S.A.',
      'url'  => 'www.rendimento.com.br'
    ],
    '741' => [
      'name' => 'Banco Ribeirão Preto S.A.',
      'url'  => 'www.brp.com.br'
    ],
    '120' => [
      'name' => 'Banco Rodobens S.A.',
      'url'  => 'www.rodobens.com.br'
    ],
    '422' => [
      'name' => 'Banco Safra S.A.',
      'url'  => 'www.safra.com.br'
    ],
    '033' => [
      'name' => 'Banco Santander (Brasil) S.A.',
      'url'  => 'www.santander.com.br'
    ],
    '743' => [
      'name' => 'Banco Semear S.A.',
      'url'  => 'www.bancosemear.com.br'
    ],
    '754' => [
      'name' => 'Banco Sistema S.A.',
      'url'  => 'www.btgpactual.com'
    ],
    '630' => [
      'name' => 'Banco Smartbank S.A.',
      'url'  => ''
    ],
    '366' => [
      'name' => 'Banco Société Générale Brasil S.A.',
      'url'  => 'www.sgbrasil.com.br'
    ],
    '637' => [
      'name' => 'Banco Sofisa S.A.',
      'url'  => 'www.sofisa.com.br'
    ],
    '464' => [
      'name' => 'Banco Sumitomo Mitsui Brasileiro S.A.',
      'url'  => 'www.smbcgroup.com.br'
    ],
    '082' => [
      'name' => 'Banco Topázio S.A.',
      'url'  => 'www.bancotopazio.com.br'
    ],
    '634' => [
      'name' => 'Banco Triângulo S.A.',
      'url'  => 'www.tribanco.com.br'
    ],
    '018' => [
      'name' => 'Banco Tricury S.A.',
      'url'  => 'www.bancotricury.com.br'
    ],
    '655' => [
      'name' => 'Banco Votorantim S.A.',
      'url'  => 'www.bancovotorantim.com.br'
    ],
    '610' => [
      'name' => 'Banco VR S.A.',
      'url'  => 'www.vrinvestimentos.com.br'
    ],
    '119' => [
      'name' => 'Banco Western Union do Brasil S.A.',
      'url'  => 'www.bancowesternunion.com.br'
    ],
    '124' => [
      'name' => 'Banco Woori Bank do Brasil S.A.',
      'url'  => 'www.wooribank.com.br'
    ],
    '102' => [
      'name' => 'Banco XP S.A.',
      'url'  => ''
    ],
    '081' => [
      'name' => 'BancoSeguro S.A.',
      'url'  => 'www.rendimento.com.br'
    ],
    '021' => [
      'name' => 'BANESTES S.A. Banco do Estado do Espírito Santo',
      'url'  => 'www.banestes.com.br'
    ],
    '755' => [
      'name' => 'Bank of America Merrill Lynch Banco Múltiplo S.A.',
      'url'  => 'www.ml.com'
    ],
    '250' => [
      'name' => 'BCV - Banco de Crédito e Varejo S.A.',
      'url'  => 'www.bancobcv.com.br'
    ],
    '144' => [
      'name' => 'BEXS Banco de Câmbio S.A.',
      'url'  => 'www.bexs.com.br'
    ],
    '017' => [
      'name' => 'BNY Mellon Banco S.A.',
      'url'  => 'www.bnymellon.com.br'
    ],
    '126' => [
      'name' => 'BR Partners Banco de Investimento S.A.',
      'url'  => 'www.brap.com.br'
    ],
    '070' => [
      'name' => 'BRB - Banco de Brasília S.A.',
      'url'  => 'www.brb.com.br'
    ],
    '092' => [
      'name' => 'Brickell S.A. Crédito, Financiamento e Investimento',
      'url'  => 'www.brickellcfi.com.br'
    ],
    '104' => [
      'name' => 'Caixa Econômica Federal',
      'url'  => 'www.caixa.gov.br'
    ],
    '114' => [
      'name' => 'Central das Cooperativas de Economia e Crédito Mútuo do Estado do Espírito Santo Ltda.',
      'url'  => 'www.cecoop.com.br'
    ],
    '320' => [
      'name' => 'China Construction Bank (Brasil) Banco Múltiplo S.A.',
      'url'  => 'www.br.ccb.com'
    ],
    '477' => [
      'name' => 'Citibank N.A.',
      'url'  => 'www.citibank.com'
    ],
    '163' => [
      'name' => 'Commerzbank Brasil S.A. - Banco Múltiplo',
      'url'  => 'www.commerzbank.com.br'
    ],
    '085' => [
      'name' => 'Cooperativa Central de Crédito - AILOS',
      'url'  => 'www.ailos.coop.br'
    ],
    '097' => [
      'name' => 'Cooperativa Central de Crédito Noroeste Brasileiro Ltda.',
      'url'  => 'www.credisis.com.br'
    ],
    '090' => [
      'name' => 'Cooperativa Central de Economia e Crédito Mutuo - SICOOB UNIMAIS',
      'url'  => 'www.sicoobunimais.com/'
    ],
    '087' => [
      'name' => 'Cooperativa Central de Economia e Crédito Mútuo das Unicreds de Santa Catarina e Paraná',
      'url'  => 'www.unicred.com.br/centralscpr/'
    ],
    '089' => [
      'name' => 'Cooperativa de Crédito Rural da Região da Mogiana',
      'url'  => 'www.credisan.com.br'
    ],
    '098' => [
      'name' => 'CREDIALIANÇA COOPERATIVA DE CRÉDITO RURAL',
      'url'  => 'www.credialianca.com.br'
    ],
    '487' => [
      'name' => 'Deutsche Bank S.A. - Banco Alemão',
      'url'  => 'www.deutsche-bank.com.br'
    ],
    '064' => [
      'name' => 'Goldman Sachs do Brasil Banco Múltiplo S.A.',
      'url'  => 'www.goldmansachs.com'
    ],
    '078' => [
      'name' => 'Haitong Banco de Investimento do Brasil S.A.',
      'url'  => 'www.haitongib.com.br'
    ],
    '062' => [
      'name' => 'Hipercard Banco Múltiplo S.A.',
      'url'  => 'www.hipercard.com.br'
    ],
    '269' => [
      'name' => 'HSBC Brasil S.A. - Banco de Investimento',
      'url'  => ''
    ],
    '132' => [
      'name' => 'ICBC do Brasil Banco Múltiplo S.A.',
      'url'  => 'www.icbcbr.com.br'
    ],
    '492' => [
      'name' => 'ING Bank N.V.',
      'url'  => 'www.ing.com'
    ],
    '139' => [
      'name' => 'Intesa Sanpaolo Brasil S.A. - Banco Múltiplo',
      'url'  => 'www.intesasanpaolobrasil.com.br'
    ],
    '652' => [
      'name' => 'Itaú Unibanco Holding S.A.',
      'url'  => 'www.itau.com.br'
    ],
    '341' => [
      'name' => 'Itaú Unibanco S.A.',
      'url'  => 'www.itau.com.br'
    ],
    '488' => [
      'name' => 'JPMorgan Chase Bank, National Association',
      'url'  => 'www.jpmorganchase.com'
    ],
    '399' => [
      'name' => 'Kirton Bank S.A. - Banco Múltiplo',
      'url'  => ''
    ],
    '128' => [
      'name' => 'MS Bank S.A. Banco de Câmbio',
      'url'  => 'www.msbank.com.br'
    ],
    '753' => [
      'name' => 'Novo Banco Continental S.A. - Banco Múltiplo',
      'url'  => 'www.nbcbank.com.br'
    ],
    '613' => [
      'name' => 'Omni Banco S.A.',
      'url'  => 'www.bancopecunia.com.br'
    ],
    '254' => [
      'name' => 'Paraná Banco S.A.',
      'url'  => 'www.paranabanco.com.br'
    ],
    '125' => [
      'name' => 'Plural S.A. - Banco Múltiplo',
      'url'  => 'www.brasilplural.com'
    ],
    '751' => [
      'name' => 'Scotiabank Brasil S.A. Banco Múltiplo',
      'url'  => 'www.br.scotiabank.com'
    ],
    '118' => [
      'name' => 'Standard Chartered Bank (Brasil) S/A–Bco Invest.',
      'url'  => 'www.standardchartered.com'
    ],
    '014' => [
      'name' => 'State Street Brasil S.A. - Banco Comercial',
      'url'  => 'www.br.natixis.com'
    ],
    '095' => [
      'name' => 'Travelex Banco de Câmbio S.A.',
      'url'  => 'www.bancoconfidence.com.br'
    ],
    '129' => [
      'name' => 'UBS Brasil Banco de Investimento S.A.',
      'url'  => 'www.ubs.com'
    ],
    '091' => [
      'name' => 'Unicred Central do Rio Grande do Sul',
      'url'  => 'www.unicred-rs.com.br'
    ],
    '084' => [
      'name' => 'Uniprime Norte do Paraná - Coop de Economia e Crédito Mútuo dos Médicos, Profissionais das Ciências',
      'url'  => ''
    ]
  ];

  public static function validCode(string $code): bool {
    if (preg_match('/^[0-9]{3}$/', $code) !== 1) {
      throw new InvalidArgumentException('A bank code must be 3 numbers long.');
    }

    return isset(self::$list[$code]) === true;
  }

  public static function getName(string $code): string {
    if (self::validCode($code) === false) {
      throw new RuntimeException(sprintf('There is no bank with code "%s".', $code));
    }

    return self::$list[$code]['name'];
  }

  public static function getUrl(string $code): string {
    if (self::validCode($code) === false) {
      throw new RuntimeException(sprintf('There is no bank with code "%s".', $code));
    }

    return self::$list[$code]['url'];
  }
}
