Roteiro
Aula Prática

SISTEMAS DISTRIBUÍDOS

ROTEIRO DE AULA PRÁTICA
NOME DA DISCIPLINA: SISTEMAS DISTRIBUIDOS

Unidade: U1 _ FUNDAMENTOS DE SISTEMAS DISTRIBUÍDOS
Aula: A4_ CONCEITOS DE SISTEMAS DISTRIBUÍDOS
Tempo previsto de execução de aula prática: 2h

OBJETIVOS
Definição dos objetivos da aula prática:
Nesta atividade prática, você aplicará a sincronização relógios através de servidor NTP em
sistema operacional Linux e Windows.

INFRAESTRUTURA
Instalações – Materiais de consumo – Equipamentos:
Equipamentos:
•

Desktop ou Notebook

•

Internet

SOLUÇÃO DIGITAL
Infraestrutura mínima necessária para execução.
Sistema operacional GNU/Linux Ubuntu Desktop 18.04.1(ou outra distro que o aluno utilize) e
Sistema operacional Windows 10.

PROCEDIMENTOS PRÁTICOS
Alguns serviços, como por exemplo, de acesso remoto e de autenticação de usuários podem não
funcionar adequadamente caso haja uma diferença muito grande no horário da máquina cliente
(solicitante) em relação à máquina servidora (que roda e disponibiliza o serviço). Por esse motivo,
é muito importante saber como habilitar a sincronização horária das máquinas utilizando o NTP.
A configuração, bem como suas etapas, varia entre os sistemas operacionais e entre suas versões.
Para realizar essa configuração em um sistema operacional GNU/Linux Ubuntu Desktop 18.04.1
(Bionic Beaver), siga o procedimento abaixo:

2

Alguns serviços, como por exemplo, de acesso remoto e de autenticação de usuários podem não
funcionar adequadamente caso haja uma diferença muito grande no horário da máquina cliente
(solicitante) em relação à máquina servidora (que roda e disponibiliza o serviço). Por esse motivo,
é muito importante saber como habilitar a sincronização horária das máquinas utilizando o NTP.
A configuração, bem como suas etapas, varia entre os sistemas operacionais e entre suas versões.
Para realizar essa configuração em um sistema operacional GNU/Linux Ubuntu Desktop 18.04.1
(Bionic Beaver), siga o procedimento abaixo:
Passo 1
Abra o Terminal, pressionando as teclas “CTRL + T” do teclado.
Passo 2
Instale o serviço “ntp”, através do gerenciador de pacotes “apt”, com o comando 1
Comando 1 :
usuario@ubuntu:~$ sudo apt install ntp
Passo 3
Anote e faça um print de tela das instalações.
Uma vez instalado o serviço, precisamos editar o arquivo de configuração do mesmo.
Comando 2 :
usuario@ubuntu:~$ sudo nano /etc/ntp.conf
Faça um print de tela do que aparece.
Passo 4
Na tela que aparecerá:
# Specify one or more NTC servers.
pool 0.ubuntu.pool.ntp.org iburst
pool 1.ubuntu.pool.ntp.org iburst
pool 2.ubuntu.pool.ntp.org iburst
pool 3.ubuntu.pool.ntp.org iburst...
Devemos remover essas informações,o que está abaixo da frase # Specify one or more
NTC servers
pressionando a tecla “DELETE” do teclado, até apagar tudo.
(Tudo que começar com pool 1,2,3,.....)
Ou seja, temos que excluir essas informações do arquivo ntp.conf
Passo 5
Agora devemos incluir, onde excluímos os dados no passo anterior, na linha abaixo do: #
Specify one or more NTC servers.
O comando: pool pool.ntp.br
Com esse comando, ajustamos os horários.
Passo 6

3

Salve essas alterações digitando “CTRL + X” no teclado, depois “S”, e por fim, “ENTER”.
Passo 7
Reinicie o serviço ntp para ele utilizar essa nova configuração, com o servidor do NTP.br,
com o comando 3
usuario@ubuntu:~$ sudo service ntp restart
Passo 8
Feito isso, o serviço estará configurado adequadamente e já estará funcionando, consultando um conjunto de servidores NTP através da Internet.
Adicionalmente, para fazer uma consulta manual e pontual, você poderá digitar o seguinte comando no Terminal: ntpq -p.

Windows 10
Para realizar essa configuração em um sistema operacional Windows 10, siga o procedimento
abaixo:
1. Abra o Prompt de Comando (CMD), pressionando as teclas “CTRL + R” do teclado, digitando
“cmd” e OK.
2. Na janela do CMD vamos inserir o código a seguir e pressionar a tecla “Enter”:
w32tm /config /syncfromflags:manual /manualpeerlist:0.pool.ntp.org
3 . Observamos que ao final do comando aparece a mensagem “O comando foi concluído com
sucesso”. Lembre-se, para executar os comandos você deve estar em um usuário Administrador
ou executar o CMD como Administrador.
Agora que fizemos o apontamento para o servidor NTP.org, que vamos utilizar, devemos reiniciar
o serviço de data e hora, para aplicar as alterações
3. Vamos utilizar o comando “net stop w32time” e “net start w32time” para parar o serviço e iniciar,
reiniciando-o.
Após isso vamos forçar uma sincronização de data e hora para verificar se está tudo funcionando
corretamente.
4. Podemos forçar uma sincronização através do comando “w32tm /resync /rediscover”
Através da saída podemos observar que nossa configuração foi feita com sucesso.

Oriento-os a fazer prints de tela a capa passo executado.

Checklist:
1. Fazer a aula prática com o Sistema Operacional Linux e Windows.
2. Imprimir os prints de tela para acompanhar o que está acontecendo.
3. Fazer um relatório do que foi desenvolvido.

4

RESULTADOS
Resultados de Aprendizagem:
O QUE SE ESPERA QUE O ALUNO TENHA APRENDIDO AO FINAL DA AULA PRÁTICA
Fazer a sincronização relógios através de servidor NTP em sistema operacional Linux e Windows.

ESTUDANTE, VOCÊ DEVERÁ ENTREGAR
Descrição orientativa sobre a entregada da comprovação da aula prática:
Para essa tarefa os itens a serem entregues são:
1) Executar sincronização relógios através de servidor NTP em sistema operacional Linux e
Windows.
2) Imprimir os prints de tela para acompanhar o que está acontecendo.
3) Fazer um relatório do que foi desenvolvido.

REFERÊNCIAS BIBLIOGRÁFICAS
Descrição (em abnt) das referências utilizadas
NTP.br. [S.l.:s.n.], [s.d.]. Disponível em: https://ntp.br/ Acesso em: 27 jun. 2024.

Unidade: U3 _ VIRTUALIZAÇÃO E CONTEINERIZAÇÃO
Aula: A1_ VIRTUALIZAÇÃO

Tempo previsto de execução de aula prática: 2h

OBJETIVOS
Definição dos objetivos da aula prática:
Nesta atividade prática, você fará a criação de máquina virtual com sistema operacional
GNU/Linux.

INFRAESTRUTURA
Instalações – Materiais de consumo – Equipamentos:
Equipamentos:
•

Desktop ou Notebook

•

Internet

SOLUÇÃO DIGITAL
Infraestrutura mínima necessária para execução.

5

Sistema operacional CentOS (ou outra distro que o aluno utilize) e o Oracle VM VirtualBox.
Sistema operacional CentOS que será utilizado como exemplo de sistema operacional da
máquina virtual ou qualquer outra distro, inclusive trarei dicas para o Debian. O Oracle VM
VirtualBox é o software onde vamos criar a máquina virtual.

PROCEDIMENTOS PRÁTICOS
Atividade proposta:
Criação de máquina virtual com sistema operacional GNU/Linux, que como exemplo trarei o CentOS através do software Oracle VM VirtualBox.

Procedimentos para a realização da atividade:
A primeira coisa que devemos fazer é realizar o download do sistema operacional GNU/LinuxCentOS, esse download pode ser feito no site do CentOS ou poderá utilizar oDisponível em:
https://www.centos.org/download/ ou https://www.debian.org/index.pt.html Acesso em 27
jun. 2024.
Se você utilizar o Debian, vá na página inicial em outros downloads:

Depois em outras versões

6

E escolha e estável(é mais antiga porem mais segura).

Se tiver alguma dúvida, assista o vídeo: https://youtu.be/JPqyuKPXR74?si=b-D8oZiZEgWp_h6_
Acesso em 27 de jun 2024.
Agora no VirtualBox devemos ir até a opção “Novo”, conforme a Figura

7

Fonte: Elaborada pelo Autor.

Agora devemos definir um nome para nossa máquina virtual, qual tipo de sistema operacional e
versão, conforme mostra a Figura:
Criando uma máquina virtual

Fonte: Elaborada pelo Autor.

Agora devemos definir a quantidade de memória RAM, que será utilizada pela nossa máquina
virtual, conforme mostra a Figura:

8

Figura : Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.

Agora devemos selecionar a criação de um novo disco virtual para ser utilizado em nossa máquina virtual, caso existam discos virtuais prontos, também podemos utilizá-los. Na Figura criamos um novo:
Figura | Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.

Na Figura definimos o tamanho do HD da nossa máquina virtual:

9

Figura - Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.

Agora que nossas configurações estão definidas, nossa máquina virtual já aparece na lista de
máquinas, vamos até a opção “Configurações” representada pelo ícone de uma engrenagem para
apontar o caminho de nossa imagem (iso) que contém o sistema operacional. Podemos observar
na Figura 6 que a opção “Configurações” está habilitada:
Figura 3.36 | Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.

10

Vemos como apontamos o caminho da imagem de instalação do sistema operacional, para isso
ocorrer devemos criar um leitor de CD virtual e indicar a imagem como se fosse um CD-ROM.
Acessamos o menu “Armazenamento”, depois “Vazio”, depois o ícone de um novo CD para localizar nossa imagem.
Figura | Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.
Após a seleção, o local onde estava escrito “Vazio” passa ter o nome da imagem do CentOS,
conforme mostra a Figura:
Figura | Criando uma máquina virtual.

11

Fonte: Elaborada pelo Autor.
Após o apontamento do caminho da imagem, devemos pressionar o botão “OK”, e depois o botão
“Iniciar”, representado pelo ícone de uma seta na cor verde. Feito isso será aberto uma nova
janela de execução da máquina virtual, que pode ser observada na Figura:
Figura | Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.
Agora devemos pressionar a tecla “Enter” do teclado, para iniciar nossa máquina via CD. Feito
isso teremos a opção de instalar nossa máquina, ela deve ser selecionada e seguir as etapas de
instalação até a sua conclusão.

12

Figura | Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.
Agora devemos seguir com a instalação do sistema operacional e podemos ver a execução da
máquina virtual.

Figura | Criando uma máquina virtual.

Fonte: Elaborada pelo Autor.
Na Figura, podemos observar como a máquina virtual, funciona dentro de uma janela em nossa
máquina Hospedeira. Outros tipos de sistemas operacionais e versões podem ser instala-

das seguindo este modelo de criação de máquinas virtuais.

Checklist:

13

•Criação da Máquina Virtual no Oracle VM Virtual Box, definindo seu nome, tipo e sistema operacional;
•Definir o tamanho da memória RAM virtual;
•Definir o tamanho do armazenamento (HD) virtual;
•Criar um CD virtual com o armazenamento da imagem (iso) do sistema operacional;
•Iniciar a Máquina Virtual;
•Pressionar uma tecla dentro da máquina virtual para ativar o boot via disco;
•Seguir o passo-a-passo de instalação do sistema operacional até sua conclusão

RESULTADOS
Resultados de Aprendizagem:
O QUE SE ESPERA QUE O ALUNO TENHA APRENDIDO AO FINAL DA AULA PRÁTICA
Habilidades na instalação de uma máquina virtual.

ESTUDANTE, VOCÊ DEVERÁ ENTREGAR
Descrição orientativa sobre a entregada da comprovação da aula prática:
Para essa tarefa os itens a serem entregues são:
4) Relatório de como instalar a sua máquina virtual.

REFERÊNCIAS BIBLIOGRÁFICAS
Descrição (em abnt) das referências utilizadas
DEBIAN. Website completo. [S.l.:s.n.], [s.d.]. Disponível em: https://www.debian.org/
Acesso em: 27 jun. 2024.
ORACLE.

Oracle

VM

VirtualBox®:

User

Manual.

2018.

Disponível

em:

https://www.virtualbox.org/manual/UserManual.html . Acesso em: 27 jun. 2024.
REDHAT. O que é virtualização? 2018. Disponível em: https://www.redhat.com/ptbr/topics/virtualization/what-is-virtualization . Acesso em: 5 mar 19

Unidade: U3 _ VIRTUALIZAÇÃO E CONTEINERIZAÇÃO
Aula: A4_ CONTEINERIZAÇÃO COM DOCKER
Tempo previsto de execução de aula prática: 2h

OBJETIVOS
Definição dos objetivos da aula prática:
Nesta atividade prática, você compreenderá como orquestrar o servidor web Apache em um
cluster simples através do Docker.

14

INFRAESTRUTURA
Instalações – Materiais de consumo – Equipamentos:
Equipamentos:
•

Desktop ou Notebook

•

Internet

SOLUÇÃO DIGITAL
Infraestrutura mínima necessária para execução.
Sistema operacional de onde vamos acessar via navegador a plataforma “Play With Docker”.

PROCEDIMENTOS PRÁTICOS
1) Inicie entrando em: https://docker.com/products/docker-desktop/

2) Ao acessar o Iniciar, você entrará em uma tela de acesso:

15

3) Depois de inscrever-se você irá para a tela Play with Docker https://labs.play-withdocker.com/ e clique em Start(iniciar)

4) Você estará em um ambiente de laboratório

16

No ambiente, começamos:

(I)

crie um cluster com cinco réplicas do servidor web Apache utilizando o Docker Swarm;

(II)

verifique em quais nós do cluster esse serviço está rodando e

(III)

acesse a página de boas-vindas desse servidor Apache através do(s) endereço(s)
IPv4 de cada nó onde esse serviço web estiver rodando.

Uma vez que você obteve acesso à plataforma, você deverá:
1. Como não foi especificada a quantidade de nós do cluster, vamos criar o mesmo com 3 nós,
que serão suficientes para analisarmos nosso cluster sem comprometer a usabilidade da plataforma de testes do Docker. Sendo assim, você deve adicionar 3 nós, que farão parte do cluster,
através do botão “Add new instance”.
2. No nó que você deseja que seja o mestre, digite o seguinte comando:
docker swarm init --advertise-addr <endereço IP desse nó>
Este comando define esse nó como manager do cluster. Repare que, ao executar esse comando,
é apresentada uma saída, com a mensagem: “Para adicionar um worker ao swarm, execute o
seguinte comando”, conforme pode ser visto na Figura 1. Sendo assim, você deve copiar a saída
que foi apresentada a você (que vai ser diferente da minha, destacada em amarelo na Figura 1),
pois esse comando deverá ser executado em cada um dos demais nós do cluster, adicionando
estes como workers desse cluster.
Figura 1 | Saída do comando docker swarm init.

Fonte: elaborado pelo autor.
3. Agora que os nós estão criados e seus papéis definidos, para criar o serviço que estará rodando
(de maneira distribuída, replicada) do servidor web Apache, digite o seguinte comando no nó
mestre:
docker service create --name WEB --publish 80:80 --replicas=5 httpd
Este comando cria 5 instâncias de um servidor web Apache, que responderá na porta mapeada
(80, nesse caso) e, para facilitar a monitoração do mesmo, demos um nome “amigável” a este
serviço: “WEB”.
4. Para saber em quais nós as 5 réplicas desse serviço estão sendo executadas, digite o seguinte
comando:
docker service ps WEB

17

5. Por fim, precisamos acessar a página de boas-vindas desse servidor Apache através do(s)
endereço(s) IPv4 de cada nó onde esse serviço web estiver rodando. Você reparou que, ao criar
o serviço, a porta que você mapeou aparece na parte superior, como um hyperlink?
Veja a porta 80, destacada em vermelho. Bem, para acessar a página de boas-vindas, basta
clicar nessa porta, em cada um dos nós onde esse serviço está rodando (no meu caso, nós 1 e
2 do cluster), para vermos a famosa mensagem “It works!” do Apache.

Checklist:
•

Criar os 5 nós.

•

Definir o nó mestre.

•

Criar o serviço Apache para rodar de maneira distribuída.

•

Verificar em que nós as réplicas do serviço estão sendo executadas.

•

Acessar a página de boas-vindas do servidor Apache.

RESULTADOS
Resultados de Aprendizagem:
O QUE SE ESPERA QUE O ALUNO TENHA APRENDIDO AO FINAL DA AULA PRÁTICA
Compreensão do que é uma conteneirização trabalhando com o Docker.

ESTUDANTE, VOCÊ DEVERÁ ENTREGAR
Descrição orientativa sobre a entregada da comprovação da aula prática:
Para essa tarefa os itens a serem entregues são:
5) Entrar no play with Docker, mostrando suas telas e o caminho que você efetuou;
6) Executar todos os passos, fazendo um relatório com saídas.

REFERÊNCIAS BIBLIOGRÁFICAS
Descrição (em abnt) das referências utilizadas
DOCKER.

Website

completo.

[S.l.:s.n.],

https://docker.com/products/docker-desktop/

[s.d.].

Disponível

em:

Acesso em: 27 jun. 2024.

Unidade: U4 _ APLICAÇÕES DE SISTEMAS DISTRIBUÍDOS E SEGURANÇA
Aula: A1_ SEGURANÇA EM SISTEMAS DISTRIBUÍDOS
Tempo previsto de execução de aula prática: 2h

OBJETIVOS
Definição dos objetivos da aula prática:
Compreender como um analisador de protocolos funciona. Trabalharemos com o Wireshark.

18

INFRAESTRUTURA
Instalações – Materiais de consumo – Equipamentos:
Equipamentos:
•

Desktop ou Notebook

•

Internet

SOLUÇÃO DIGITAL
Infraestrutura mínima necessária para execução.
Fazer download do Wireshark no site https://www.wireshark.org/#download

PROCEDIMENTOS PRÁTICOS
Atividade proposta:
Compreender um analisador de pacotes funciona.
O Wireshark é um analisador de pacotes de rede gratuito e de código aberto. Permite
capturar e interagir com os dados trafegados em uma rede em tempo real. É utilizado para
análise de rede, solução de problemas, desenvolvimento de software e protocolos, e aprendizado.

Procedimentos para a realização da atividade:
1) A primeira coisa que devemos fazer é realizar o download do Wireshark Disponível em
https://www.wireshark.org Acesso em 27 jun. 2024.
Faça o download.

2) Compreendendo a página inicial

19

1. Abra o Wireshark.
2. No menu principal, selecione Capture e, em seguida, Options. Será apresentada uma
caixa listando as interfaces de rede. Selecione a interface e clique em Start. Eu escolhi
Wi-Fi.
3. Construtor de Filtros
A caixa de diálogo de construção de filtros é um recurso que torna mais fácil a utilização do
Wireshark pelos usuários para capturar e criar filtros de exibição. Para acessar esta caixa de
diálogo, clique no menu Analyze e na opção Display Filter Expression.

Checklist:
•

Instalar Wireshark;

•

Explorar o wireshark.

RESULTADOS

20

Resultados de Aprendizagem:
O QUE SE ESPERA QUE O ALUNO TENHA APRENDIDO AO FINAL DA AULA PRÁTICA
Conhecer o inicio do que faz um analisador de protocolos (Wireshark) poderoso e seguro,
absolutamente confiável, que é mantido por especialistas em rede e constantemente atualizado
para novas tecnologias disponibilizadas. As três principais funções do Wireshark são:
Captura de pacotes — ao escutar uma conexão de rede, ele captura os fluxos de tráfego;
Filtragem — todos os dados capturados são fatiados e filtrados para obter apenas as informações
desejadas;
Visualização — você tem acesso a diversas informações e pode visualizar conversas e fluxos de
rede.

ESTUDANTE, VOCÊ DEVERÁ ENTREGAR
Descrição orientativa sobre a entregada da comprovação da aula prática:
Para essa tarefa os itens a serem entregues são:
7) Relatório dos recursos experimentados no Wireshark, com captura de telas.

REFERÊNCIAS BIBLIOGRÁFICAS
Descrição (em abnt) das referências utilizadas
WIRESHARK.

Website

completo.

[S.l.:s.n.],

https://www.wireshark.org Acesso em: 27 jun. 2024.

21

[s.d.].

Disponível

em:

