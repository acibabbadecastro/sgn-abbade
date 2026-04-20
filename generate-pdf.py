#!/usr/bin/env python3
"""Gerador de PDF a partir de Markdown"""

from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak
from reportlab.lib.enums import TA_LEFT, TA_CENTER
import re

def markdown_to_text(md_content):
    """Converte Markdown básico para texto formatado"""
    # Remove formatação Markdown
    text = md_content
    text = re.sub(r'###\s+(.+)', r'\1', text)  # H3
    text = re.sub(r'##\s+(.+)', r'\1', text)   # H2
    text = re.sub(r'#\s+(.+)', r'\1', text)    # H1
    text = re.sub(r'\*\*(.+?)\*\*', r'\1', text)  # Bold
    text = re.sub(r'\*(.+?)\*', r'\1', text)      # Italic
    text = re.sub(r'`(.+?)`', r'\1', text)        # Code
    text = re.sub(r'\[(.+?)\]\(.+?\)', r'\1', text)  # Links
    text = re.sub(r'^-\s+', '• ', text, flags=re.MULTILINE)  # Lists
    text = re.sub(r'^\d+\.\s+', '• ', text, flags=re.MULTILINE)  # Numbered lists
    return text

def generate_pdf(md_file, pdf_file, title):
    """Gera PDF a partir de arquivo Markdown"""
    
    # Lê o conteúdo
    with open(md_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Configura o documento
    doc = SimpleDocTemplate(
        pdf_file,
        pagesize=A4,
        rightMargin=2*cm,
        leftMargin=2*cm,
        topMargin=2*cm,
        bottomMargin=2*cm
    )
    
    # Estilos
    styles = getSampleStyleSheet()
    styles.add(ParagraphStyle(name='CustomTitle', parent=styles['Heading1'], fontSize=24, textColor=colors.darkblue, spaceAfter=30, alignment=TA_CENTER))
    styles.add(ParagraphStyle(name='CustomHeading', parent=styles['Heading2'], fontSize=16, textColor=colors.darkblue, spaceBefore=20, spaceAfter=10))
    styles.add(ParagraphStyle(name='CustomSubHeading', parent=styles['Heading3'], fontSize=14, textColor=colors.darkgrey, spaceBefore=15, spaceAfter=8))
    styles.add(ParagraphStyle(name='CustomBody', parent=styles['Normal'], fontSize=11, spaceBefore=6, spaceAfter=6))
    
    story = []
    
    # Título
    story.append(Paragraph(title, styles['CustomTitle']))
    story.append(Spacer(1, 0.5*cm))
    
    # Processa o conteúdo linha por linha
    for line in content.split('\n'):
        line = line.strip()
        
        if not line or line.startswith('---'):
            story.append(Spacer(1, 0.3*cm))
            continue
        
        if line.startswith('# '):
            story.append(Paragraph(markdown_to_text(line), styles['CustomTitle']))
            story.append(Spacer(1, 0.3*cm))
        elif line.startswith('## '):
            story.append(Paragraph(markdown_to_text(line), styles['CustomHeading']))
            story.append(Spacer(1, 0.2*cm))
        elif line.startswith('### '):
            story.append(Paragraph(markdown_to_text(line), styles['CustomSubHeading']))
            story.append(Spacer(1, 0.1*cm))
        elif line.startswith('- ') or line.startswith('* '):
            story.append(Paragraph('• ' + markdown_to_text(line[2:]), styles['CustomBody']))
        elif line.startswith('|'):
            # Tabela - simplificado
            cells = [cell.strip() for cell in line.split('|') if cell.strip()]
            if cells:
                table = Table([cells])
                table.setStyle(TableStyle([
                    ('BACKGROUND', (0, 0), (-1, 0), colors.lightgrey),
                    ('TEXTCOLOR', (0, 0), (-1, -1), colors.black),
                    ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
                    ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
                    ('FONTSIZE', (0, 0), (-1, -1), 10),
                    ('BOTTOMPADDING', (0, 0), (-1, -1), 8),
                    ('TOPPADDING', (0, 0), (-1, -1), 8),
                    ('GRID', (0, 0), (-1, -1), 0.5, colors.grey),
                ]))
                story.append(table)
                story.append(Spacer(1, 0.1*cm))
        else:
            if line and not line.startswith('[') and not line.startswith('!['):
                story.append(Paragraph(markdown_to_text(line), styles['CustomBody']))
    
    # Constroi o PDF
    doc.build(story)
    print(f"✅ PDF gerado: {pdf_file}")

if __name__ == '__main__':
    import sys
    
    files = [
        ('CURRICULO-ACIB-COMPLETO.md', 'CURRICULO-ACIB.pdf', 'Currículo - Acib ABBADE'),
        ('PITCH-ACIB.md', 'PITCH-ACIB.pdf', 'Pitch Profissional - Acib ABBADE'),
        ('GITHUB-PROFILE.md', 'GITHUB-PROFILE.pdf', 'Perfil GitHub - Acib ABBADE'),
    ]
    
    for md_file, pdf_file, title in files:
        try:
            generate_pdf(md_file, pdf_file, title)
        except Exception as e:
            print(f"❌ Erro ao gerar {pdf_file}: {e}")
