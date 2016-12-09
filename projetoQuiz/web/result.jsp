<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="com.example.quiz.Quiz"%>
<%
    if(request.getParameter("user-test") != null){
        String answers[] = {
            request.getParameter("0")
            ,request.getParameter("1")
            ,request.getParameter("2")
            ,request.getParameter("3")
            ,request.getParameter("4")
            ,request.getParameter("5")
            ,request.getParameter("6")
            ,request.getParameter("7")
            ,request.getParameter("8")
            ,request.getParameter("9")
        };
        Quiz.validateTest(answers);
    }
%>
<!DOCTYPE html>
<head>
<title>Questionário</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
</head>

<body>
    <jsp:include page="WEB-INF/header.jsp"></jsp:include>        
        
    <div id="section">
        <h2>Teste concluído:</h2><br>
    <ul>
       <h3>Sua pontuação</h3>
        <%= Quiz.getLastGrade()+ "%" %>
    </ul>  
    </div>
    <script src="js/jquery-1.11.3.js"></script>
</body>
</html>