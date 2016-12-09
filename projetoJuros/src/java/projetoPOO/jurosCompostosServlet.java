/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package projetoPOO;

import java.io.IOException;
import java.io.PrintWriter;
import static java.lang.Double.parseDouble;
import static java.lang.Integer.parseInt;
import java.text.DecimalFormat;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import static java.lang.Integer.parseInt;

@WebServlet(name = "jurosCompostosServlet", urlPatterns = {"/jurosCompostosServlet"})
public class jurosCompostosServlet extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response, boolean post)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        
        try (PrintWriter out = response.getWriter()) {
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Servlet jurosCompostosServlet</title>");            
            out.println("</head>");
            out.println("<body>");
             out.println("<title>Início</title>\n" +
"        <meta charset=\"utf-8\">\n" +
"        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n" +
"        <!-- Bootstrap Core CSS -->\n" +
"        <link href=\"css/bootstrap.css\" rel=\"stylesheet\">\n" +
"        <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">\n" +
"        <link rel=\"stylesheet\" href=\"http://www.w3schools.com/lib/w3.css\">\n" +          
"        <!-- Custom CSS -->\n" +
"        <link href=\"css/sidebar.css\" rel=\"stylesheet\">");            
            out.println("</head>");
            out.println("<body>");
            out.println("<div id=\"mySidenav\" class=\"sidenav\">\n" +
"        <a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>\n" +
"            <a style=\"font-size:20px\" href=\"indexServlet\">Sobre a Equipe</a>" +
"            <a style=\"font-size:20px\" href=\"jurosSimplesServlet\">Juros Simples</a>\n" +
"            <a style=\"font-size:20px\" href=\"jurosCompostosServlet\">Juros Compostos</a>\n" +
"        </div>\n" +
"        <div id=\"main\">\n" +
"          <span style=\"font-size:25px;cursor:pointer\" onclick=\"openNav()\">&#9776; Menu</span>\n" +
"          <h2 align=\"center\">Calculadora de Juros Composto</h2><br>\n" +
"          <form class=\"form-horizontal\" method=\"POST\" action=\"jurosCompostosServlet\">\n" +
"            <div class=\"form-group\">\n" +
"              <label class=\"control-label col-sm-2\" for=\"Capital\">Capital:</label>\n" +
"              <div class=\"col-sm-8\">\n" +
"                <input type=\"text\"  name=\"Capital\" class=\"form-control\" id=\"Capital\" placeholder=\"Digite o valor do capital\">\n" +
"              </div>\n" +
"            </div>\n" +
"            <div class=\"form-group\">\n" +
"              <label class=\"control-label col-sm-2\" for=\"Taxa\">Taxa:</label>\n" +
"              <div class=\"col-sm-8\"> \n" +
"                <input type=\"text\"  name=\"Taxa\" class=\"form-control\" id=\"Taxa\" placeholder=\"Digite o valor da taxa aplicada\">\n" +
"              </div>\n" +
"            </div>\n" +
"            <div class=\"form-group\">\n" +
"              <label class=\"control-label col-sm-2\" for=\"Periodo\">Período:</label>\n" +
"              <div class=\"col-sm-8\"> \n" +
"                <input type=\"text\" name=\"Periodo\" class=\"form-control\" id=\"Periodo\" placeholder=\"Entre com o período estimado\">\n" +
"              </div>\n" +
"            </div>  \n" +
"            <div class=\"form-group\"> \n" +
"              <div class=\"col-sm-offset-2 col-sm-10\">\n" +
"              <button type=\"submit\" class=\"btn btn-info btn-lg\" data-toggle=\"modal\" data-target=\"#myModal\">Enviar</button>\n" +
"\n" +
"              </div>\n" +
"            </div>\n" +
"          </form>\n");
           if (post) {
                try
                {
                    double PV = parseDouble(request.getParameter("Capital"));
                    double CV = PV;
                    double i = parseDouble(request.getParameter("Taxa"));
                    int ct = 1;
                    i=i/100;
                    int n = parseInt(request.getParameter("Periodo"));

                    out.print("<div class=\"container\">\n" +
                    "  <table align=\"center\" class=\"w3-table w3-centered\">\n" +
                    "    <thead>\n" +
                    "      <tr>\n" +
                    "        <th>Mês</th>\n" +
                    "        <th>Juros</th>\n" +
                    "        <th>Montante</th>\n" +
                    "      </tr>\n" +
                    "    </thead>\n");

                        for(int j = 0; j < n; j++)
                        {
                            double FV = PV * Math.pow((1+i),ct);

                        DecimalFormat df = new DecimalFormat("R$,##0.00;($,##0.00");
                        String dx = df.format(FV);

                        out.print("<tbody>\n" +
                        "      <tr>\n" +
                        "        <td>"+(ct++)+"</td>\n" +
                        "        <td>"+(FV - CV)+"</td>\n" +
                        "        <td>"+dx+"</td>\n" +
                        "      </tr>\n");
                        CV = FV;
                    }
                    out.println("</tbody>\n" +
                    "  </table>\n" +
                    "  </div>\n" +
                    "</div>");
                }
                catch(NumberFormatException e)
                {
                    out.println("<h4 align=\"center\">Você digitou uma letra, tente novamente.</h4");
                }
                }
           
        out.println("</div>");
        out.println("<script type=\"text/javascript\" src=\"./js/boostrap.js\"></script>\n" +
"        <script type=\"text/javascript\" src=\"./js/boostrap.min.js\"></script>\n" +
"        <script type=\"text/javascript\" src=\"./js/jquery-1.10.2.js\"></script>\n" +
"        <script type=\"text/javascript\" src=\"./js/sidebar.js\"></script>");
                
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
        processRequest(request, response, false);
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
        processRequest(request, response, true);
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
