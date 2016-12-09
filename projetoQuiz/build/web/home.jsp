<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="com.example.quiz.User"%>
<%
    String usr = "";
    if (session.getAttribute("user") == null) {
        response.sendRedirect("index.jsp");
    } else {
        usr = session.getAttribute("user").toString();
    }
%>
<!DOCTYPE html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Questionário</title> 
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <jsp:include page="WEB-INF/header.jsp"></jsp:include>       
        <div class="container">
            <h1>Olá <%= usr%></h1>
            <br>
            <h2>Instruções</h2>
            <ul>
                <br>
                <li>Total de Perguntas: 10.</li>
                <li>Tempo previsto: 5 Minutos.</li>
                <li>Questões baseadas em segmentos da área de TI.</li>
                <li>Clique em <b>Iniciar</b> para iniciar o teste.</li>
                <li>Depois do teste começar, não pressione voltar ou o botão de atualizar e nem feche a janela do navegador.</li>
                </ul>  
            <br/>
            <button class="btn btn-lg btn-primary" id="start" onClick="parent.location='test.jsp'">Iniciar</button>    
        </div>
        <script src="js/jquery-1.11.3.js"></script>
    </body>
</html>