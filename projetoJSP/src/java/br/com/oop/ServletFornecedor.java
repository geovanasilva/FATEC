/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.oop;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import json.JSONObject;

/**
 *
 * @author Usuario
 */
public class ServletFornecedor extends HttpServlet {

    Fornecedor fornecedor;

    @Override
    public void init() throws ServletException {
        fornecedor = new Fornecedor();
    }

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        
        if(request.getParameter("_method").equals("select"))
        {
            Fornecedor f = (Fornecedor) Database.select("fornecedor",Integer.parseInt(request.getParameter("id")));
            JSONObject jsonObject = new JSONObject();
            
            jsonObject.put("nome", f.getNome());
            jsonObject.put("nome_social", f.getNome_social());
            jsonObject.put("cnpj", f.getCnpj());
            jsonObject.put("endereco", f.getEndereco());
            jsonObject.put("telefone", f.getTelefone());
            jsonObject.put("email", f.getEmail());
            
            out.print(jsonObject);
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
