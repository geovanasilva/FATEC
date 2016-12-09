<%@ include file="WEB-INF/header.jspf" %>
<%@page import="java.text.DecimalFormat"%>
<div class="row">
    <div class="col-md-6">
        <h3> Sistema de amortização constante </h3>  
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
        String p = request.getParameter("mes");//parcelas
        String t = request.getParameter("saldo");
        String v = request.getParameter("valor");
        
        DecimalFormat df = new DecimalFormat("R$,##0.00;"); 

        int parcelas = (p != null) ? Integer.parseInt(p) : 1;//parcelas
        double total = (t != null) ? Float.parseFloat(t) : 0;
        double taxa = (v != null) ? Float.parseFloat(v) : 0;
        
        double juros = .0;
        double vl_parcela = .0;        

        double soma_juros = .0;
        double soma_vl_parcela = .0;        
                
        double vl_amortizacao = total / parcelas;
        
    %>

    <div class="col-md-6">
        <h3> Resultado </h3>  
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parcelas</th>
                    <th>Amortização</th>
                    <th>Juros</th>
                    <th>Pagamento</th>
                    <th>Saldo Devedor</th>
                </tr>
            </thead>            

            <%for (int i = 1; i <= parcelas; i++) {%>
            <tr>
                <td><%= i%></td>                     
                <td><%= df.format(vl_amortizacao)%></td>
                <td><% juros = (taxa / 100) * total;%><%=  df.format(juros)%></td>
                <td><% vl_parcela = vl_amortizacao + juros;%><%=  df.format(vl_parcela)%></td>
                <td><% total -= vl_amortizacao;%><%=  df.format(total)%></td>                    
            </tr>
            <% soma_juros += juros; %>
            <% soma_vl_parcela += vl_parcela; %>
            <%}%>

            <tr>
                <td><%= "TOTAL"%></td>
                <td><%= df.format(vl_amortizacao * parcelas)%></td>
                <td><%= df.format(soma_juros) %></td>
                <td><%= df.format(soma_vl_parcela)%></td>

            </tr>
        </table>
    </div>
</div>
<%@ include file="WEB-INF/footer.jspf" %>