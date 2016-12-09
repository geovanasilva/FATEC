package projetoPOO;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class indexServlet extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) {
            /* TODO output your page here. You may use following sample code. */
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Início</title>\n" +
"        <meta charset=\"utf-8\">\n" +
"        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n" +
"        <!-- Bootstrap Core CSS -->\n" +
"        <link href=\"css/bootstrap.css\" rel=\"stylesheet\">\n" +
"        <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">\n" +
"        <!-- Custom CSS -->\n" +
"        <link href=\"css/sidebar.css\" rel=\"stylesheet\">");            
            out.println("</head>");
            out.println("<body>");
            out.println("<div id=\"mySidenav\" class=\"sidenav\">\n" +
"        <a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>\n" +
"            <a style=\"font-size:20px\" href=\"indexServlet\">Sobre a Equipe</a>" +
"            <a style=\"font-size:20px\" href=\"jurosSimplesServlet\">Juros Simples</a>\n" +
"            <a style=\"font-size:20px\" href=\"jurosCompostosServlet\">Juros Composto</a>\n" +
"        </div>\n" +
"        <div id=\"main\">\n" +
"          <span style=\"font-size:25px;cursor:pointer\" onclick=\"openNav()\">&#9776; Menu</span>\n" +
"          <h1 align=\"center\">A equipe</h1><br>\n" +
"                <div align=\"center\" class=\"row\">\n" +
"                    <div class=\"col-md-4\">\n" +
"                        <img class=\"img-circle img-responsive img-center\" src=\"images/geovana.png\">\n" +
"                        <h2>Geovana Silva</h2>\n" +
"                        <p>Apaixonada por tecnologia, hoje me encontro cursando Análise e Desenvolvimento de Sistemas pela Fatec de Praia Grande e tenho o objetivo de trabalhar com desenvolvimento web (front-end para ser exata), mas o céu é o limite. :D</p>\n" +
"                    </div>\n" +
"                    <div class=\"col-md-4\">\n" +
"                        <img class=\"img-circle img-responsive img-center\" src=\"images/jorge.png\">\n" +
"                        <h2>Jorge Helio</h2>\n" +
"                        <p>Cursando Análise e Desenvolvimento de Sistemas na faculdade de Tecnologia de Praia Grande, tem como objetivo trabalhar com desenvolvimento mobile no futuro.</p>\n" +
"                    </div>\n" +
"                    <div class=\"col-md-4\">\n" +
"                        <img class=\"img-circle img-responsive img-center\" src=\"images/welton.png\">\n" +
"                        <h2>Welton Miguel</h2>\n" +
"                        <p>Formado em Tecnólogo em Comércio Exterior, tenho trabalhado desde meus 19 anos na área portuária de Santos como assistente de operações. Atualmente estou cursando Análise e Desenvolvimento de Sistemas pela Fatec de Praia Grande e futuramente pretendo trabalhar como Desenvolvedor Java.</p>\n" +
"                    </div>\n" +
"                </div>\n" +
"        </div>");
            out.println("<script type=\"text/javascript\" src=\"js/boostrap.js\"></script>\n" +
"        <script type=\"text/javascript\" src=\"js/boostrap.min.js\"></script>\n" +
"        <script type=\"text/javascript\" src=\"js/jquery-1.10.2.js\"></script>\n" +
"        <script type=\"text/javascript\" src=\"js/sidebar.js\"></script>");
            out.println("</body>");
            out.println("</html>");
        }
    }
    
    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>
    
}
