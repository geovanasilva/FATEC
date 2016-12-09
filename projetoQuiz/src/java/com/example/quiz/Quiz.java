
package com.example.quiz;

import java.util.ArrayList;

public class Quiz {
    private static double lastGrade = 0.0;
    private  static double GradesSum = 0.0;
    private  static int TestsCount = 0;
    
    public  static double getLastGrade(){
        return lastGrade;
    }
    
    public  static double getGradeAverage(){
        return GradesSum /(double)TestsCount;
    }
    
    public  static double validateTest(String [] answers){
        int corrects = 0;
        for (int i = 0; i < test.size(); i++) {
            Question q = test.get(i);
            if(q.getAnswer().equals(answers[i]))
                corrects++;
        }
        double grade = 100.0* (double)corrects / (double)test.size();
        TestsCount++;
        GradesSum+=grade;
        lastGrade=grade;
        return grade;
    }
    
    private static ArrayList<Question> test;
    public static ArrayList<Question> getTest(){
        if(test == null){
            test = new ArrayList<>();
        Question q1 = new Question("1) Um Banco de Dados é um:", "e - conjunto de dados integrados destinados a atender às necessidades de uma comunidade de usuários.", 
        new String[]{"a - conjunto de objetos da realidade sobre os quais se deseja manter informações."
        ,"b - conjunto de operações sobre dados integrados destinados a modelar processos."
        ,"c - software que incorpora as funções de definição, recuperação e alteração de dados."
        ,"d - software que modela funções de definição, recuperação e alteração de dados e programas."
        ,"e - conjunto de dados integrados destinados a atender às necessidades de uma comunidade de usuários."});
         
        Question q2 = new Question("2) A proteção das informações e dos sistemas das organizações requer o uso de recursos de proteção como os firewalls, utilizados para:","a - ajudar a impedir que a rede privada da empresa seja acessada sem autorização a partir da Internet." 
        ,new String[]{"a - ajudar a impedir que a rede privada da empresa seja acessada sem autorização a partir da Internet."
        ,"b - liberar o uso de todos os serviços de rede somente aos usuários registrados pelo administrador da rede."
        ,"c - garantir que cada pacote de dados seja entregue com segurança apenas ao destinatário informado, reduzindo assim o tráfego na rede."
        ,"d - garantir que nenhum colaborador possa comprometer a segurança das informações da organização."
        ,"e - garantir que os computadores da rede não sejam infectados por malwares ou atacados por hackers."});
        
        Question q3 = new Question("3) No sistema Operacional Windows, caso o usuário tenha excluído arquivos e venha a se arrepender,<br>"
        +"estes itens poderão ser restaurados da Lixeira. Na tela, basta clicar na Lixeira e o conteúdo da Lixeira será exibido.<br>"
        +"O usuário deverá selecionar o item a ser restaurado, então clicar no menu Arquivo e depois em Restaurar, e a restauração será feita.<br>"
        +"O arquivo restaurado será devolvido à(ao):", "a - Local de Origem."
        ,new String[]{"a - Local de Origem."
        ,"b - Pasta Restauração."
        ,"c - Barra de Tarefas."
        ,"d - Área de Trabalho."
        ,"e - Pasta Documentos."});  
        
        Question q4 = new Question("4) Sobre a memória RAM é correto afirmar", "b - É a memória principal, nela são armazenadas as informações enquanto estão sendo processadas."
        ,new String[]{"a - É a memória permanente do computador. Onde se instala o software e também onde é armazenado os documentos e outros arquivos."
        ,"b - É a memória principal, nela são armazenadas as informações enquanto estão sendo processadas."
        ,"c - É uma memória não volátil, isto é, os dados gravados não são perdidos quando se desliga o computador."
        ,"d - É a memória secundária ou memória de massa. É usada para gravar grande quantidade de dados."
        ,"e - É uma memória intermediária entre a memória principal e o processador."});        
        
        Question q5 = new Question("5) As funções do núcleo do Linux (escalonamento de processos, gerenciamento de memória, operações de entrada e saída, acesso ao sistema de arquivos)<br>"
        + "são executadas no espaço de núcleo. Uma característica do núcleo Linux é que algumas das funções podem ser compiladas e executadas como módulos,<br>"
        + "que são bibliotecas compiladas separadamente da parte principal do núcleo."
        +"Essas características fazem com que o núcleo do Linux seja classificado como:", "a - Monolítico."
        ,new String[]{"a - Monolítico."
        ,"b - Multifunções."
        ,"c - Distribuído."
        ,"d - Integrado."
        ,"e - Único."});
        
        Question q6 = new Question("6) Um usuário do Google Chrome em português deseja ativar o recurso para ajudar a completar pesquisas e URLs digitados na barra de endereços do navegador.<br>"
        +"Para isso ele deve acessar o botão 'Personalizar e Controlar o Google Chrome' , "
        +"clicar na opção 'Configurações', na opção 'Mostrar configurações avançadas...'<br>"
        +"e clicar no quadrado que habilita esse recurso que se encontra em:", "d - Rede."
        ,new String[]{"a - Conteúdo da web."
        ,"b - Extensões."
        ,"c - Pesquisar."
        ,"d - Rede."
        ,"e - Privacidade."});
        
        Question q7 = new Question("7) O cavalo de Troia (trojan)", "c - pode ser instalado por vírus, phishing ou outros programas, com a finalidade de abrir um backdoor."
        ,new String[]{"a - a impede que o sistema operacional se inicie ou seja executado corretamente."
        ,"b - aumenta o tráfego na Internet e gera um grande volume de dados de caixas postais de correio eletrônico."
        ,"c - pode ser instalado por vírus, phishing ou outros programas, com a finalidade de abrir um backdoor."
        ,"d - também é conhecido como vírus de macro, por utilizar os arquivos do MS Office."
        ,"e - não pode ser combatido por meio de firewall."});      
        
        Question q8 = new Question("8) Um Assistente de Gestão Escolar, por meio do Google Chrome, versão 40, em sua configuração padrão,<br>"
        + "acessa um site aguardando a publicação de um edital que pode ser feita a qualquer momento.<br>"
        +"Ao constatar que o edital ainda não está disponível, o assistente, por meio de atalho do teclado, decide atualizar a página que está sendo exibida no navegador.<br>"
        +"Assinale a alternativa que contém o atalho descrito no enunciado.", "b - F5."
        ,new String[]{"a - Ctrl + F2."
        ,"b - F5."
        ,"c - F4."
        ,"d - F2."
        ,"e - Shift + F2."});
        
        Question q9 = new Question("9) Para prevenir que vírus se instalem nos computadores de seus usuários, o Gmail não permite que sejam enviados ou recebidos arquivos executáveis.<br>"
        +"Como consequência dessa política, dentre os arquivos listados abaixo, o único que poderia ser enviado por e-mail através do Gmail é:", "e - arq_e.txt."
        ,new String[]{"a - arq_a.pif."
        ,"b - arq_b.exe."
        ,"c - arq_c.bat."
        ,"d - arq_d.jar."
        ,"e - arq_e.txt."});
        
        Question q10 = new Question("10) Com relação à manutenção de equipamentos de informática, assinale a opção correta.", "c - Uma maneira eficaz de fazer backup de arquivos do computador é instalar um HD externo, pela porta USB, e realizar a cópia dos arquivos normalmente."
        ,new String[]{"a - Para corrigir o problema do computador que apresenta a hora errada ao ser inicializado, mesmo após ter sido configurado com a hora correta, é suficiente substituir o CNIP."
        ,"b - Ao se instalarem monitores de LCD, é necessária a instalação de um conversor digital para se ter acesso aos padrões abertos da Internet."
        ,"c - Uma maneira eficaz de fazer backup de arquivos do computador é instalar um HD externo, pela porta USB, e realizar a cópia dos arquivos normalmente."
        ,"d - Para ampliar a capacidade de armazenamento de dados do computador, é relevante expandir os pentes de memória RAM."
        ,"e - A tecnologia USB provê conexão mais rápida à Internet em redes wireless."});
        
        test.add(q1);        
        test.add(q2);
        test.add(q3);
        test.add(q4);
        test.add(q5);
        test.add(q6);        
        test.add(q7);
        test.add(q8);
        test.add(q9);
        test.add(q10);
        }
        return test;
    }
}
