#!/usr/bin/env python3
from fpdf import FPDF

class ContratoPDF(FPDF):
    def header(self):
        pass
    def footer(self):
        pass

pdf = ContratoPDF()
pdf.add_page()
pdf.set_auto_page_break(auto=True, margin=15)

# Título
pdf.set_font('Helvetica', 'B', 14)
pdf.cell(0, 8, 'CONTRATO DE LOCAÇÃO RESIDENCIAL', 0, 1, 'C')
pdf.ln(5)

# Texto do contrato
pdf.set_font('Helvetica', '', 10)

contrato = """Pelo presente instrumento particular, as partes abaixo qualificadas, de pleno e comum acordo, firmam o presente contrato de locação residencial, nos termos da Lei nº 8.245/91 (Lei de Locações), mediante as seguintes cláusulas e condições:"""

pdf.multi_cell(0, 5, contrato)
pdf.ln(3)

# Cláusula 1 - Das Partes
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA PRIMEIRA - DAS PARTES', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'LOCADOR:')
pdf.cell(0, 5, 'Nome: MARIZA THEODORO SILVA', 0, 1)
pdf.cell(0, 5, 'CPF: 282.419.288-74', 0, 1)
pdf.cell(0, 5, 'RG: 29.456.196-1', 0, 1)
pdf.cell(0, 5, 'Endereço: Rua Takeo Ota, 745 - Parque Meia Lua - Jacareí - SP', 0, 1)
pdf.ln(3)

pdf.multi_cell(0, 5, 'LOCATÁRIO:')
pdf.cell(0, 5, 'Nome: LUAN RODRIGO DE MORAES', 0, 1)
pdf.cell(0, 5, 'CPF: 442.297.818-73', 0, 1)
pdf.cell(0, 5, 'RG: 49.383.059-5', 0, 1)
pdf.cell(0, 5, 'Nascimento: 09/09/1993', 0, 1)
pdf.cell(0, 5, 'Natural: JACAREI-SP', 0, 1)
pdf.ln(5)

# Cláusula 2 - Do Imóvel
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA SEGUNDA - DO IMÓVEL', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'O LOCADOR cede em locação ao LOCATÁRIO o imóvel situado na:')
pdf.cell(0, 5, 'Endereço: Rua Lagoa Cassange, 64 - Baixo Lagoa Azul - Jacareí - SP - CEP 12335-492', 0, 1)
pdf.ln(5)

# Cláusula 3 - Do Prazo
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA TERCEIRA - DO PRAZO', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'O presente contrato terá vigência de 12 (doze) meses, iniciando-se em 04 de abril de 2026 e terminando em 04 de abril de 2027.')
pdf.ln(5)

# Cláusula 4 - Do Valor
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA QUARTA - DO VALOR E FORMA DE PAGAMENTO', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'O valor mensal da locação é de R$ 600,00 (seiscentos reais), a ser pago mediante Pix, através do número (12)988443969, com vencimento no dia 25 de cada mês.')
pdf.ln(3)
pdf.multi_cell(0, 5, 'Parágrafo único: O LOCATÁRIO deverá apresentar o comprovante de pagamento ao LOCADOR até a data do vencimento. O LOCADOR emitirá recibo assinado confirmando o recebimento do valor.')
pdf.ln(5)

# Cláusula 5 - Da Entrada
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA QUINTA - DA ENTRADA', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'O LOCATÁRIO já pagou a quantia de R$ 600,00 (seiscentos reais) referente a entrada/mês de ocupação, referente ao período de 04/04/2026.')
pdf.ln(5)

# Cláusula 6 - Da Renovação
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA SEXTA - DA RENOVAÇÃO', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'O presente contrato não renova automaticamente. Ao término do prazo contratual, caso ambas as partes desejem dar continuidade à locação, deverá ser elaborado novo contrato.')
pdf.ln(5)

# Cláusula 7 - Do Aviso Prévio
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA SÉTIMA - DO AVISO PRÉVIO', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'Caso o LOCATÁRIO não deseje continuar no imóvel após o término do contrato, deverá avisar o LOCADOR com antecedência mínima de 30 (trinta) dias antes do vencimento contratual.')
pdf.ln(3)
pdf.multi_cell(0, 5, 'Parágrafo único: Caso o LOCATÁRIO interrompa o contrato antes do prazo estipulado, serão aplicadas as regras previstas na Lei nº 8.245/91 (Lei de Locações), inclusive quanto à multa e notificações.')
pdf.ln(5)

# Cláusula 8 - Das Utilidades
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA OITAVA - DAS UTILIDADES', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'Os serviços de água e energia elétrica deverão ser transferidos para o nome do LOCATÁRIO (LUAN RODRIGO DE MORAES) no prazo de 10 (dez) dias úteis após a assinatura deste contrato. Todas as despesas decorrentes são de responsabilidade exclusiva do LOCATÁRIO.')
pdf.ln(5)

# Encerramento
pdf.set_font('Helvetica', 'B', 11)
pdf.cell(0, 6, 'CLAÚSULA NONA - DAS DISPOSIÇÕES GERAIS', 0, 1)
pdf.set_font('Helvetica', '', 10)
pdf.multi_cell(0, 5, 'As partes reconhecem que o presente contrato é regido pela Lei nº 8.245/91 e pelo Código Civil Brasileiro, responsabilizando-se pelo cumprimento de todas as cláusulas aqui estabelecidas.')
pdf.ln(8)
pdf.multi_cell(0, 5, 'E por estarem de pleno acordo, as partes assinam o presente contrato em 02 (duas) vias de igual teor.')
pdf.ln(10)

pdf.set_font('Helvetica', '', 10)
pdf.cell(0, 5, 'Jacareí - SP, 04 de abril de 2026.', 0, 1)
pdf.ln(15)

# Assinaturas
pdf.cell(85, 5, '', 0, 0)
pdf.cell(85, 5, '', 0, 1)
pdf.cell(85, 5, '_____________________________', 0, 0, 'C')
pdf.cell(85, 5, '_____________________________', 0, 1, 'C')
pdf.cell(85, 5, 'MARIZA THEODORO SILVA', 0, 0, 'C')
pdf.cell(85, 5, 'LUAN RODRIGO DE MORAES', 0, 1, 'C')
pdf.cell(85, 5, 'LOCADOR (a)', 0, 0, 'C')
pdf.cell(85, 5, 'LOCATÁRIO (a)', 0, 1, 'C')
pdf.ln(10)

pdf.cell(85, 5, '_____________________________', 0, 0, 'C')
pdf.cell(85, 5, '_____________________________', 0, 1, 'C')
pdf.cell(85, 5, 'TESTEMUNHA 1', 0, 0, 'C')
pdf.cell(85, 5, 'TESTEMUNHA 2', 0, 1, 'C')

# Salvar
output = '/root/.openclaw/workspace/contrato_locaçao_mariza_luan_2026.pdf'
pdf.output(output)
print(f'PDF gerado: {output}')
