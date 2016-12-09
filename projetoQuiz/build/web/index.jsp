<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="com.example.quiz.User"%>
<%@page import="com.example.quiz.Quiz"%>
<%
    boolean valid = true;
    if (session.getAttribute("user") == null) {
        User usr = new User();
    } else {
        valid = false;
        session.setAttribute("user", null);
    }
%>
<!DOCTYPE html>
<html>
    <head>
        <title>Questionário</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <jsp:include page="WEB-INF/header.jsp"></jsp:include>
        <div class="container">
            <div class="card card-container">
            <br>
            <h2 class='login_title text-center'>Entrar</h2>
            <hr>
            <form action="login.jsp" class="form-signin">
                <span id="reauth-username" class="reauth-username"></span>
                <p class="input_title">Nome de usuário</p>
                <input type="text" id="username" name="username" class="form-control login_box" placeholder="Usuário" required autofocus>
                <button class="btn btn-lg btn-primary" type="submit">Entrar</button>
            </form>
        </div>
    </div> 
    <script src="js/jquery-1.11.3.js"></script>
</body>
</html>
