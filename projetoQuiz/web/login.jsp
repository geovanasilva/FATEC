<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="com.example.quiz.User"%>
<%
    String user = request.getParameter("username");
    if (user != null) {
        User usuario = new User(user);
        session.setAttribute("user", usuario.getCurrentUser());
        response.sendRedirect("home.jsp");
    }
%>
