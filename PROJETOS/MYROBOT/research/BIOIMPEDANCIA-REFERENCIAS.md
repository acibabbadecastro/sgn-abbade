# 🔬 BIOIMPEDÂNCIA - REFERÊNCIAS TÉCNICAS

**Projeto:** MYROBOT  
**Data:** 28/04/2026  
**Categoria:** Pesquisa Técnica  

---

## 📚 O QUE É BIOIMPEDÂNCIA?

A **bioimpedância elétrica (BIA)** é uma técnica não-invasiva que mede a oposição do corpo humano à passagem de uma corrente elétrica de baixa intensidade.

### Princípio Básico:
- Tecidos com água (músculos, órgãos) = **Conduzem bem** (baixa impedância)
- Tecidos sem água (gordura, ossos) = **Conduzem mal** (alta impedância)

---

## 🎯 APLICAÇÕES COMUNS

| Área | Uso |
|------|-----|
| **Nutrição** | Análise de composição corporal |
| **Medicina** | Monitoramento de hidratação |
| **Fitness** | Medição de massa muscular/gordura |
| **Geriatria** | Avaliação de estado nutricional |
| **Nefrologia** | Controle de líquidos em diálise |

---

## 🔧 COMPONENTES TÍPICOS DE UM DISPOSITIVO

### Hardware:
- Microcontrolador (ESP32, Arduino, STM32)
- Gerador de sinal AC (frequência específica, ex: 50kHz)
- Eletrodos de contato (4 eletrodos: 2 corrente + 2 tensão)
- Amplificador de instrumentação
- Conversor ADC
- Display (LCD/OLED)
- Comunicação (Bluetooth/WiFi)

### Frequências Comuns:
- **5-50 kHz:** Análise de gordura corporal
- **100 kHz:** Análise de massa celular
- **200-500 kHz:** Análise de hidratação

---

## 📊 FÓRMULAS E CÁLCULOS

### Impedância (Z):
```
Z = √(R² + Xc²)
```
Onde:
- R = Resistência
- Xc = Reatância capacitiva

### Percentual de Gordura (fórmula de Deurenberg):
```
%Gordura = (4.95 / Densidade) - 4.50) × 100
```

---

## 🔍 REFERÊNCIAS PARA PESQUISA

### Artigos:
- Bioimpedance Analysis (BIA) - NIH
- Validade da bioimpedância em diferentes populações
- Normas IEC 60601-1 para equipamentos médicos

### Projetos Open Source:
- [Buscar no GitHub: bioimpedance arduino]
- [Buscar no GitHub: body composition scale]

### Normas:
- IEC 60601-1 (Segurança de equipamentos médicos)
- ISO 13485 (Sistemas de gestão da qualidade para dispositivos médicos)

---

## 💡 IDEIAS PARA O PROJETO

1. **Balança Inteligente com Bioimpedância**
   - Mede peso + composição corporal
   - Conecta com app

2. **Dispositivo Portátil**
   - Tipo "fita métrica" inteligente
   - Medição rápida de gordura localizada

3. **Sistema de Monitoramento Contínuo**
   - Wearable (pulseira/relógio)
   - Monitora hidratação ao longo do dia

4. **Analisador Profissional**
   - Equipamento para academias/clínicas
   - Alta precisão, múltiplas frequências

---

*Documento de referência - MYROBOT Project*  
*Atualizado em: 28/04/2026*
