<%@ include file="WEB-INF/header.jspf" %>
<%@ page import="java.text.DecimalFormat" %>
<%@ page import="java.text.DecimalFormatSymbols" %>
<%@ page import="java.util.Locale" %>


<div class="row">
    <div class="col-md-6">
        <h3> Sistema de amortização americano </h3>  
        <form method="POST">
            <div class="form-group">
                <input name="mes" placeholder="Digite a quantidade de meses" class="form-control"/>
            </div>
            <div class="form-group">
                <input name="saldo" placeholder="Valor saldo devedor" class="form-control"/>
            </div>
            <div class="form-group">
                <input name="valor" placeholder="Digite o valor de juros" class="form-control"/>
            </div>

            <input name="submit" class="btn btn-success" type="submit" value="Enviar" />
        </form> 
    </div>  

    <%
        
        Locale BRAZIL = new Locale("pt", "BR");
        DecimalFormatSymbols REAL = new DecimalFormatSymbols(BRAZIL);
        DecimalFormat DINHEIRO_REAL = new DecimalFormat("¤ ###,###,##0.00", REAL); 
        
        
        String m = request.getParameter("mes");
        String s = request.getParameter("saldo");
        String v = request.getParameter("valor");
     %>
        
        
       <%
        int mes = (m != null) ? Integer.parseInt(m) : 0;
        float saldo = (s != null) ? Float.parseFloat(s) : 0;
        float valor = (v != null) ? Float.parseFloat(v) : 0;

       
    %>
    
     <%
          double nv;
          double nv1;
          double nv2;
          nv = saldo;
          nv1=0;
          nv2=0;
%>

<%!
         public String mascaraDinheiro(double valor, DecimalFormat moeda) {
                return moeda.format(valor);
            }
    %>

    <div class="col-md-6">
        <h3> Resultado </h3>  
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parcelas</th>
                    <th>Saldo</th>
                    <th>Amortização</th> 
                    <th>Juros</th>
                    <th>Prestação</th>
                </tr>
            </thead>
            <tbody>
                <% for(int i=0; i < mes; i++){
              nv = saldo*(valor/100);
              nv1=nv1+nv;
              nv2=nv;                          %> 
                   
            <tr><td><%= (i) %></td>   
            
            <td><%=  mascaraDinheiro(saldo,DINHEIRO_REAL) %></td>
            <td><center>--</center></td>
            
            <a href="../../../../Desktop/amortizacao-americana.jsp"></a>
           <% if(i >= 1){ %>   
           <td><%= mascaraDinheiro(nv,DINHEIRO_REAL) %></td> 
          
            <td><%= mascaraDinheiro(nv2,DINHEIRO_REAL) %></td> 
            <%} else{%>
           <td><center>--</center></td>       
        <td><center>--</center></td>
           <%}%>
           
                       
           <% if(i+1 == mes){ %>  
             <Tr><td><%= (i+1) %> </td>
            <td> <center>--</center> </td>  
             <td><center><%=mascaraDinheiro(saldo,DINHEIRO_REAL)%></center></td>
            <td><%= mascaraDinheiro(nv,DINHEIRO_REAL) %></td> 
            <td><%= mascaraDinheiro(saldo+nv,DINHEIRO_REAL)%></td></tr>
             <Tr><td>Total </td>
            <td> <center>--</center> </td>
             <td><center>--</center></td>
            <td><%= mascaraDinheiro(nv1,DINHEIRO_REAL) %></td> 
            <td><%= mascaraDinheiro(saldo+nv1,DINHEIRO_REAL)%></td></tr>
           <%}%>
         
              
        <%}%>  
        
            </tbody>
        </table>
    </div>
</div>
<%@ include file="WEB-INF/footer.jspf" %>