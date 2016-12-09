<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="com.example.quiz.Quiz"%>
<%@page import="com.example.quiz.Question"%>
<%@page import="com.example.quiz.Question"%>
<%@page import="java.util.ArrayList"%>
<%@page import="java.util.LinkedHashMap"%>
<!DOCTYPE html>
<head>
<title>Questionário</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
</head>

<body onload="startTimer()">
    <script type="text/javascript">
    var timer=300;
    var min=0;
    var sec=0;
        function startTimer(){
            min=parseInt(timer/60);
            sec=parseInt(timer%60);
            if(timer<1){
            $("#submit").click();
                //document.getElementById('result.jsp').submit();
            }
            document.getElementById("time").innerHTML = "<b>Tempo restante: </b>"+min.toString()+":"+sec.toString();
            timer--;
            setTimeout(function(){startTimer();}, 1000);
        }
        
    </script>

    <jsp:include page="WEB-INF/header.jsp"></jsp:include>
    <div id="section">
        <br>
        <p id="time"></p><br>
        <form action="result.jsp" id="form">
            <%ArrayList<Question> test = Quiz.getTest();%>
            <% for (Question q: Quiz.getTest()){%>
                <h4><%= q.getQuestion() %></h4>
                <% for (String a: q.getAlternatives()){%>
                        <input type="radio" name="<%= test.indexOf(q)%>" value="<%= a %>"/>
                        <%= a%><br>   
                <%}%>
                <hr>
            <%}%>
            <br>
            </div>
            <br>
            <button class="btn btn-lg btn-primary" type="submit" name="user-test" value="Enviar">Enviar</button>
        </form>
    <script src="js/jquery-1.11.3.js"></script>
</body>
</html>