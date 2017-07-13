<%@page import="br.com.oop.Database"%>
<%@page import="br.com.oop.Pessoa"%>
<!DOCTYPE html>
<% 
    if( request.getParameter("_method") != null )
    {
        Pessoa p;
        switch( request.getParameter("_method").toString() )
        {
            case "insert" :
                p = new Pessoa();
                p.setNome(request.getParameter("nm_cliente_salvar"));
                p.setEmail(request.getParameter("email_cliente_salvar"));
                p.setTelefone(request.getParameter("tel_cliente_salvar"));
                p.setEndereco(request.getParameter("endereco"));
                p.setCpf(request.getParameter("cd_cliente_salvar"));
                p.setRg(request.getParameter("cd2_cliente_salvar"));
                Database.getPessoasList().add(p);
                response.sendRedirect(request.getRequestURI());
                break;
            case "update" :
                int id_cliente = Integer.parseInt(request.getParameter("id_editar"));
                p = Database.getPessoasList().get(id_cliente);
                p.setNome(request.getParameter("nm_cliente_editar"));
                p.setEmail(request.getParameter("email_cliente_editar"));
                p.setTelefone(request.getParameter("tel_cliente_editar"));
                p.setEndereco(request.getParameter("endereco_cliente_editar"));
                p.setCpf(request.getParameter("cd_cliente_editar"));
                p.setRg(request.getParameter("cd2_cliente_editar"));
                response.sendRedirect(request.getRequestURI());
                break;
            case "delete" :
                p = Database.getPessoasList().remove(Integer.parseInt(request.getParameter("id_delete")));
                response.sendRedirect(request.getRequestURI());
                break;
            default:
                break;
        }
    }
%>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Projeto POO </title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/simple-sidebar.css">
    </head>

    <body>
        <div class="container-fluid">
            <%@include file="__includes/sidebar.jsp" %>
            <!-- A classe col-md-offset-2 "pula" duas colunas e col-md-10, bem, diz que a div terÃ¡ o tamanho de dez colunas -->
            <div class="main-content col-md-10 col-md-offset-2 col-sm-8">
                <div class="row">    
                    <div class="search-bar">
                        <div class="form-group has-feedback">
                            <i class="glyphicon glyphicon-search form-control-feedback"></i>
                            <input type="search" class="form-control" placeholder="Procure por um cliente, fornecedor etc..." maxlength="20" /> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 style="text-shadow: ">Clientes</h3>
                    </div>

                    <div class="tabela">
                        <% if (!Database.getPessoasList().isEmpty()) {%>
                        <table class="table table-striped conf-tabela">
                            <thead>
                                <tr>
                                    <td class="text-center">Nome </td><% request.getRequestURI(); %>
                                    <td class="text-center">CPF</td>
                                    <td class="text-center">RG</td>
                                    <td class="text-center">Email</td>
                                    <td class="text-center">Telefone</td>
                                    <td class="text-center">Endereco</td>
                                </tr>
                            </thead>
                            <tbody>
                                <% for (Pessoa p : Database.getPessoasList()) {%>
                                <tr data-id="<%= Database.getPessoasList().indexOf(p)%>">
                                    <td class="text-center"><%= p.getNome()%></td>
                                    <td class="text-center"><%= p.getCpf()%></td>
                                    <td class="text-center"><%= p.getRg()%></td>
                                    <td class="text-center"><%= p.getEmail()%></td>
                                    <td class="text-center"><%= p.getTelefone()%></td>
                                    <td class="text-center"><%= p.getEndereco()%></td>                                    
                                    <td class="text-center">
                                        <a role="button" class="exibirConta" data-toggle="modal" data-target="#modalExibicao" ><i class="glyphicon glyphicon-eye-open"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a role="button" class="editarConta" data-toggle="modal" data-target="#modalEdicao" data-name="btn-altera-cliente"><i class="glyphicon glyphicon-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a role="button" class="excluirConta" data-name="btn-exclui-cliente" data-toggle="modal" data-target="#modalDelecao"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
                                </tr>
                                <% } %>
                            </tbody>
                        </table>   
                        <% } else {%>
                        <div class="alert alert-warning text-center" style="">
                            <strong>Nenhum cliente foi cadastrado :/</strong> 
                        </div>
                        <% }%>
                    </div>
                </div>
                <!-- BotÃ£o de inclusÃ£o de cadastro-->
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a role="button" data-toggle="modal" data-target="#novoFornecedor" style="width: 2em; border-radius: 50%; background-color: #51B8B4; margin-top: 4%; font-size: 2em; color: white" class="btn btn-md">+</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de criação -->
        <div id="novoFornecedor" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <h2 class="modal-title">Novo cliente</h2>
                        <h4>Para adicionar um novo cliente, por favor preencha todos os campos abaixo.</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="#">
                                    <input type="hidden" name="_method" value="insert" />
                                    <div class="form-group">
                                        <label for="nm_cliente_salvar"><strong>Nome do cliente</strong></label>
                                        <input type="text" name="nm_cliente_salvar" id="nm_cliente_salvar" class="form-control add" placeholder="Digite o nome do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="cd_cliente_salvar"><strong>CPF do cliente</strong></label>
                                        <input type="text" name="cd_cliente_salvar" id="cd_cliente_salvar" class="form-control add" placeholder="Digite o CPF do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="cd2_cliente_salvar"><strong>RG do cliente</strong></label>
                                        <input type="text" name="cd2_cliente_salvar" id="cd2_cliente_salvar" class="form-control add" placeholder="Digite o RG do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email_cliente_salvar"><strong>Email do cliente</strong></label>
                                        <input type="text" name="email_cliente_salvar" id="email_cliente_salvar" class="form-control add" placeholder="Digite o email do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tel_cliente_salvar"><strong>Telefone do cliente</strong></label>
                                        <input type="text" name="tel_cliente_salvar" id="tel_cliente_salvar" class="form-control add" placeholder="Digite o telefone do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="endereco_cliente_salvar"><strong>Endereço do cliente</strong></label>
                                        <input type="text" name="endereco_cliente_salvar" id="endereco_cliente_salvar" class="form-control add" placeholder="Digite o endereço do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger form-control"  type="submit" >Salvar</button><!-- data-name="btn-adiciona-cliente" -->
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de ediÃ§Ã£o -->
        <div id="modalEdicao" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <h4 class="modal-title">Editar cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="#">
                                    <input type="hidden" data-name="id_editar" name="id_editar" value="" />
                                    <input type="hidden" name="_method" value="update" />
                                    <div class="form-group">
                                        <label for="nm_cliente_editar"><strong>Nome do cliente</strong></label>
                                        <input type="text" name="nm_cliente_editar" id="nm_cliente_editar" class="form-control edit" placeholder="Digite o nome do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="cd_cliente_editar"><strong>CPF do cliente</strong></label>
                                        <input type="text" name="cd_cliente_editar" id="cd_cliente_editar" class="form-control edit" placeholder="Digite o CPF do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="cd2_cliente_editar"><strong>RG do cliente</strong></label>
                                        <input type="text" name="cd2_cliente_editar" id="cd2_cliente_editar" class="form-control edit" placeholder="Digite o RG do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email_cliente_editar"><strong>Email da cliente</strong></label>
                                        <input type="text" name="email_cliente_editar" id="email_cliente_editar" class="form-control edit" placeholder="Digite o email do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tel_cliente_editar"><strong>Telefone do cliente</strong></label>
                                        <input type="text" name="tel_cliente_editar" id="tel_cliente_editar" class="form-control edit" placeholder="Digite o telefone do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <label for="endereco_cliente_editar"><strong>Endereço do cliente</strong></label>
                                        <input type="text" name="endereco_cliente_editar" id="endereco_cliente_editar" class="form-control edit" placeholder="Digite o endereço do cliente" />
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" type="submit" data-name="btn-altera-cliente-send" >Alterar</button>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de exclusão -->
        <div class="modal fade" id="modalDelecao" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"  class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <h2 class="modal-title">Você tem certeza que deseja excluir este cliente?</h2>
                        <h4>Depois de excluído, para ter os dados novamente, será necessário o recadastro.</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form role="form" action="#" method="post">
                                    <div class="form-group text-center" align="left">
                                        <button class="btn btn-success form-control" type="button" title="Cancelar" data-dismiss="modal">Não</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form role="form">
                                    <input type="hidden" data-name="id_delete" name="id_delete" value="" />
                                    <input type="hidden" name="_method" value="delete" />
                                    <div class="form-group text-center" align="right">
                                        <button class="btn btn-danger form-control" type="submit" title="Excluir">Sim</button>
                                    </div>    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de exibiÃ§Ã£o -->
        <!-- ExibiÃ§Ã£o completa dos dados do cliente -->

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                // Adiciona o cliente
                $('[data-name="btn-adiciona-cliente"]').click(function (button) {
                    button.preventDefault();
                    
                });

                // Edita o cliente, com base no seu "id"
                $('[data-name="btn-altera-cliente"]').click(function (button) {
                    button.preventDefault();
                    var $this = $(this);
                    $('[data-name="id_editar"]').val($($this).closest("tr").attr("data-id"));

                    $.ajax({
                        url: 'cliente',
                        method: "POST",
                        dataType: 'json',
                        data: {
                            '_method': 'select',
                            'id': $('[data-name="id_editar"]').val()
                        }
                    }).done(function (retorno) {
                        $("#nm_cliente_editar").val(retorno.nome);
                        $("#cd_cliente_editar").val(retorno.cpf);
                        $("#cd2_cliente_editar").val(retorno.rg);
                        $("#email_cliente_editar").val(retorno.email);
                        $("#tel_cliente_editar").val(retorno.telefone);
                        $("#endereco_cliente_editar").val(retorno.endereco);
                    });

                });

                $('[data-name="btn-altera-cliente-send"]').click(function (button) {
                    //button.preventDefault();
                    
                });

                $('[data-name="btn-exclui-cliente"]').click(function (button) {
                    var $this = $(this);
                    $('[data-name="id_delete"]').val($($this).closest("tr").attr("data-id"));
                    console.log($('[data-name="id_delete"]').val());
                });
            });
        </script>
    </body>
</html>
