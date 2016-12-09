<%@page import="java.text.DecimalFormat"%>
<%@ include file="WEB-INF/header.jspf" %>
<div class="row">
    <div class="col-md-6">
        <h3> Sistema de amortização Price </h3>  
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
        String m = request.getParameter("mes");
        String s = request.getParameter("saldo");
        String v = request.getParameter("valor");
             
        double n = (m != null) ? Integer.parseInt(m) : 0;
        double pv = (s != null) ? Float.parseFloat(s) : 0;
        double i = (v != null) ? Float.parseFloat(v) : 0;
        double p,i2,res1;
          DecimalFormat df = new DecimalFormat("R$,##0.00;");  
        p =0;
        i= (i/100);
        i2 = i;
        i = i +1;
        res1= Math.pow(i,n);
        
        //PRESTAÇÃO         
        p = pv *((res1*i2) /(res1- 1));
        //Juros
        double juros = 0.0;
        double amort = 0.0;
        double totalJuros, totalAmort, totalP;
        totalJuros = 0.0;
        totalAmort =0.0;
        totalP = 0.0;    
    %>
    
    <div class="col-md-6">
        <h3> Resultado </h3>  
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Prestacao</th>
                    <th>Juros</th>
                    <th>Amortizacao</th>
                    <th>Saldo devedor</th>
                </tr>
            </thead>
            <tbody>
            <%for(int x =0;x<=n;x++){ %>
                <tr>
                    <td> <%= x %></td>
                    
                    <% if(x == 0) { %>
                        <td>-</td>
                    <% } else { %>
                        <td><%=df.format(p) %></td>
                      
                    <% } %>
                    
                    <% if(x == 0) { %>
                        <td>-</td>
                    <% } else { %>
                        <td><%= df.format((juros = pv*i2)) %></td>
                      
                    <% } %>
 
                    <% if(x == 0) { %>
                        <td>-</td>
                    <% } else { %>
                        <td><%= df.format((amort = p - juros)) %></td>
                        
                    <% } %>

                    <% if(x == 0){ %>
                        <td><%= pv %></td>
                    <%} else { %>
                        <% if (x == 12){ %>
                            <td> <%=(pv = 0.0) %> </td>
                        <%  } else { %>
                            <td> <%=df.format((pv = pv - amort)) %></td>
                        <% } %>
                    <% } %>
                </tr>
                <% totalP =  totalP + p; %>
                <% totalJuros = totalJuros + juros; %>
                <% totalAmort = totalAmort + amort;%>
  
  <% } %> 
            <tr>
            <td>Total</td>
            <td><%= df.format(totalP) %></td>
            <td><%= df.format(totalJuros) %></td>
            <td><%= df.format(totalAmort) %></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<%@ include file="WEB-INF/footer.jspf" %>